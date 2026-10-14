<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('curriculums', function (Blueprint $table) {
            $table->integer('curriculum_id')->primary();
            $table->integer('program_id');
            $table->string('curriculum_code')->unique();
            $table->integer('effective_year');
            $table->string('status');

            $table->foreign('program_id')->references('program_id')->on('programs');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curriculums');
    }
};
