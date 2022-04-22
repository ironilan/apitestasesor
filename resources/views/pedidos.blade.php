@extends('layouts.principal')

@section('contenido')
<div class="container">
    <h1 class="mt-4 mb-4 text-center">Pedidos</h1>
    <div id="app_tabla">
        <div>
        	<a class="btn btn-success" href="{{ url('api/pedidos') }}">Ver json de pedidos</a>
        </div>
    </div>
   
</div> 

@endsection

@section('js')

	


@endsection