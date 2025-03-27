<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\CitaController;
use Controllers\LoginController;
use Controllers\APIController;

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

// API de citas
$router->get('/api/servicios', [APIController::class, 'index']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();