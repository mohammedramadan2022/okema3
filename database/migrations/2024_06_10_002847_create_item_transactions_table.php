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
        Schema::create('item_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id');
            $table->integer('store_id');
            $table->integer('quantity');
            $table->integer('quantity_before');
            $table->integer('quantity_after');
            $table->enum('type' , array('supply' , 'store_exchange' ,'order'));
            $table->integer('store_from_id')->nullable();
            $table->integer('store_to_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_transactions');
    }
};
