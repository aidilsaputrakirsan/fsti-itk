<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentActivity extends Model
{
    use HasFactory;

    protected $table = 'student_activities';

    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'organizer',
        'location',
        'description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function getIsPastAttribute()
    {
        $compareDate = $this->end_date ? $this->end_date : $this->start_date;
        return $compareDate->endOfDay()->isPast();
    }
}
