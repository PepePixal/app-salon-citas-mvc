<h1 class="nombre-pagina">Restablecer Password</h1>
<p class="descripcion-pagina">Introduce el nuevo Password</p>

<!-- inserta la vista de alertas, si las hay -->
<?php 
    include_once __DIR__ . "/../templates/alertas.php" 
?>
<!-- comprobar la var error enviada por render(), si e true, -->
<!-- el usuario token no existe en la db, parar para no mostrar el formulario -->
<?php if($error) return; ?>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu nueva Password" name="password">
    </div>
    
    <input type="submit" class="boton" value="Restablecer password">
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿No tienes cuenta? Crear nueva</a>
    <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
</div>