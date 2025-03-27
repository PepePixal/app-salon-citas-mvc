<?php

// pronombre auto, único para nuestra class
namespace MVC;

class Router
{
    //almacenaran las rutas GET y POST
    public array $getRoutes = [];
    public array $postRoutes = [];

    //método q almacena las URLs que reaccionan a un método o función GET,
    //requiere la /URL y la fución asociada a esa URL,
    //en el arreglo almacena la $url como llave y la función $fn como su valor
    public function get($url, $fn) {
        $this->getRoutes[$url] = $fn;
    }

    //método q almacena las URLs que reaccionan a un método o función FORM,
    //requiere la /URL y la fución asociada a esa URL,
    //en el arreglo, almacena la $url como llave y la función $fn como su valor
    public function post($url, $fn) {
        $this->postRoutes[$url] = $fn;
    }

    //método que comprueba si el tipo de request (solicitud) es GET o POST,
    //valida si la ruta actual está en alguno de los arreglos del Rounter ($rutasGET) o ($rutasPOST),
    // si está obtiene su método asociado, protege las rutas que requieran autenticación y 
    // llama al método asociado a las rutas que no requieren autenticación.
    public function comprobarRutas() {
        
        //para tener acceso a la superglobal $_SESSION
        //session_start();

        // Arreglo de rutas protegidas...
        // $rutas_protegidas = ['/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar'];

        // $auth = $_SESSION['login'] ?? null;

        //obtiene la url del la página actual, de la superglobal php $_SERVER,
        // si no encuentra nada ?? asigna '/'
        $currentUrl = $_SERVER['PATH_INFO'] ?? '/';
        //obtiene el método de consulta (request), de la superglobal php $_SERVER,
        $method = $_SERVER['REQUEST_METHOD'];

        //si el método es GET, obtiene la funcion asociada a la url actual
        if ($method === 'GET') {
            //obtiene, el valor de la llave [$currentUrl] del arreglo getRoutes,
            // ese valor es la función asociada a la url actual, si no existe ?? null
            $fn = $this->getRoutes[$currentUrl] ?? null;

        //si el método NO es GET, es POST, obtiene la funcion asociada a la url actual   
        } else {
            //obtiene, el valor de la llave [$currentUrl] del arreglo postRoutes,
            // ese valor es la función asociada a la url actual, si no existe ?? null
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }

        //si existe la funcion asociada a la url...
        if ( $fn ) {
            //call_user_func() permite llamar a una función por su nombre, cuando no sabemos si existe,
            //requiere la funcion $fn y con $this le damos acceso a los métodos y atributos de su clase Router
            call_user_func($fn, $this); // This es para pasar argumentos

        //si no existe la url o la funcion asociada
        } else {
            echo "Página No Encontrada o Ruta no válida";
        }
    }


    //Metodo que muestra el layout.php principal y las views .php insertadas,
    //recibe la vista a insertar en el layout.php y datos
    public function render($view, $datos = []) {

        //itera el arrelgo asoc con la informacion recibida en $datos,
        //tomando cada llave y su valor
        foreach ($datos as $key => $value) {

            //con $$key, en cada iteración, el nombre de la llave $key,
            //se convierte en una nueva variable que almacena su propoio valor,
            //retornando así tantas variables y sus valores, como elementos 
            //tenga el arreglo recibido, pudiendo acceder a todas las variables
            $$key = $value;
        }

        //inicia una cache, buffer o almacenamiento en memoria,
        //el valor de salida del código, posterior a ob_start(), se almacena en esa memória
        ob_start(); // Almacenamiento en memoria durante un momento...

        //importa el archivo recibido en $view, que contiene la vista de contenido,
        //esto se almacena en memoria
        include_once __DIR__ . "/views/$view.php";

        //asigna lo que haya en memoria a la var $contenido  y 
        //posteriormente borra o vacía la memoria
        $contenido = ob_get_clean();

        //importa el archivo de vista layout.php, que contiene el header,
        //el footer y en médio tiene insertada la var $contenido que contiene
        //lo que se había almacenado en memoria, lo que hemos recibido en $view.
        //Se muestra todo en el navegador.
        include_once __DIR__ . '/views/layout.php';
    }
}
