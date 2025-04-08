//para no cargar de funciones una vez el DOMContendLoaded esté cargado,
//ponemos solo iniciarApp() y dentro de esta el resto de métodos
document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
});

function iniciarApp() {
    buscarPorFecha();
}

function buscarPorFecha () {
    //selecciona elemento html con id fecha
    const fechaInput = document.querySelector('#fecha');
    //asigna listener de evento input a fecha,
    //que ejecutara una función enviando el evento e
    fechaInput.addEventListener('input', function(e){
        //obtiene la fecha selecionada en el input,
        //del value del target del evento recibido en e
        const fechaSeleccionada = e.target.value;

        //redirige al ususario a la misma página actual,
        //pero enviando la fecha en la url (querystring),
        //para poder leerla en php en la super global $_GET
        window.location = `?fecha=${fechaSeleccionada}`;
    })
}


