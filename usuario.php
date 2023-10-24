<?php
//importar la conexión
require 'includes/config/database.php';
$db=conectarDB();
//crear un email y un password
$email="correos@correo.com";
$password= "123456";

// hashear password
$passwordHash=password_hash($password,PASSWORD_DEFAULT);

//query para crear el usuario
$query= "INSERT INTO usuarios(email, UPassword) VALUES ('${email}', '${password}');";
echo $query;

//agregarlo a la bd
//mysqli_query($db, $query);
?>