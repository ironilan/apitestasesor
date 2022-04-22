<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asesor;
use App\Models\AsesorCliente;
use App\Models\Cliente;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{


    public function index()
    {
        $data = [];
        $asesores = Asesor::all();

        foreach ($asesores as $key => $asesor) {
            $clientes = $asesor->clientes;
            $total_pedidos = 0;
            $customers = [];
            $productos = [];
            $pedidos = [];
            $detalles = [];
            //pedidos
            foreach ($clientes as $key => $cliente) {
                $cantPedido = Pedido::where('cliente_id', $cliente->id)->sum('total_pedidos');                
                $total_pedidos = $total_pedidos + $cantPedido;

               

                foreach ($cliente->pedidos as $key => $ped) {
                    $detalle_all = $ped->detallepedidos;

                    foreach ($detalle_all as $key => $detalle) {

                        $producto = [
                            'id_producto' => $detalle->producto->id,
                            'tipo' => $detalle->producto->tipo,
                            'cantidad' => $detalle->cantidad,
                            'valor_unitario' => $detalle->precio,
                            'total' => $detalle->cantidad * $detalle->precio,
                        ];

                        array_push($productos, $producto);
                    }


                    $pedido = [
                        'id_pedido' => $ped->id,
                        'total_productos' => $ped->detallepedidos->sum('cantidad'),
                        'total_pedido' => $ped->total,
                        'estado' => $ped->estado,
                        'fecha_pago' => $ped->fecha_pago,
                        'productos' => $productos
                    ];

                    array_push($pedidos, $pedido);
                }

                $customer = [
                    'id_cliente' => $cliente->id,
                    'total_pedidos' => count($pedidos),
                    'name' => $cliente->nombre,
                    'detalle_pedidos' => $pedidos
                ];


                array_push($customers, $customer);
            }

            $dato = [
                'codigo_asesor' => $asesor->codigo,
                'name' => $asesor->nombre,
                'clientes_asignados' => count($clientes),
                'total_pedidos' => $total_pedidos,
                'clientes' => $customers
            ];


            array_push($data, $dato);
        }

        return response()->json($data,200);
    }
     
    public function indexqq()
    {
        $pedidos = [];
        $pedidos_all = Pedido::latest('id')->get();





        foreach ($pedidos_all as $key => $ped) {
            $cliente = Cliente::find($ped->cliente->id);
            $asesorCliente = AsesorCliente::where('cliente_id', $cliente->id)->get()->last();
            
            if ($asesorCliente) {
                $asesor = Asesor::find($asesorCliente->asesor_id);

                $pedido = [
                    'codigo_asesor' => $asesor->codigo,
                    'cliente' => $ped->cliente->nombre,
                    'pedido' => [
                        'pedido_id' => $ped->id,
                        'total' => $ped->total,
                        'total_pedidos' => $ped->total_pedidos,
                        'fecha_pago' => $ped->fecha_pago,
                        'estado' => $ped->estado,
                        'detalle_pedido' => $ped->detallepedidos
                    ],
                ];


                array_push($pedidos, $pedido);
            }

            
        }


        return response()->json($pedidos,200);
    }
}
