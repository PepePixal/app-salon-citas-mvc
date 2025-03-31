<?php

namespace Model;

class Cita extends ActiveRecord {
    //indica la tabla para las querys
    protected static $tabla = 'citas';
    //arreglo asoc. para el mapeo de las columnas de la tabla
    protected static $columnasDB = [ 'id', 'fecha', 'hora', 'usuarioId'];

    //definicion de los atributos del objeto cita
    public $id;
    public $fecha;
    public $hora;
    public $usuarioId;

    //definicion del constructor del objeto, recibe arreglo como argumento y
    //retorna un objeto con los atributos
    public function __construct( $args = []) {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->usuarioId = $args['usuarioId'] ?? '';
    }
}