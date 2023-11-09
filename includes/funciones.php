<?php

define('TEMPLATES_URL', __DIR__ . '\\templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
function incluirTemplate($nombre, $inicio, $relativePath = '')
{
    if (!defined('RELATIVE_PATH')) {
        define('RELATIVE_PATH', $relativePath);
    }

    include TEMPLATES_URL . "\\${nombre}.php";
}
function estaAutenticado(): bool
{
    session_start();
    $auth = $_SESSION['login'];
    if ($auth) {
        return true;
    }
    return false;

}
?>