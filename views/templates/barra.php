<!-- la var $nombre la estamos pasando desde render() de CitaController.php -->
<div class="barra">
    <p>Hola: <?php echo $nombre ?? '';?> </p>
    <a class="boton" href="/logout">Cerrar Sesión</a>
</div>