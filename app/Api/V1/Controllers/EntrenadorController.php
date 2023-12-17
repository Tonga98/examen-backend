<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewEntrenadorRequest;
use App\Models\Entrenador;
use App\Models\Equipo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class EntrenadorController extends Controller
{
    public function crear(NewEntrenadorRequest $request):JsonResponse
    {
            //Obtener el nombre que ya fue validado
            $nombre = $request->nombre;

            //Crear entrenador
            $entrenador = Entrenador::create([
                'nombre' => $nombre
            ]);

            return response()->json([
                'status' => 'ok',
                'id_entrenador' => $entrenador->id
            ]);
    }

    public function detalle(int $entrenador_id): JsonResponse
    {
        try {
            //Obtener el entrenador o lanzar ModelNotFoundException
            $entrenador = Entrenador::findOrFail($entrenador_id);

            //Obtener los equipos que lidera
            $equipos = Equipo::where('id_entrenador', $entrenador_id)->get();

            return response()->json([
                'status' => 'ok',
                'entrenador' => $entrenador,
                'equipos' => $equipos
            ]);

        }catch (ModelNotFoundException $e){
            return response()->json([
                'status' => 'Error',
                'message'=> 'Entrenador no encontrado'
            ],404);
        }
    }

    public function listar(): JsonResponse{
        //Obtener los entrenadores
        $entrenadores = Entrenador::all();

        return response()->json([
            'status' => 'ok',
            'entrenadores' => $entrenadores
        ]);
    }
}
