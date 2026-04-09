<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZiProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'banner_image_path',
        'description',
        'service_declaration_image_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
