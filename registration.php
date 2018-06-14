<?php
include "views/layouts/base-header.php";
include "views/layouts/base-footer.php";

session_start();

get_base_header(
    '<link rel="stylesheet" href="public/css/outside.css">'
);
?>

<div class="container">
    <div class="card">
        <span class="logo">
            <img src="public/images/insta.png" alt="Instafeed picture">
        </span>
        <p>Registrate para ver fotos y videos de tus amigos.</p>
        <form action="app/Controllers/auth/registry.php" method="post">
            <input type="text"
                   name="username"
                   class="form-input"
                   placeholder="Nombre de Usuario">
           <input type="text"
                  name="name"
                  class="form-input"
                  placeholder="Nombre Completo">
          <input type="text"
                 name="email"
                 class="form-input"
                 placeholder="Correo Electronico">
         <input type="password"
                name="password"
                class="form-input"
                placeholder="Contraseña">
         <input type="submit" class="btn btn-blue" value="Registrar">
        </form>
        <?php if (isset($_SESSION['messages'])): ?>
        <div class="alert danger">
            <?php
                 echo $_SESSION['messages'];
                 unset($_SESSION['messages']);
            ?>
        </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
        <div class="alert success">
            <?php
                 echo $_SESSION['success'];
                 unset($_SESSION['success']);
            ?>
        </div>
        <?php endif; ?>
    </div>

    <div class="card">
        <p>¿Tienes una cuenta? <a href="login.php">Iniciar Sesión</a></p>
    </div>
</div>

<?php
get_base_footer();
?>
