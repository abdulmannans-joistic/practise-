<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'question_id',
        'choice_id'
    ];

}
