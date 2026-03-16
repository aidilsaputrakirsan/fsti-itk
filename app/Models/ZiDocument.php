<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZiDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'file_url'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
