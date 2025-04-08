<?php

namespace Model;

class AdminCita extends ActiveRecord {

    //la consulta SQL se hará sobre varias tablas de la DB
    //relacionadas y con algunos nombres de columnas como alias,
    //pero solo es necesario indicar una de las tablas de la DB
    protected static $tabla = 'citasservicios';
    //las columnas son exactamente las que genera la consulta SQL
    protected static $columnasDB = ['id', 'hora', 'cliente', 'email', 'telefono', 'servicio', 'precio'];

    public $id;
    public $hora;
    public $cliente;
    public $email;
    public $telefono;
    public $servicio;
    public $precio;

    public function __construct( $args = []) {
        $this->id = $args['id'] ?? null;
        $this->hora = $args['hora'] ?? '';
        $this->cliente = $args['cliente'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->servicio = $args['servicio'] ?? '';
        $this->precio = $args['precio'] ?? '';
    }

}