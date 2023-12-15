<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use app\Models\Pokemon;
use Exception;

class PokemonController extends Controller
{
    public function listar()
    {
        $pokemones = [];
        try {
            $pokemones = Pokemon::all();
            return [
                'status' => 'ok',
                'pokemones' => $pokemones
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }
}
