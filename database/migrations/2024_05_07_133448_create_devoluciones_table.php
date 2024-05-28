<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('devoluciones', function (Blueprint $table) {
            $table->id();
            $table->text('recomendacion')->nullable();
            $table->tinyInteger('devuelto')->nullable();
            $table->integer('puntos')->nullable();
            $table->unsignedBigInteger('entrega_id');
            $table->foreign('entrega_id')
                ->references('id')
                ->on('entregas')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('devoluciones');
    }
};
