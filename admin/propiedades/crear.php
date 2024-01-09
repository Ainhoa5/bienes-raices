<?php
include '../../includes/app.php';
use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image;

/* estaAutenticado(); */



incluirTemplate('header', false, '../../');
$db = conectarDB();

//consultar para obtener a los vendedores
$consulta = "SELECT * FROM vendedores;";
$vendedoresQuery = mysqli_query($db, $consulta);

//inicializo los errores
$errores = Propiedad::getErrores();
$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedores_id = '';


if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $propiedad = new Propiedad($_POST);

  /* Set values */
  $titulo = $propiedad->titulo;
  $precio = $propiedad->precio;
  $descripcion = $propiedad->descripcion;
  $habitaciones = $propiedad->habitaciones;
  $wc = $propiedad->wc;
  $estacionamiento = $propiedad->estacionamiento;
  $carpetaImagenes = '../../imagenes/';
  if (!is_dir($carpetaImagenes)) {
    mkdir($carpetaImagenes);
  }
  $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

  if ($_FILES['imagen']['tmp_name']) {
    //Realiza resize
    $image = Image::make($_FILES['imagen']['tmp_name']);
    $image->fit(800, 600);
    $propiedad->setImagen($nombreImagen);
  }
  $errores = $propiedad->validar();
  if (empty($errores)) {
    //Subir la imagen
    $image->save($carpetaImagenes . $nombreImagen);
    //guardar en la bd
    $resultado = $propiedad->guardar();

    if ($resultado) {
      header('location: /admin/index.php?mensaje=1');
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../../build/css/app.css">
</head>

<body>
  <!-- Mostrar los errores -->
  <main class="contenedor seccion">
    <h1>Crear</h1>
    <?php foreach ($errores as $error) { ?>
      <div class="alerta error">
        <?php echo $error; ?>
      </div>

    <?php } ?>

    <a href="/admin/" class="boton boton-verde">Volver</a>
    <form class="formulario" method="POST" action="crear.php" enctype="multipart/form-data">
      <fieldset>
        <legend> Información General</legend>
        <!-- Titulo -->
        <input type="hidden" name="id">
        <label for="titulo">Título: </label>
        <input type="text" id="titulo" name="titulo" placeholder="Título propiedad"
          value="<?php echo htmlspecialchars($titulo); ?>">
        <!-- Precio -->
        <label for="precio">Precio</label>
        <input type="number" id="precio" name="precio" placeholder="Type a price" value="<?php echo htmlspecialchars($precio); ?>">
        <!-- Imagen -->
        <label for="imagen">Imagen: </label>
        <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">
        <!-- Descipcion -->
        <label for="descripcion">Descipción</label>
        <textarea name="descripcion" id="Descipcion" placeholder="Descripcion" cols="30"
          rows="10"><?php echo htmlspecialchars($descripcion); ?></textarea>
        <!-- habitaciones -->
        <label for="habitaciones">habitaciones</label>
        <input type="number" id="habitaciones" name="habitaciones" placeholder="Número de Habitaciones"
          value="<?php echo $habitaciones; ?>">
        <!-- wc -->
        <label for="wc">wc</label>
        <input type="number" id="wc" name="wc" placeholder="Número de wc" value="<?php echo $wc; ?>">
        <!-- estacionamiento -->
        <label for="estacionamiento">Estacionamiento</label>
        <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Número de estacionamientos"
          value="<?php echo htmlspecialchars($estacionamiento); ?>">
        <!-- Vendedores -->
        <fieldset>
          <legend>Vendedor</legend>
          <select name="vendedores_id">
            <option value="">--Seleccione--</option>
            <?php while ($vendedor = mysqli_fetch_assoc($vendedoresQuery)) { ?>
              <option value="<?php echo $vendedor['id']; ?>">
                <?php echo $vendedor['nombre'] . " " . $vendedor['apellidos']; ?>
              </option>
            <?php } ?>
          </select>
        </fieldset>
        <button type="submit" class="boton boton-verde">Enviar</button>
    </form>
  </main>
</body>

</html>


<!-- <?php

// if ($_SERVER["REQUEST_METHOD"] == "GET") {


//   if (isset($_GET['titulo'])) {
//     $titulo = $_GET['titulo'];


//     $titulo = filter_var($titulo, FILTER_SANITIZE_STRING);


//     echo "Título: $titulo <br>";
//   } else {
//     echo "All fields are required.";
//   }
// }
?> -->
<?php
incluirTemplate('footer', false);
?>