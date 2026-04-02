<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaFakultas extends Model
{
    use HasFactory;

    protected $table = 'agenda_fakultas';
    
    protected $fillable = [
        'title', 'organizer', 'start_date', 'end_date', 'location', 'description'
    ];
}