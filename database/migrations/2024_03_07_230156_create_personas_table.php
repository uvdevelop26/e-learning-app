<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 200);
            $table->string('apellido', 200);
            $table->string('ci_numero', 100);
            $table->string('sexo');
            $table->string('telefono');
            $table->string('direccion');

            $table->unsignedBigInteger('ciudade_id');

            $table->foreign('ciudade_id')
                ->references('id')
                ->on('ciudades')
                ->onDelete('cascade');

            
           /*  $table->unsignedBigInteger('ciudade_id');
            
            $table->foreign('ciudade_id')
                ->references('id')
                ->on('ciudades')
                ->onDelete('set null'); */
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('personas');
    }
};
