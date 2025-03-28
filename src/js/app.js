//var paso para los botones del menu de citas
let paso = 1;
//vars de paso para los botones de paginación de citas
const pasoInicial = 1;
const pasoFinal = 3

//Variable tipo objeto para cita. Los objetos en js
//se pueden reescribir aunque esten declarados con const.
const cita = {
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

//cuando todo el DOM esté ya cargado, se ejecuta la función
document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
});

//definición de la funcion
function iniciarApp(){
    //muestra la sección inicial, tomando el valor de la 
    //variable paso, inicializada a 1, antes de pulsar los botones.
    mostrarSeccion();
    //Cambia la sección, cuando se presionen los botones (tabs)
    tabs(); 
    //agrega y quita los botones del paginador
    botonesPaginador();
    //muestra pagina siguiente con el botón paginador
    paginaSiguiente();
    //muestra pagina anterior con el botón paginador
    paginaAnterior();
    
    //consulta la API en el backend de PHP
    consultarAPI();

    //Agrega el nombre del clinte al atributo del objeto cita
    nombreCliente();
    //Agrega la fecha de la cita al atributo del objeto cita
    seleccionarFecha();
    //Agrega la hora de la cita al atributo del objeto cita
    seleccionarHora();

    //Mostrar resumen de información antes de enviar la cita
    mostrarResumen();
}

//funcion para mostrar la sección y resaltar el botón, según el botón pulsado
function mostrarSeccion() {

    //Antes de mostrar la sección, olcultar la sección que ya tenga la clase '.mostrar'.
    //Seleciona la sección que ya tenga la clase 'mostrar'
    const seccionAnterior = document.querySelector('.mostrar');
    //si se ha encontrado alguna sección con la clase '.mostrar':
    if(seccionAnterior) {
        //elimina la clase 'mostrar' de la sección, para que no se muestre 
        seccionAnterior.classList.remove('mostrar');
    }

    //seleciona la sección, por su atributo id= (#paso-número en la var ${paso}
    const seccion = document.querySelector(`#paso-${paso}`);
    //agrega la clase 'mostrar', a las sección seleccionada
    seccion.classList.add('mostrar');


    //**Resaltar el botón (tab) de la sección que se etá mostrando:
    
    //primero, quitar la clase de 'actual' al tab si algún botón lo tiene
    const tabAnterior = document.querySelector('.actual');
    //si se ha encontrado algun botón con la clase 'actual':
    if(tabAnterior) {
        tabAnterior.classList.remove('actual');
    }

    //selecciona el atributo htm personalizado [data-paso], 
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    //asigna la clase 'actual' al boton (tab) seleccionado
    tab.classList.add('actual');

};


//funcion que identifica que botón (tab) se está pulsando
function tabs() {

    //asigna a botones, los elemetos html button, dentro de la class .tabs
    const botones = document.querySelectorAll('.tabs button');

    //no podemos asignar un evento a todos los botones,
    //pero como botones es de tipo nodelist, algo parecido a un arreglo,
    //podemos itererlo y asignarle un evento a cada botón
    botones.forEach( boton => {
        //asigna un listner de evento click a cada boton y ejecuta una function
        //enviando el evento en (e), que contiene la información cada evento click
        boton.addEventListener('click', function(e) {
            //en e.target.dataset.paso, está el valor del atributo html data-paso de cada boton,
            //el valor es tipo string, lo pasamos a tipo entero y lo asignamos a la var paso
            paso = parseInt( e.target.dataset.paso );
            //console.log(paso);
            //llama a la función mostrarSección en cada click de un botón
            mostrarSeccion();
            //llama funcion botonnesPaginador que meustran u ocultan los botones de paginación
            botonesPaginador();

        });
    });
}

//agrega y quita los botones del paginador
function botonesPaginador() {
    //selecciona los botones por su id
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    //si el valor de la var paso es = 1
    if(paso === 1) {
        //ocultar la vista del botón <<Anterior
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
        
    } else if (paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');

        //paso 3 corresponde al botón tab Resumen, lláma al método:
        mostrarResumen();
        
    } else if (paso ==2) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }

    //llama a la función 
    mostrarSeccion();
}

//muenstra pagina anterior con el botón paginador
function paginaAnterior() {
    //seleciona el botón por su id
    const paginaAnterior = document.querySelector('#anterior');
    //asigna un evento click al botón
    paginaAnterior.addEventListener('click', function() {
        if(paso <= pasoInicial) return;
        //resta 1 al valor de paso
        paso--;

        //llama a la función
        botonesPaginador();
    });
}

