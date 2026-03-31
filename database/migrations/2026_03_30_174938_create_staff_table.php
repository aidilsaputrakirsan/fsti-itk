<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nip')->nullable();
            $table->enum('type', ['Dosen', 'Tendik']);
            $table->string('structural_position')->nullable();
            $table->string('functional_position')->nullable();
            $table->text('image_url')->nullable();

            $table->boolean('is_active')->default(true);

            $table->json('education_history')->nullable();
            $table->json('expertise')->nullable();
            $table->json('competency_certification')->nullable();
            $table->json('research_history')->nullable();
            $table->json('community_service_history')->nullable();
            $table->json('work_experience')->nullable();
            $table->json('awards')->nullable();
            $table->json('academic_profiles')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
