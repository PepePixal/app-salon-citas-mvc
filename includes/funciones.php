<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

//Función para revisar qeu el usuario este autenticado.
//En el LoginController, tenemos $_SESSION['login'] = true;
//Definimos función isAuth() : void .. que no retorna nada
function isAuth() : void {
    //vilidamos, si $_SESSION['login'] NO ! está definida o NO es diferente a null
    //significa que no se ha iniciado sesión
    if(!isset($_SESSION['login'])) {
        //redirigimos al inicio raiz
        header('Location: /');
    }
}

