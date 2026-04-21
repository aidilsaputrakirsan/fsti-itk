<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpidCategory extends Model
{
    use HasFactory;

    protected $table = 'ppid_categories';

    protected $fillable = ['jenis_informasi', 'nama_kategori', 'urutan'];

    public function dokumen()
    {
        return $this->hasMany(PpidDocument::class, 'ppid_category_id');
    }
}
