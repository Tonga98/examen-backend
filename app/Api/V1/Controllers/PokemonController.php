<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pokemon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class PokemonController extends Controller
{
    public function listar(): array
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
