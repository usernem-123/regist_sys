<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfer_credentials', function (Blueprint $table) {
            $table->integer('transfer_id')->primary();
            $table->integer('student_id');
            $table->string('previous_school');
            $table->string('previous_program');
            $table->string('status');

            $table->foreign('student_id')->references('student_id')->on('students');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfer_credentials');
    }
};
