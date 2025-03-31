<?php

//Nuestra API para consultar los servicios de la DB

// pronombre auto, único para nuestra class
namespace Controllers;
//importa class, permitiendo no usar MVC\
use Model\Servicio;
use Model\Cita;


class APIController {
    //Consulta a la DB y retorna la info como JSON
    public static function index() {
        //all() retorna un arreglo de ogjetos con todos los servicios de la tabla servicios
        $servicios = Servicio::all();
        //la función de php json_encode(), convierte el arreglo de objetos en un formato JSON,
        //que podrá ser consultado diréctamente con JavaScript
        echo json_encode($servicios);
    }

    //método para guardar la información en la tabla citas de la DB
    public static function guardar() {
     
        //intancia de la class Modelo Cita(), enviando $_POST, generada por el método POST.
        //el nuevo objeto cita solo tomará los datos id:null, fecha y hora, de $_POST,
        //faltará el usuarioID, para guradarlo todo en la tabla citas de la DB
        $cita = new Cita($_POST);

        //llama al método de Model AcitiveRecord para guardar la info en la tabla citas, 
        $resultado = $cita->guardar();
     
        //la función de php json_encode(), convierte el arreglo de objetos en un formato JSON,
        //que podrá ser consultado diréctamente con JavaScript
        echo json_encode($resultado);
        
    }
}