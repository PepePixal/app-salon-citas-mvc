<?php
//pronombre automático para la class
namespace Model;

class Servicio extends ActiveRecord {
    //indica la tabla para las querys
    protected static $tabla = 'servicios';
    //arreglo asoc. para el mapeo de las columnas de la tabla
    protected static $columnasDB = ['id', 'nombre', 'precio'];

    //definicion de los atributos del objeto Servicio
    public $id;
    public $nombre;
    public $precio;

    //definicion del constructor del objeto, recibe arreglo como argumento y
    //retorna un objeto con los atributos
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
    }

}