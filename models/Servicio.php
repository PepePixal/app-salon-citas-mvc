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

    //valida los campos del formulario enviados con POST, retornando $alertas
    public function validar() {
        if(!$this->nombre){
            //agrega al arreglo $alertas, la llave error y el mensaje como valor,
            //usamos self:: porque $alertas está definida en el model ActiveRecord.
            self::$alertas ['error'][] = 'El nombre del servicio es obligatorio';
        }
        if(!$this->precio){
            self::$alertas ['error'][] = 'El precio del servicio es obligatorio';
        }
        //valida si el precio no es un número
        if(!is_numeric($this->precio)){
            self::$alertas ['error'][] = 'El precio no es válido';
        }

        //retorna la var $alertas, para enviarlas en el render()
        return self::$alertas;
    }

}