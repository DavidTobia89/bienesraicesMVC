<?php
namespace Controllers;
use MVC\Router;
use Model\Propiedad; 
use Model\Vendedor; 
// Importar Intervention Image
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PropiedadController {

    public static function index(Router $router){
        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();

        // Muestra mensaje condicional
        $resultado = $_GET['resultado'] ?? null;

        $router->render('propiedades/index', [
            'propiedades' => $propiedades,
            'vendedores' => $vendedores,
            'resultado' => $resultado
        ]);
    }

    public static function crear(Router $router){
        $errores = Propiedad::getErrores();
        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();

        // Ejecutar el código después de que el usuario envia el formulario
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

           /** Crea una nueva instancia */
            $propiedad = new Propiedad($_POST['propiedad']);
            
            // Generar un nombre único
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        
            // Crear una instancia del ImageManager con el driver GD
            $manager = new ImageManager(new Driver());

            if ($_FILES['propiedad']['imagen']['tmp_name']) {
                // Leer la imagen desde el sistema de archivos
                $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen']);

                // Redimensionar la imagen proporcionalmente a 800px de ancho
                $image->scale(width: 800);

                // Si deseas agregar una marca de agua, puedes hacerlo aquí
                // $image->place('path/to/watermark.png');

                // Guardar la imagen modificada
                

                $propiedad->setImagen($nombreImagen);
            }
            // Validar
            $errores = $propiedad->validar();
            if(empty($errores)) {

                // Crear la carpeta para subir imagenes
                if(!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }

                // Guarda la imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);

                // Guarda en la base de datos
                $resultado = $propiedad->guardar();

                if($resultado) {
                    header('location: /propiedades');
                }
            }
        }
        $router->render('propiedades/crear', [
            'errores' => $errores,
            'propiedad' => $propiedad,
            'vendedores' => $vendedores
        ]);
    }
    public static function actualizar(Router $router){
        $id = validarORedireccionar('/propiedades');

        // Obtener los datos de la propiedad
        $propiedad = Propiedad::find($id);

        // Consultar para obtener los vendedores
        $vendedores = Vendedor::all();

        // Arreglo con mensajes de errores
        $errores = Propiedad::getErrores();

        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

                // Asignar los atributos
                $args = $_POST['propiedad'];

                $propiedad->sincronizar($args);

                // Validación
                $errores = $propiedad->validar();

                // Subida de archivos
                // Generar un nombre único
                $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

                $manager = new ImageManager(new Driver());

                if (isset($_FILES['propiedad']['tmp_name']['imagen']) && $_FILES['propiedad']['tmp_name']['imagen']) {
                    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            
                    // Leer la imagen desde el sistema de archivos
                    $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen']);
            
                    // Redimensionar la imagen proporcionalmente a 800px de ancho
                    $image->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
            
                    // Si deseas agregar una marca de agua, puedes hacerlo aquí
                    // $image->insert('path/to/watermark.png');
            
                    // Guardar la imagen modificada
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
            
                    // Establecer la imagen en la propiedad
                    $propiedad->setImagen($nombreImagen);
                }
            


                
                if(empty($errores)) {
                    // Almacenar la imagen
                    if($_FILES['propiedad']['tmp_name']['imagen']) {
                        $image->save(CARPETA_IMAGENES . $nombreImagen);
                    }

                    // Guarda en la base de datos
                    $resultado = $propiedad->guardar();

                    if($resultado) {
                        header('location: /propiedades');
                    }
                }

        }

        $router->render('propiedades/actualizar', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }
    public static function eliminar() {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tipo = $_POST['tipo'];

            // peticiones validas
            if(validarTipoContenido($tipo) ) {
                // Leer el id
                $id = $_POST['id'];
                $id = filter_var($id, FILTER_VALIDATE_INT);
    
                // encontrar y eliminar la propiedad
                $propiedad = Propiedad::find($id);
                $resultado = $propiedad->eliminar();

                // Redireccionar
                if($resultado) {
                    header('location: /propiedades');
                }
            }
        }
    }

}
?>