//muenstra pagina siguiente con el botón paginador
function paginaSiguiente() {
    //seleciona el botón por su id
    const paginaSiguiente = document.querySelector('#siguiente');
    //asigna un evento click al botón
    paginaSiguiente.addEventListener('click', function() {
        if(paso >= pasoFinal) return;
        //agraga 1 al valor de paso
        paso++;

        //llama a la función
        botonesPaginador();
    });
}


//función asíncrona con awaits para consultar la API de servicios, en el backend de PHP
async function consultarAPI() {

    //try chatch, ejecuta el código y si hay error lo captura,
    //sin parar el resto de código de la función.
    try {
        //url donde se encuentra la API
        const url = 'http://localhost:3000/api/servicios';
        //consulta a la API en la url, esperando (await) el resultado,
        const resultado = await fetch(url);
        // Entre toda la iformación retornada por fetch(), en Prototype está el método json(),
        //con el que obtendremos el JSON contenido en el resultado, de la petición fetch(),
        //como un arreglo indexado de objetos, que corresponden a los servicios.
        const servicios = await resultado.json();

        //llama a la función enviando servicios (arreglo indexado de objetos) 
        mostrarServicios(servicios);

    } catch (error) {
        console.log(error);
    }
}

//muestra los servicios consultados a la API, en la página citas
function mostrarServicios(servicios) {
    //recorre el arreglo de objetos servicios y a cada objeto servicio..
    servicios.forEach( servicio => {

        //destructuring, extrae las propiedades de cada objeto, en servicio,
        //convirtendolas en variables independientes, con sus valores
        const { id, nombre, precio } = servicio;

        //scripting de javascript:

        //crea un elemento html párrafo ('P') y lo asigna a la var
        const nombreServicio = document.createElement('P');
        //agrega una clase al párrafo nombreServicio, para dar estilos .scss
        nombreServicio.classList.add('nombre-servicio');
        
        nombreServicio.textContent = nombre;
        
        //crea un elemento html párrafo ('P') y lo asigna a la var
        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        //asigna el valor de la var precio, al contenido del párrafo html,
        //con template string para variable y signo €
        precioServicio.textContent = `${precio} €`;

        //crea un contenedor div html
        const servicioDiv = document.createElement('DIV');
        //agrega una clase al contenedor div
        servicioDiv.classList.add('servicio');
        //agrega un atributo personalizado data-id-servicio=
        //y le asigna el valor de la var id
        servicioDiv.dataset.idServicio = id;
        //console.log(servicioDiv)


        //agrega al contenedor div, los párrafos nombre y precio
        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);
        
        //inyecta el contenedor div servicioDiv,
        //en el div con id="servicios", del archivo views\cita\index.php
        document.querySelector('#servicios').appendChild(servicioDiv);
        
        //Asocia un evento click al contenedor div, que ejecuta una función
        //que llama al método seleccionarServicio() enviándole el servicio iterado,
        //como parametro tipo objeto.
        servicioDiv.onclick = function() {
            seleccionarServicio(servicio);
        }

        //* todo el proceso se repite por cada servicio del foreach 
    })
}

//función que se ejecuta por cada click en un contenedor div servcicio,
//recibido como parámetro el objeto servicio
function seleccionarServicio(servicio) {
    //destructuring, extrae la propiedad servicios (arreglo), del objeto cita,
    //convirtendo servicios en una variable, tipo arreglo
    const { servicios } = cita;
    //destructuring
    const { id } = servicio;

    //Identificar el elemento html que se ha seleccionado con el click.
    //Selecciona el elemento html (div), por su atributo personalizado data-id-servicio=,
    //cuyo valor sea igual al valor de lo que tenga la var destructurada id de servicio
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    //Comprobar si el servicio seleccionado ya estaba agregado en servicios de la cita.
    //Verifica si en el array servicios (de cita), existe ya agregado algún objeto, cuyo id
    // sea igual al valor de la variable id del servicio selecionado. Retorna true o false.
    if (servicios.some( agregado => agregado.id === id )) {
        //como el servicio seleccionado ya esta agregado a servicios, lo elimina con:
        //.filter() genera un nuevo arreglo servicios, filtrando solo los objetos agregados,
        //cuyos id no coincida (!==) con el id del servicio seleccionado 
        // y lo reasigna a la propiedad servicios del objeto cita
        cita.servicios = servicios.filter( agregado => agregado.id !== id );

        //elimina la clase 'seleccionado' al elemento html seleccionado en divServicio
        divServicio.classList.remove('seleccionado');  //para aplicar estilo .scss

    } else {
        //como el servicio seleccionado no está agregado a servicios, lo agrega con:
        //[...servicios, servicio] , ...toma una copia de lo que hay la var arreglo sevicios y
        //le agrega el nuevo objeto servicio recibido como argumento, el resultado lo reasigna
        //a la propiedad servicios del objeto cita.
        cita.servicios = [...servicios, servicio]

        //agrega la clase 'seleccionado' al elemento html seleccionado en divServicio
        divServicio.classList.add('seleccionado');  //para aplicar estilo .scss
    }

}

