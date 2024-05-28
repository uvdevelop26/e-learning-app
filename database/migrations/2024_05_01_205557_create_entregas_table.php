<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('entregas', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('completado')->nullable();
            $table->unsignedBigInteger('tarea_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('tarea_id')
                ->references('id')
                ->on('tareas')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('entregas');
    }
};
