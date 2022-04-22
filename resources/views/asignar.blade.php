@extends('layouts.principal')

@section('contenido')
<div class="container">
    <h1 class="mt-4 mb-4 text-center">Asesores</h1>
    <div id="app_tabla">
        <div class="row">
            <table id="tbl-asesores" class="tabla-informacion table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Código</th>
                        <th scope="col">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    

                </tbody>
            </table>           
        </div>
    </div>
   
    <div id="app_editar" style="display: none;">
        <h1>Asignacion de clientes <button class="btn btn-default" onclick="mostrar_datos();">Volver</button></h1>
        <hr>
        <div class="row">
            <div class="col-6">
                <form id="formActualizar">
                    <input type="hidden" name="id" id="idasesor">
                    <div class="form-group mb-2">
                        <h3>Clientes asignados</h3>
                       <div id="listaClientesAsignados"></div>
                    </div>
                    <div class="form-group mt-2" >
                       <h3>Lista de clientes</h3>
                       <div id="listaClientes"></div>
                    </div>
                    <div class="boton mt-4">
                        <button class="btn btn-primary">Asignar</button>
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
            url: 'http://localhost:3000/api/asesores',
            responseType: 'json'
        }).then(function(res) {
            asesores = res.data;

            const tbody = document.querySelector('#tbl-asesores tbody');
            tbody.innerHTML = '';
            for (let i = 0; i < asesores.length; i++) {
                let fila = tbody.insertRow();
                fila.insertCell().innerHTML = asesores[i]['id'];
                fila.insertCell().innerHTML = asesores[i]['nombre'];
                fila.insertCell().innerHTML = asesores[i]['codigo'];
                fila.insertCell().innerHTML = `
                    <button class="btn btn-success" onclick="editar(${asesores[i]['id']})">Asignar clientes</button>
                `;
            }

            mostrarOcultarForm('lista');
        })
        .catch(function(err) {
            console.log(err);
        });
        
    }



    let lista_clientes_asignados =  (idasesor) => {
        
        axios({
            method: 'get',
            url: `http://localhost:3000/api/clientes_asignados/${idasesor}`,
            responseType: 'json'
        }).then(function(res) {
            console.log(res);
            let clientes = res.data;
            const listClientes = document.querySelector('#listaClientesAsignados');
            listClientes.innerHTML = '';

            for (let i = 0; i < clientes.length; i++) {
                listClientes.innerHTML += `<label> ${clientes[i]['nombre']}</label><br>`;
            }
        })
        .catch(function(err) {
            console.log(err);
        });
        
    }


    let lista_clientes_por_asignar =  () => {
        
        axios({
            method: 'get',
            url: `http://localhost:3000/api/clientes`,
            responseType: 'json'
        }).then(function(res) {
            console.log(res);
            let clientes = res.data;
            const listClientes = document.querySelector('#listaClientes');
            listClientes.innerHTML = '';

            for (let i = 0; i < clientes.length; i++) {
                listClientes.innerHTML += `<label><input type="checkbox" name="cliente[]" value="${clientes[i]['id']}" value="${clientes[i]['id']}"> ${clientes[i]['nombre']}</label><br>`;
            }
        })
        .catch(function(err) {
            console.log(err);
        });
        
    }


    let mostrarOcultarForm = (tipo) => {
        switch (tipo) {
            case 'lista':
            document.querySelector('#app_tabla').style.display = 'block';
            //document.querySelector('#app_crear').style.display = 'none';
            document.querySelector('#app_editar').style.display = 'none';
            break;

            

            case 'editar':
            document.querySelector('#app_tabla').style.display = 'none';
            //document.querySelector('#app_crear').style.display = 'none';
            document.querySelector('#app_editar').style.display = 'block';
            break;
            default:
            document.querySelector('#app_tabla').style.display = 'block';
            //document.querySelector('#app_crear').style.display = 'none';
            document.querySelector('#app_editar').style.display = 'none';
            break;
            }
    }



    let editar = (id) => {
        mostrarOcultarForm('editar');

        $('#idasesor').val(id);

        lista_clientes_asignados(id);

        lista_clientes_por_asignar();
    }



    //asignar clientes al asesor
    $('#formActualizar').submit(function(e){
        e.preventDefault();
        
        
        let data = new FormData(document.getElementById("formActualizar"));
        
        axios({
            url: `http://localhost:3000/api/asignar_clientes`,
            method: "POST",
            data: data,
            headers: {
                "Content-Type": `application/json`,
            },
        })
        .then(function (response) {
            Swal.fire(
              'Asignado!',
              'Se ha asignado con éxito',
              'success'
            );
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
                url: `http://localhost:3000/api/asesores/${id}`,
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