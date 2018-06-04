<?php
include "views/layouts/base-header.php";
include "views/layouts/base-footer.php";

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
        <form  action="" method="post">
            <input type="text"
                   name="username"
                   class="form-input"
                   placeholder="Nombre de Usuario">
           <input type="text"
                  name="name"
                  class="form-input"
                  placeholder="Nombre Completo">
          <input type="email"
                 name="email"
                 class="form-input"
                 placeholder="Correo Electronico">
         <input type="password"
                name="password"
                class="form-input"
                placeholder="Contraseña">
         <input type="submit" class="btn btn-blue" value="Registrar">
        </form>
    </div>

    <div class="card">
        <p>¿Tienes una cuenta? <a href="login.php">Iniciar Sesión</a></p>
    </div>
</div>

<?php
get_base_footer();
?>
