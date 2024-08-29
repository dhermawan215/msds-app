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
        Schema::create('sample_request_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sample_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->string('qty')->nullable();
            $table->string('label_name')->nullable();
            $table->tinyInteger('finished')->default(0)->nullable();
            $table->bigInteger('assign_to')->nullable();
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
        Schema::dropIfExists('sample_request_products');
    }
};
