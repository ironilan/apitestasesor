<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asesor;
use App\Models\AsesorCliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AsesorController extends Controller
{
    public function index()
    {
        $asesores = Asesor::latest('id')->get();

        return response()->json($asesores, 200);
    }


    public function store(Request $request)
    {

        //  return $request->all();
        $asesor = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:255',
        ]);

        if($asesor->fails()){
            return response()->json($asesor->errors()->toJson(), 400);
        }


        Asesor::create([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo
        ]);

        return response()->json(['status' => true, 'message' => 'Se ha creado con éxito!'], 200);
    }

    
    public function show($id)
    {

        $asesor = Asesor::find($id);        

        if ($asesor) {           

            return response()->json($asesor, 200);
        }

        return response()->json(['status' => false, 'message' => 'No existe un asesor con ese id.'], 400);
    }

    
    
    public function update(Request $request, $id)
    {

        //return $request->all();
        $asesor = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:255'
        ]);

        if($asesor->fails()){
            return response()->json($asesor->errors()->toJson(), 400);
        }

        $asesor = Asesor::find($id);
        //return $asesor;
        if (!$asesor) {
            return response()->json(['status' => true, 'message' => 'No se ha encontrado el asesor'], 400);
        }

        $asesor->nombre = $request->nombre;
        $asesor->codigo = $request->codigo;
        $asesor->save();

        

        return response()->json(['status' => true, 'message' => 'Se ha actualizado con éxito!'], 200);
    }

    
    public function destroy($id)
    {
        $asesor = Asesor::find($id);
        $status = '';
        $msj = '';

        if ($asesor) {
            $asesorAsignado = AsesorCliente::where('asesor_id', $asesor->id)->get();
            if (count($asesorAsignado) > 0) {
                $status = 'tiene_clientes';
                $msj = 'No se puede eliminar debido a que tiene clientes asociados.';
            }else{
                $asesor->delete();
                $status = 'confirmado';
                $msj = 'Eliminado correctamente';
            }
        }


         

        return response()->json(['status' => $status, 'msj' => $msj], 200);
        
    }
}
