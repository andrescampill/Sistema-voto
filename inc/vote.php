<?php 
$sql = "SELECT * FROM `vote` WHERE `activa` = '1'";
$resultado = mysqli_query($conec, $sql);
if($resultado->num_rows > 0){
    $r = $resultado->fetch_assoc();
    $titulo = $r["titulo"];
    $desc = $r["texto"];
    $id = $r["id"];
} else {
    echo "No existe ninguna votación en el momento <br>";
    echo "<style>.v{
        display: none;
        visibility: hidden;
        }</style>";
}
if(isset($_POST['submit'])){
    if(!empty($id)){
        switch($_POST['op']){
            case "si":
                $sql = "UPDATE `vote` SET `si` = `si` + 1 WHERE `vote`.`id` = '$id';";
                $resultado = mysqli_query($conec, $sql);
                if ($resultado == true){
                    echo "Tu voto se ha guardado correctamente";
                } else {
                    echo "Ha habido un error:{$resultado->error}";
                }
                break;
            case "no":
                $sql = "UPDATE `vote` SET `no` = `no` + 1 WHERE `vote`.`id` = '$id';";
                $resultado = mysqli_query($conec, $sql);
                if ($resultado == true){
                    echo "Tu voto se ha guardado correctamente";
                } else {
                    echo "Ha habido un error:{$resultado->error}";
                }
                break;
            case "abs":
                $sql = "UPDATE `vote` SET `abs` = `abs` + 1 WHERE `vote`.`id` = '$id';";
                $resultado = mysqli_query($conec, $sql);
                if ($resultado == true){
                    echo "Tu voto se ha guardado correctamente";
                } else {
                    echo "Ha habido un error:{$resultado->error}";
                }
                break;
        }
    } else{
        echo "No hay ninguna votación activa";
    }
}
?>
<form method="post" class="form" class="v">
    <h1 class="v"><?= $titulo ?></h1>
    <p class="v"><?= $desc?></p>
    <input type="radio" name="op" value="si" class="v"> <label for="si" class="v">A favor</label> <br>
    <input type="radio" name="op" value="no" class="v"> <label for="si" class="v">En contra</label> <br>
    <input type="radio" name="op" value="abs" class="v"> <label for="si" class="v">Abstención</label> <br>
    <input type="submit" name="submit" class="v">
</form>