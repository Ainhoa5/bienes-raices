<?php
include '../../includes/funciones.php';
incluirTemplate('header', false, '../../');
// Import your function to connect to database
include '../../includes/config/database.php';
// Check if id_to_edit is set from GET request
if (isset($_GET['id_to_edit'])) {
    $id_to_edit = $_GET['id_to_edit'];

    // Connect to the database
    $db = conectarDB();

    // Fetch existing record
    $query = "SELECT * FROM propiedades WHERE id = '$id_to_edit'";
    $result = mysqli_query($db, $query);

    $property = mysqli_fetch_assoc($result);
}

// Close the database connection
mysqli_close($db);
?>
<?php
// Connect to the database
$db = conectarDB();

// Fetch all vendors
$vendorQuery = "SELECT * FROM vendedores";
$vendorResult = mysqli_query($db, $vendorQuery);

// Array to store all vendors
$vendors = [];
while ($vendor = mysqli_fetch_assoc($vendorResult)) {
    $vendors[] = $vendor;
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

    <main class="contenedor seccion">
        <h1>Editar</h1>

        <form class="formulario" action="update.php" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend> Información General</legend>
                <!-- ID -->
                <input type="hidden" name="id_to_update" value="<?php echo $property['id']; ?>">
                <!-- Titulo -->
                <label for="titulo">Título: </label>
                <input type="text" name="titulo" value="<?php echo $property['titulo']; ?>">
                <!-- Precio -->
                <label for="precio">Precio</label>
                <input type="number" name="precio" id="precio" value="<?php echo $property['precio']; ?>">
                <!-- habitaciones -->
                <label for="habitaciones">habitaciones</label>
                <input type="number" name="habitaciones" id="habitaciones"
                    value="<?php echo $property['habitaciones']; ?>">
                <!-- wc -->
                <label for="wc">wc</label>
                <input type="number" id="wc" name="wc" placeholder="Número de wc" value="<?php echo $wc; ?>">
                <!-- estacionamiento -->
                <label for="estacionamiento">Estacionamiento</label>
                <input type="number" name="estacionamiento" id="estacionamiento"
                    value="<?php echo $property['estacionamiento']; ?>">
                <!-- Imagen -->
                <!-- <label for="current_image">Current Image:</label>
                <img src="<?php echo '../../imagenes/' . $property['imagen']; ?>" alt="Current Property Image"
                    width="100" onerror="this.onerror=null; this.src='default_image.png'">
                <label for="imagen">Imagen: </label>
                <input type="file" name="imagen" id="imagen" accept="image/jpeg, image/png"
                    value="<?php echo $property['imagen']; ?>"> -->
                <!-- Descipcion -->
                <label for="descripcion">Descipción</label>
                <textarea name="descripcion" id="descripcion" cols="30"
                    rows="10"><?php echo $property['descripcion']; ?></textarea>
                <!-- Vendedores -->
                <fieldset>
                    <legend>Vendedor</legend>
                    <select name="vendedores_id" id="vendedores_id">
                <?php foreach($vendors as $vendor): ?>
                    <option 
                        value="<?php echo $vendor['id']; ?>" 
                        <?php echo $property['vendedores_id'] == $vendor['id'] ? 'selected' : ''; ?>
                    >
                        <?php echo $vendor['nombre']; // Or whatever the vendor's name field is ?>
                    </option>
                <?php endforeach; ?>
                </select>
                </fieldset>
                <button type="submit" class="boton boton-verde">Enviar</button>
        </form>
    </main>
</body>

</html>
<?php
incluirTemplate('footer', false);
?>