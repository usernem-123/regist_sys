<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->integer('subject_id')->primary();
            $table->string('subject_code')->unique();
            $table->string('subject_name');
            $table->decimal('lecture_units', 5, 2);
            $table->decimal('lab_units', 5, 2);
            $table->decimal('total_units', 5, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
