<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\KategoriPpid;

class DokumenPpid extends Model
{
    use HasFactory;

    protected $table = 'dokumen_ppids';

    protected $fillable = ['kategori_ppid_id', 'judul_dokumen', 'file_url'];

    public function kategori()
    {
        return $this->belongsTo(KategoriPpid::class, 'kategori_ppid_id');
    }
}
