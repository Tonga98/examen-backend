<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use app\Models\Equipo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquipoController extends Controller
{
    public function listar(Request $request)
    {
        try {
            $request->validate(['id_entrenador' => 'required|exists:entrenadores,id']);
            $idEntrenador = $request->id_entrenador;
            $equipos = Equipo::where('id_entrenadores', $idEntrenador)->paginate(10);
            return [
                'status' => 'ok',
                'equipos' => $equipos
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function detalle($id)
    {
        $equipo = null;
        try {
            $equipo = Equipo::select(
                'equipos.id as id',
                'equipos.nombre as nombre',
                'pokemones.id as id_pokemones',
                'pokemones.nombre as nombre_pokemones',
                'pokemones.tipo as tipos_pokemones',
                'equipo_pokemones.orden as orden_pokemones'
            )
                ->join('equipo_pokemones', 'equipo_pokemones.id_equipos', 'equipos.id')
                ->join('pokemones', 'pokemones.id', 'equipo_pokemones.id_pokemones')
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

    public function crear()
    {
        //
    }
}
