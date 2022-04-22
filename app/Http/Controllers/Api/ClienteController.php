<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::latest('id')->get();

        return response()->json($clientes, 200);
    }


    public function store(Request $request)
    {

        //  return $request->all();
        $cliente = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:255',
        ]);

        if($cliente->fails()){
            return response()->json($cliente->errors()->toJson(), 400);
        }


        Cliente::create([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo
        ]);

        return response()->json(['status' => true, 'message' => 'Se ha creado con éxito!'], 200);
    }

    
    public function show($id)
    {

        $cliente = Cliente::find($id);        

        if ($cliente) {           

            return response()->json($cliente, 200);
        }

        return response()->json(['status' => false, 'message' => 'No existe un cliente con ese id.'], 400);
    }

    
    
    public function update(Request $request, $id)
    {

        //return $request->all();
        $cliente = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:255'
        ]);

        if($cliente->fails()){
            return response()->json($cliente->errors()->toJson(), 400);
        }

        $cliente = Cliente::find($id);
        //return $cliente;
        if (!$cliente) {
            return response()->json(['status' => true, 'message' => 'No se ha encontrado el cliente'], 400);
        }

        $cliente->nombre = $request->nombre;
        $cliente->codigo = $request->codigo;
        $cliente->save();

        

        return response()->json(['status' => true, 'message' => 'Se ha actualizado con éxito!'], 200);
    }

    
    public function destroy($id)
    {
        $cliente = Cliente::find($id);
        $status = '';
        $msj = '';

        if ($cliente) {
            $pedido = Pedido::where('cliente_id', $cliente->id)->get();
            if (count($pedido) > 0) {
                $status = 'tiene_pedidos';
                $msj = 'No se puede eliminar debido a que tiene pedidos realizados.';
            }else{
                $cliente->delete();
                $status = 'confirmado';
                $msj = 'Eliminado correctamente';
            }
        }


         

        return response()->json(['status' => $status, 'msj' => $msj], 200);
        
    }
}
