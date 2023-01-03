<?php
$sql = "SELECT * FROM `vote` WHERE `activa` = '1'";
$resultado = mysqli_query($conec, $sql);
$msg = '';
$user = $_SESSION['user'];
if ($resultado->num_rows > 0) {
    $r = $resultado->fetch_assoc();
    $titulo = $r["titulo"];
    $desc = $r["texto"];
    $id = $r["id"];
    $users = json_decode($r['users'], true);
    if (!in_array("$user", $users)) {
        if (isset($_POST['submit'])) {
            if (!empty($id)) {
                switch ($_POST['op']) {
                    case "si":
                        $sql = "UPDATE `vote` SET `si` = `si` + 1 WHERE `vote`.`id` = '$id';";
                        $resultado = mysqli_query($conec, $sql);
                        array_push($users, $user);
                        $users = json_encode($users);
                        $sql2 = "UPDATE `vote` SET `users` = '$users' WHERE `vote`.`id` = '$id';";
                        $resultado2 = mysqli_query($conec, $sql2);
                        if ($resultado == true && $resultado2 == true) {
                            $msg = "Tu voto se ha guardado correctamente";
                            header("Refresh:3");
                        } else {
                            $msg = "Ha habido un error:{$resultado->error} y {$resultado2->error}";
                        }
                        break;
                    case "no":
                        $sql = "UPDATE `vote` SET `no` = `no` + 1 WHERE `vote`.`id` = '$id';";
                        $resultado = mysqli_query($conec, $sql);
                        array_push($users, $user);
                        $users = json_encode($users);
                        $sql2 = "UPDATE `vote` SET `users` = '$users' WHERE `vote`.`id` = '$id';";
                        $resultado2 = mysqli_query($conec, $sql2);
                        if ($resultado == true && $resultado2 == true) {
                            $msg = "Tu voto se ha guardado correctamente";
                            header("Refresh:3");
                        } else {
                            $msg = "Ha habido un error:{$resultado->error} y {$resultado2->error}";
                        }
                        break;
                    case "abs":
                        $sql = "UPDATE `vote` SET `abs` = `abs` + 1 WHERE `vote`.`id` = '$id';";
                        $resultado = mysqli_query($conec, $sql);
                        array_push($users, $user);
                        $users = json_encode($users);
                        $sql2 = "UPDATE `vote` SET `users` = '$users' WHERE `vote`.`id` = '$id';";
                        $resultado2 = mysqli_query($conec, $sql2);
                        if ($resultado == true && $resultado2 == true) {
                            $msg = "Tu voto se ha guardado correctamente";
                            header("Refresh:3");
                        } else {
                            $msg = "Ha habido un error:{$resultado->error} y {$resultado2->error}";
                        }
                        break;
                }
            } else {
                $msg = "No hay ninguna votación activa";
            }
        }
    } else {
        $msg = "Ya has votado y tu voto se ha registrado correctamente";
        echo "<style>.v{
            display: none;
            }</style>";
    }
} else {
    $msg = "No existe ninguna votación en el momento";
    echo "<style>.v{
        display: none;
        }</style>";
}
?>
<div class="form">
    <form method="post" class="vote" class="v">
        <h1 class="v"><?= $titulo ?></h1>
        <p class="v"><?= $desc ?></p>
        <input type="radio" name="op" value="si" class="v r" required> <label for="si" class="v rt">A favor</label> <br>
        <input type="radio" name="op" value="no" class="v r" required> <label for="si" class="v rt">En contra</label> <br>
        <input type="radio" name="op" value="abs" class="v r" required> <label for="si" class="v rt">Abstención</label> <br>
        <input type="submit" name="submit" class="v b">
        <p><?= $msg ?></p>
    </form>
</div>