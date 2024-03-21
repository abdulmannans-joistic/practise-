<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Question;
use App\Models\Choice;
use App\Models\QrCode;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeGenerator;


class CampaignController extends Controller
{
    // const EXPERIENCE_LEVELS = [
    //     'any' => 'Any Experience',
    //     'fresher' => 'Freshers can also apply',
    //     'fresher_not' => 'Freshers need not apply',
    // ];
    
    // const SALARY_OPTIONS = [
    //     'income_efforts' => 'Income based on your own efforts',
    //     'industry_standard' => 'As per Industry Standards',
    //     'negotiable' => 'Negotiable',
    // ];
    
    public function create()
    {
        return view('campaigns.create');
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'campaign_name' => 'required|string|max:255',
            'campaign_experience_req' => 'required|string',
            'campaign_pref_salary' => 'required|string',
            'campaign_location' => 'required|string|max:255',
            'campaign_document_url' => 'required|url',
        ]);
    
        DB::beginTransaction();
    
        try {
          
            $campaign = Campaign::create([
                'user_id' => $request->user()->id,
                'campaign_name' => $validatedData['campaign_name'],
                'campaign_status' => 'active',
                'campaign_experience_req' => $validatedData['campaign_experience_req'],
                'campaign_pref_salary' => $validatedData['campaign_pref_salary'],
                'campaign_location' => $validatedData['campaign_location'],
                'campaign_document_url' => $validatedData['campaign_document_url'],
            ]);
    
            DB::commit();
    
            if($request->ajax()) {
                $nextSectionView = view('campaigns.partials.set_questions', compact('campaign'))->render();
                    return response()->json([
                    'success' => true,
                    'campaign_id' => $campaign->id,
                    'next_section_html' => $nextSectionView
                ]);
            }
     
        } catch (\Exception $e) {
            DB::rollback();
    
           if($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create campaign: ' . $e->getMessage()
                ]);
            }
    
           return back()->withErrors(['error' => 'Failed to create campaign: ' . $e->getMessage()]);
        }
    }
    

    public function addQuestions(Request $request, $campaign_id)
    {
        
        $validatedData = $request->validate([
            'questions' => 'required|array|max:4',
            'questions.*.text' => 'required|string|max:255',
            'questions.*.choices' => 'required|array|max:4',
            'questions.*.choices.*.text' => 'required|string|max:255',
            'questions.*.choices.*.is_correct' => 'required',
        ]);
    
        DB::beginTransaction();

        try {
            $campaign = Campaign::findOrFail($campaign_id); 
            foreach ($validatedData['questions'] as $index => $questionData) {
                $question = new Question([
                    'campaign_id' => $campaign_id, 
                    'question_text' => $questionData['text'],
                ]);
                $question->save();
    
                foreach ($questionData['choices'] as $choiceData) {
                    $choice = new Choice([
                        'question_id' => $question->id,
                        'choice_text' => $choiceData['text'],
                        'choice_is_correct' => $choiceData['is_correct'],
                    ]);
                    $choice->save();
                }
            }
    
            DB::commit();
    
           
           if ($request->ajax()) {
                $localQrCodeUrl = $this->generateQrCode($campaign_id);
                $qrCodeView = view('campaigns.partials.get_qr_code', compact('localQrCodeUrl'))->render();
    
                return response()->json([
                    'success' => true,
                    'qr_code_html' => $qrCodeView,
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    

    public function generateQrCode($campaignId)
    {
        $campaign = Campaign::findOrFail($campaignId);
    
        $data = [
            'empNo' => $campaign->user_id,
            'jid' => $campaign->id,
        ];
    
        $url = $this->generateDynamicLink($data);
    
        // Generate QR code content
        $qrCodeContent = QrCodeGenerator::format('svg')->size(250)->generate($url);
    
        // Save QR code locally
        $fileName = 'qrcodes/' . uniqid('qr_code_') . '.svg';
        Storage::disk('public')->put($fileName, $qrCodeContent);
        $localUrl = Storage::disk('public')->url($fileName);
    
        // Optional: Upload to S3 for future use
        /*
        $s3Path = Storage::disk('s3')->put($fileName, $qrCodeContent, 'public');
        $s3Url = Storage::disk('s3')->url($s3Path);
        */
        $qrCodeRecord = QrCode::create([
            'campaign_id' => $campaign->id,
            'qr_code_data' => $localUrl, // Use local URL for immediate use
            // 'qr_code_data' => $s3Url, // Switch to this for S3 URL
        ]);
    
        return $localUrl;
    }
    
    public function generateDynamicLink($data)
    {
        $encryptedData = encrypt(json_encode($data)); // Laravel's built-in encryption
        $baseUrl = "https://www.messenger.com/t/";
        $pageId = "223989747469150"; 

        return "{$baseUrl}{$pageId}?data={$encryptedData}";
    }


    

}