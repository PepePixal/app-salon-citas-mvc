<?php

$db = mysqli_connect('localhost', 'root', 'root', 'appsalon_mvc');

//para que la db acepte carácteres tipo ñ (utf8)
$db->set_charset('utf8');



if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "error de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
