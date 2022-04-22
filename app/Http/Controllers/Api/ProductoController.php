<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Detallepedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::latest('id')->get();

        return response()->json($productos, 200);
    }


    public function store(Request $request)
    {

        //  return $request->all();
        $producto = Validator::make($request->all(), [
            'tipo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'precio' => 'required',
        ]);

        if($producto->fails()){
            return response()->json($producto->errors()->toJson(), 400);
        }


        Producto::create([
            'tipo' => $request->tipo,
            'precio' => $request->precio,
            'nombre' => $request->nombre
        ]);

        return response()->json(['status' => true, 'message' => 'Se ha creado con éxito!'], 200);
    }

    
    public function show($id)
    {

        $producto = Producto::find($id);        

        if ($producto) {           

            return response()->json($producto, 200);
        }

        return response()->json(['status' => false, 'message' => 'No existe un producto con ese id.'], 400);
    }

    
    
    public function update(Request $request, $id)
    {

        //return $request->all();
        $producto = Validator::make($request->all(), [
            'tipo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'precio' => 'required',
        ]);

        if($producto->fails()){
            return response()->json($producto->errors()->toJson(), 400);
        }

        $producto = Producto::find($id);
        //return $producto;
        if (!$producto) {
            return response()->json(['status' => true, 'message' => 'No se ha encontrado el producto'], 400);
        }

        $producto->tipo = $request->tipo;
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->save();

        

        return response()->json(['status' => true, 'message' => 'Se ha actualizado con éxito!'], 200);
    }

    
    public function destroy($id)
    {
        $producto = Producto::find($id);
        $status = '';
        $msj = '';

        if ($producto) {
            $pedido = Detallepedido::where('producto_id', $producto->id)->get();
            if (count($pedido) > 0) {
                $status = 'tiene_pedidos';
                $msj = 'No se puede eliminar se encuentra registrado en un pedido.';
            }else{
                $producto->delete();
                $status = 'confirmado';
                $msj = 'Eliminado correctamente';
            }
        }


         

        return response()->json(['status' => $status, 'msj' => $msj], 200);
        
    }
}
