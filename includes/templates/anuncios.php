<?php
//importar la conexión
include 'includes/config/database.php';


// Capture the search query if it exists
$search_term = $_GET['search_term'] ?? null;

//consultar
$db = conectarDB();


// SQL query
if ($search_term) {
    $sql = "SELECT * FROM propiedades WHERE titulo LIKE ?";
    $stmt = $db->prepare($sql);
    if ($stmt === false) {
        die("Failed to prepare SQL statement: " . $db->error);
    }
    $orgValue = $search_term;
    $search_term = '%' . $search_term . '%'; // Use wildcards for LIKE query
    $stmt->bind_param('s', $search_term);
} else {
    $sql = "SELECT * FROM propiedades";
    $stmt = $db->prepare($sql);
}

// Execute and fetch results
$stmt->execute();
$result = $stmt->get_result();

//mysqli_data_seek($result, 0);

?>

<form action="index.php" method="get">
    <input type="text" name="search_term" placeholder="Buscar por titulo..." value="<?php echo $orgValue?>">
    <input type="submit" value="Search">
</form>
<div>
    <p>
        <?php
        if ($result->num_rows === 0) {
            echo "La propiedad seleccionada no existe";
        }
        ?>
    </p>
</div>
<div>
</div>
<?php while ($property = mysqli_fetch_assoc($result)): ?>
    <div class="contenedor-anuncios">
        <div class="anuncio">
            <picture>
                <source srcset="<?php echo "imagenes/" . $property['imagen'] ?>" type="image/webp">
                <source srcset="<?php echo "imagenes/" . $property['imagen'] ?>" type="image/jpeg">
                <img loading="lazy" src="<?php echo "imagenes/" . $property['imagen'] ?>" alt="anuncio">
            </picture>
            <div class="contenido-anuncio">
                <h3>
                    <?php echo $property['titulo']; ?>
                </h3>
                <p class="precio">
                    <?php echo $property['precio']; ?>
                </p>

                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                        <p>
                            <?php echo $property['wc']; ?>
                        </p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg"
                            alt="icono estacionamiento">
                        <p>
                            <?php echo $property['estacionamiento']; ?>
                        </p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                        <p>
                            <?php echo $property['habitaciones']; ?>
                        </p>
                    </li>
                </ul>

                <a href="anuncio.html" class="boton-amarillo-block">
                    Ver Propiedad
                </a>
            </div>
        </div>
    </div>
<?php endwhile; ?>


<?php
//cerrar la conexión

mysqli_close($db);
?>