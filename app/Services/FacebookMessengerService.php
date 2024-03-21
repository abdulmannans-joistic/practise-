<?php namespace App\Services;

use Illuminate\Support\Facades\Http;

class FacebookMessengerService
{
    protected $accessToken;

    public function __construct()
    {
        $this->accessToken = config('facebook.access_token');
    }

    private function makeAPICall($messageData)
    {
        $url = "https://graph.facebook.com/v13.0/me/messages?access_token=" . $this->accessToken;
        $response = Http::post($url, $messageData);
        return $response->json();
    }

    public function getUserName($userId)
    {
        $url = "https://graph.facebook.com/v13.0/$userId?fields=first_name&access_token=$this->accessToken";
        $response = Http::get($url);
        return $response->json()['first_name'] ?? '';
    }

    public function getUserLastName($userId)
    {
        $url = "https://graph.facebook.com/v13.0/$userId?fields=last_name&access_token=$this->accessToken";
        $response = Http::get($url);
        return $response->json()['last_name'] ?? '';
    }

    public function getUserEmail($userId)
    {
        $url = "https://graph.facebook.com/v13.0/$userId?fields=email&access_token=$this->accessToken";
        $response = Http::get($url);
        return $response->json()['email'] ?? '';
    }

    public function sendTextMessage($recipientId, $messageText)
    {
        $messageData = [
            "recipient" => [ "id" => $recipientId ],
            "message" => [ "text" => $messageText ]
        ];
        return $this->makeAPICall($messageData);
    }
    public function sendDynamicButtons($recipientId, $text, $buttons)
    {
        
        $formattedButtons = [];
        foreach ($buttons as $button) {
            $formattedButton = [
                'type' => $button['type'] === 'web_url' ? 'web_url' : 'postback',
                'title' => $button['title'],
            ];
            if ($button['type'] === 'web_url') {
                $formattedButton['url'] = $button['url'];
                $formattedButton['webview_height_ratio'] = 'full';
                $formattedButton['messenger_extensions'] = true;
            } else {
                $formattedButton['payload'] = $button['payload'];
            }
            $formattedButtons[] = $formattedButton;
        }

        $payload = [
            'recipient' => ['id' => $recipientId],
            'message' => [
                'attachment' => [
                    'type' => 'template',
                    'payload' => [
                        'template_type' => 'button',
                        'text' => $text,
                        'buttons' => $formattedButtons,
                    ],
                ],
            ],
        ];

        return $this->makeAPICall($payload);
    }

    public function processPostback($senderId, $payload)
    {
        switch ($payload) {
            case 'GET_STARTED':
                $this->sendTextMessage($senderId, "Welcome to our Messenger Bot!");
                break;
            default:
                $this->handleCustomPostback($senderId, $payload);
                break;
        }
    }
    
    protected function handleCustomPostback($senderId, $payload)
    {
        if (strpos($payload, 'CONFIRM_APPLICATION') === 0) {
            list($action, $jobId) = explode('-', $payload);
            $this->initiateJobApplicationProcess($senderId, $jobId);
        }
    }
    protected function initiateJobApplicationProcess($senderId, $jobId)
    {
        $this->sendTextMessage($senderId, "Thank you for showing interest in Job ID: $jobId. Please follow the next steps to complete your application.");
    }

    public function sendQuickReplies($recipientId, $text, $replies)
    {
        $quickReplies = array_map(function ($reply) {
            return [
                "content_type" => "text",
                "title" => $reply['title'],
                "payload" => $reply['payload']
            ];
        }, $replies);

        $messageData = [
            "recipient" => ["id" => $recipientId],
            "message" => [
                "text" => $text,
                "quick_replies" => $quickReplies
            ]
        ];

        return $this->makeAPICall($messageData);
    }


    public function processMessage($userId, $message, $payload = null)
    {
        if ($payload) {
            if ($payload === 'CONFIRM_EMAIL') {
                // Process confirmation
                $this->sendTextMessage($userId, "Email confirmed. What's next?");
            } else {
                $this->sendTextMessage($userId, "Please confirm your email to proceed.");
            }
        } else {
            $this->sendTextMessage($userId, "Welcome to our service! Please confirm your email.");
            $this->sendQuickReplies($userId, "Is this your correct email?", [
                ['title' => 'Yes', 'payload' => 'CONFIRM_EMAIL'],
                ['title' => 'No', 'payload' => 'REJECT_EMAIL']
            ]);
        }
    }

    public function sendWebviewButton($recipientId, $buttonText, $url)
    {
        $messageData = [
            "recipient" => ["id" => $recipientId],
            "message" => [
                "attachment" => [
                    "type" => "template",
                    "payload" => [
                        "template_type" => "button",
                        "text" => "Need more info...",
                        "buttons" => [
                            [
                                "type" => "web_url",
                                "url" => $url,
                                "title" => $buttonText,
                                "webview_height_ratio" => "full",
                                "messenger_extensions" => true
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $this->makeAPICall($messageData);
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

    public function updateCampaignStatus($campaignId, $newStatus)
    {
        $campaign = Campaign::find($campaignId);

        if (!$campaign) {
            return false;
        }

        $campaign->campaign_status = $newStatus;
        $campaign->save();

        return true;
    }




}
?>