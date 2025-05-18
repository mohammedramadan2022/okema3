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
        Schema::create('safes_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('safe_id');
            $table->string('safable_type');
            $table->unsignedBigInteger('safable_id');
            $table->unsignedBigInteger('admin_id');
            $table->double('amount')->default(0);
            $table->double('balance_before')->default(0);
            $table->double('balance_after')->default(0);
            $table->enum('effect', ['debit', 'deposit']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('safes_transactions');
    }
};
