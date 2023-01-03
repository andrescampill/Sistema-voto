<?php
$titulo = "Votaciones - Sistema de voto";
include $_SERVER['DOCUMENT_ROOT'] . '/inc/header-panel.php';
include $_SERVER['DOCUMENT_ROOT'] . '/config/class.php'
?>
<?php 
$msg = '';
if(isset($_POST['submit'])){
    // Creamos el objeto
    $vote = new vote;
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
    $desc = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_SPECIAL_CHARS);
    $vote->titulo = $titulo;
    $vote->texto = $desc;
    $vote->si = $vote->no = $vote->abs = 0;
    $vote->activa = 1;
    $vote->users = json_encode(array());
    // Lo guardamos en la base de datos
    $sql = "INSERT INTO `vote` (`titulo`, `texto`, `si`, `no`, `abs`, `users`, `activa`) VALUES ('$vote->titulo', '$vote->texto', '$vote->si', '$vote->no', '$vote->abs', '$vote->users', '$vote->activa')";
    $resultado = mysqli_query($conec, $sql);
    if($resultado == true){
        $msg = "Se ha guardado la votación";
    } else {
        $msg = "Ha ocurrido un error: $resultado->error";
    }
}
?>
<main class="contenido">
    <h1>Voatciones</h1>
    <form action="" method="POST">
        <h3>Crear una votación</h3>
        <input type="text" name="titulo" placeholder="Titulo"> <br>
        <input type="text" name="desc" placeholder="Descripción"> <br>
        <input type="submit" name="submit">
        <p><?= $msg ?></p>
    </form>
</main>
<hr>
<!-- Otros sistemas -->

<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/footer.php' ?>