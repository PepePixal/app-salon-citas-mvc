<h1 class="nombre-pagina">Crear Nueva Cita</h1>

<!-- Inserta el contenedor con el nombre de usuario y Cerrar Sesión -->
<?php  
    include_once __DIR__ . '/../templates/barra.php';
?>

<p class="descripcion-pagina">Selecciona tus servicos y coloca tus datos</p>
<div id="app">
    <!-- navegacion con atributo personalizado data-paso -->
    <nav class="tabs">
        <button type="button" data-paso="1" class="actual">Servicios</button>
        <button type="button" data-paso="2">Información Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>

    <div id=paso-1 class="seccion">
        <h3>Servicios</h3>
        <p class="text-center">Selecciona los servicios</p>
        <!-- en este div se inyectará el div generado por el método mostrarServicios() de app.js -->
        <div id="servicios" class="listado-servicios"></div>
    </div>

    <!-- div ocultado,por defecto, en la hoja de stilo _cita.scss, .seccion  -->
    <div id=paso-2 class="seccion">
        <h3>Datos y Cita</h3>
        <p class="text-center">Rellena tus datos y fecha de tu cita</p>

        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input
                    id="nombre" 
                    type="text" 
                    placeholder="Tu Nombre"
                    value="<?php echo $nombre?>"
                    disabled
                />
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <!-- con min=, ponemos la fécha actual, obtenida con php, como fecha mínima seleccionable -->
                <!-- si queremos agregar un día a la fecha actual, agrega:  ,strtotime('+1 day');  -->
                <input
                    id="fecha"
                    type="date"
                    min="<?php echo date('Y-m-d'); ?>"

                />
            </div>
            <div class="campo">
                <label for="hora">Hora</label>
                <input 
                    id="hora"
                    type="time">
            </div>

            <!-- input typo oculto para poder obtener el id del usuario desde el $_POST -->
            <input type="hidden" id="id" value="<?php echo $id; ?>" >
        </form>
        
    </div>

    <!-- div ocultado,por defecto, en la hoja de stilo _cita.scss, .seccion  -->
    <div id="paso-3" class="seccion contenido-resumen">
        <h3>Resumen</h3>
        <p class="text-center">Verifica que la información es correcta</p>
    </div>

    <!-- &laquo; (lef) y &raquo; (right) imprimen dobles flechas de los botones -->
    <div class="paginacion">
        <button id="anterior" class="boton">&laquo; Anterior</button>
        <button id="siguiente" class="boton">Siguiente &raquo;</button>
    </div>

</div>

<!-- instrucción de importacion de scripts, que se imprimiran en el html de layout.php,
cuando reciba esta vista index.php como contenido en $contenido -->
<?php

        //script para la ventana de aviso, personalizada, de "cita ragistrada (en app.js),
        //comprobar el script sweetalert2, en la consola del navegador ejecuta swal (objeto).
        //script para app.js
    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
    ";

?>