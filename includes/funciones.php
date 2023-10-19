<?php
    include 'app.php';
    function incluirTemplate($nombre,$inicio,$relativePath=''){
        if (!defined('RELATIVE_PATH')) {
            define('RELATIVE_PATH', $relativePath);
        }
        
        include TEMPLATES_URL."\\${nombre}.php";
    }
?>