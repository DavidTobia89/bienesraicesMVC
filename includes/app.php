<?php 


// Incluye funciones generales de la aplicación
require 'funciones.php';

// Incluye la configuración de la base de datos
require 'config/database.php';

// Incluye el autoload de Composer
require __DIR__ . '/../vendor/autoload.php';
$db = conectarDB();
// Usa la clase Propiedad del namespace App
use Model\ActiveRecord;

// Crea una nueva instancia de la clase Propiedad
ActiveRecord::setDB($db);

