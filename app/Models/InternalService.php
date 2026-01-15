<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalService extends Model
{
    protected $fillable = [
        'name',
        'description',
        'link_url',
        'category',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
