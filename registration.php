<?php
include "views/layouts/base-header.php";
include "views/layouts/base-footer.php";
include_once "app/Classes/FlashMessage.php";
include_once "app/utils/helpers.php";

$flashMessage = new FlashMessage();

get_base_header('<link rel="stylesheet" href="'.base_url('public/css/outside.css').'">');
?>
<div class="container">
    <div class="card">
        <span class="logo">
            <img src="<?= base_url(); ?>public/images/insta.png" alt="Instafeed picture">
        </span>
        <p>Regístrate para ver fotos y vídeos de tus amigos.</p>
        <form action="<?= base_url(); ?>app/Controllers/auth/registry.php" method="POST" novalidate>
            <input type="text" class="form-input" name="username" value="<?= $flashMessage->getInput('username'); ?>" placeholder="nombre de usuario" required >
            <input type="text" class="form-input" name="name" value="<?= $flashMessage->getInput('name'); ?>" placeholder="nombre completo" required >
            <input type="email" class="form-input" name="email"  value="<?= $flashMessage->getInput('email'); ?>" placeholder="correo electronico" required >
            <input type="password" class="form-input" name="password" placeholder="contraseña" required >
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

        <?php if ($flashMessage->hasSuccessMessage()): ?>
        <div class="alert success">
          <?= $flashMessage->getSuccessMessage() ?>
        </div>
        <?php endif; ?>
    </div>

    <div class="card">
        <p>¿Tienes una cuenta? <a href="<?= base_url(); ?>auth/login">Entrar</a> </p>
    </div>
</div>

<?php
get_base_footer();
?>