//obtine el nobre del cliente y lo agrega al atributo del objeto cita
function nombreCliente() {
    //selecciona, el atributo .value del elemento html cuyo atributo id (#) es 'nombre',
    //en el archivo /cita/index.php, desde donde se importa el script app.js
    // y asigna el value a la propiedad nombre del objeto cita
    cita.nombre = document.querySelector('#nombre').value;

    //console.log(cita.nombre);
}

//Obtiene y Agrega la fecha de la cita al atributo del objeto cita
function seleccionarFecha() { 

    //select el elemento html con id (#) fecha, en cita/index.php
    const inputFecha = document.querySelector('#fecha');
    //asigna un evento input, al input con id fecha, enviando el evento (e)
    inputFecha.addEventListener('input', function(e) {

        //nueva instancia del método Date(), enviando el valor del elemento que disparó el evento,
        //o sea, la fecha introducida en el input,
        //con .getUTCDay() obtenemos el número del día respecto a la semana (6 = sabado y 0 = domingo)
        const dia = new Date(e.target.value).getUTCDay();

        //filtra sábados (6) y domingos (0), para que no se puedan seleccionar en al cita
        if( [6, 0].includes(dia) ) {
            //asigna '', para que la fecha no quede seleccionada en el value
            e.target.value = ''
            //llama función, enviando 'mensaje', y 'tipo de mensaje'
            mostrarAlerta('Fines de semana no permitidos', 'error', '.formulario');
        }

        //obtiene el valor .value de la fecha introducida en el input
        // y la asigna a la propiedad fecha del objeto cita
        cita.fecha = inputFecha.value;
    });
}

//selecciona hora, acotando el horario
function seleccionarHora() {
    //select el elemento html con id (#) hora, en cita/index.php
    const inputHora = document.querySelector('#hora');
    //asigna un evento input, al input con id hora, enviando el evento (e)
    inputHora.addEventListener('input', function(e) {

        //obtenemos el valor del evento input (e), que es la hora y minutos
        const horaCita = e.target.value
        //.split(), separa los elementos de una cadena, según el separador que le indiquemos (:),
        //almacena los elementos en un arreglo indexado y [0] toma el valor del elemento del arreglo con indice 0 ,
        //que corresponde solo a la hora. (12:45 separa los elementos por : los guarda en un array y toma el 12)
        const hora = horaCita.split(":")[0];

        //si la hora seleccionada es menor que 10h o mayor que 18h, NO se puede
        if ( hora < 10 || hora > 17 ) {
            //asigna '', para que la hora no quede seleccionada en el value
            e.target.value = ''
            //llama función, enviando 'mensaje', y 'tipo de mensaje'
            mostrarAlerta('Horario de 10h a 18h', 'error', '.formulario' );
        } else {
            //asigna el valor de la hora seleccionada, al atributo hora del objeto cita
            cita.hora = e.target.value;
        }


    })

}

//Muestra alerta en la Crear Nueva Cita. Requiere argumentos,
// 'mensaje', 'tipo mensaje', 'elemento html donde mostrarse' y 
// 'desaparece' inicializado a true, por si no se recibe
function mostrarAlerta(mensaje, tipo, elemento, desaparece = true ) {

    //comprobar si se está mostrando una alerta previa,
    //probando a seleccionar algún elememto html que ya tenga la clase .alerta asignada
    const alertaPrevia = document.querySelector('.alerta');
    //si se ha podido seleccionar algún elemento html con la clase .alerta,
    //significa que ya se está mostrando una alerta, la eliminamos 
    if(alertaPrevia) {
        alertaPrevia.remove();
    };

    //crea elemento html div y lo asigna a alerta
    const alerta = document.createElement('DIV');
    //agrega el mensaje recibido en mensaje, al div
    alerta.textContent = mensaje;
    //agreta clase al div, para qestilo .scss
    alerta.classList.add('alerta');
    //agreta clase al div, recibida como param en tipo, para estilo .scss
    alerta.classList.add(tipo); 

    //selecciona elemento html con class igual al valor de elemento, recibido como argumento
    const referencia = document.querySelector(elemento);
    //inyecta el div alerta en el formulario, de cita/index.php
    referencia.appendChild(alerta);

    //si no se recibe el argumento desaparece, por defecto es true.
    //Si desaparece es true:
    if(desaparece) {
        //elimina la alerta pasdos 3 segundos
        setTimeout(() => {
            alerta.remove();
        }, 3000 );
    }
}

