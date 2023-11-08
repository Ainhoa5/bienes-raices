<?php
require './includes/config/database.php';
$db = conectarDB();
$errores = [];
function callErrors($errores){
    foreach ($errores as $error) { ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php
    }
}

//validación del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $UPassword = mysqli_real_escape_string($db, $_POST['UPassword']);
    //comprobamos errores
    if (!$email) {
        $errores[] = "El email es obligatorio o no es válido";
    }

    if (!$UPassword) {
        $errores[] = "El password es obligatorio";
    }
    //en caso de no haber errores
    if (empty($errores)) {
        //revisar si el usuario existe
        $query = "SELECT * FROM usuarios WHERE  email='${email}'";
        $resultado = mysqli_query($db, $query);
        if ($resultado->num_rows) {
            //revisar si el password es correcto
            $usuario = mysqli_fetch_assoc($resultado);
            //nos devolverá true o false en el caso de que el password guardado en la bd sea igual al pasado por post
            $auth = password_verify($UPassword, $usuario["UPassword"]);
            if ($auth) {
                //el usuario está autentificado
                session_start();
                // echo "<pre>";
                // var_dump($_SESSION);
                // echo "</pre>";
                //llenamos los datos de la sesión
                $_SESSION["usuario"]=$usuario["email"];
                $_SESSION["login"]=true;
                header('Location: /admin');
            } else {
                $errores[] = "El password es incorrecto";
                callErrors($errores);
            }
        } else {
            $errores[] = "El usuario no existe";
            callErrors($errores);
        }

    }
}
//inclusión del encabezado
require './includes/funciones.php';
incluirTemplate('header', false, '');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="build/css/app.css">
</head>

<body>
    <form method="POST" class="formulario">
        <fieldset>
            <legend>Email y Password</legend>

            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="Tu Email" id="email" required>

            <label for="UPassword">Password</label>
            <input type="password" name="UPassword" placeholder="UPassword" id="UPassword" required>


        </fieldset>
        <input type="submit" value="Iniciar sesión" class="boton boton-verde">

    </form>
</body>

</html>