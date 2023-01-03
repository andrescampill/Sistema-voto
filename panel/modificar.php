<?php
$titulo = "Modificar usuarios - Sistema de voto";
include $_SERVER['DOCUMENT_ROOT'] . '/inc/header-panel.php';
?>
<?php
// Personalizarmos los datos del formulario
$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id = '$id'";
$resultado = mysqli_query($conec, $sql);
$bd = $resultado->fetch_assoc();
$user = $bd["user"];
$nombre = $bd["nombre"];
$cont = $bd["cont"];
if ($bd["perm"] == 1) {
    $perm = "checked";
} else {
    $perm = '';
}
$msg ='';
// Conseguimos los datos y los enviamos
if(isset($_POST['submit'])){
    if(!empty($_POST['user'])){
        if(!empty($_POST['nombre'])){
            if(!empty($_POST['cont'])){
                if(!empty($_POST['cont2'])){
                    if($_POST['cont'] == $_POST['cont2']){
                        // El formulario esta completo y correcto
                        $usernew = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_SPECIAL_CHARS);
                        $nombrenew = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
                        $contnew = $_POST['cont'];
                        if (isset($_POST['perm'])) {
                            $permnew = 1;
                        } else {
                            $permnew = 0;
                        }
                        //Comprobamos si existe ese usuario
                        if($usernew == $user){
                            $sql = "UPDATE users SET `user`='$usernew', `nombre`='$nombrenew', `cont`='$contnew', `perm`='$permnew'  WHERE `users`.`id` = '$id';";
                            $result = mysqli_query($conec, $sql);
                            if($result == true){
                                $msg = "Usuario: $user actualizado correctamente";
                            }
                        }else { 
                        $usersql = "SELECT * FROM users WHERE user = '$usernew'";
                        $userresult = mysqli_query($conec, $usersql);
                        if ($userresult->num_rows == 0){
                            // No existe usuario igual
                            $sql = "UPDATE users SET `user`='$usernew', `nombre`='$nombrenew', `cont`='$contnew', `perm`='$permnew'  WHERE `users`.`id` = '$id';";
                            $result = mysqli_query($conec, $sql);
                            if($result == true){
                                echo "Actualizado correctamente";
                            }
                            } else{
                                $msg = "Error, existe una persona con ese mismo usuario";
                            }
                        }
                        } else {
                            $msg = "Las contraseñas no coinciden";
                        }
                    }
                }
            }
        }
    }
?>
<link rel="stylesheet" href="/styles/modificar.php.css">
<main class="contenido">
    <h1>Modificar usuario</h1>
    <div class="form">
    <form method="post">
        <label for="id">ID: </label><input type="number" name="id" disabled value=<?= $id ?>>
        <a href="#" class="tooltip">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-help help" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <circle cx="12" cy="12" r="9"></circle>
                <line x1="12" y1="17" x2="12" y2="17.01"></line>
                <path d="M12 13.5a1.5 1.5 0 0 1 1 -1.5a2.6 2.6 0 1 0 -3 -4"></path>
            </svg>
            <span class="tooltip-top">No se puede moficiar el ID.</span>
        </a>

        <br>
        <label for="user">Usuario:</label><input type="text" name="user" value="<?= $user ?>" required> <br>
        <label for="nombre">Nombre: </label><input type="text" name="nombre" value="<?= $nombre ?>" required> <br>
        <label for="cont">Contraseña: </label><input type="text" name="cont" value="<?= $cont ?>" required> <br>
        <label for="cont2">Repetir contrasñea: </label><input type="text" name="cont2" required> <br>
        <label for="perm">Permisos</label><input type="checkbox" name="perm" <?= $perm ?>><br>
        <input type="submit" name="submit" class="submit">
        <p class="msg"><?= $msg ?></p>
    </form>
    </div>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/footer.php' ?>