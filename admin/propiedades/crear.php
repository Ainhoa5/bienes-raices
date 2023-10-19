<?php
include '../../includes/funciones.php';
include '../../includes/config/database.php';
incluirTemplate('header', false, '../../');
$db = conectarDB();

//consultar para obtener a los vendedores
$consulta = "SELECT * FROM vendedores;";
$vendedoresQuery = mysqli_query($db, $consulta);

/* echo "<pre>";
var_dump($vendedoresQuery);
echo "</pre>";
exit; */
//inicializo los errores
$errores = [];

// inicializo las variables a vacío
$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedores_id = '';
$creado = date("Y-m-d"); // Obtiene la fecha actual en formato "YYYY-MM-DD"


if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $titulo = $_POST['titulo'];
  $precio = $_POST['precio'];
  $descripcion = $_POST['descripcion'];
  $habitaciones = $_POST['habitaciones'];
  $wc = $_POST['wc'];
  $estacionamiento = $_POST['estacionamiento'];
  $vendedores_id = $_POST['vendedores_id'];
  $imagen = $_FILES['imagen'];


  //comprobación de los datos
  if (!$titulo) {
    $errores[] = "Debes añadir un título";
  }
  if (!$precio) {
    $errores[] = "Debes añadir un precio";
  }
  if (strlen($descripcion) < 50) {
    $errores[] = "Debes añadir una descripcion y debe tener al menos 50 caracteres";
  }
  if (!$habitaciones) {
    $errores[] = "Debes añadir el número de habitaciones";
  }
  if (!$wc) {
    $errores[] = "Debes añadir el número de wc";
  }
  if (!$estacionamiento) {
    $errores[] = "Debes añadir el número de estacionamientos";
  }
  if (!$imagen['name']) {
    $errores[] = "La imagen es obligatoria";
  }
  //validar la imagen por tamaño
  //medida máxima en kb
  $medida = 100;
  if (($imagen['size'] / 1024) > $medida) {
    $errores[] = "Reduzca el tamaño de la imagen, debe ser menor a" . $medida . "Kb.";
  }
  //creamos la carpeta imágenes en la raíz del proyecto si es que no existe
  $carpetaImagenes = '../../imagenes';
  if (!is_dir($carpetaImagenes)) {
    mkdir($carpetaImagenes);
  }

  if (empty($errores)) {
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg"; //Generar nombre único
    $rutaCompletaImagen = $carpetaImagenes . '/' . $nombreImagen; // Ruta completa con barra diagonal
    move_uploaded_file($imagen['tmp_name'], $rutaCompletaImagen); // Subir archivo
    //Contenido de los insert
    $query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id)
   VALUES ('$titulo', '$precio', '$nombreImagen', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedores_id');
   ";
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $resultado = mysqli_query($db, $query);

    if ($resultado) {
      //echo "Insertado correctamente";
    } else {
      echo "No se ha insertado correctamente: " . mysqli_error($db);
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
        >
      </div>

    <?php } ?>

    <a href="/admin/" class="boton boton-verde">Volver</a>
    <form class="formulario" method="POST" action="crear.php" enctype="multipart/form-data">
      <fieldset>
        <legend> Información General</legend>
        <!-- Titulo -->
        <label for="titulo">Título: </label>
        <input type="text" id="titulo" name="titulo" placeholder="Título propiedad" value="<?php echo $titulo; ?>">
        <!-- Precio -->
        <label for="precio">Precio</label>
        <input type="number" id="precio" name="precio" placeholder="Type a price" value="<?php echo $precio; ?>">
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
          value="<?php echo $estacionamiento; ?>">
        <!-- Imagen -->
        <label for="imagen">Imagen: </label>
        <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">
        <!-- Descipcion -->
        <label for="descripcion">Descipción</label>
        <textarea name="descripcion" id="Descipcion" placeholder="Descripcion" cols="30"
          rows="10"><?php echo $descripcion; ?></textarea>
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