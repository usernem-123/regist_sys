<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clearance_details', function (Blueprint $table) {
            $table->integer('clearance_detail_id')->primary();
            $table->integer('clearance_id');
            $table->integer('office_id');
            $table->string('status');
            $table->date('clearance_date')->nullable();
            $table->string('remarks')->nullable();

            $table->foreign('clearance_id')->references('clearance_id')->on('clearances');
            $table->foreign('office_id')->references('office_id')->on('offices');
            $table->unique(['clearance_id', 'office_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clearance_details');
    }
};
