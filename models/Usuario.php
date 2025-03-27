<?php
//pronombre automático para la class
namespace Model;

class Usuario extends ActiveRecord {
    //indica la tabla para las querys
    protected static $tabla = 'usuarios';
    //para el mapeo de las columnas de la tabla
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    //definición de atributos del objeto
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    //definicion del constructor del objeto, recibe arreglo como argumento y
    //retorna un objeto con los atributos
    public function __construct( $args = []) {
        //cuando se instancie la clase Usuario, se asignara a cada atributo,
        //el valor que viene en $args[], o si no, null o vacio
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    //Mensajes de validación para la creación de una cunta
    public function validarNuevaCuenta() {
        if(!$this->nombre) {
            //self:: porque es una variable arreglo, static y heredada de ActiveRecord.
            //El mensaje se almacena en el arreglo $alertas,
            //al final [] del arreglo ['error'] 
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->apellido) {
        
            self::$alertas['error'][] = 'El Apellido es Obligatorio';
        }
        if(!$this->email) {
            
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if(!$this->password) {
            
            self::$alertas['error'][] = 'El Password es Obligatorio';
        }
        //si la longitud del password es < a 6 carácteres
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'Password mínimo 6 carácteres';
        }

        return self::$alertas;
    }

    //Metodo para validar los campos del login, email y password
    public function validarLogin() {
        if(!$this->email) {
            
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if(!$this->password) {
            
            self::$alertas['error'][] = 'El Password es Obligatorio';
        }
        
        return self::$alertas;
    }

    //método validar email del formunario olvide-password
    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }

        return self::$alertas;
    }
    
    //método validar email del formunario olvide-password
    public function validarPassword() {
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password es Obligatorio';
        }
        //si la longitud del password es < a 6 carácteres
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'Password mínimo 6 carácteres';
        }

        return self::$alertas;
    }

    //Método para comprobar si el usuario (email) ya estába registrado
    public function existeUsuario() {
        //define el query para la consulta, limita a 1 registro
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1 "; 

        //ejecuta la consulta SQL con el $query definido.
        //self::, para acceder al método query() de la var $db, estática heredada de ActiveRecord.
        $resultado = self::$db->query($query);
        
        //La consulta retorna un objeto, si en su propiedad "num_rows" tiene algún valor,
        //significa que ha encontrado un email existente en la DB. El usuario ya existe.
        if($resultado->num_rows) {
            //agrega el mensaje al final [] del arreglo ['error'] del arreglo $alertas
            self::$alertas['error'][] = 'El usuario ya está registrado';
        }

        //retorna el objeto resultado de la consulta, que contiene la propiedad "num_rows"
        return($resultado);
    }

    //Método para hashear el password del usuario antes de guardarlo
    public function hashPassword() {
        //password_hash() función de php que requiere el password a hashear y un método de hasheo
        $this->password = password_hash($this->password, PASSWORD_BCRYPT );
    }

    //Método que crea automáticamente un token único para el usuario,
    public function crearToken() {
        //uniqid() función de php que genera, automáticamente, un token o id, único
        // y lo asignamos al atributo token de nuestro objeto usuario
        $this->token = uniqid();
    }

    //Método q comprueba el password y el verificado, del usuario en la DB
    public function comprobarPasswordAndVerificado($password) {
        //La función de php password_verify(), verifica el password introducido por el usuario, 
        //con el hasheado en la DB. Requiere ambos passwords. En $this tenemos el objeto $usuario
        $resultado = password_verify($password, $this->password);

        //si $resultado de verificar la pasword, NO ! es true ó ||
        //el atributo 'confirmado' del objeto usuario en $this, es 0
        if(!$resultado || !$this->confirmado) {
            //agrega mensaje, al final [] del arreglo ['error'] del arreglo $alertas
            self::$alertas['error'][] = 'Password Incorrecto o Cuenta NO Confirmada';
        
        //de lo contrario, el pasword es true y el usuario esta confirmado 1:
        } else {
            //el método retorna true
            return true;
        }
    }

}
