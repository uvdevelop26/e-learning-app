<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('clase_unidade', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clase_id');
            $table->unsignedBigInteger('unidade_id');

            $table->foreign('clase_id')
                ->references('id')
                ->on('clases')
                ->onDelete('cascade');
            $table->foreign('unidade_id')
                ->references('id')
                ->on('unidades')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('clase_unidade');
    }
};
