<?php
include __DIR__."/../layouts/base-header.php";
include __DIR__."/../layouts/base-footer.php";


$flashMessage = new App\Classes\FlashMessage();


get_base_header(
    '<link rel="stylesheet" href="'.base_url().'public/css/outside.css">'
);
?>
<div class="container">
    <div class="card">
        <span class="logo">
            <img src="<?= base_url(); ?>public/images/insta.png" alt="Instafeed picture">
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
        <p>¿No tienes cuenta? <a href="<?= base_url(); ?>auth/registration">Registrate</a> </p>
    </div>
</div>
<?php
get_base_footer();
?>