//Mostrar resumen de información antes de enviar la cita
function mostrarResumen() {

    //selecciona elemento html con class .contenido-resumen y lo asigna a resumen
    const resumen = document.querySelector('.contenido-resumen');

    //Primero limpiar el contenido que pueda tener el div .contenido-resumen.
    //Mientras el elemento html resumen (.contenido-resume) tenga un nodo hijo...
    while (resumen.firstChild) {
        //elimina de resumen el primer nodo hijo, enviado como argumento,
        //sucesivamente hasta eliminar todos los nodos hijos
        resumen.removeChild(resumen.firstChild);
    }

    //Comprobar si hay valores vacios '' en los propiedades del objeto cita o || si la propiedad
    //arreglo servicios está vacio, .length = 0 elementos.
    //El método para objetos Object.values( objeto_a_iterar), itera las propiedades del objeto,
    //retornando un arreglo indexado con los valores de las propiedades,
    //el método .includes(valor_a_buscar), comprueba si entre los valores se incluye el valor buscado
    if( Object.values(cita).includes('') || cita.servicios.length === 0 ) {
        //llama método enviando todos los argumentos.
        mostrarAlerta('Faltan Servicios, Fecha u Hora', 'error', '.contenido-resumen', false);
        //parar aquí el código, para no poner todo el código que falta en un else.
        return;
    } 

    //Cabecera para Resumen Servicios
    const headingServicios = document.createElement('H4');
    headingServicios.textContent = 'Resumen de Servicios';
    //Inyecta en el elemento html div .contenido-resumen, guardado en resumen
    resumen.appendChild(headingServicios);

    //En este punto del código ya tenmos información en todos los atributos del objeto cita,
    //Aplicamos destructuring para manipular los atributos como variables independientes,  
    //recordando que servicios es un arreglo indexado:
    const { nombre, fecha, hora, servicios } = cita;

    //La propiedad servicios es un arreglo indexado de objetos,
    //iteramos el arreglo y por cada objeto servicio:
    servicios.forEach( servicio => {
        //como cada servicio es un objeto, lo podemos destructurar
        const { id, precio, nombre } = servicio;
        //crea un div para cada servicio
        const contenedorServicio = document.createElement('DIV');
        //agrega clase al contenedor, para estilo .scss
        contenedorServicio.classList.add('contenedor-servicio');

        //crea un párrafo para cada servicio
        const textoServicio = document.createElement('P');
        //agrega el valor de la var destructurada al párrfo
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio: </span>${precio} €`;

        //agrega los párrafos al contenedor div
        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        //Inyecta en el elemento html div .contenido-resumen, guardado en resumen
        resumen.appendChild(contenedorServicio);
    });

    //Cabecera para Resumen Cita
    const headingCita = document.createElement('H4');
    headingCita.textContent = 'Resumen de Servicios y Cita';
    //Inyecta en el elemento html div .contenido-resumen, guardado en resumen
    resumen.appendChild(headingCita);

    //Crea elemento html párrfo P
    const nombreCliente = document.createElement('P');
    //Agrega contenido al párrafo, con template string `` texto y variable
    nombreCliente.innerHTML = `<span>Nombre: </span>${nombre}`;

    //** Formatear fecha español, antes de mostrar, COMPLICADO EXPLICAR
    //Solo cambia el aspecto, NO cambia el formato original del dato fecha para la DB.
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate();
    const year = fechaObj.getFullYear();
    const fechaUTC = new Date( Date.UTC(year, mes, dia));
    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'};
    const fechaFormateada = fechaUTC.toLocaleDateString('es-ES', opciones);
    //** FIN script fecha español... */

    //Crea elemento html párrfo P
    const fechaCita = document.createElement('P');
    //Agrega contenido html al párrafo, con la var fechaFormateada
    fechaCita.innerHTML = `<span>Fecha: </span>${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora: </span>${hora} horas`;

    //Inyecta en el elemento html div .contenido-resumen, guardado en resumen
    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);

}