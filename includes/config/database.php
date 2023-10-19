<?php 
    conectarDB();
 function conectarDB(){
    $db= mysqli_connect('localhost','root', '', 'bienesraices_crud');
    if (!$db) {
        echo "no se conectó";
    }
    return $db;
 }?>