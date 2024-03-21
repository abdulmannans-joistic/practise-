<?php
namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Campaign;
use App\Models\Question;
use App\Models\Choice;
use App\Models\ApplicantAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Services\FacebookMessengerService;


class WebviewController extends Controller
{
    public function applicationForm($campaignId, $userId) {
        $campaign = Campaign::find($campaignId);
        if (!$campaign) {
            abort(404, 'Campaign not found.');
        }
        
        $questions = Question::where('campaign_id', $campaignId)->with('choices')->get();
       // print_r($questions);die;
        return view('application_form', compact('campaign', 'userId', 'questions'));
    }

    public function submitApplicationForm(Request $request, $campaignId, $userId) {
        $validator = Validator::make($request->all(), [
            'applicant_name' => 'required|string|max:255',
            'applicant_email' => 'required|email',
            'applicant_resume_url' => 'nullable|url',
            'answers' => 'required|array',
            'answers.*' => 'required|exists:choices,id',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()]);
        }
    
        DB::beginTransaction();
        try {
            $applicant = Applicant::create([
                'campaign_id' => $campaignId,
                'applicant_name' => $request->input('applicant_name'),
                'applicant_email' => $request->input('applicant_email'),
                'applicant_resume_url' => $request->input('applicant_resume_url'),
                'application_status' => 'new', // Default status
            ]);
    
            // $score = 0;
            // $answers = $request->input('answers');
            // foreach ($answers as $questionId => $choiceId) {
            //     $choice = Choice::find($choiceId);
            //     if ($choice && $choice->choice_is_correct) {
            //         $score++;
            //     }
    
            //     ApplicantAnswer::create([
            //         'applicant_id' => $applicant->id,
            //         'question_id' => $questionId,
            //         'choice_id' => $choiceId,
            //     ]);
            // }
    
            // Initialize score
            $score = 0;
            $totalQuestions = 0;

            // Retrieve all correct answers for the campaign's questions
            $correctAnswers = Choice::whereHas('question', function($q) use ($campaignId) {
                $q->where('campaign_id', $campaignId);
            })->where('choice_is_correct', true)
            ->pluck('id', 'question_id');

            // Processing answers
            $answers = $request->input('answers', []);
            foreach ($answers as $questionId => $choiceId) {
                $totalQuestions++;
                if (isset($correctAnswers[$questionId]) && $correctAnswers[$questionId] == $choiceId) {
                    $score++;
                }

                ApplicantAnswer::create([
                    'applicant_id' => $applicant->id,
                    'question_id' => $questionId,
                    'choice_id' => $choiceId,
                ]);
            }

            // Calculate the final score, e.g., as a percentage
            $finalScorePercentage = ($totalQuestions > 0) ? ($score / $totalQuestions) * 100 : 0;

            $applicant->finalScore()->updateOrCreate(
                ['applicant_id' => $applicant->id], 
                ['match_percentage' => $finalScorePercentage] 
            );

            DB::commit();
    
            $fbService = resolve(FacebookMessengerService::class);
            $fbService->sendTextMessage($userId, "Your application has been submitted successfully.");
    
            return response()->json(['success' => true, 'message' => 'Application submitted successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'An error occurred while submitting the application.', 'error' => $e->getMessage()]);
        }
    }
}
