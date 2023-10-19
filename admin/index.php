<?php
include '../includes/funciones.php';
incluirTemplate('header', false, '../');
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../build/css/app.css">
</head>


<main class="contenedor seccion">
    <h1>Crear</h1>
    <a href="propiedades/crear.php" class="boton boton-verde">
    Create
    </a>
    <a href="propiedades/consultar.php" class="boton boton-verde">
    Read
    </a>
    <a href="propiedades/actualizar.php" class="boton boton-verde">
    Update
    </a>
    <a href="propiedades/consultar.php" class="boton boton-verde">
    Delete
    </a>
</main>
<?php
incluirTemplate('footer', false);
?>