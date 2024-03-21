<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'question_text',
    ];

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }
}
