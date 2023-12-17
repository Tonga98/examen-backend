<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewEquipoRequest;
use App\Http\Requests\VerificarEntrenadorRequest;
use App\Models\Equipo;
use Exception;
use App\Models\EquipoPokemon;
use Illuminate\Http\JsonResponse;

class EquipoController extends Controller
{

    public function listar(VerificarEntrenadorRequest  $request): JsonResponse{

        //Obtener el id del entrenador validado
        $entrenador_id = $request->id_entrenador;

        //Recuperar los equipos asociados al entrenador
        $equipos = Equipo::where('id_entrenador', $entrenador_id)->paginate(10);

        return response()->json([
            'status' => 'ok',
            'equipos' => $equipos
        ]);
    }

    public function detalle($id): array
    {
        $equipo = null;
        try {
            $equipo = Equipo::select(
                'equipos.id as id',
                'equipos.nombre as nombre',
                'pokemones.id as id_pokemones',
                'pokemones.nombre as nombre_pokemones',
                'pokemones.tipo as tipos_pokemones',
                'equipos_pokemones.orden as orden_pokemones'
            )
                ->join('equipos_pokemones', 'equipos_pokemones.id_equipo', 'equipos.id')
                ->join('pokemones', 'pokemones.id', 'equipos_pokemones.id_pokemon')
                ->where('equipos.id', $id)
                ->get()
                ->toArray();


            if (empty($equipo)) {
                throw new Exception("No se encontro el equipo.");
            }

            return [
                'status' => 'ok',
                'equipo' => $equipo
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function crear(NewEquipoRequest $request): JsonResponse
    {
        try {
            //Obtener los datos validados
            $data = $request->validated();
            $nombreEquipo = $data['nombre'];
            $entrenador_id = $data['id_entrenador'];
            $pokemones = $data['pokemones']; //Son los id de los pokemones, no los objetos
            $id_primero = $data['id_primero'];
            $id_segundo = $data['id_segundo'] ?? null;

            //Si la cantidad de pokemones >= 2 entonces id_segundo != null
            if (count($pokemones) >= 2 && is_null($id_segundo)) {
                throw new Exception("Establecer el orden de los pokemones");
            }

            //Verificar que los id de orden, $id_primero e $id_segundo esten en la lista de pokemones
            if (!in_array($id_primero, $pokemones) || (!is_null($id_segundo) && !in_array($id_segundo, $pokemones))) {
                throw new Exception("Los id de orden no corresponden a los pokemones");
            }

            //Verificar que $id_primero e $id_segundo no sean iguales
            if (!is_null($id_segundo) && $id_primero == $id_segundo) {
                throw new Exception("Los id de orden de pokemones no pueden ser iguales");
            }

            //Crear el equipo
            $equipo = Equipo::create([
                'nombre' => $nombreEquipo,
                'id_entrenador' => $entrenador_id
            ]);

            //Para cada pokemon crear los datos en la tabla intermedia
            foreach ($pokemones as $pokemon_id) {

                //Obtener el orden del pokemon
                    if ($pokemon_id == $id_primero) {
                        $orden = 1;
                    } else if ($pokemon_id == $id_segundo) {
                        $orden = 2;
                    } else {
                        $orden = 3;
                    }

                $equipoPokemon = EquipoPokemon::create([
                    'id_equipo' => $equipo->id,
                    'id_pokemon' => $pokemon_id,
                    'orden' => $orden
                ]);
            }

            return response()->json([
                'status' => 'ok',
                'message' => 'Equipo creado correctamente.'
            ], 200);
        } catch (Exception $e){
            return response()->json([
                'status' => 'Error',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
