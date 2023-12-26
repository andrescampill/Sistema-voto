<?php
$titulopag = "Modificar votación - Sistema de voto";
include $_SERVER['DOCUMENT_ROOT'] . '/inc/header-panel.php';
include $_SERVER['DOCUMENT_ROOT'] . '/config/class.php'
?>
<?php
$msg = '';
$id = $_GET['id'];
$sql = "SELECT * FROM vote WHERE id = '$id'";
$resultado = mysqli_query($conec, $sql);
$data = $resultado->fetch_assoc();
$titulo = $data["titulo"];
$texto = $data["texto"];
$activa = $data["activa"];
$total = $data["si"] + $data["no"] + $data["abs"];
$totalopc = '';
if ($total == 0) {
    $total = 1;
}
if ($activa == 1) {
    //activa
    $activa = "checked";
} else {
    // cerrada
    $activa = '';
}
// Guardamos los datos
if (isset($_POST['submit'])) {
    $desc = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_SPECIAL_CHARS);
    if (!empty($_POST['activa'])) {
        $activa = 1;
    } else {
        $activa = 0;
    }
    $sql = "UPDATE vote SET `texto`='$desc', `activa`='$activa' WHERE `vote`.`id` = '$id';";
    $resultado = mysqli_query($conec, $sql);
    if ($resultado == true) {
        $msg = "Se ha actualizado correctamente";
        header('Refresh:2');
    } else {
        $msg = "Ha habido un error";
    }
}
// Mostrar dependiendo del tipo
if ($data["type"] != "per") {
    $ida = "";
    $ida2 = "esconder"; // Esconder
} else { // Para evitar problemas, aqui dentro se encuentra todo el codigo que hace funcioar a las votaciones personalizadas
    $ida = "esconder";
    $ida2 = "";
    // Mostrar resultados
    $op = json_decode($data['op'], true);
    $totalop = count($op);
}
?>
<link rel="stylesheet" href="/styles/info.css">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<main class="contenido">
    <h1>Votación - <?= $titulo ?></h1>
    
    <form method="post">
        <label for="id"> ID</label><input type="number" name="id" disabled value="<?= $id ?>"> <br>
        <label for="titulo"> Titulo</label><input type="text" name="titulo" disabled value="<?= $titulo ?>"> <br>
        <label for="desc"> Descripción</label><textarea name="desc" cols="30" rows="4" class="textarea"><?= $texto ?></textarea> <br>
        <label for="activa" class="lc">Activa: </label><input type="checkbox" class="c" name="activa" <?= $activa ?>><br>
        <input type="submit" name="submit" value="Actualizar" class="enviar"> <br>
        <button onclick="linka()" class="exportar">Exportar</button>
        <?= $msg ?>
    </form>
    <hr>
    <div class="resultados">
        <h3>Resultados</h3>
        <div class="content2">
            <!-- Cuando es normal -->
            <div class="text" id="<?= $ida ?>"> <!-- NORMAL -->
                <table>
                    <tr>
                        <th>Opción</th>
                        <th>Número</th>
                        <th>Porcentage</th>
                    </tr>
                    <tr>
                        <td>
                            <p>A favor (sies)</p>
                        </td>
                        <td>
                            <p><?= $data["si"] ?></p>
                        </td>
                        <td>
                            <p><?= number_format($data["si"] / $total * 100, 2) ?>%</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>En contra (noes)</p>
                        </td>
                        <td>
                            <p><?= $data["no"] ?></p>
                        </td>
                        <td>
                            <p><?= @number_format($data["no"] / $total * 100, 2) ?>%</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Abstenciones</p>
                        </td>
                        <td>
                            <p><?= $data["abs"] ?></p>
                        </td>
                        <td>
                            <p><?= @number_format($data["abs"] / $total * 100, 2) ?>%</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="t"><b>Total:ㅤ</b></p>
                        </td>
                        <td><?= $total ?></td>
                        <td></td>
                    </tr>
                </table>
                <?php
                if ($data["type"] != "per") {
                    echo '<div class="graf">';
                    echo '<span id="grafico" class="<?= $id ?>"></span>';
                    echo '</div>';
                    $op = array();
                }
                ?>
            </div>

            <!-- CUANDO SEA PERSONALIZADO -->
            <div class="text" id="<?= $ida2 ?>">
                <table>
                    <tr>
                        <th>Opción</th>
                        <th>Número</th>
                        <th>Porcentage</th>
                    </tr>
                    <?php
                    if ($data["type"] == "per") {
                        $totalopc = 0;
                        foreach ($op as $opcion) {
                            foreach ($opcion as $opcion => $value) {
                                $totalopc = $totalopc + $value;
                            }
                        }
                        foreach ($op as $columns) {
                            echo '<tr>';
                            foreach ($columns as $column => $value) {
                                if ($value > 0) {
                                    echo '<td>' . $column . '</td>';
                                    echo '<td>' . $value . '</td>';
                                    echo '<td>' . number_format($value / $totalopc * 100, 2) . '% </td>';
                                } else {
                                    echo '<td>' . $column . '</td>';
                                    echo '<td>' . $value . '</td>';
                                    echo '<td>' . number_format($value / $totalop * 100 * 0, 2) . '% </td>';
                                }
                            }
                            echo '</tr>';
                        }
                    }
                    ?>
                    <tr>
                        <td>
                            <p class="t"><b>Total:ㅤ</b></p>
                        </td>
                        <td><?= $totalopc ?></td>
                        <td></td>
                    </tr>
                </table>
                <?php
                if ($data["type"] == "per") {
                    echo '<div class="graf">';
                    echo '<span id="grafico2" class="' . $ida2 . '"></span>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
</main>

<?php
$fecha = date("dmoHis");

?>

<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(draw2Chart);
    google.charts.setOnLoadCallback(draw1Chart);



    function draw1Chart() {

        var data = google.visualization.arrayToDataTable([
            ['Opción', 'Número'],
            ['A favor', <?= $data["si"] ?>],
            ['En contra', <?= $data["no"] ?>],
            ['Abstenciones', <?= $data["abs"] ?>],
        ]);

        var options = {
            title: 'Grafico de resultados.'
        };
        var chart = new google.visualization.PieChart(document.getElementById('grafico'));
        chart.draw(data, options);

    }


    function draw2Chart() {

        <?php
        echo "var data = google.visualization.arrayToDataTable([
                ['Opción', 'Número'],";
        foreach ($op as $opcion) {
            foreach ($opcion as $opcion => $value) {
                echo "['{$opcion}', {$value}],";
            }
        }
        echo "]);";
        ?>

        var options = {
            title: 'Grafico de resultados.'
        };

        var charta = new google.visualization.PieChart(document.getElementById('grafico2'));
        charta.draw(data, options);
    }
</script>
</div>
<style>
    #exp2 {
        background-color: red;
        color: black;
    }
</style>
<script>
    function linka() {
        var handle = window.open('/panel/vote/exportar.php?id=<?php echo $id ?>&time=<?php echo $fecha ?>', "_blank");
        handle.blur();
        window.focus();
    };
    document.getElementById("buton").addEventListener("click", linka);
</script>


<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/footer.php' ?>