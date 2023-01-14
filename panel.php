<?php $titulopag = "Panel - Sistema de voto - FEMAE";
include "inc/header-panel.php"; ?>
<link rel="stylesheet" href="/styles/panel.css">
<main class="contenido">
    <?php
    $user = $_SESSION['user'];
    //Conseguimos el nombre complreto
    $sql = "SELECT * FROM users WHERE user = '$user'";
    $resnom = mysqli_query($conec, $sql);
    $nom = $resnom->fetch_column(2);
    if (date('H') < 13) {
        echo '<h1>Buenos días ' . $nom . '</h1>';
    } elseif (date('H') >= 13 && date('H') < 20) {
        echo '<h1>Buenas tardes ' . $nom . '</h1>';
    } elseif (date('H') >= 20) {
        echo '<h1>Buenas noches ' . $nom . '</h1>';
    } else {
    }
    ?>
    <br>
    <?php include 'inc/vote.php'?>
</main>
<?php include 'inc/footer.php' ?>