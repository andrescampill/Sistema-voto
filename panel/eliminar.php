<?php $titulo = "Borrar usuarios - Sistema de voto";
include $_SERVER['DOCUMENT_ROOT'] . '/inc/header-panel.php' ?>
<?php
$id = $_GET['id'];

    $sql = "DELETE FROM users WHERE id = '$id'";
    $resultado = mysqli_query($conec, $sql);
    if ($resultado == 1) {
        header('Location: /panel/usuarios.php');
    } else {
        echo "Ha habido un error ";
        echo $resultado->error;
    }
?>