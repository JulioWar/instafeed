<?php
include "../../utils/helpers.php";
include "../../Classes/FlashMessage.php";

$flashMessage = new FlashMessage();

// Creando la Conexion a la Base de Datos
$connection = new mysqli("localhost", "root", "", "instafeed");

// Verificando erores de conexion a la base de datos
if ($connection->connect_errno) {
  echo "Fallo al conectar a MYSQL: (".$connection->connect_errno.") ".
  $connection->connect_error;
}

$username = $_POST['username'];
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Validando los datos
if (!empty($username) && !empty($name) && !empty($email) && !empty($password)) {

  if (strpos($username,' ') !== false) {
    $flashMessage->addError('username', 'El Nombre de Usuario no puede tener espacios');
  } else {
    $result = $connection->query(
      "SELECT * FROM users WHERE username='$username'"
    );

    if ($result->num_rows > 0) {
      $flashMessage->addError('username', 'Este Nombre de usuarios ya ha sido utilizado para otra cuenta.');
    }
  }

  // Validando si el Correo es valido
  if (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) {
    $flashMessage->addError('email', 'El Correo debe ser valido.');
  } else {
    $result = $connection->query(
      "SELECT * FROM users WHERE email='$email'"
    );

    if ($result->num_rows > 0) {
      $flashMessage->addError('email', 'Este Correo ya ha sido utilizado para otra cuenta.');
    }
  }

  if (strlen($password) < 8) {
    $flashMessage->addError('password', 'La contraseña deber ser por lo menos de 8 caracteres.');
  }

} else {
  $flashMessage->setMessage('Verifique que todos los campos esten llenos.');
}


// Retornando mensajes de error si existen
if ($flashMessage->hasMessage() || $flashMessage->hasErrors()) {

  $flashMessage->setInputs($_POST);

  // Guardando los cambios en la sesion
  $flashMessage->save();
  header("Location: ".base_url()."registration.php");
  exit();
}

$password = md5($password);
$result = $connection->query(
  "INSERT INTO users (username, name, email, password) ".
  "VALUES('$username', '$name', '$email', '$password')"
);

if ($result) {
  $flashMessage->setSuccessMessage('Te has Registrado Exisamente.');
} else {
  $flashMessage->setMessage("Falló el registro del usuario: (" . $connection->errno . ") " . $connection->error);
}

$flashMessage->save();
header("Location: ".base_url()."registration.php");
exit();
