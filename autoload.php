<?php
spl_autoload_register(function($class) {    
    $filename = __DIR__ . "/class/$class.php";
    $filename = str_replace('\\', '/', $filename);

    if ( file_exists($filename) ) {
        require_once($filename);
    } else {
        echo '<div class="alert alert-danger">Erro ao carregar a classe ' . $filename . '</div>';
    }
});