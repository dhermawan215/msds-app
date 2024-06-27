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
        Schema::create('sample_requests', function (Blueprint $table) {
            $table->id();
            $table->string('sample_ID')->unique();
            $table->string('subject')->nullable();
            $table->date('required_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->integer('delivery_by');
            $table->bigInteger('sample_source_id')->nullable();
            $table->bigInteger('requestor')->nullable();
            $table->integer('sample_status')->nullable();
            $table->bigInteger('sales_manager')->nullable();
            $table->boolean('is_sales_manager')->default(false);
            $table->tinyInteger('sales_manager_status')->nullable();
            $table->text('sales_manager_note')->nullable();
            $table->timestamp('sales_manager_approve_at')->nullable();
            $table->bigInteger('rnd')->nullable();
            $table->tinyInteger('rnd_status')->nullable();
            $table->text('rnd_note')->nullable();
            $table->timestamp('rnd_approve_at')->nullable();
            $table->bigInteger('cs')->nullable();
            $table->tinyInteger('cs_status')->nullable();
            $table->text('cs_note')->nullable();
            $table->timestamp('cs_approve_at')->nullable();
            $table->text('sample_token');
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
        Schema::dropIfExists('sample_requests');
    }
};
