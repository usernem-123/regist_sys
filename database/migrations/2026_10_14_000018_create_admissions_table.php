<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->integer('admission_id')->primary();
            $table->integer('student_id');
            $table->integer('program_id');
            $table->date('admission_date');
            $table->string('status');

            $table->foreign('student_id')->references('student_id')->on('students');
            $table->foreign('program_id')->references('program_id')->on('programs');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
