'use strict';
let listar_productos = async() => {
    let asesores;
    await axios({
            method: 'get',
            url: 'http://localhost:3000/api/asesores',
            responseType: 'json'
        }).then(function(res) {
            asesores = res.data;
        })
        .catch(function(err) {
            console.log(err);
        });
    return asesores;
};


