<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('unidades', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->string('tema');
            $table->string('objetivos')->nullable();
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('unidades');
    }
};
