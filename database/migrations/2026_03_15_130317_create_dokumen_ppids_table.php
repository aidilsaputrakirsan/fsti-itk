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
        Schema::create('dokumen_ppids', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kategori_ppid_id')->constrained('kategori_ppids')->onDelete('cascade');

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
        Schema::dropIfExists('dokumen_ppids');
    }
};
