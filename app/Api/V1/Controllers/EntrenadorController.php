<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use app\Models\Entrenador;
use Exception;
use Illuminate\Http\Request;

class EntrenadorController extends Controller
{
    public function crear(Request $request)
    {
        $nombre = $request->nombr;
        try {
            if (empty($nombre)) {
                throw new Exception("Debe Ingresar el nombre.");
            }
            $entrenador = Entrenador::create([
                'nombre' => $nombre
            ]);
            return [
                'status' => 'ok',
                'id_entrenador' => $entrenador->id
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function detalle()
    {
        //
    }
}
