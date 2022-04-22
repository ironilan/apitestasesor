@extends('layouts.principal')

@section('contenido')
<div class="container mt-4 mb-4">
        <h1 class="mt-4 mb-4 text-center">Módulos de administración</h1>
        <div class="row">
            <div class="col">
                <a href="{{ url('asesores') }}">
                    <div class="card text-white bg-primary mb-3" >
                        <div class="card-body">
                            <h5 class="card-title">Asesores</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="{{ url('clientes') }}">
                    <div class="card text-white bg-success mb-3" >
                        <div class="card-body">
                            <h5 class="card-title">Clientes</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="{{ url('productos') }}">
                    <div class="card text-white bg-warning mb-3" >
                        <div class="card-body">
                            <h5 class="card-title">Productos</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                    </div>                    
                </a> 
            </div>
            
        </div>
    </div> 

    <div class="container " style="margin-top: 5rem;">
        <h1 class="mt-4 mb-4 text-center">Módulos de asignación</h1>
        <div class="row">
            <div class="col">
                <a href="{{ url('asignar') }}">
                    <div class="card text-white bg-danger mb-3" >
                        <div class="card-body">
                            <h5 class="card-title">Asignar clientes al Asesor</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                    </div>
                </a> 
            </div>
            <div class="col">
                <a href="{{ url('pedidos') }}">
                    <div class="card text-white bg-info mb-3" >
                        <div class="card-body">
                            <h5 class="card-title">Pedidos</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                    </div>
                </a> 
            </div>
        </div>
    </div>

@endsection