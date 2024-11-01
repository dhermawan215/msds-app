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
        Schema::create('sample_request_materials', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('material_id')->nullable();
            $table->string('inventory_code')->nullable();
            $table->string('batch_number')->nullable();
            $table->double('qty')->nullable();
            $table->bigInteger('unit_id')->nullable();
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
        Schema::dropIfExists('sample_request_materials');
    }
};
