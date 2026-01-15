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
        // 1. Modul PPID Fakultas
        Schema::create('ppid_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('category', ['Informasi Berkala', 'Informasi Serta Merta', 'Informasi Setiap Saat', 'Informasi Dikecualikan', 'Regulasi', 'Formulir'])->default('Informasi Berkala');
            $table->text('description')->nullable();
            $table->string('file_path')->nullable(); // PDF/Doc storage path
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Modul Zona Integritas
        Schema::create('integrity_zones', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('Berita ZI'); // Changed from enum to string for flexibility
            $table->text('content'); // Rich text
            $table->string('image_path')->nullable();
            $table->string('document_path')->nullable(); // For policy PDFs
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        // 3. Modul Alumni & Tracer Study
        Schema::create('alumni_tracers', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g., "Laporan Tracer Study 2024"
            $table->string('type')->default('Report'); // Changed from enum for flexibility ('Survey Link' or 'Report')
            $table->string('url')->nullable(); // Link to Google Form or external
            $table->string('file_path')->nullable(); // PDF report
            $table->text('description')->nullable();
            $table->integer('year')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 4. Modul Survei Kepuasan (Internal DB storage for simple polls/feedback)
        Schema::create('satisfaction_surveys', function (Blueprint $table) {
            $table->id();
            $table->string('respondent_email')->nullable(); // Optional anonymity
            $table->string('respondent_name')->nullable();
            $table->enum('respondent_type', ['Mahasiswa', 'Dosen', 'Tenaga Kependidikan', 'Alumni', 'Mitra/Pengguna', 'Masyarakat Umum']);
            $table->string('service_category'); // e.g. "Layanan Akademik", "Sarpras"
            $table->integer('rating'); // 1-5 scale
            $table->text('feedback')->nullable();
            $table->timestamps();
        });

        // 5. Modul Akses Layanan Internal (External Links)
        Schema::create('internal_services', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. "Sistem Informasi Akademik"
            $table->text('description')->nullable();
            $table->string('link_url');
            $table->string('icon_url')->nullable(); // Or icon class name
            $table->string('category')->nullable(); // e.g. "Akademik", "Keuangan"
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internal_services');
        Schema::dropIfExists('satisfaction_surveys');
        Schema::dropIfExists('alumni_tracers');
        Schema::dropIfExists('integrity_zones');
        Schema::dropIfExists('ppid_documents');
    }
};
