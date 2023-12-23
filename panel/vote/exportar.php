<?php
$titulopag = "Exportar - Sistema de voto";
include $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();
if ($_SESSION['perm'] == false || empty($_SESSION['perm'])) {
    header('Location: /inicio.php');
}
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<?php
$id = $_GET["id"];
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
    $msg = "activo";
} else {
    // cerrada
    $msg = "inactivo";
}
if ($data["type"] == 'per') {
    $msg2 = "personalizado";
    $ida = "esconder";
    $ida2 = "";
    // Mostrar resultados
    $op = json_decode($data['op'], true);
    $totalop = count($op);
} else {
    $msg2 = "común";
    $ida = "";
    $ida2 = "esconder";
}
?>
<meta name="viewport" content="width=1604px, height=767px">
<img src="/assets/img/pdf-header.png" alt="" srcset="">
<h1>CERTIFICADO DE VOTACIÓN</h1>
<div class="contenido">
    <p>El Sistema de Voto en linea de la Federación Murciana de Asociaciones de Estudiantes (FEMAE), informa que, a fecha de <text id="fecha"></text> a las <text id="hora"> </text>, la votación con título: "<?= $titulo ?>", estado <?= $msg ?>, identificación: <?= $id ?>, tipo <?= $msg2 ?> y descripción: "<?= $texto ?>", se encuentra en el Sistema de Votación digital de la Federación y cuenta con el siguiente resultado:</p>
    <div class="text" id="<?= $ida ?>"> <!-- NORMAL -->
        <table id="resultados">
            <tr>
                <th>Opción</th>
                <th>Número de votos</th>
                <th> Porcentaje</th>
            </tr>
            <tr>
                <td>
                    <p>A favor (sies)</p>
                </td>
                <td class="center">
                    <p class="center"><?= $data["si"] ?></p>
                </td>
                <td>
                    <p><?= number_format($data["si"] / $total * 100, 2) ?>%</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>En contra (noes)</p>
                </td>
                <td class="center">
                    <p class="center"><?= $data["no"] ?></p>
                </td>
                <td>
                    <p><?= @number_format($data["no"] / $total * 100, 2) ?>%</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Abstenciones</p>
                </td>
                <td class="center">
                    <p class="center"><?= $data["abs"] ?></p>
                </td>
                <td>
                    <p><?= @number_format($data["abs"] / $total * 100, 2) ?>%</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="t"><b>Total:ㅤ</b></p>
                </td>
                <td class="center">
                    <p><?= $total ?></p>
                </td>
                <td></td>
            </tr>
        </table>
    </div>

    <?php
    if ($data["type"] != "per") {
        echo '<span id="grafico" class="<?= $id ?>"></span>';
        $op = array();
    }
    ?>
    <!-- CUANDO SEA PERSONALIZADO -->
    <div id="<?= $ida2 ?>" class="text">
        <table id="resultadosp">
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
                            echo '<td class="center">' . $value . '</td>';
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
            echo '<span id="grafico2" class="' . $ida2 . '"></span>';
        }
        ?>
    </div>
</div>

<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(draw1Chart);
    google.charts.setOnLoadCallback(draw2Chart);


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
            title: 'Gráfico de resultados.'
        };

        var charta = new google.visualization.PieChart(document.getElementById('grafico2'));
        charta.draw(data, options);
    }
</script>

<p id="final">Y para que conste a los efectos oportunos se expide el presente documento en la Región de Murcia, a <text id="fecha2"></text> a las <text id="hora2"></text>.</p>
</div>

<div class="abajo">

    <p id="aviso">Los datos facilitados son meramente informativos y no vinculantes. Los datos válidos deberán ser proporcionados por los procedimientos habituales. La Federación se exibe de cualquier probelma que pueda causar el presente documento.</p>

    <table id="pie" cellspacing="85">

        <tr id="piet">
            <td id="piep">Federación Murciana de
                Asociaciones de Estudiantes
                FEMAE – NIF G30578975
                Reg. Asoc. CARM Nº 125/2ª</td>
            <td id="piep">www.femae.org
                info@femae.org
                @femaemurcia</td>
            <td id="piep">Centro Municipal La Nave
                Polígono Industrial Camposol
                Calle Mayor, 55
                30002, Murcia, Murcia</td>
        </tr>
    </table>
</div>
<script>
    const meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
    const dias_semana = ['Domingo', 'Lunes', 'martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
    const fecha = new Date();
    document.getElementById("fecha").innerHTML = (dias_semana[fecha.getDay()] + ', ' + fecha.getDate() + ' de ' + meses[fecha.getMonth()] + ' de ' + fecha.getUTCFullYear());
    document.getElementById("fecha2").innerHTML = (dias_semana[fecha.getDay()] + ', ' + fecha.getDate() + ' de ' + meses[fecha.getMonth()] + ' de ' + fecha.getUTCFullYear());

    const hora = fecha.getHours();
    const minutos = (fecha.getMinutes() < 10 ? '0' : '') + fecha.getMinutes();
    const seg = fecha.getSeconds();
    document.getElementById("hora").innerHTML = (`${hora}:${minutos}:${seg}`);
    document.getElementById("hora2").innerHTML = (`${hora}:${minutos}:${seg}`);
</script>

<link rel="stylesheet" href="/styles/exportar.css">
<script>window.onload = function() { window.print(); }</script>