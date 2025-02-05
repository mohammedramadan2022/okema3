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
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_device_id');
            $table->date('reservation_date');
            $table->time('reservation_time');
            $table->integer('status')->default(0)->comment('0 for initiate 1 for done 2 for canceled');
            $table->longText('client_notes')->nullable();
            $table->longText('okema_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
