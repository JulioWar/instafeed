<?php
include_once "../../utils/helpers.php";
include_once "../../Classes/FlashMessage.php";

$flashMessage = new FlashMessage();

$email = $_POST['email'];
$password = $_POST['password'];

// Creando la Conexion a la Base de Datos
$connection = new mysqli("localhost", "root", "", "instafeed");

// Verificando erores de conexion a la base de datos
if ($connection->connect_errno) {
  echo "Fallo al conectar a MYSQL: (".$connection->connect_errno.") ".
  $connection->connect_error;
}

if (!empty($email) && !empty($password)) {

  if (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) {
    $flashMessage->addError('email','El Correo debe ser valido.');
    $flashMessage->save();
    header('Location: '.base_url().'login.php');
    exit();
  }

  $password = md5($password);

  $result = $connection->query(
    "SELECT * FROM users WHERE email='$email' AND password='$password'"
  );

  if ($result->num_rows > 0) {
    header('Location: '.base_url());
    exit();
  } else {
    $flashMessage->setMessage('Las Credenciales son incorrectas.');
  }

} else {
  $flashMessage->setMessage('Verifique que todos los campos esten llenos.');
}

if ($flashMessage->hasMessage() || $flashMessage->hasErrors()) {
  $flashMessage->save();
  header('Location: '.base_url().'login.php');
  exit();
}
