<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Introducción a PHP </title>
    <link rel="stylesheet" href="<?= RELATIVE_PATH ?>build/css/app.css">
</head>

<body>
    <header class="header <?php echo $inicio ? 'inicio' : ''; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="<?= RELATIVE_PATH ?>index.php">
                    <img src="<?= RELATIVE_PATH ?>build/img/logo.svg" alt="Logotipo de Bienes Raices">
                </a>

                <div class="mobile-menu">
                    <img src="<?= RELATIVE_PATH ?>build/img/barras.svg" alt="icono menu responsive">
                </div>

                <div class="derecha">
                    <img class="dark-mode-boton" src="<?= RELATIVE_PATH ?>build/img/dark-mode.svg">
                    <nav class="navegacion">
                        <a href="<?= RELATIVE_PATH ?>nosotros.php">Nosotros</a>
                        <a href="<?= RELATIVE_PATH ?>anuncios.php">Anuncios</a>
                        <a href="<?= RELATIVE_PATH ?>blog.php">Blog</a>
                        <a href="<?= RELATIVE_PATH ?>contacto.php">Contacto</a>
                    </nav>
                </div>


            </div> <!--.barra-->

            <?php echo $inicio ? '<h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>' : '' ?>
        </div>
    </header>