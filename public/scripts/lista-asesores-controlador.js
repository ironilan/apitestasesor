'use strict';
const tbody = document.querySelector('#tbl-asesores tbody');
let mostrar_datos = async() => {
    let asesores = await listar_productos();
    tbody.innerHTML = '';
    for (let i = 0; i < asesores.length; i++) {
        let fila = tbody.insertRow();
        fila.insertCell().innerHTML = asesores[i]['id'];
        fila.insertCell().innerHTML = asesores[i]['nombre'];
        fila.insertCell().innerHTML = asesores[i]['codigo'];
        fila.insertCell().innerHTML = `
            <button class="btn btn-info" onclick="editar(${asesores[i]['id']})">Editar</button>
            <button class="btn btn-danger" onclick="eliminar(${asesores[i]['id']})">Eliminar</button>
        `;
    }


};
mostrar_datos();



