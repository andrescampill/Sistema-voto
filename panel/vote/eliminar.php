<?php
$titulopag = "Eliminar votación - Sistema de voto";
include $_SERVER['DOCUMENT_ROOT'] . '/inc/header-panel.php';
$id = $_GET['id'];

    $sql = "DELETE FROM vote WHERE id = '$id'";
    $resultado = mysqli_query($conec, $sql);
    if ($resultado == 1) {
        header('Location: /panel/vote.php');
    } else {
        echo "Ha habido un error ";
    }

?>