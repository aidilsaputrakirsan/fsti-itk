<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->text('address')->nullable();
            $table->string('operating_hours')->nullable();
            $table->text('google_maps_iframe')->nullable();
            $table->string('academic_wa_number')->nullable();
            $table->string('academic_wa_link')->nullable();
            $table->string('finance_wa_number')->nullable();
            $table->string('finance_wa_link')->nullable();
            $table->string('email')->nullable();
            $table->string('instagram_username')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('tiktok_username')->nullable();
            $table->string('tiktok_link')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};