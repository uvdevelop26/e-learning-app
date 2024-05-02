<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('materiale_tareas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->text('url');
            $table->unsignedBigInteger('materiable_id');
            $table->string('materiable_type');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materiale_tareas');
    }
};
