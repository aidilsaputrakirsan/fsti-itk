<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpidDocument extends Model
{
    use HasFactory;

    protected $table = 'ppid_documents';

    protected $fillable = ['ppid_category_id', 'judul_dokumen', 'file_url'];

    public function kategori()
    {
        return $this->belongsTo(PpidCategory::class, 'ppid_category_id');
    }
}