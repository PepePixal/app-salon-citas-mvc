<?php

//Nuestra API para consultar los servicios de la DB

// pronombre auto, único para nuestra class
namespace Controllers;
//importa class, permitiendo no usar MVC\
use Model\Cita;
use Model\Servicio;
use Model\CitaServicio;


class APIController {
    //Consulta a la DB y retorna la info como JSON
    public static function index() {
        //all() retorna un arreglo de ogjetos con todos los servicios de la tabla servicios
        $servicios = Servicio::all();
        //la función de php json_encode(), convierte el arreglo de objetos en un formato JSON,
        //que podrá ser consultado diréctamente con JavaScript
        echo json_encode($servicios);
    }

    //método para guardar la información en las tablas citas y citasservicios de la DB
    public static function guardar() {

        //** Almacena la cita en la tab citas y retorna el id de la cita...

        //Instancia de la class Modelo Cita(), enviando $_POST (generada por el método POST).
        //El nuevo objeto cita tomará los datos id:null, fecha, hora y usuarioId de $_POST,
        //y se asigna el objeto a $cita
        $cita = new Cita($_POST);

        //llama al método guardar(), de Model AcitiveRecord, que guardará la info en la tabla citas,
        //el método crear retorna, el id (cita) y el resultado, que asignamos a $resultado
        $resultado = $cita->guardar();

        //asigna a $id el id de la cita que rotorna guardar() en el arreglo $resultado
        $id = $resultado['id'];

        //** ........FIN */

        //** Almacena el id de la cita y los id de los servicios en la tabla citasservicios....
        //Los id de idServicios, en $_POST['servicios'] tiene formato de String 
        //separados por comas {"servicios":"1,2"}, explode() separa cada string según 
        //el seprardor indicado ",", retornando un arreglo {"servicios":["1","2"]} y lo asigna a $idServicios
        $idServicios = explode(",", $_POST['servicios']);

        //itera el arreglo $idServicios y por cada id $idSercicio..
        foreach ($idServicios as $idServicio) {
            //en cada itereción:
            //crea el arreglo asoc $args, con el id de la cita en $id y
            //el propio id del servicio en $idServicio
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];
            //en cada itereción:
            //nueva instancia del modelo CitaServicio, enviando argumento $args,
            //retorna un nuevo objeto con id=null, citaId y servicioId 
            $citaServicio = new CitaServicio($args);
            //en cada itereción:
            //metodo guardar() para crear un nuevo registro en la tabla citasservicios
            $citaServicio->guardar();
        };
        //** .....FIN */

        //Retornamos resultado JSON.
        //La función de php json_encode(), transforma el arreglo asoc con la info de $resultado,
        //a formato JSON y lo retorna al app.js JavaScript
        //echo json_encode(['resultado' => $resultado]);
        echo json_encode($resultado);
    }

    public static function eliminar() {
        //valida que estamos usando un método POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //obtinene el id de la cita, de la super global $_POST
            $id = $_POST['id'];

            //debuguear($id);

            //llama método find() que buscar por id, 
            //basado en modelo de la clase Cita que extiende de ActiveRecord 
            $cita = Cita::find($id);

            //llama método eliminar de Active Record
            $cita->eliminar();

            //redirige a la página actual donde se encuentra el usuario,
            //la url se obtiene de $_SERVER['HTTP_REFERER']
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}