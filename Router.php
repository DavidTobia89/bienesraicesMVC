<?php
namespace MVC;

class Router {
 
    public $rutasGET = [];
    public $rutasPOST = [];
 
    public function get($url, $fn) {
        $this->rutasGET[$url] = $fn;
    }
    public function post($url, $fn) {
        $this->rutasPOST[$url] = $fn;
    }
    public function comprobarRutas() {
        session_start();
        $auth = $_SESSION ['login'] ?? null;

        $rutas_protegidas = ['/admin, /propiedades/crear, /propiedades/actualizar, /propiedades/eliminar, /vendedores/crear, /vendedores/actualizar, /vendedores/eliminar'];

        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];
 
        // Obtiene la URL actual y la busca en el arreglo de RutasGET
        // Si no existe le asigna un valor NULL
        if ( $metodo === 'GET' ) {
            $fn = $this->rutasGET[$urlActual] ?? null;
        }else {
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }
        if (in_array($urlActual, $rutas_protegidas) && !$auth){
            header('Location: /');
        }
        if ( $fn ) {
            // Si la URL si existe y tiene una función asociada entonces ejecuta la función
            call_user_func( $fn, $this );   // Permite ejecutar una función 
        } else {
            echo "Página no encontrada";
        }
    }
 // Muestra una vistas

 public function render($view, $datos = []) {
    // Leer lo que le pasamos  a la vista
    foreach ($datos as $key => $value) {
        $$key = $value;  // Doble signo de dolar significa: variable variable, básicamente nuestra variable sigue siendo la original, pero al asignarla a otra no la reescribe, mantiene su valor, de esta forma el nombre de la variable se asigna dinamicamente
    }

    ob_start(); // Almacenamiento en memoria durante un momento...

    // entonces incluimos la vista en el layout
    include_once __DIR__ . "/views/$view.php";
    $contenido = ob_get_clean(); // Limpia el Buffer
    include_once __DIR__ . '/views/layout.php';
    }
}