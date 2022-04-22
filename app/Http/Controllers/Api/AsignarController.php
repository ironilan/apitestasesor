<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asesor;
use Illuminate\Http\Request;

class AsignarController extends Controller
{
    public function clientes_asesor($idasesor)
    {
        $asesor = Asesor::find($idasesor);
        $data = [];

        if ($asesor) {
            $data = $asesor->clientes;
        }
    

        return response()->json($data, 200);
    }


    public function asignar_clientes(Request $request)
    {
        $asesor = Asesor::find($request->id);

        if ($asesor) {
            $asesor->clientes()->sync($request->cliente);
        }
        
        return $asesor->clientes;
    }
}
