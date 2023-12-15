<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class EquipoPokemon extends Model
{
    public $timestamps = false;

    public $table = "equipos_pokemones";

    protected $fillable = ['id_equipos', 'id_pokemones', 'orden'];
}
