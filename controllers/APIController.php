<?php
// pronombre auto, único para nuestra class
namespace Controllers;
//importa class Router, permite no usar MVC\
use MVC\Router;
use Model\Servicio;


class APIController {
    public static function index() {
        //all() retorna un arreglo de ogjetos con todos los servicios de la tabla servicios
        $servicios = Servicio::all();
        //la función de php json_encode(), convierte el arreglo de objetos en un formato JSON,
        //que podrá ser consultado diréctamente con JavaScript
        echo json_encode($servicios);
    }
}