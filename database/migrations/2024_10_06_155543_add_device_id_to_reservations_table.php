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
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('device_id')->nullable()->after('client_device_id'); // Adjust 'some_column' to position it correctly
            $table->date('reservation_date')->nullable()->change();
            $table->integer('client_device_id')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('device_id');
            $table->date('reservation_date')->nullable(false)->change();

        });
    }
};
