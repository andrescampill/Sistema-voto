<?php include 'config/database.php'; ?>
<?php 
session_start();
$user = $cont = '';
$error = '';
if (isset($_POST['submit'])) {
    // Validamos si ha puesto un usuario
    // (Nos lo podriamos saltar pq el HTML tiene puesto el required, pero por si acaso)
    if(empty($_POST['user'])){
        $error = "Tienes que poner todos los datos";
    } else {
        // $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_SPECIAL_CHARS);
        $user = $_POST['user'];
    }

    if(empty($_POST['cont'])){
        $error = "Tienes que poner todos los datos";
    } else {
        $cont = $_POST['cont'];
    }

    $sql = "SELECT * FROM users WHERE user = '$user' AND cont = '$cont'";
    $result = mysqli_query($conec, $sql);
    if($result->num_rows > 0){
        if ($result->fetch_column(4) == 1){
            header('Location: /panel.php');
            $_SESSION['user'] = $user;
            $_SESSION['perm'] = true;
        } else {
        $_SESSION['user'] = $user;
        $_SESSION['perm'] = false;
        header('Location: /inicio.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de voto - FEMAE</title>
    <link rel="stylesheet" href="/styles/index.css">
    
</head>
<body>
    <p class="titulo">Sistema de voto</p>
    <div class="formulario">
        <p>Inicia sesión</p>
        <form action="" method="post">
            <input type="text" name="user" placeholder="Usuario" required> <br>
            <input type="password" name="cont", placeholder="Contraseña" required><br>
            <input type="submit" name="submit" class="submit">
            <?= $error ?>
        </form>
    </div>
    


<?php include 'inc/footer.php'?>