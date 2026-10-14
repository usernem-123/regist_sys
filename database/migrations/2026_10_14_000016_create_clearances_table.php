<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clearances', function (Blueprint $table) {
            $table->integer('clearance_id')->primary();
            $table->integer('student_id');
            $table->integer('semester_id');
            $table->string('clearance_type');
            $table->string('overall_status');

            $table->foreign('student_id')->references('student_id')->on('students');
            $table->foreign('semester_id')->references('semester_id')->on('semesters');
            $table->unique(['student_id', 'semester_id', 'clearance_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clearances');
    }
};
