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
    echo '<div class="t">Tienes permisos de administrador, <a href="/panel.php"><button>Ir al panel de administrador</button></a></div>';
}
?>
<link rel="stylesheet" href="/styles/inicio.css">
<!-- Contenido -->
<link rel="stylesheet" href="/styles/form-user.css">
<?php include 'inc/vote.php'?>
<?php include "inc/footer.php" ?>