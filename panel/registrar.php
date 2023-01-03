<?php // Codigo base
$titulo = "Usuario - Sistema de voto FEMAE";
include $_SERVER['DOCUMENT_ROOT'] . '/inc/header-panel.php';
?>
<!-- Pagina en si -->
<?php
$error = '';
$nombre = $cont = $cont2 = $user = $perm = '';
$class = $disabled = '';

if (isset($_POST['submit'])) {
    $cont = $_POST['cont'];
    $cont2 = $_POST['cont2'];
    if (!empty($cont)) {
        if ($cont == $cont2) {
            if (!empty($_POST['user'])) {
                if (!empty($_POST['user'])) {
                    $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_SPECIAL_CHARS);
                    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
                    $cont = $_POST['cont'];
                    if (isset($_POST['perm'])) {
                        $perm = 1;
                    } else {
                        $perm = 0;
                    }
                    $por = $_SESSION['user'];
                    // Ya tenemos todos los datos en las variables.
                    // Primero comprobamos si existe un usuario con ese user
                    $sql1 = "SELECT * FROM users WHERE user = '$user'";
                    $resuser = mysqli_query($conec, $sql1);
                    if ($resuser->num_rows == 0) {
                        $sql = "INSERT INTO users (user, nombre, cont, perm, por) VALUES ('{$user}', '{$nombre}', '{$cont}', '{$perm}', '{$por}')";
                        $resultado = mysqli_query($conec, $sql);
                        if ($resultado == true) {
                            $error = "Se ha creado correctamente";
                        } else {
                            // REVISAR 
                            // $error = "Ha habido un error en el proceso: {$resultado->error}";
                        }
                    } else {
                        $error = "Ya existe una persona con ese usuario";
                        $class = "invalid";
                    }
                } else {
                    $error = "Tienes que poner un nombre";
                }
            } else {
                $error = "Tienes que poner un usuario";
            }
        } else {
            $error = "Contraseña diferente";
        }
    } else {
        $error = "Tienes que poner una contraseña";
    }
}
?>
<link rel="stylesheet" href="/styles/registrar.css">
<main class="contenido">
    <h1>Registrar a usuarios</h1>
    <div class="form">
        <form action="/panel/registrar.php" method="post" class="register">
            <div class="input">
                <input type="text" name="user" class="user <?= $class ?>" placeholder="Usuario" required>
                <input type="text" name="nombre" class="nombre <?= $class ?>" placeholder="Nombre completo" required><br>
                <input type="password" name="cont" class="cont <?= $class ?>" placeholder="Contraseña" id="password" required><br>
                <input type="password" name="cont2" class="cont2 <?= $class ?>" placeholder="Repite la contraseña" id="confirm_password" required> <br>
            </div>
            <input type="checkbox" name="perm" class="perm" placeholder="Permisos"> <label for="perm" class="perm label">Permisos</label> <br>
            <input type="submit" class="submit" name="submit">
            <button onclick="history.back(-2)" class="atras">Atras / Cancelar </button> <br>
            <p class="error" <?= $class ?>><?= $error ?><p>
    </div>
    </form>
            

</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/footer.php' ?>