<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('docentes', function (Blueprint $table) {
            $table->id();
            $table->string('profesion');
            $table->unsignedBigInteger('persona_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('estado_id');

            $table->foreign('persona_id')
                ->references('id')
                ->on('personas')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('estado_id')
                ->references('id')
                ->on('estados')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('docentes');
    }
};
