<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquiposPokemonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipos_pokemones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_pokemon');
            $table->unsignedBigInteger('id_equipo');
            $table->integer('orden');
            $table->timestamps();

            $table->foreign('id_pokemon')->references('id')->on('pokemones');
            $table->foreign('id_equipo')->references('id')->on('equipos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipos_pokemones');
    }
}
