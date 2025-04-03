<?php

// pronombre auto, único para nuestra class
namespace Controllers;

//para instanciar la class Router sin el namespace MVC
use MVC\Router;
use Classes\Email;
use Model\Usuario;


class LoginController {
    //instancia de Router para tener acceso a sus métodos,
    //sin tener que crear una nueva instancia de Router.
    public static function login( Router $router ) {
        //arreglo alertas vacio
        $alertas = [];

        //nueva instancia de Usuario vacio, para poder enviar al render
        $auth = new Usuario;

        //si el método de solicitud ha sido POST
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //instancia de un nuevo objeto usuario, enviando $_POST
            $auth = new Usuario($_POST);

            //validar los campos del login, email y password
            $alertas = $auth->validarLogin();

            //si no hay alertas, ha pasado la validación de los inputs
            if(empty ($alertas)) {
                //comprobar si el email existe en la DB.
                //El método requiere la columna de la tabla y el dato a buscar.
                //El método retorna, todo el objeto usuario, o null
                $usuario = Usuario::where('email', $auth->email);

                //si el usuario existe
                if($usuario) {
                    //Verificar el password y que el usuario este verificado, en la DB.
                    //LLama al método enviando el password introducido por el usuario,
                    //si el retorno es true
                    if ( $usuario->comprobarPasswordAndVerificado($auth->password) ) {
                        //autenticar la sesión al usuario, loguearlo
                        session_start();
                        //al iniciar la sesión, tenemos acceso al arreglo super glob $_SESSION,
                        //inicalmente vacio, donde podemos almacenar información
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //Redirecciona, según el usuario es tipo admin, o no
                        //si el valor de la propiedad admin es = 1, es tipo Administrador
                        if($usuario->admin === '1') {
                            //agrega elemento admin a $_SESSION, con el valor de admin ("1") o null
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            //redirección al panel de administrador
                            header('Location: /admin');
                            
                        //es tipo cliente
                        }else {
                            //redirección a la página de citas
                            header('Location: /cita');
                        }
                    }
                
                //usuario email no existe
                } else {
                    Usuario::setAlerta('error', 'Usuario No encontrado');
                }
            }
        }

        //obtine las posibles alertas antes de enviar la vist con render()
        $alertas = Usuario::getAlertas();

