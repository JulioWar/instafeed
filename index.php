<?php
// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';

require_once(__DIR__.'/app/utils/helpers.php');


// Create Router instance
$router = new \Bramus\Router\Router();

// Importando Rutas
include_once(__DIR__.'/configs/routes.php');

// Run it!
$router->run();
