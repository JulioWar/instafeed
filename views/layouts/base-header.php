<?php
function get_base_header($head = '')
{
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Instafeed</title>
    <!-- EVITANDO QUE EL VIEWPORT SEA ESCALABLE Y SE PUEDA REALIZAR ZOOM -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- DEFINIENDO EL FAVICON PARA LA APLICACION -->
    <link rel="shortcut icon" type="image/png" href="public/images/logo.png">

    <!-- CARGANDO HOJA DE ESTILOS-->
    <link href="https://fonts.googleapis.com/css?family=Barlow" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <?= $head ?>
</head>

<body>

<?php
}
?>
