<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zi_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('banner_image_path')->nullable();
            $table->longText('description')->nullable();
            $table->string('service_declaration_image_path')->nullable();
            $table->string('external_website_url')->nullable();
            $table->timestamps();
        });

        Schema::create('zi_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('file_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zi_documents');
        Schema::dropIfExists('zi_profiles');
    }
};
