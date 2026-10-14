<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subject_prerequisites', function (Blueprint $table) {
            $table->integer('prerequisite_id')->primary();
            $table->integer('subject_id');
            $table->integer('prerequisite_subject_id');
            $table->decimal('minimum_grade', 5, 2);

            $table->foreign('subject_id')->references('subject_id')->on('subjects');
            $table->foreign('prerequisite_subject_id')->references('subject_id')->on('subjects');
            $table->unique(['subject_id', 'prerequisite_subject_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subject_prerequisites');
    }
};
