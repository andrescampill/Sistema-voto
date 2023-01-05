<?php
$titulopag = "Modificar votaciones - Sistema de voto";
include $_SERVER['DOCUMENT_ROOT'] . '/inc/header-panel.php'; ?>

<main class="contenido">
    <?php
    $id = $_GET['id'];
    $sql = "SELECT activa FROM vote WHERE id = '$id'";
    $resultado1 = mysqli_query($conec, $sql);
    $resultado1 = $resultado1->fetch_column(0);
    var_dump($resultado1);
    if ($resultado1 == 1) {
        $v = "0";
    } else {
        $v = "1";
    }
    $sql = "UPDATE `vote` SET `activa` = '$v' WHERE `vote`.`id` = '$id';";
    $resultado = mysqli_query($conec, $sql);
    if ($resultado == 1) {
        header('Location: /panel/vote.php');
    } else {
        echo "Ha habido un error ";
    }
    ?>
</main>