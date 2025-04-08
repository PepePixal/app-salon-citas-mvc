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

//comprueba si es el último servicio de la cita, 
function esUltimo(string $actual, string $proximo): bool {
    //si el valor de $actual de diferente al de $proximo,
    //siginifica que es el último servicio de la cita
    if( $actual !== $proximo ){
        return true;
    }
    return false;
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

//Función para comprobar si el ususario autenticado es tipo admin
function isAdmin(): void {
    //si el arreglo asoc $_SESSION en su atributo 'admin',
    //NO ! está declarado o es NO ! es diferente a null (es null)
    if(!isset($_SESSION['admin'])) {
        //redirige al usuario a la página inicial raiz
        header('Location: /');
    }
}

