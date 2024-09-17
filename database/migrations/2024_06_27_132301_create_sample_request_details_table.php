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
        Schema::create('sample_request_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sample_id')->nullable();
            $table->bigInteger('sample_req_product_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->enum('batc_type', ['PROD', 'LAB'])->nullable();
            $table->string('batch_number')->nullable();
            $table->string('netto')->nullable();
            $table->text('ghs')->nullable();
            $table->string('user_request_name')->nullable();
            $table->date('manufacture_date')->nullable();
            $table->date('expired_date')->nullable();
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
        Schema::dropIfExists('sample_request_details');
    }
};