        //llama met render() enviando vista y arreglo
        $router->render('auth/login', [
            'alertas' => $alertas,
            'auth' => $auth
        ]);

    }

    public static function logout() {
        //reabrimos sesión
        session_start();
        //cerramos sesión asignando arreglo vacio a la super glob $_SESSION
        $_SESSION = [];
        //redirigimos al inicio raiz 
        header('Location: /');
    }
    
    public static function olvide(Router $router) {
        //arreglo alertas vacio
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

            //validar el formualrio (email) olvide-password
            $alertas = $auth->validarEmail();

            //si no hay alertas, el formulario está validado
            if(empty($alertas)){
                //comprobar si el email existe en la db
                //método requiere columna y valor a buscar.
                //Retorna arreglo con todas las columnas del registro, o null
                $usuario = Usuario::where('email', $auth->email);

                //si usuario (email) existe y el atributo confirmado = "1"
                if($usuario && $usuario->confirmado === "1") {
                    //generar un nuevo token único y lo agrega al atribugo token del usuario
                    $usuario->crearToken();
                    
                    //actualiza el usuario con el nuevo token, en la db
                    $usuario->guardar();

                    //Enviar email con el nuevo token.
                    //nueva instancia de la clase email, enviando datos,
                    //para obtener el objeto de la clase Email con los datos del usuario
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    //llama método de la class email, que envía el email con las instrucciones
                    $email->enviarInstrucciones();

                    Usuario::setAlerta('exito', 'Instruciones enviadas a tu email');

                //el usuario no existe o no está confirmado
                } else {
                    Usuario::setAlerta('error', 'El Usuario NO existe o NO está confirmado');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide-password', [
            'alertas' => $alertas,
        ]);
    }

    public static function recuperar(Router $router) {
        //arreglo alertas vacio
        $alertas = [];
        //var para modificar la vista, si token no valido
        $error = false;

        //obtener el token sanitizado (s), de la url, del arreglo super glob $_GET
        $token = s($_GET['token']);

        //buscar usuario por su token, en la DB
        $usuario = Usuario::where('token', $token);

        //si el usuario NO existe en la DB
        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token NO válido');
            //asigna true a la var error para modificar la vista, render()
            $error = true;
        }

        //cuando el usuario envíe el formaulaio
        if($_SERVER['REQUEST_METHOD'] === 'POST') {           
            //nueva instancia el objeto Usuario enviando la info del formulario,
            //retorna objeto usuario vacio, con el password enviado por el usuario
            $password = new Usuario($_POST);

            //validar si el input passoword viene vacio
            $alertas = $password->validarPassword();

            //si no hay alertas, el formulario está validado
            if(empty($alertas)) {
                //anular el password antiguo del objeto usuario en memoria
                $usuario->password = null;
                //asignar al objeto usuario, el nuevo password enviado por el usuario
                //que está en el objeto $password
                $usuario->password = $password->password;
                //hashear el nuevo password, antes de guardar el usuario
                $usuario->hashPassword();
                //eliminar el nuevo token, antes de guardar el usuario
                $usuario->token = '';
                //guardar (actualizar) el usuario con la nueva password en la DB
                $resultado = $usuario->guardar();
                //si hay resultado, el usuario se ha actualizado
                if($resultado) {
                    header('Location: /');
                }

            }


        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error'  => $error
        ]);
    }

    public static function crear(Router $router) {
        //instancia clase Usuario, obtiene un objeto vacio
        $usuario = new Usuario;

        //Alertas vacias de errores
        $alertas = [];

        //Si el metodo de solicitud ha sido POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            //sincroniza los datos del arreglo $_POST,
            //con las propiedades del objeto vacio $usuario
            $usuario->sincronizar($_POST);

            //llama método, para validar los campos del form Nueva cuenta
            $alertas = $usuario->validarNuevaCuenta();
            
            //Revisa que $alertas esté vacio
            if(empty($alertas)) {
                //llama método que comprueba si el usuario (email) ya registrado en la DB,
                //el método retorna el objeto resultado de la consulta, lo asigna a $resultado
                $resultado = $usuario->existeUsuario();

                //Si el objeto resultado, en su propiedad "num_rows" tiene algún valor,
                //significa que ha encontrado un email existente en la DB. El usuario ya existe.
                if($resultado->num_rows) {
                    //llama al método estático getAlertas() de la clase Usuario q extiende de ActiveRecord
                    // y obtiene las alertas que haya generado el método existeUsuario(),
                    $alertas = Usuario::getAlertas();
                
                //de lo contrario, no hay ningún usuario registrado con el email consultado
                } else {
                    //hashear el password del objeto $usuario, antes de guardarlo en la DB
                    $usuario->hashPassword();

                    //Crear automáticamente un token único para el usuario,
                    //para comprobar posteriormente que no es un robot
                    $usuario->crearToken();

                    //Enviar email con el token para verificar usuario
                    //Nueva instancia de la clase Email, enviando parámetros requeridos. Retorna objeto.
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

                    //llama al método enviarConfirmacion() de la clase Email
                    $email->enviarConfirmacion();

                    //Crear el usuario en la DB
                    $resultado = $usuario->guardar();

                    if($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }
        
        //llama método render envia vista y arreglo con
        //la información del usuario
        $router->render('auth/crear-cuenta', [
            //envia los datos del usuario, sincronizados, para mostrar
            'usuario' => $usuario,
            //envia los mensajes de error de la validación del form
            'alertas' => $alertas,
        ]);
    }

    //método que muestra la vista "Hemos enviado email para la confirmación"
    public static function mensaje(Router $router) {
        $router->render('auth/mensaje');
    }

    //método validación del token recibido en la url, cuando el usuario pulsa el enlace.
    //Para confirmar o denegar la nueva cuenta.
    public static function confirmar(Router $router) {
        //definicion arreglo vacio alertas
        $alertas = [];

        //obtener el token de la url y sanitizarlo
        $token = s($_GET['token']);

        //llama al método where() de la class Usuario, que busca un registro,
        //requiere la columna y el valor, para buscar el registro. Retorna objeto.
        $usuario = Usuario::where('token', $token);
        
        //si el usuario está vacio, no se ha encontrado el token recibido en la url
        if(empty($usuario)) {
            //llama método setAlerta() requiere tipo y mensaje
            Usuario::setAlerta('error', 'Token NO Válido');

        } else {
            //modificar a 1, la propiedad 'confirmado' del usuario
            $usuario->confirmado = "1";

            //modificar a null, la propiedad 'token' del usuario, elimina el token
            $usuario->token = '';

            //guardar (actualizar) en la DB, el usuario con los nuevos valores.
            //llama al metodo guradar
            $usuario->guardar();

            //llama método setAlerta() requiere tipo y mensaje
            Usuario::setAlerta('exito', 'Cuenta Comprobada Correctamente');
        }

        //obtine las alertas, antes de enviar la vista con render()
        $alertas = Usuario::getAlertas();

        //método muestra alertas confirmación o denegación de nueva cuenta
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas,
        ]);

    }

}