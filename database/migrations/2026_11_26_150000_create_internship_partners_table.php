<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internship_partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('business_field', 150);
            $table->string('location', 150);
            // kp | magang | kp_magang
            $table->string('type', 20)->default('kp_magang');
            // ID program studi yang mahasiswanya pernah KP/magang di mitra ini
            $table->json('study_program_ids')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internship_partners');
    }
};
