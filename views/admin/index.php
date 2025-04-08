<h1 class="nombre-pagina">Panel de Administración</h1>

<!-- Inserta el contenedor con el nombre de usuario y Cerrar Sesión -->
<?php  
    include_once __DIR__ . '/../templates/barra.php';
?>
<h4>Buscar Citas</h4>

<div id="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input
                type="date"
                id="fecha"
                name="fecha"
                value=<?php echo $fecha?>
            >
        </div>
    </form>
</div>

<?php 
    if(count($citas) === 0) {
        echo "<h4>No hay Citas en esta fecha</h4>";
    }
?>

<div class="citas-admin">
    <ul class="citas">
        <?php
            //definición de var
            $idCita = 0;
            //itera el arreglo indexado $citas y por cada elemento     
            //$key es la posición y $cita tiene el valor, de cada elemento iterado 
            foreach ($citas as $key => $cita ) {
                //filtra para mostrar solo una vez, los datos comunes de las citas con el mismo id
                if ($idCita !== $cita->id) {
                    //asigna a $idCita el id de la cita que esta iterando
                    $idCita = $cita->id;

                    //var $total (servicios) inicializa da a 0 para cada cita
                    $total = 0;
        ?>

                    <li>
                        <p>Cita: <span><?php echo $cita->id; ?></span></p>
                        <p>Hora: <span><?php echo $cita->hora; ?></span></p>
                        <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
                        <p>Email: <span><?php echo $cita->email; ?></span></p>
                        <p>Teléfono: <span><?php echo $cita->telefono; ?></span></p>
                    </li>
                    <p>Servicios:</p>

        <?php
                } //...fin if
                
                //sumatorio de los precios de los servicios, por cada servicio de la cita
                $total += $cita->precio;
        ?>
        
                <p class="servicio"> <?php echo "- " . $cita->servicio . " " . $cita->precio ."€"; ?> </p>
        
                <!-- Comprobar si es el último servicio de la cita, para la suma -->
                <?php
                    //asigna el id de la cita a $actual
                    $actual = $cita->id;
                    //obtiene el id del elemento en la posición $key + 1
                    $proximo = $citas[$key + 1]->id ?? 0;

                    //si el resultado que retorna el método es true
                    if (esUltimo($actual, $proximo)) { 
                ?>
                        <p class="total">Total Servicios: <span><?php echo $total ." €"; ?></span></p>

                        <!-- form eliminar la cita -->
                        <form action="/api/eliminar" method="POST">
                            <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                            <input type="submit" class="boton-eliminar" value="Eliminar">
                        </form>

            <?php
                    }
            } //...fin foreach
            ?>
    </ul>
</div>

<!-- instrucción de importacion de scripts, que se imprimira en el html de layout.php,
cuando reciba esta vista index.php como contenido en $contenido -->
<?php
    //js para el buscador de citas por fecha
    $script = "<script src='build/js/buscador.js'></script>"
?>