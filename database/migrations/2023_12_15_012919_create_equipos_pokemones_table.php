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
            $table->tinyInteger('orden');
            $table->timestamps();

            $table->foreign('id_pokemon')->references('id')->on('pokemones')
                ->onUpdate('restrict')->onDelete('restrict');

            $table->foreign('id_equipo')->references('id')->on('equipos')
                ->onUpdate('restrict')->onDelete('restrict');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
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
