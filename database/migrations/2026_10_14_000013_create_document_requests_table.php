<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_requests', function (Blueprint $table) {
            $table->integer('request_id')->primary();
            $table->integer('student_id');
            $table->integer('document_type_id');
            $table->date('request_date');
            $table->string('purpose');
            $table->string('status');
            $table->date('release_date')->nullable();

            $table->foreign('student_id')->references('student_id')->on('students');
            $table->foreign('document_type_id')->references('document_type_id')->on('document_types');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_requests');
    }
};
