<?php
// Import your function to connect to database
include '../../includes/config/database.php';

// Check if id_to_delete is set
if (isset($_POST['id_to_delete'])) {
    $id_to_delete = $_POST['id_to_delete'];

    // Connect to the database
    $db = conectarDB();
    // Fetch existing record
    $query = "SELECT imagen FROM propiedades WHERE id = '$id_to_edit'";
    $result = mysqli_query($db, $query);
    $property = mysqli_fetch_assoc($result);
    
    // Create delete query
    $query = "DELETE FROM propiedades WHERE id = '$id_to_delete'";

    // Eliminar imagen

    // Execute the query
    if (mysqli_query($db, $query)) {
        // Redirect to the previous page or a specific location
        header("Location: consultar.php");
    } else {
        echo "Error: " . mysqli_error($db);
    }

    // Close the database connection
    mysqli_close($db);
}
?>