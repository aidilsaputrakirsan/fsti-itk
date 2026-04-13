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
        Schema::create('ppid_documents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ppid_category_id')->constrained('ppid_categories')->onDelete('cascade');

            $table->string('judul_dokumen');
            $table->text('file_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppid_documents');
    }
};
