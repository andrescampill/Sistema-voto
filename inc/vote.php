<?php
$sql = "SELECT * FROM `vote` WHERE `activa` = '1'";
$resultado = mysqli_query($conec, $sql);
$msg = $d = $op = $total = '';
$user = $_SESSION['user'];
$encriptkey = 'MejorFederacion';
$AES = "AES-256-ECB";
$d = $sii = $noi = $absi = '';
$r = $resultado->fetch_assoc();
$tipo = @$r["type"];
if ($resultado->num_rows > 0) {
    $titulo = $r["titulo"];
    $desc = $r["texto"];
    $id = $r["id"];
    $oper = json_decode($r["op"], true);
    $users = json_decode($r['users'], true);
    $user = strtolower($user);
    if (!in_array("$user", $users)) {
        if ($r["type"] != "per") { // Cuando es normal
            if (isset($_POST['submit'])) {
                if (!empty($id)) {
                    switch ($_POST['op']) {
                        case "si":
                            $sql = "UPDATE `vote` SET `si` = `si` + 1 WHERE `vote`.`id` = '$id';";
                            $resultado = mysqli_query($conec, $sql);
                            $user = strtolower($user);
                            array_push($users, $user);
                            $users = json_encode($users);
                            $sql2 = "UPDATE `vote` SET `users` = '$users' WHERE `vote`.`id` = '$id';";
                            $resultado2 = mysqli_query($conec, $sql2);
                            if ($resultado == true && $resultado2 == true) {
                                $msg = "Tu voto se ha guardado correctamente";
                                $si = openssl_encrypt("si", $AES, $encriptkey);
                                header("Refresh:3");
                                setcookie("id", $id, time() + 1800);
                                setcookie("op", $si, time() + 1800, true);
                            } else {
                                $msg = "Ha habido un error: {$resultado->error} y {$resultado2->error}";
                            }
                            break;
                        case "no":
                            $sql = "UPDATE `vote` SET `no` = `no` + 1 WHERE `vote`.`id` = '$id';";
                            $resultado = mysqli_query($conec, $sql);
                            $user = strtolower($user);
                            array_push($users, $user);
                            $users = json_encode($users);
                            $sql2 = "UPDATE `vote` SET `users` = '$users' WHERE `vote`.`id` = '$id';";
                            $resultado2 = mysqli_query($conec, $sql2);
                            if ($resultado == true && $resultado2 == true) {
                                $msg = "Tu voto se ha guardado correctamente";
                                header("Refresh:3");
                                $no = openssl_encrypt("no", $AES, $encriptkey);
                                setcookie("id", $id, time() + 1800);
                                setcookie("op", "$no", time() + 1800, true);
                            } else {
                                $msg = "Ha habido un error:{$resultado->error} y {$resultado2->error}";
                            }
                            break;
                        case "abs":
                            $sql = "UPDATE `vote` SET `abs` = `abs` + 1 WHERE `vote`.`id` = '$id';";
                            $resultado = mysqli_query($conec, $sql);
                            $user = strtolower($user);
                            array_push($users, $user);
                            $users = json_encode($users);
                            $sql2 = "UPDATE `vote` SET `users` = '$users' WHERE `vote`.`id` = '$id';";
                            $resultado2 = mysqli_query($conec, $sql2);
                            if ($resultado == true && $resultado2 == true) {
                                $msg = "Tu voto se ha guardado correctamente";
                                header("Refresh:3");
                                $abs = openssl_encrypt("abs", $AES, $encriptkey);
                                setcookie("id", $id, time() + 1800);
                                setcookie("op", "$abs", time() + 1800, true);
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
            // Cuando es personalizado
            $max = $r["max"];
            $total = '<p class="v" style="font-size: 13px;"> Puedes seleccionar un total de ' . $max . ' casilla(s).</p>';
            $a = 0;
            if (isset($_POST['submit'])) {
                $i = 0;
                if ($max == 1) {
                    foreach ($oper as $opcion) {
                        foreach ($opcion as $opcion => $value) {
                            // $oper = array
                            // $Opcion = Letra
                            // $value = valor
                            if (@$_POST[$opcion]) { // Solo actualizamos el valor si el usuario lo ha puesto.
                                // Actualizamos el valor
                                $oper[$i][$opcion] = $value + 1;
                                $option = json_encode($oper);
                                $user = strtolower($user); // Actualizamos el usuario en la lista, identico al normal.
                                array_push($users, $user);
                                $users = json_encode($users);
                                $sql = "UPDATE `vote` SET `users` = '$users', `op` = '$option' WHERE `vote`.`id` = '$id';";
                                $resultado = mysqli_query($conec, $sql);
                                if ($resultado == true) {
                                    $msg = "Se ha guardado la votación";
                                    $op1 = $opcion;
                                    setcookie("id", $id, time() + 1800);
                                    setcookie("op", $op1, time() + 1800, true);
                                    header("Refresh:3");
                                } else {
                                    $msg = "Ha ocurrido un error: $resultado";
                                }
                            }
                        }
                        $i = $i + 1;
                    }
                } else {
                    // Si el maximo de votos es > 1
                    foreach ($oper as $opcion) {
                        foreach ($opcion as $opcion => $value) {
                            if (@$_POST[$opcion]) {
                                $a = $a + 1;
                            }
                        }
                    }
                    if ($a <= $max) {
                        // Tiene menos que las maximas. BIEN
                        $opcionc = [];
                        foreach ($oper as $opcion) {
                            foreach ($opcion as $opcion => $value) {
                                if (@$_POST[$opcion]) {
                                    $oper[$i][$opcion] = $value + 1;
                                    array_push($opcionc, $opcion);
                                }
                            }
                            $i = $i + 1;
                        }
                        $option = json_encode($oper);
                        $user = strtolower($user); // Actualizamos el usuario en la lista, identico al normal.
                        array_push($users, $user);
                        $users = json_encode($users);
                        $sql = "UPDATE `vote` SET `users` = '$users', `op` = '$option' WHERE `vote`.`id` = '$id';";
                        $resultado = mysqli_query($conec, $sql);
                        if ($resultado == true) {
                            $msg = "Se ha guardado la votación";
                            $opcionc = implode(', ', $opcionc);
                            $op1 = $opcionc;
                            setcookie("id", $id, time() + 1800);
                            setcookie("op", $op1, time() + 1800, true);
                            header("Refresh:3");
                        } else {
                            $msg = "Ha ocurrido un error: $resultado";
                        }
                    } else { // Tiene más de las permitidas.
                        $msg = "Puedes seleccionar $max opciones como maximo.";
                    }
                }
            }
        }
    } else {
        if (@$_COOKIE['id'] && @$_COOKIE['op']) {
            if ($r["type"] != "per") {
                $msg = "¡Ya has votado en la votación activa! Tu voto se ha registrado correctamente <br> Puedes observar arriba lo que has votado en la <b>última</b> votación";
                $vid = $_COOKIE['id'];
                $op = openssl_decrypt($_COOKIE['op'], $AES, $encriptkey);
                $d = "disabled";
                $sql = "SELECT * FROM `vote` WHERE `id` = '$vid'";
                $resultado = mysqli_query($conec, $sql);
                $r = $resultado->fetch_assoc();
                if ($r && $vid == $id) {
                    $titulo = $r["titulo"];
                    $desc = $r["texto"];
                    switch ($op) {
                        case "si":
                            $sii = "checked";
                            break;
                        case "no":
                            $noi = "checked";
                            break;
                        case "abs":
                            $absi = "checked";
                            break;
                    }
                } else {
                    $msg = "Has votado y tu repuesta se ha guardado correctamente.";
                    echo "<style>.v{
        display: none;
        }</style>";
                }
            } else {
                // $op = openssl_decrypt($_COOKIE['op'], $AES, $encriptkey); // Más adelante se arregla en el formulario.
                $op = $_COOKIE['op'];
                $d = "disabled";
                $msg = "¡Ya has votado en la votación activa! Tu voto se ha registrado correctamente <br> Puedes observar arriba lo que has votado en la <b>última</b> votación.";
                $cookiew = true;
            }
        } else {
            $msg = "Has votado y tu repuesta se ha guardado correctamente.";
            echo "<style>.v{
    display: none;
    }</style>";
        }
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
        <?= $total ?>
        <?php
        if ($tipo != "per") {
            // Añadimos los campos normales para cuando son normales.
            echo '<input type="radio" name="op" value="si" class="v r" required ' . $d . ' ' . $sii . '> <label for="si" class="v rt">A favor</label> <br>
            <input type="radio" name="op" value="no" class="v r" required ' . $d . ' ' . $noi . '> <label for="si" class="v rt">En contra</label> <br>
            <input type="radio" name="op" value="abs" class="v r" required ' . $d . ' ' . $absi . '> <label for="si" class="v rt">Abstención</label> <br>';
        } else {
            // Si son personalizados tenemos que añadir campos personalizados.
            foreach ($oper as $opcion) {
                foreach ($opcion as $opcion => $value) {
                    if ($opcion != 0) {
                        if (!empty($cookiew)) {
                            $op2 = explode(", ", $op);
                            if (in_array($opcion, $op2)) {
                                $opcionc = "checked";
                            } else {
                                $opcionc = "";
                            }
                        } else {
                            $opcionc = "";
                        }
                        echo '<input type="checkbox" name="' . $opcion . '" value="' . $opcion . '" class="v r" ' . $opcionc . ' ' . $d . ' > <label for="si" class="v rt">' . $opcion . '</label> <br>';
                    }
                }
            }
        }
        ?>
        <input type="submit" name="submit" class="v b" <?= $d ?>>
        <p class="msg"><?= $msg ?></p>
    </form>
</div>