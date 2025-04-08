<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\APIController;
use Controllers\CitaController;
use Controllers\AdminController;
use Controllers\LoginController;
use Controllers\ServicioController;
use Dom\Attr;

//instancia de la clase Router
$router = new Router();

//** Rutas Iniciar sesión usuario
//llama a get() o post() enviando ruta y arreglo con clase y método.
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

//Rutas Recuperar password 
//muestra formulario para enviar un email de recuperación
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);
//muestra formlario para enviar la nueva contraseña
$router->get('/recuperar', [LoginController::class, 'recuperar']);
$router->post('/recuperar', [LoginController::class, 'recuperar']);

//Rutas crear cuenta usuario
$router->get('/crear-cuenta', [LoginController::class, 'crear']);
$router->post('/crear-cuenta', [LoginController::class, 'crear']);

//Confirmar cuenta de usuario
$router->get('/mensaje', [LoginController::class, 'mensaje']);
$router->get('/confirmar-cuenta', [LoginController::class, 'confirmar']);

//** Rutas Crear Citas - Area Privada
$router->get('/cita', [CitaController::class, 'index']);
$router->get('/admin', [AdminController::class, 'index'] );

// API de citas
//obtiene los servcicios de la BD y los convierte a JSON 
$router->get('/api/servicios', [APIController::class, 'index']);
//obtiene los datos del formulario citas FormData() y los convierte a JSOM
$router->post('/api/citas', [APIController::class, 'guardar']);
$router->post('/api/eliminar', [APIController::class, 'eliminar']);

//** CRUD de Servicios
//muestra todos los servicios
$router->get('/servicios', [ServicioController::class, 'index']);
//muestra el formulario para crear servicios
$router->get('/servicios/crear', [ServicioController::class, 'crear']);
//envia el formulario para guardar los servicios
$router->post('/servicios/crear', [ServicioController::class, 'crear']);
//muestra el formulario para buscar los sercios a actualizar
$router->get('/servicios/actualizar', [ServicioController::class, 'actualizar']);
//envia el formulario para buscar y actualizar servicios
$router->post('/servicios/actualizar', [ServicioController::class, 'actualizar']);
//para eliminar servicios
$router->post('/servicios/eliminar', [ServicioController::class, 'eliminar']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();