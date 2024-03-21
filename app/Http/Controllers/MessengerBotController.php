<?php

namespace App\Http\Controllers;
use App\Services\FacebookMessengerService;


use Illuminate\Http\Request;

class MessengerBotController extends Controller
{
    protected $fbService;

    public function __construct(FacebookMessengerService $fbService)
    {
        $this->fbService = $fbService;
        $this->accessToken = config('facebook.access_token');
    }

    public function handleWebhook(Request $request, FacebookMessengerService $fbService)
    {
        if ($request->method() === 'GET') {
            return $this->verifyWebhook($request);
        }

        $this->handleMessages($request, $fbService);
        return response('EVENT_RECEIVED', 200);
    }

    protected function verifyWebhook(Request $request)
    {
        $verifyToken = config('facebook.verify_token');
        $mode = $request->query('hub_mode');
        $token = $request->query('hub_verify_token');
        $challenge = $request->query('hub_challenge');

        if ($mode && $token && $mode === 'subscribe' && $token === $verifyToken) {
            return response($challenge, 200);
        }

        return response('Verification failed', 403);
    }

    protected function handleMessages(Request $request, FacebookMessengerService $fbService)
    {
        // Extracting the entry
        $entry = $request->input('entry.0.messaging.0', null);
        if ($entry) {
            $senderId = $entry['sender']['id'] ?? null;
            $messageText = $entry['message']['text'] ?? null;
            $postbackPayload = $entry['postback']['payload'] ?? null;
    
            // Handling text message
            if ($messageText) {
                $fbService->sendTextMessage($senderId, "You said: $messageText");
            }
    
            if ($postbackPayload) {
                $fbService->processPostback($senderId, $postbackPayload);
            }
        }
        if (isset($entry['message']['attachments'])) {
            foreach ($entry['message']['attachments'] as $attachment) {
                if ($attachment['type'] == 'image') {
                    $fbService->sendTextMessage($senderId, "Thanks for the image!");
                }
            }
        }
    }

    public function handleUserMessage($userId, $message)
    {
        $userState = UserState::where('user_id', $userId)->first();

        if ($userState && $userState->state === 'awaiting_reply') {
            $reply = $this->generateReplyBasedOnInput($message);
            $this->sendTextMessage($userId, $reply);
        } else {
            $this->sendTextMessage($userId, "Welcome! Send 'start' to begin.");
        }
    }

    protected function generateReplyBasedOnInput($input)
    {
        return "Here's a response tailored to your input: " . $input;
    }

    public function storeUserResponse($campaignId, $userId, $questionId, $choiceId)
    {
        $applicant = Applicant::firstOrCreate([
            'campaign_id' => $campaignId,
            'user_id' => $userId, 
        ]);

        ApplicantAnswers::create([
            'applicant_id' => $applicant->id,
            'question_id' => $questionId,
            'choice_id' => $choiceId,
        ]);
    }

    public function sendQuickReply($recipientId)
    {
        $messageData = [
            'recipient' => [
                'id' => $recipientId
            ],
            'message' => [
                'text' => "Choose an option:",
                'quick_replies' => [
                    [
                        "content_type" => "text",
                        "title" => "Option 1",
                        "payload" => "OPTION_1_PAYLOAD",
                    ],
                    [
                        "content_type" => "text",
                        "title" => "Option 2",
                        "payload" => "OPTION_2_PAYLOAD",
                    ]
                ]
            ]
        ];

        Http::post("https://graph.facebook.com/v12.0/me/messages?access_token={$this->access_token}", $messageData);
    }

