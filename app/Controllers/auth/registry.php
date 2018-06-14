<?php


$username = $_POST['username'];
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

//echo $username . ' - '. $name.' - '. $email.' - '.$password;

session_start();

$connection = new mysqli('localhost', 'root', '', 'instafeed');

if ($connection->connect_errno) {
    echo "Fallo la conexiona MYSQL ($connection->connect_errno) $connection->connect_error";
}



// Validando informacion
if (!empty($username) && !empty($name) && !empty($email) && !empty($password)) {

    if (strpos($username, ' '))  {
        $_SESSION['messages'] = 'El Nombre de Usuario no puede tener espacios';
    } else {
        $result = $connection->query("SELECT * FROM users WHERE username='$username'");

        if ($result->num_rows > 0) {
            $_SESSION['messages'] = "El Nombre de Usuario $username ya existe.";
        }
    }

    if (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) {
        $_SESSION['messages'] = 'El Correo debe ser valido.';
    }


    if (isset($_SESSION['messages'])) {
        header('Location: http://localhost/instafeed/registration.php');
        exit();
    }


    $password = md5($password);
    $result = $connection->query(
        "INSERT INTO users (username, name, email, password) ".
        "VALUES('$username', '$name', '$email', '$password')"
    );

    if (!$result) {
        $_SESSION['messages'] = "Fallo el registro del usuario: ($connection->connect_errno)  $connection->error";
    } else {
        $_SESSION['success'] = 'Te has Registrado Exitosamente.';
    }

    if (isset($_SESSION['success'])) {
        header('Location: http://localhost/instafeed/registration.php');
        exit();
    }

} else {

    $_SESSION['messages'] = 'Verifique los campos';

    header('Location: http://localhost/instafeed/registration.php');
    exit();
}
