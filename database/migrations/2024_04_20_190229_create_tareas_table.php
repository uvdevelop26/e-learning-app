<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('instruccion')->nullable();
            $table->date('fecha_entrega');
            $table->time('hora_entrega');
            $table->integer('puntos')->nullable();
            $table->unsignedBigInteger('unidade_id');
            $table->foreign('unidade_id')
                ->references('id')
                ->on('unidades')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tareas');
    }
};
