<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'applicant_name',
        'applicant_email',
        'applicant_resume_url',
        'application_status',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function finalScore()
    {
        return $this->hasOne(ApplicantFinalScore::class, 'applicant_id');
    }
}
