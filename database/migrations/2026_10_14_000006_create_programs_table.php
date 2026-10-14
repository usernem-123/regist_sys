<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->integer('program_id')->primary();
            $table->integer('department_id');
            $table->string('program_code')->unique();
            $table->string('program_name');
            $table->string('degree_type');

            $table->foreign('department_id')->references('department_id')->on('departments');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
