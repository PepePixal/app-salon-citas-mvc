<?php

namespace Model;

class CitaServicio extends ActiveRecord {
    //indica la tabla para las querys
    protected static $tabla = 'citasservicios';
    //arreglo para el mapeo de las columnas de la tabla
    protected static $columnasDB = ['id', 'citaId', 'servicioId'];

    //definicion de los atributos del objeto cita
    public $id;
    public $citaId;
    public $servicioId;

    //definicion del constructor del objeto, recibe argumento arreglo y
    //retorna un objeto con los atributos
    public function __construct( $args = []) {
        $this->id = $args['id'] ?? null;
        $this->citaId = $args['citaId'] ?? '';
        $this->servicioId = $args['servicioId'] ?? '';
    }
}