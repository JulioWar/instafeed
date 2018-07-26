<?php
include "views/layouts/base-header.php";
include "views/layouts/base-footer.php";
include_once "app/utils/helpers.php";
include_once "app/Classes/FlashMessage.php";


$flashMessage = new FlashMessage();


get_base_header(
    '<link rel="stylesheet" href="public/css/outside.css">'
);
?>
<div class="container">
    <div class="card">
        <span class="logo">
            <img src="public/images/insta.png" alt="Instafeed picture">
        </span>
        <form action="<?= base_url(); ?>app/Controllers/auth/login.php" method="POST" >
            <input type="email"
                class="form-input"
                 name="email"
                 placeholder="correo electronico">
            <input type="password" class="form-input" name="password" placeholder="contraseña" >
            <input type="submit" class="btn btn-blue" value="Entrar">
        </form>

        <?php if ($flashMessage->hasErrors() || $flashMessage->hasMessage()): ?>
        <div class="alert danger">
          <?php if ($flashMessage->hasMessage()): ?>
          <p><?= $flashMessage->getMessage() ?></p>
          <?php endif; ?>

          <?php if ($flashMessage->hasErrors()): ?>
            <ul>
              <?php foreach ($flashMessage->all() as $error): ?>
                <li><?= $error[0] ?></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <div class="card">
        <p>¿No tienes cuenta? <a href="registration.php">Registrate</a> </p>
    </div>
</div>
<?php
get_base_footer();
?>
