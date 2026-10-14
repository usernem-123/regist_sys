<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->integer('semester_id')->primary();
            $table->integer('academic_year_id');
            $table->string('semester_name');
            $table->string('term_code');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status');

            $table->foreign('academic_year_id')->references('academic_year_id')->on('academic_years');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
