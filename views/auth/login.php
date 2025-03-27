<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>

<!-- inserta la vista de alertas, si las hay -->
<?php 
    include_once __DIR__ . "/../templates/alertas.php" 
?>

<form class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu Email" name="email" 
            value="<?php echo $auth->email ?>"
        />
    </div>
    <div class="campo">
        <label for="password">Poassword</label>
        <input type="password" id="password" placeholder="Tu password" name="password">
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión">
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿No tienes cuenta? Crear nueva</a>
    <a href="/olvide">¿Olvidé mi password?</a>
</div>