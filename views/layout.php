<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Salón</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="/build/css/app.css">
</head>
<body>
    <div class="contenedor-app">
        <div class="imagen"></div>
        <div class="app">
            <?php echo $contenido; ?>
        </div>
    </div>

    <!-- importa script, imprimiendo con php, el valor de la variable $script,
    y si no hay ningún valor en la var $script ??, imprime '', no importa nada y no da error -->
    <!-- El valor de la var $script, vendrá en el archivo recibido en $contenido,
     esto permite importar en layout.php, diferentes scripts, según el archivo recibido -->
    <?php
        echo $script ?? '';
    ?>

</body>
</html>