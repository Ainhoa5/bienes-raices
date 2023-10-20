<?php
//importar la conexión
include 'includes/config/database.php';

//consultar
$db = conectarDB();
$sql = "SELECT * FROM propiedades";
$result = mysqli_query($db, $sql); 
// Reiniciar el puntero del resultado, en caso de que sea necesario
mysqli_data_seek($result, 0);

?>

<?php while($property = mysqli_fetch_assoc($result)): ?>
<div class="contenedor-anuncios">
    <div class="anuncio">
        <picture>
            <source srcset="<?php echo "imagenes/".$property['imagen']?>" type="image/webp">
            <source srcset="<?php echo "imagenes/".$property['imagen']?>" type="image/jpeg">
            <img loading="lazy" src="<?php echo "imagenes/".$property['imagen']?>" alt="anuncio">
        </picture>
        <div class="contenido-anuncio">
            <h3><?php echo $property['titulo']; ?></h3>
            <p class="precio"><?php echo $property['precio']; ?></p>

            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo $property['wc']; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg"
                        alt="icono estacionamiento">
                    <p><?php echo $property['estacionamiento']; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p><?php echo $property['habitaciones']; ?></p>
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