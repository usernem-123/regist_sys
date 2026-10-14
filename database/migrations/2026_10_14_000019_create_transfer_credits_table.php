<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfer_credits', function (Blueprint $table) {
            $table->integer('transfer_credit_id')->primary();
            $table->integer('transfer_id');
            $table->integer('equivalent_subject_id');
            $table->string('previous_subject');
            $table->decimal('credited_units', 5, 2);
            $table->string('status');

            $table->foreign('transfer_id')->references('transfer_id')->on('transfer_credentials');
            $table->foreign('equivalent_subject_id')->references('subject_id')->on('subjects');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfer_credits');
    }
};
