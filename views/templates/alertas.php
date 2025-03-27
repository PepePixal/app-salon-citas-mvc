<?php
    //itera el arreglo alertas,
    //en cada iteración obtendrá el arreglo con $key error o exito, con su arreglo de mensajes 
    foreach( $alertas as $key => $mensajes):
        //en cada iteración obtendra cada mensaje del arreglo $key error o exito, iterado    
        foreach($mensajes as $mensaje):
?>
    <!-- por cada mensaje iterado, al div le agrega la clase alerta y 
     una clase con el nombre de la var $key error o exito -->
    <div class="alerta <?php echo $key; ?>"> 
        <!-- imprime cada mensaje iterado -->
        <?php echo $mensaje ?>
    </div> 
<?php
        endforeach;
    endforeach;

?>