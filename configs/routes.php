<?php

$router->before('GET|POST', '/', function() {
    session_start();
    if (isset($_SESSION['user'])) {
        header('location: '.base_url().'user/explore');
    } else {
        header('location: '.base_url().'auth/login');
    }
    exit();
});

$router->before('GET|POST','/auth/.*', function() {
  session_start();

  if (isset($_SESSION['user'])) {
    header('location: '.base_url().'user/explore');
    exit();
  }

});

$router->before('GET|POST','/user/.*', function() {
  session_start();
  if (!isset($_SESSION['user'])) {
    header('location: '.base_url().'auth/login');
    exit();
  }
});


// Rutas Publicas
$router->get('/auth/login', 'App\Controllers\AuthController@getLogin');
$router->post('/auth/login', 'App\Controllers\AuthController@login');


// Ruta vista de Registro
$router->get('/auth/registration', 'App\Controllers\AuthController@getRegistration');

// Ruta para procesar el formulario y registrar un nuevo usuario.
$router->post('/auth/register', 'App\Controllers\AuthController@register');

// Rutas Protegidas
$router->post('/user/logout','App\Controllers\AuthController@logout');
$router->get('/user/explore', 'App\Controllers\ExplorerController@home');
