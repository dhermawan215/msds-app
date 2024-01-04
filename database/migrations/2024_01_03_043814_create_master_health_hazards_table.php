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
        Schema::create('master_health_hazards', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->text('description')->nullable();
            $table->string('language')->default('en')->nullable();
            $table->string('created_by');
            $table->bigInteger('hazard_statement_id');
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
        Schema::dropIfExists('master_health_hazards');
    }
};
