<?php
function conectarDB() : mysqli{
    $db = new mysqli('localhost', 'root', 'root', 'bienesraices_crud');
    if(!$db){
        echo "Error no se pudo conectar";
        exit; // Falta punto y coma al final de esta línea
    }
    return $db;
}
?>
