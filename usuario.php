<?php
//importar la conexión
require 'includes/config/database.php';
require '../../includes/funciones.php';
$auth=estaAutenticado();
if(!$auth){
    header('Location: /');
}
$db=conectarDB();
//crear un email y un password
$name="Ainhoa";
$email="roxyaa111@gmail.com";
$password= "123456";

// hashear password
$passwordHash=password_hash($password,PASSWORD_DEFAULT);

//query para crear el usuario
$query= "INSERT INTO usuarios(Nombre, Email, UPassword) VALUES ('${name}', '${email}', '${passwordHash}');";
echo $query;

//agregarlo a la bd
mysqli_query($db, $query);
?>