<?php
// pronombre auto, único para nuestra class
namespace Controllers;

//para instanciar las class Router sin el namespace \
use MVC\Router;
use Model\AdminCita;


class AdminController {
    //instancia de Router para tener acceso a sus métodos,
    //sin tener que crear una nueva instancia de Router.
    public static function index( Router $router) {
        //abrimos sesión para obtener los datos de la $_SESSION
        session_start();

        isAdmin();

        //la super global $_GET, contiene un arreglo con el querystring
        //enviado en la url, por la función de js buscadorPorFecha() en buscador.js
        //debuguear($_GET);
        //obtenemos la fecha de la $_GET, un string con toda la fecha,
        //si $_GET no tiene fecha ?? obtenemos la fecha actual, del servidor
        $fecha = $_GET['fecha'] ?? date('Y-m-d');

        //divide la fecha a strings separados (y, m, d) en un arreglo indexado ,
        //y asigna el arreglo a $fehas
        $fechas = explode('-', $fecha);  

        //checkdate() chequea que la fecha sea válida, retornando true o false.
        //checkdate() requiere parámetros en este orden mes, dia , año
        //si la fecha NO ! es válida o real (false)
        if (!checkdate($fechas[1], $fechas[2], $fechas[0])) {
            //redirecciona a la página de error /404
            header('Location: /404');
        }

        //Consulta a la BD
        //Definición de la consulta SQL
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasservicios ";
        $consulta .= " ON citasservicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasservicios.servicioId ";
        $consulta .= " WHERE fecha =  '$fecha' ";

        //llama al método que hará la consulta, enviando el SQL.
        $citas = AdminCita::SQL($consulta);

        //debuguear($citas);

        //llama método render(), enviando archivo vista y arreglo con info
        $router->render('/admin/index', [
            'nombre' => $_SESSION['nombre'] ?? '',
            'citas' => $citas,
            'fecha' => $fecha
        ]);

    }
}