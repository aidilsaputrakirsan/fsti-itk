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
        Schema::create('static_pages', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // 'visi', 'misi', 'bagan-organisasi'
            $table->string('title');
            $table->longText('content')->nullable(); // JSON for 'misi', Text for 'visi'
            $table->string('image_path')->nullable(); // For 'bagan-organisasi'
            $table->timestamps();
        });

        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nip')->nullable();
            $table->string('email')->nullable();
            $table->string('position')->nullable(); // Jabatan structural (Dekan, etc.)
            $table->string('prodi')->nullable();    // For Dosen
            $table->string('jurusan')->nullable();  // For Dosen
            $table->string('category');             // Enum-like index
            $table->string('image_path')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('static_pages');
        Schema::dropIfExists('staff');
    }
};
