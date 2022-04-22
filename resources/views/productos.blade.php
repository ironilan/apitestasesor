@extends('layouts.principal')

@section('contenido')
<div class="container">
    <h1 class="mt-4 mb-4 text-center">Módulos de Productos</h1>
    <div id="app_tabla">
        <button class="btn btn-success" onclick="crear()">Crear producto</button>
        <div class="row">
            <table id="tbl-asesores" class="tabla-informacion table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    

                </tbody>
            </table>           
        </div>
    </div>
    <div id="app_crear" style="display: none;">
        <h1>crear <button class="btn btn-default" onclick="mostrar_datos();">Volver</button></h1>
        <div class="row">
            <div class="col-6">
                <form id="formCrear">
                    <div class="form-group mb-2">
                        <input type="text" class="form-control" name="nombre" placeholder="Nombre">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" class="form-control" name="tipo" placeholder="tipo">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" class="form-control" name="precio" placeholder="precio">
                    </div>
                    <div class="boton mb-2">
                        <button class="btn btn-primary">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="app_editar" style="display: none;">
        <h1>Editar <button class="btn btn-default" onclick="mostrar_datos();">Volver</button></h1>
        <div class="row">
            <div class="col-6">
                <form id="formActualizar">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group mb-2">
                        <input type="text" class="form-control" name="nombre" placeholder="Nombre" id="nombre">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" class="form-control" name="tipo" placeholder="tipo" id="tipo">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" class="form-control" name="precio" placeholder="precio" id="precio">
                    </div>
                    <div class="boton mb-2">
                        <button class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 

@endsection

@section('js')



<script>
    let mostrar_datos = async () => {
        let asesores;
        await axios({
            method: 'get',
            url: 'http://localhost:3000/api/productos',
            responseType: 'json'
        }).then(function(res) {
            asesores = res.data;

            const tbody = document.querySelector('#tbl-asesores tbody');
            tbody.innerHTML = '';
            for (let i = 0; i < asesores.length; i++) {
                let fila = tbody.insertRow();
                fila.insertCell().innerHTML = asesores[i]['id'];
                fila.insertCell().innerHTML = asesores[i]['tipo'];
                fila.insertCell().innerHTML = asesores[i]['nombre'];
                fila.insertCell().innerHTML = asesores[i]['precio'];
                fila.insertCell().innerHTML = `
                    <button class="btn btn-info" onclick="editar(${asesores[i]['id']})">Editar</button>
                    <button class="btn btn-danger" onclick="eliminar(${asesores[i]['id']})">Eliminar</button>
                `;
            }

            mostrarOcultarForm('lista');
        })
        .catch(function(err) {
            console.log(err);
        });
        
    }


    let mostrarOcultarForm = (tipo) => {
        switch (tipo) {
            case 'lista':
            document.querySelector('#app_tabla').style.display = 'block';
            document.querySelector('#app_crear').style.display = 'none';
            document.querySelector('#app_editar').style.display = 'none';
            break;

            case 'crear':
            document.querySelector('#app_tabla').style.display = 'none';
            document.querySelector('#app_crear').style.display = 'block';
            document.querySelector('#app_editar').style.display = 'none';
            break;

            case 'editar':
            document.querySelector('#app_tabla').style.display = 'none';
            document.querySelector('#app_crear').style.display = 'none';
            document.querySelector('#app_editar').style.display = 'block';
            break;
            default:
            document.querySelector('#app_tabla').style.display = 'block';
            document.querySelector('#app_crear').style.display = 'none';
            document.querySelector('#app_editar').style.display = 'none';
            break;
            }
    }


    let editar = (id) => {
        mostrarOcultarForm('editar');

        axios({
            url: `http://localhost:3000/api/productos/${id}`,
            method: "GET",
            headers: {
                "Content-Type": `application/json`,
            },
        })
        .then(function (response) {
            //todo ha ido bien
            $('#nombre').val(response.data.nombre);
            $('#tipo').val(response.data.tipo);
            $('#precio').val(response.data.precio);
            $('#id').val(response.data.id);
          })
          .catch(function (response) {
            //error
            console.log(response);
          });
    }


    let crear = () => {
        mostrarOcultarForm('crear');
        $('.form-control').val('');
    }


    //crear asesores
    $('#formCrear').submit(function(e){
        e.preventDefault();
        
        
        let data = new FormData(document.getElementById("formCrear"));
        
        
        axios({
            url: `http://localhost:3000/api/productos`,
            method: "POST",
            data: data,
            headers: {
                "Content-Type": `application/json`,
            },
        })
        .then(function (response) {
            //todo ha ido bien
            mostrar_datos();
          })
          .catch(function (response) {
            //error
            console.log(response);
          });
    });

    //crear asesores
    $('#formActualizar').submit(function(e){
        e.preventDefault();
        
        
        let data = {
            'nombre' : $('#nombre').val(),
            'tipo' : $('#tipo').val(),
            'precio' : $('#precio').val()
        };
        let id = $('#id').val();


        //console.log(data);
        
        axios({
            url: `http://localhost:3000/api/productos/${id}`,
            method: "PUT",
            data: data,
            headers: {
                "Content-Type": `application/json`,
            },
        })
        .then(function (response) {
            //todo ha ido bien
            mostrar_datos();
          })
          .catch(function (response) {
            //error
            console.log(response);
          });
    });


    let eliminar = id => {
        Swal.fire({
          title: '¿Estas seguro?',
          text: "Se eliminará tu registro",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, confirmar'
        }).then((result) => {
            axios({
                method: 'DELETE',
                url: `http://localhost:3000/api/productos/${id}`,
                responseType: 'json'
            }).then(function(res) {
                //console.log(res.data);
                if (res.data.status == 'confirmado') {
                    Swal.fire(
                      'Eliminado!',
                      'Se ha eliminado con éxito',
                      'success'
                    )
                }else{
                    Swal.fire(
                      'Opps!',
                      res.data.msj,
                      'success'
                    )
                }

                mostrar_datos();
            })
            .catch(function(err) {
                console.log(err);
            });
            
        })
    }

    $(document).ready(function(){
        mostrar_datos();

    });

</script>

@endsection