<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sample_request_customers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sample_id')->nullable();
            $table->bigInteger('customer_id')->nullable();
            $table->string('customer_pic')->nullable();
            $table->text('delivery_address')->nullable();
            $table->text('customer_note')->nullable();
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
        Schema::dropIfExists('sample_request_customers');
    }
};
