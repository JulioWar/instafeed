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
        <form action="" method="POST" >
            <input type="email" class="form-input" name="email" placeholder="correo electronico" required >
            <input type="password" class="form-input" name="password" placeholder="contraseña" required >
            <input type="submit" class="btn btn-blue" value="Entrar">
        </form>
    </div>

    <div class="card">
        <p>¿No tienes cuenta? <a href="registration.php">Registrate</a> </p>
    </div>
</div>
<?php
get_base_footer();
?>
