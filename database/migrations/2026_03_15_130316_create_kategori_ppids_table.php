<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kategori_ppids', function (Blueprint $table) {
            $table->id();

            // UBAH DI SINI: Dari enum menjadi string agar Admin bisa mengetik/menambah jenis halaman apa saja tanpa batas
            $table->string('jenis_informasi');

            // Nama kategori (Contoh: "A. Profil Fakultas...")
            $table->string('nama_kategori');

            // Agar Admin bisa mengatur urutan tampil (A, B, C)
            $table->integer('urutan')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_ppids');
    }
};
