<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPpid extends Model
{
    use HasFactory;

    protected $table = 'kategori_ppids';

    protected $fillable = ['jenis_informasi', 'nama_kategori', 'urutan'];

    public function dokumen()
    {
        return $this->hasMany(DokumenPpid::class, 'kategori_ppid_id');
    }
}
