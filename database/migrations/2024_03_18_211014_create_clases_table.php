<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('clases', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->unsignedBigInteger('materia_id');
            $table->unsignedBigInteger('docente_id');
            $table->unsignedBigInteger('estado_id');

            $table->foreign('materia_id')
                ->references('id')
                ->on('materias')
                ->onDelete('cascade');
            $table->foreign('docente_id')
                ->references('id')
                ->on('docentes')
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
        Schema::dropIfExists('clases');
    }
};