    public function sendGenericTemplate($recipientId)
    {
        $messageData = [
            'recipient' => [
                'id' => $recipientId
            ],
            'message' => [
                'attachment' => [
                    'type' => 'template',
                    'payload' => [
                        'template_type' => 'generic',
                        'elements' => [
                            [
                                'title' => "Title",
                                'image_url' => "Image_URL",
                                'subtitle' => "Subtitle",
                                'default_action' => [
                                    'type' => 'web_url',
                                    'url' => "URL",
                                    'webview_height_ratio' => 'tall',
                                ],
                                'buttons' => [
                                    [
                                        'type' => 'web_url',
                                        'url' => "Button_URL",
                                        'title' => "Visit Website"
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        Http::post("https://graph.facebook.com/v12.0/me/messages?access_token={$this->access_token}", $messageData);
    }

    protected function handleMessage($messagingEvent)
    {
        $senderId = $messagingEvent['sender']['id'];
        if (isset($messagingEvent['message']['attachments'])) {
            foreach ($messagingEvent['message']['attachments'] as $attachment) {
                if ($attachment['type'] == 'image') {
                    $this->sendTextMessage($senderId, "Thanks for the image!");
                }
            }
        } else if (isset($messagingEvent['message']['text'])) {
            $messageText = $messagingEvent['message']['text'];
            $this->sendTextMessage($senderId, "You said: $messageText");
        }
    }

    protected function sendJobDescription($senderId, $jobId)
    {
        $jobDescription = "Here is the job description for Job ID: {$jobId}.";

        $this->fbService->sendTextMessage($senderId, $jobDescription);

        $this->fbService->sendQuickReplies($senderId, "Interested in applying?", [
            ['title' => 'Yes', 'payload' => "CONFIRM_APPLICATION-{$jobId}"],
            ['title' => 'No', 'payload' => 'DECLINE_APPLICATION']
        ]);
    }

    protected function initiateJobApplication($senderId, $jobId, $employerNo)
    {

        $this->fbService->sendTextMessage($senderId, "Your application for Job ID: {$jobId} has been initiated. Please follow the instructions to complete your application.");

        $applicationUrl = "https://yourdomain.com/applicationForm?jobId={$jobId}&userId={$senderId}&employerNo={$employerNo}";
        $this->fbService->sendWebviewButton($senderId, "Fill Application Form", $applicationUrl);
    }

    protected function handleApplicationDecline($senderId)
    {
        $this->fbService->sendTextMessage($senderId, "We're sorry to see you go. If you change your mind, feel free to reach out again!");
    }

    protected function confirmApplication($senderId, $jobId)
    {
        $this->fbService->sendTextMessage($senderId, "Thank you for confirming your interest. We will get back to you with more details soon.");
    }

     protected function handlePostback($senderId, $postbackPayload)
     {
         list($action, $jobId, $employerNo) = explode('-', $postbackPayload);
 
         switch ($action) {
             case 'GET_STARTED':
                 $this->sendWelcomeMessage($senderId);
                 break;
             case 'VIEW_JOB_DESC':
                 $this->sendJobDescription($senderId, $jobId);
                 break;
             case 'APPLY':
                 $this->initiateJobApplication($senderId, $jobId, $employerNo);
                 break;
             case 'DECLINE_APPLICATION':
                 $this->handleApplicationDecline($senderId);
                 break;
             case 'CONFIRM_APPLICATION':
                 $this->confirmApplication($senderId, $jobId);
                 break;
         }
     }
 
     protected function sendWelcomeMessage($senderId)
     {
         $welcomeText = "Welcome to our Job Portal! How can we assist you today?";
         $this->fbService->sendTextMessage($senderId, $welcomeText);
     }

     protected function sendJobApplicationForm($senderId, $jobId)
     {
         $applicationFormUrl = route('job.application.form', ['jobId' => $jobId, 'userId' => $senderId]); // Example route name and parameters
         $this->fbService->sendWebviewButton($senderId, "Apply Now", $applicationFormUrl);
     }

     protected function handleAttachments($senderId, $attachments)
    {
        foreach ($attachments as $attachment) {
            if ($attachment['type'] == 'image') {
                $this->fbService->sendTextMessage($senderId, "Thanks for the image! We'll review it and get back to you.");
            }
        }
    }

    public function sendCampaignDetails($recipientId, $campaignId)
    {
        $campaign = Campaign::find($campaignId);

        if (!$campaign) {
            $this->sendTextMessage($recipientId, "The requested campaign does not exist.");
            return;
        }

        $message = "Campaign Name: {$campaign->campaign_name}\n"
                . "Location: {$campaign->campaign_location}\n"
                . "Status: {$campaign->campaign_status}\n"
                . "Details: {$campaign->campaign_document_url}";

        $this->sendTextMessage($recipientId, $message);
    }
    

}
