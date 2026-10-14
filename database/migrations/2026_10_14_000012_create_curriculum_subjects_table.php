<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('curriculum_subjects', function (Blueprint $table) {
            $table->integer('curriculum_subject_id')->primary();
            $table->integer('curriculum_id');
            $table->integer('subject_id');
            $table->integer('year_level');
            $table->integer('semester_no');
            $table->string('subject_type');
            $table->boolean('is_required');

            $table->foreign('curriculum_id')->references('curriculum_id')->on('curriculums');
            $table->foreign('subject_id')->references('subject_id')->on('subjects');
            $table->unique(['curriculum_id', 'subject_id', 'year_level', 'semester_no']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curriculum_subjects');
    }
};
