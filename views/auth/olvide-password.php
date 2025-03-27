<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Tu email de usuario</p>

<!-- inserta la vista de alertas, si las hay -->
<?php 
    include_once __DIR__ . "/../templates/alertas.php" 
?>

<form class="formulario" method="POST" action="/olvide">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu Email" name="email">
    </div>
    
    <input type="submit" class="boton" value="Recuperar password">
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿No tienes cuenta? Crear nueva</a>
    <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
</div>