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
        Schema::create('sys_user_modul_roles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sys_modul_id');
            $table->bigInteger('sys_user_group_id');
            $table->tinyInteger('is_akses');
            $table->text('fungsi');
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
        Schema::dropIfExists('sys_user_modul_roles');
    }
};
