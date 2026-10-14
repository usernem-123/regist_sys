<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_records', function (Blueprint $table) {
            $table->integer('academic_record_id')->primary();
            $table->integer('student_id');
            $table->integer('subject_id');
            $table->integer('semester_id');
            $table->decimal('final_grade', 5, 2)->nullable();
            $table->string('remarks')->nullable();

            $table->foreign('student_id')->references('student_id')->on('students');
            $table->foreign('subject_id')->references('subject_id')->on('subjects');
            $table->foreign('semester_id')->references('semester_id')->on('semesters');
            $table->unique(['student_id', 'subject_id', 'semester_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_records');
    }
};
