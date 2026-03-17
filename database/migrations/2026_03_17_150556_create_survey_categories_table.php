<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('survey_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Aspek Penilaian
            $table->boolean('is_active')->default(true); // Status Aktif/Tidak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_categories');
    }
};