<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'post_category_id',
        'tags',
        'status',
        'image_path',
        'published_at',
    ];

    protected $appends = ['image_url'];

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : null;
    }
}
