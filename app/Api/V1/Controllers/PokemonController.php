<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use app\Models\Pokemon;
use Exception;
use GuzzleHttp\Client;

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

    public function getPokemons()
    {
        // Hacer la solicitud a la PokeAPI para obtener una lista de Pokémon
        $client = new Client();
        $response = $client->get('https://pokeapi.co/api/v2/pokemon?limit=15');
        $data = json_decode($response->getBody(), true);

        // Extraer información relevante y devolverla como respuesta JSON
        $pokemons = collect($data['results'])->pluck('name')->pluck('tipo');
        return response()->json($pokemons);
    }
}
