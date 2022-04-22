<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function asesores()
    {
        return view('asesores');
    }


    public function clientes()
    {
        return view('clientes');
    }

    public function productos()
    {
        return view('productos');
    }

    public function asignar()
    {
        return view('asignar');
    }


    public function pedidos()
    {
        return view('pedidos');
    }
}
