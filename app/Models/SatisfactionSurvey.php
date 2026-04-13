<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SatisfactionSurvey extends Model
{
    protected $table = 'satisfaction_surveys'; 
    protected $fillable = [
        'respondent_name',
        'respondent_email',
        'respondent_type',
        'service_category',
        'rating',
        'feedback',
    ];
}