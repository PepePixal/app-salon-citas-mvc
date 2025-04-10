<?php

//$_ENV es la variable global de las variables de entorno .env
$db = mysqli_connect(
    $_ENV['DB_HOST'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
    $_ENV['DB_NAME'],
);

//para que la db acepte carácteres tipo ñ (utf8)
$db->set_charset('utf8');

if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "error de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
