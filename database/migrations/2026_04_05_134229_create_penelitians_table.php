<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penelitians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('study_program_id')->nullable()->constrained('study_programs')->nullOnDelete();
            $table->string('nama_dosen');
            $table->text('judul');
            $table->string('tahun', 4);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penelitians');
    }
};
