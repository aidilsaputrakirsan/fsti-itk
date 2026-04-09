<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Profil ZI (Menyimpan 1 baris data untuk pengaturan halaman)
        Schema::create('zi_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('banner_image_path')->nullable();
            $table->longText('description')->nullable();
            $table->string('service_declaration_image_path')->nullable(); // Maklumat Pelayanan
            $table->timestamps();
        });

        // Tabel Dokumen ZI (Menyimpan daftar dokumen tanpa pengelompokan area)
        Schema::create('zi_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title'); // Contoh: SK Tim Zona Integritas FSTI 2025
            $table->string('file_url')->nullable(); // Path lokal atau Tautan Eksternal
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zi_documents');
        Schema::dropIfExists('zi_profiles');
    }
};