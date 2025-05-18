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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('quote_id');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')
                ->on('clients')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('quote_date');
            $table->date('due_date');
            $table->float('amount')->nullable();
            $table->float('final_amount')->nullable();
            $table->integer('discount_type')->default(0);
            $table->float('discount')->default(0);
            $table->text('note')->nullable();
            $table->text('term')->nullable();

            $table->integer('recurring')->default(0);
            $table->integer('status')->default(1);

            $table->string('shop_name');  // Add your column here
            $table->string('location');
            $table->boolean('type')->default(0)->comment('0 = maintenance, 1 = sales');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by')->nullable();
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
