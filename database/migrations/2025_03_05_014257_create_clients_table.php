<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('attention');
            $table->string('email');
            $table->string('contact')->nullable();
            $table->boolean('is_active')->default(1);
            $table->string('company_name')->nullable();
            $table->integer('invoice_start')->nullable();
            $table->integer('quote_start')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cleints');
    }
};
