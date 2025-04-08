<?php
namespace Controllers;

use MVC\Router;

class ServicioController {

    public static function index(Router $router) {
        //abre sesión para obtener los datos de la $_SESSION
        session_start();

        //llama método render() class router, enviando archivo vista y arreglo con info
        $router->render('/servicios/index', [
            'nombre' => $_SESSION['nombre'] ?? '',
        ]);
    }

    public static function crear(Router $router) { 
        //abre sesión para obtener los datos de la $_SESSION
        session_start();

        //si el tipo de solicitud HTTP al servidor es tipo POST
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }

        //llama método render() class router, enviando archivo vista y arreglo con info
        $router->render('/servicios/crear', [
            'nombre' => $_SESSION['nombre'] ?? '',
        ]);

    }
    
    public static function actualizar(Router $router) {  
        //si el tipo de solicitud HTTP al servidor es tipo POST
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }

        //llama método render() de la class router, enviando archivo vista y arreglo con info
        $router->render('/servicios/actualizar', [
            'nombre' => $_SESSION['nombre'] ?? '',
        ]);
    }
    
    public static function eliminar(Router $router) {  
        //si el tipo de solicitud HTTP al servidor es tipo POST
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }
    }
}