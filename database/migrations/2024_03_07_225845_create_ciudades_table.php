<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('ciudades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 200);
            $table->unsignedBigInteger('departamento_id');
            $table->foreign('departamento_id')
                ->references('id')
                ->on('departamentos')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('ciudades');
    }
};
