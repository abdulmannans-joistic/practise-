<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'campaign_name',
        'campaign_status',
        'campaign_experience_req',
        'campaign_pref_salary',
        'campaign_location',
        'campaign_document_url',
    ];

    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }
}
