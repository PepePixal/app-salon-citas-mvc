<div class="campo">
    <label for="nombre">Nombre</label>
    <input 
        type="text"
        id="nombre"
        placeholder="Nonbre Servico"
        name="nombre"
        value="<?php echo $servicio->nombre; ?>"
        />
        <!-- asigna a value el valor enviado en el render de ServicioController.php -->
    </div>
    
    <div class="campo">
        <label for="precio">Precio</label>
        <input 
        type="number"
        id="precio"
        placeholder="Precio Servico"
        name="precio"
        value="<?php echo $servicio->precio; ?>"
        />
        <!-- asigna a value el valor enviado por el render de ServicioController.php -->
</div>