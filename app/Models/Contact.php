<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'address', 
        'operating_hours', 
        'google_maps_iframe',
        'academic_wa_number', 
        'academic_wa_link',
        'finance_wa_number', 
        'finance_wa_link',
        'email', 
        'instagram_username', 
        'instagram_link',
        'tiktok_username', 
        'tiktok_link'
    ];
}