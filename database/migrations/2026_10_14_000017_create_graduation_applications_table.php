<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('graduation_applications', function (Blueprint $table) {
            $table->integer('graduation_application_id')->primary();
            $table->integer('student_id');
            $table->integer('program_id');
            $table->integer('semester_id');
            $table->date('application_date');
            $table->string('evaluation_status');
            $table->string('clearance_status');
            $table->string('graduation_status');

            $table->foreign('student_id')->references('student_id')->on('students');
            $table->foreign('program_id')->references('program_id')->on('programs');
            $table->foreign('semester_id')->references('semester_id')->on('semesters');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('graduation_applications');
    }
};
