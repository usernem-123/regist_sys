<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_types', function (Blueprint $table) {
            $table->integer('document_type_id')->primary();
            $table->string('document_name');
            $table->decimal('processing_fee', 10, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_types');
    }
};
