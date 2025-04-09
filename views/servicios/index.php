<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Administración de Servicios</p>

<?php
    include_once __DIR__ . '/../templates/barra.php';
?>

<ul class="servicios">
    <?php
    //itera el arreglo $servicios y por cada $servicio..
    foreach($servicios as $servicio) {
    ?>
        <li>
            <p>Nombre: <span><?php echo $servicio->nombre; ?> </span> </p>
            <p>Precio: <span><?php echo $servicio->precio; ?> € </span> </p>

            <div class="acciones">
                <!-- enlace actualizar enviando en la url el id del servicio -->
                <a class="boton" href="/servicios/actualizar?id=<?php echo $servicio->id; ?>">Actualizar</a>
            
                <!-- form para eliminar vía POST -->
                <form action="/servicios/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $servicio->id; ?>" >
                    <input type="submit" value="Borrar" class="boton-eliminar"> 
                </form>

            </div>
        </li>
    <?php
    }
    ?>
</ul>