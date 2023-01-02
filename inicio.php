<?php
session_start();
if (isset($_SESSION['user'])) {
} else {
    header('Location: /');
}

?>
<!-- HEADER -->
<?php include "inc/header.php" ?>
<?php
if ($_SESSION['perm'] == 1) {
    echo 'Tienes permisos de administrador, <a href="/panel.php"><button>Ir al panel de administrador</button></a>';
}
?>

<?php include "inc/footer.php" ?>