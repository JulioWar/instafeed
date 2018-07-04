<?php
include "../../Classes/FlashMessage.php";

$flashMessage = new FlashMessage();

$username = $_POST['username'];
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Creando la conexion a la base de datos
$connection = new mysqli('localhost', 'root', '', 'instafeed');

// Si la conexion falla, mostramos el mensaje correspondiente en pantalla
if ($connection->connect_errno) {
    echo "Fallo la conexiona MYSQL ($connection->connect_errno) $connection->connect_error";
}


// Validando informacion
if (!empty($username) && !empty($name) && !empty($email) && !empty($password)) {

    // Validando si el nombre de usuario tienen espacios
    if (strpos($username, ' '))  {
        $flashMessage->addError('username', 'El Nombre de Usuario no puede tener espacios');
    } else {
        // Si el nombre de usuario no tiene espacios entonces verificamos si existe en la base de datos
        $result = $connection->query("SELECT * FROM users WHERE username='$username'");

        // Verficamos que la consulta haya retornado algun resultado
        // Si existen mas de un resultado eso quiere decir, que ya existe en la base de datos
        if ($result->num_rows > 0) {
            $flashMessage->addError('username', "El Nombre de Usuario $username ya existe.");
        }
    }

    // Validando si el correo electronico tiene el formato por medio de una EXPRESION REGULAR
    if (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) {
        $flashMessage->addError('email', 'El Correo debe ser valido.');
    } else {
        // Se el correo electronico tiene el formato deseado, entonces procedemos a verificar
        // si existe en la base de datos
        $result = $connection->query("SELECT * FROM users WHERE emails='$email'");

        // Verficamos que la consulta haya retornado algun resultado
        // Si existen mas de un resultado eso quiere decir, que ya existe en la base de datos
        if ($result->num_rows > 0) {
            $flashMessage->addError('email', "El Correo $email ya existe.");
        }
    }

    // Si el elemento messages del arreglo $_SESSION esta establecido, entonces
    // redireccionamos al usuario al formulario de registro con el mensaje de error
    // ya establecido
    if (isset($_SESSION['messages'])) {
        header('Location: http://localhost/instafeed/registration.php');
        exit();
    }

    // la funcion md5 encripta la contraseña para evitar que sea leida desde la base de datos
    $password = md5($password);

    // Creamos y ejecutamos la consulta para insertar el nuevo usuario a la base de datos
    $result = $connection->query(
        "INSERT INTO users (username, name, email, password) ".
        "VALUES('$username', '$name', '$email', '$password')"
    );

    // Enviamos un mensaje de error si la consulta falla o retornamos un mensaje de exito
    // en caso contrario.
    if (!$result) {
        $_SESSION['messages'] = "Fallo el registro del usuario: ($connection->connect_errno)  $connection->error";
    } else {
        $_SESSION['success'] = 'Te has Registrado Exitosamente.';
    }

    // Verificando si exite algun mensaje para retornar al usuario
    if (isset($_SESSION['success']) || isset($_SESSION['messages'])) {
        header('Location: http://localhost/instafeed/registration.php');
        exit();
    }

} else {

    $_SESSION['messages'] = 'Verifique los campos';
    header('Location: http://localhost/instafeed/registration.php');
    exit();
}
