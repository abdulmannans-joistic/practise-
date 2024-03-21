<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Applicant;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $campaigns = Campaign::withCount('applicants')
            ->with(['applicants' => function($query) {
                $query->with(['finalScore']);
            }])
            ->where('user_id', $userId)
            ->get();

        $metrics = [
            'totalJobPosts' => $campaigns->count(),
            'totalApplied' => $campaigns->sum('applicants_count'),
            'totalMatches' => 0 
        ];

        $jobPosts = $campaigns->map(function ($campaign) use (&$metrics) {
            $perfectMatches = $campaign->applicants->filter(function ($applicant) {
                return optional($applicant->finalScore)->match_percentage == 100;
            })->count();

            $seventyFiveMatches = $campaign->applicants->filter(function ($applicant) {
                return optional($applicant->finalScore)->match_percentage >= 75 && optional($applicant->finalScore)->match_percentage < 100;
            })->count();

            $fiftyMatches = $campaign->applicants->filter(function ($applicant) {
                return optional($applicant->finalScore)->match_percentage >= 50 && optional($applicant->finalScore)->match_percentage < 75;
            })->count();

            $thirtyMatches = $campaign->applicants->filter(function ($applicant) {
                return optional($applicant->finalScore)->match_percentage >= 30 && optional($applicant->finalScore)->match_percentage < 50;
            })->count();

            $metrics['totalMatches'] += $perfectMatches;

            return [
                'id' => $campaign->id,
                'name' => $campaign->campaign_name,
                'applied' => $campaign->applicants_count,
                'perfectMatches' => $perfectMatches,
                'seventyFiveMatches' => $seventyFiveMatches,
                'fiftyMatches' => $fiftyMatches,
                'thirtyMatches' => $thirtyMatches,
                'status' => $campaign->campaign_status
            ];
        });

        return view('dashboard', compact('jobPosts', 'metrics'));
    }
}
