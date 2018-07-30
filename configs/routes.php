<?php


// Rutas Publicas
$router->get('/auth/login', 'App\Controllers\AuthController@getLogin');


// Ruta vista de Registro
$router->get('/auth/registration', 'App\Controllers\AuthController@getRegistration');
// Ruta para procesar el formulario y registrar un nuevo usuario.
$router->post('/auth/register', 'App\Controllers\AuthController@register');

// Rutas Protegidas
$router->get('/user/explore', 'App\Controllers\ExplorerController@home');
