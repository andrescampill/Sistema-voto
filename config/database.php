<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'andres');
define('DB_PASS', '1234');
define('DB_NAME', 'vote_db');

$conec = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conec->connect_error){
    die('Conexión fallida' . $conec->connect_error);
}
// echo "Connectado con la Base de Datos con exito";
?>