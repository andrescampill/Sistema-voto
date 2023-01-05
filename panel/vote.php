<?php
$titulopag = "Votaciones - Sistema de voto";
include $_SERVER['DOCUMENT_ROOT'] . '/inc/header-panel.php';
include $_SERVER['DOCUMENT_ROOT'] . '/config/class.php'
?>
<?php
$msg = '';
if (isset($_POST['submit'])) {
    // Creamos el objeto
    if (!empty($_POST['titulo'])) {
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
        if ($resultado == true) {
            $msg = "Se ha guardado la votación";
        } else {
            $msg = "Ha ocurrido un error: $resultado";
        }
    } else {
        $msg = "Hace falta un nombre"; 
    }
}
// Mostrar lista de votaciones

?>
<link rel="stylesheet" href="/styles/vote.php.css">
<main class="contenido">
    <h1>Voatciones</h1>
    <div class="form1">
        <form method="POST">
            <h3>Crear una votación</h3>
            <input type="text" name="titulo" placeholder="Titulo" class="i ti" required> <br>
            <textarea name="desc" cols="30" rows="2" placeholder="Descripción" spellcheck="true" wrap="soft"></textarea><br>
            <input type="submit" name="submit" value="Crear" class="crear i">
            <p class="msg"><?= $msg ?></p>
        </form>
    </div>
    <hr>
    <!-- Otros sistemas -->
    <h3 class="vote">Lista de votaciones.</h3>
    <a href="/panel/vote.php" class="act">
        <svg xmlns=" http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh acts" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
            <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path>
        </svg>
    </a>

    <table>
        <tr>
            <th>ID</th>
            <th>Titulo</th>
            <th>Descripción</th>
            <th>A favor</th>
            <th>En contra</th>
            <th>Abstenciones</th>
            <th>Activa</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <?php
        $sql = "SELECT * FROM vote";
        $resultado = mysqli_query($conec, $sql);
        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                if ($row["activa"] == 1) {
                    $activa = "Si";
                } else {
                    $activa = "No";
                }
                echo '<tr><td>' . $row["id"] . '</td><td>' . $row["titulo"] . '</td><td>' . $row["texto"] . '</td><td>' . $row["si"] . '</td> <td>' . $row["no"] . '</td><td>' . $row["abs"] . '</td><td>' . $activa . '</td><td><a href="/panel/vote/activar.php?id=' . $row["id"] . '"><button class="activar">Activar / Desactivar</button></a></td><td><a href="/panel/vote/info.php?id=' . $row["id"] . '"><button class="mod">Más información</button></a></td><td><a href="/panel/vote/eliminar.php?id=' . $row["id"] . '"><button class="borrar" >Borrar</button></a></td>';
            }
        } else {
            echo "<td></td><td>¡No se han encontrado votaciones!</td>";
        }
        ?>

    </table>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/footer.php' ?>