<?php
session_start();
if (isset($_SESSION['user'])) {
} else {
    header('Location: /');
}
include $_SERVER['DOCUMENT_ROOT'] . '/config/class.php';
include "inc/header.php" 
?>
<?php
 // Comprobamos si hay alguna votación activa
if ($_SESSION['perm'] == 1) {
    echo 'Tienes permisos de administrador, <a href="/panel.php"><button>Ir al panel de administrador</button></a>';
}
?>
<!-- Contenido -->
<?php include 'inc/vote.php'?>
<?php include "inc/footer.php" ?>