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
            $table->bigInteger('requestor')->nullable();
            $table->date('required_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('delivery_by');
            $table->text('requestor_note')->nullable();
            $table->bigInteger('sample_source_id')->nullable();
            $table->integer('sample_status')->nullable();
            $table->text('sample_pic')->nullable();
            $table->tinyInteger('sample_pic_status')->nullable();
            $table->text('sample_pic_note')->nullable();
            $table->timestamp('sample_pic_approve_at')->nullable();
            $table->text('rnd')->nullable();
            $table->tinyInteger('rnd_status')->nullable();
            $table->text('rnd_note')->nullable();
            $table->timestamp('rnd_approve_at')->nullable();
            $table->bigInteger('cs')->nullable();
            $table->tinyInteger('cs_status')->nullable();
            $table->text('cs_note')->nullable();
            $table->timestamp('cs_approve_at')->nullable();
            $table->text('token')->nullable();
            $table->timestamp('token_expired_at')->nullable();
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
