<?php
include "layouts/header.php";
include "layouts/base-footer.php";

$usuario = $_SESSION['user'];
$posts = $usuario->posts()->get();

get_header();
?>

    <div id="explorer" class="container">
        <h5>Explorar</h5>
        <!-- <?= var_dump($_SESSION['user']); ?> -->
        <?= $usuario->id .' = '. $usuario->name; ?>
        <form action="<?= base_url() ?>user/logout" method="post">
          <button type="submit" class="btn btn-default">
            Cerrar Sesion
          </button>
        </form>

        <div class="grid">
			<?php for($contador = 0; $contador < 24; $contador++): ?>
            <article class="post" style="background-image: url(https://picsum.photos/<?= rand(500, 600); ?>/<?= rand(500, 600); ?>)">
                <a href="" class="post-info">
                    <span class="likes">
                        <img src="<?= base_url(); ?>public/images/like.svg" alt="likes">
                    </span>
                </a>
            </article>
			<?php endfor; ?>
        </div>
    </div>
<?php
    get_base_footer();
?>
