<?php
include '../../includes/app.php';
use App\Propiedad;
$propiedades = Propiedad::all();

incluirTemplate('header', false, '../../');

// Connect to the database
$db = conectarDB();
$carpetaImagenes = '../../imagenes';
// Check if the connection is successful
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL query to retrieve data from the 'propiedades' table
$sql = "SELECT * FROM propiedades";

// Execute the query
$result = mysqli_query($db, $sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Propiedades</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Editar</th>
                <th>Borrar</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($propiedades as $propiedad):?>
                <tr>
                    <td>
                        <?php echo $propiedad->id; ?>
                    </td>
                    <td>
                        <?php echo $propiedad->titulo; ?>
                    </td>
                    <td>
                        <?php echo $propiedad->precio; ?>
                    </td>
                    <!-- Image display starts here -->
                    <td>
                        <img src="<?php echo $carpetaImagenes . '/' . $propiedad->imagen; ?>" alt="Property Image" width="50"
                            onerror="this.onerror=null; this.width='100'; this.src='<?php echo $carpetaImagenes . '/' ?>default_image.png'">
                    </td>
                    <!-- Image display ends here -->
                    <td>
                        <form action="editar.php" method="GET">
                            <input type="hidden" name="id_to_edit" value="<?php echo $propiedad->id; ?>">
                            <input type="submit" value="Edit">
                        </form>
                    </td>
                    <td>
                        <form action="eliminar.php" method="POST">
                            <input type="hidden" name="id_to_delete" value="<?php echo $propiedad->id ?>">
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>
<?php
// Close the database connection
mysqli_close($db);
incluirTemplate('footer', false);
?>