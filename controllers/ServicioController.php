<?php
namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController {

    public static function index(Router $router) {
        //abre sesión para obtener los datos de la $_SESSION
        session_start();

        isAdmin();

        //llama metodo static :: all() desde el modelo class Servicio,
        // que retornará todos los servicios encotrados en la tabla servicios
        $servicios = Servicio::all();

        //llama método render() class router, enviando archivo vista y arreglo con info
        $router->render('/servicios/index', [
            'nombre' => $_SESSION['nombre'] ?? '',
            'servicios' => $servicios
        ]);
    }

    public static function crear(Router $router) { 
        //abre sesión para obtener los datos de la $_SESSION
        session_start();

        isAdmin();

        //instancia la class Servicio del Model Servicio, que retorna un objeto vacio
        //y lo asigna a la var $servicio. Para poder enviar en el render()
        $servicio = new Servicio;
        //var para las alertas de validación del formulario
        $alertas = [];

        //si el tipo de solicitud HTTP al servidor es tipo POST
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //sincroniza el objeto vacio $servicio, con los datos del form enviados con POST,
            //POST genera la super global $_POST
            $servicio->sincronizar($_POST);

            //instancia al método validar() de la class Servicio, que validara
            //los elementos del objeto en $servicio y retornará arreglo alertas
            $alertas = $servicio->validar();

            //si no hay alertas de error
            if (empty($alertas)) {
                //llama al método guardar();
                $servicio->guardar();
                //redirige al usuario
                header('Location: /servicios');
            }

        }

        //llama método render() class router, enviando archivo vista y arreglo con info
        $router->render('/servicios/crear', [
            'nombre' => $_SESSION['nombre'] ?? '',
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);

    }
    
    public static function actualizar(Router $router) {  
        session_start();
        isAdmin();

        //obtiene el id del servicio, que viene en la url, y estará en la $_GET,
        //si $id NO ! es un número, retorna
        if( !is_numeric($_GET['id']) ) return;
        // llama al método find() enviando el id del servicio a buscar, 
        $servicio = Servicio::find($_GET['id']);
        //var para las alertas de validación del formulario
        $alertas = [];
        
        //si el tipo de solicitud HTTP al servidor es tipo POST
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //sincroniza actualizando los datos del modelo $servicio del find(),
            //con los nuevos datos del formulario actualizar en $_POST
            $servicio->sincronizar($_POST);
            //metodo validar para los nuevos datos del form
            $alertas = $servicio->validar();

            //si no hat alertas pdemos guardar el nuevo servicio
            if(empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        //llama método render() de la class router, enviando archivo vista y arreglo con info
        $router->render('/servicios/actualizar', [
            'nombre' => $_SESSION['nombre'] ?? '',
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }
    
    public static function eliminar(Router $router) { 
        session_start();
        isAdmin();
        
        //si el tipo de solicitud HTTP al servidor es tipo POST
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $servicio = Servicio::find($id);
            $servicio->eliminar();
            header('Location: /servicios');
        }
    }
}