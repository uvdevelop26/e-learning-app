<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->text('contenido');
            $table->unsignedBigInteger('anuncio_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('anuncio_id')
                ->references('id')
                ->on('anuncios')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('comentarios');
    }
};
