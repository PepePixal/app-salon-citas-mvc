<h1 class="nombre-pagina">Actualizar Servicio</h1>
<p class="descripcion-pagina">Actualiza los valores del formunario</p>

<?php
    include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<!-- no requerimos el action en el form de actualizar -->
<form method="POST" class="formulario">
    <?php
    include_once __DIR__ . '/formulario.php';
    ?>
    <input type="submit" class="boton" value="Actualizar Servicio">
</form>