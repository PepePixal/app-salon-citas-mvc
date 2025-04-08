<!-- la var $nombre la estamos pasando desde render() de CitaController.php -->
<div class="barra">
    <p>Hola: <?php echo $nombre ?? '';?> </p>
    <a class="boton" href="/logout">Cerrar Sesión</a>
</div>

<!-- Verifica si es usuario tipo admin para mostrar el menú de administrador-->
<?php
//la funcion php isset() determina si el arreglo $_SESSION en su clave 'admin',
//tiene una variable declarada y es diferente de null, entonces retorna true
if (isset($_SESSION['admin']) ) {
?>

    <div class="barra-servicios">
        <a class="boton" href="/admin">Ver Citas</a>
        <a class="boton" href="/servicios">Ver Servicios</a>
        <a class="boton" href="/servicios/crear">Nuevo Servicio</a>
    </div>

<?php
};
?>