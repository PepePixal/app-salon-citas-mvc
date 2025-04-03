<?php

// pronombre auto, único para nuestra class
namespace Controllers;
//importa class Router, permite no usar MVC\
use MVC\Router;

class CitaController {
    //instancia de Router para tener acceso a sus métodos,
    //sin tener que crear una nueva instancia de Router.
    public static function index (Router $router) {

        //estamos en una sección privada donde el usuario se ha logueado,
        //podemos iniciar sesion, para obtener datos del usuario, en $_SESSION
        session_start();

        //llama método que comprueba si el usuario está autenticado,
        //si no está autenticado, lo redirecciona al inicio raiz
        isAuth();

        //llama met render() vistas, enviando vista y arreglo asoc.
        $router->render('cita/index', [
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id']
        ]);
    }

}

?>