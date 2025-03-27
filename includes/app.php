<?php 

//importación de archivos
require 'funciones.php';
require 'database.php';
require __DIR__ . '/../vendor/autoload.php';

// Conectarnos a la base de datos
use Model\ActiveRecord;
//llama metodo setDB() enviando la conexión
ActiveRecord::setDB($db);