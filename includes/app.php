<?php 

// Importa la class ActiveRecord
use Model\ActiveRecord;

//Incluye y evalua automáticamente todas las dependencias
//externas que gestiona Composer
require __DIR__ . '/../vendor/autoload.php';

//Para poder utilizar las variables de entorno de .env
//Esto genera la variable superglobal $_ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

//incluye y evalua los archivos
require 'funciones.php';
require 'database.php';

//llama metodo setDB() enviando la conexión
ActiveRecord::setDB($db);