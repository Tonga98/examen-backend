<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\Models\Pokemon;
use App\PokeApi;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\JsonResponse;

class AppController extends Controller
{
    public function getPokemones(): JsonResponse
    {
        try {
            //Url base de PokeApi
            $baseUrl = new PokeApi();
            $baseUrl = $baseUrl->getUrlApi();

            //Hacer la solicitud a la PokeAPI para obtener una lista de 15 Pokemones
            $client = new Client();
            $response = $client->get($baseUrl . 'pokemon?limit=15');
            $pokemones = json_decode($response->getBody(), true);

            //Iterar sobre la lista de Pokemones y guardarlos en la base de datos
            foreach ($pokemones['results'] as $pokemonData) {

                //Obtener el tipo
                $pokemonInfoResponse = $client->get($pokemonData['url']);
                $pokemonInfo = json_decode($pokemonInfoResponse->getBody(),true);
                $type = $pokemonInfo['types'][0]['type']['name'];

                //Guardar pokemon
                $pokemon = Pokemon::create([
                    'nombre' => $pokemonData['name'],
                    'tipo' => $type
                ]);
            }

            return response()->json(['message' => 'Pokemones importados y guardados correctamente.']);
        }catch (RequestException $e){
            return response()->json(['error' => 'Error al obtener o guardar los Pokemones.']);
        }

    }
}
