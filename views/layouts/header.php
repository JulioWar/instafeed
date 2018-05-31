<?php
include "base-header.php";

function get_header($head = '')
{
?>

<?= get_base_header($head); ?>

<header>
    <div class="container">
        <a class="logo" href="./">
            <img src="public/images/instagram-logo.svg" alt="Logo">
            <img src="public/images/insta.png" alt="Nombre Aplicacion">
        </a>
        <input class="form-input" type="search" placeholder="Buscar">
        <nav>
            <a href="./">
                    <img src="public/images/compass.svg" alt="Explorar">
                </a>
            <a href="profile.html">
                    <img src="public/images/user.svg" alt="Perfil">
                </a>
        </nav>
    </div>
</header>

<?php
}
?>
