<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->integer('student_id')->primary();
            $table->integer('program_id');
            $table->string('student_number')->unique();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('birth_date');
            $table->string('sex');
            $table->string('email')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('address');
            $table->string('status');

            $table->foreign('program_id')->references('program_id')->on('programs');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
