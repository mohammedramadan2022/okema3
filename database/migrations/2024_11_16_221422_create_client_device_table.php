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
        Schema::create('client_device', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->integer('device_id');
            $table->integer('city_id');
            $table->string('image')->nullable();
            $table->string('carton_image')->nullable();
            $table->string('invoice_image')->nullable();
            $table->string('file_path')->nullable();
            $table->integer('status')->default(0)->comment('0 for waiting 1 for active 2 for refused');
            $table->date('purchase_date');
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_device');
    }
};
