<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('materias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo');
            $table->integer('horas_semanales');
            $table->text('plan_estudio')->nullable();
            $table->string('descripcion');
            $table->unsignedBigInteger('semestre_id');

            $table->foreign('semestre_id')
                ->references('id')
                ->on('semestres')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('materias');
    }
};
