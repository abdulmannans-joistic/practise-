<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantFinalScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'match_percentage'
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
