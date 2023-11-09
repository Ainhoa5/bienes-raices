<?php
// Import your function to connect to database
include '../../includes/app.php';

// Check if id_to_update and other fields are set
if(isset($_POST['id_to_update'])) {
    $id_to_update = $_POST['id_to_update'];
    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];
    $habitaciones = $_POST['habitaciones'];
    $wc = $_POST['wc'];
    $estacionamiento = $_POST['estacionamiento'];
    $descripcion = $_POST['descripcion'];
    $vendedores_id = $_POST['vendedores_id'];

    // Connect to the database
    $db = conectarDB();

    // Update query
    $query = "UPDATE propiedades SET 
            titulo = '$titulo', 
            precio = '$precio', 
            habitaciones = '$habitaciones', 
            wc = '$wc', 
            estacionamiento = '$estacionamiento', 
            descripcion = '$descripcion',
            vendedores_id = '$vendedores_id'
          WHERE id = '$id_to_update'";

    // Execute the query
    if(mysqli_query($db, $query)) {
        header("Location: consultar.php");
    } else {
        echo "Error: " . mysqli_error($db);
    }

    // Close the database connection
    mysqli_close($db);
}
?>
