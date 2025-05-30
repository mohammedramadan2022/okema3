<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo_header')->nullable();
            $table->string('fave_icon')->nullable();
            $table->string('app_name',500)->nullable();
            $table->text('privacy_policy')->nullable();
            $table->text('terms_of_use')->nullable();
            $table->string('quote_no_prefix')->default('QUO');
            $table->string('quote_no_suffix')->nullable();
            $table->string('invoice_no_prefix')->default('INV');
            $table->string('invoice_no_suffix')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
