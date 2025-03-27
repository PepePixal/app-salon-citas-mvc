<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Formunario para nueva Cuenta</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php" 
?>

<form class="formulario" method="POST" action="/crear-cuenta">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <!-- en value imprime el valor del atributo nombre sanitizado con s -->
        <input type="text" id="nombre" placeholder="Tu nombre" name="nombre"
            value= "<?php echo s($usuario->nombre); ?>" 
        />
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" placeholder="Tu apellido" name="apellido"
            value= "<?php echo s($usuario->apellido); ?>"
        />
    </div>
    <div class="campo">
        <label for="telefono">Teléfono</label>
        <input type="tel" id="telefono" placeholder="Tu teléfono" name="telefono"
            value= "<?php echo s($usuario->telefono); ?>"
        />
    </div>
    <div class="campo">
        <label for="email">E-mail</label>
        <input type="email" id="email" placeholder="Tu email" name="email"
            value= "<?php echo s($usuario->email); ?>"
        />
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu password" name="password">
    </div>

    <input type="submit" class="boton" value="Crear Cuenta">
    
</form>

<div class="acciones">
    <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
    <a href="/olvide">¿Olvidé mi password?</a>
</div>