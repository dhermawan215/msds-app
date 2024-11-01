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
        Schema::create('sample_request_product_documents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sample_req_product_id')->nullable();
            $table->enum('document_category', ['MSDS', 'PDS'])->default(null)->nullable();
            $table->string('document_name')->nullable();
            $table->text('document_path')->nullable();
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
        Schema::dropIfExists('sample_request_product_documents');
    }
};
