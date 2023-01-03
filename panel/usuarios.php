<?php
$titulo = "Usuario - Sistema de voto";
include $_SERVER['DOCUMENT_ROOT'] . '/inc/header-panel.php';
?>
<main class="contenido">
    <link rel="stylesheet" href="/styles/usuarios.php.css">
    <h1>Usuarios</h1>
    <a href="/panel/registrar.php"><button class="registrar">Registrar a nuevo usuario</button></a> <br>
    <br>
    <table>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Nombre</th>
            <th>Contraseña</th>
            <th></th>
            <th></th>
        </tr>
        <?php
            $sql = "SELECT * FROM users";
            $resultado = mysqli_query($conec, $sql);
            if ($resultado->num_rows > 0) {
                while($row = $resultado -> fetch_assoc()){
                    echo '<tr><td>' . $row["id"] . '</td><td>' . $row["user"] . '</td><td>' . $row["nombre"] . '</td><td class="cont">' . htmlspecialchars($row["cont"]) . '</td> <td><a href="/panel/modificar.php?id=' . $row["id"] . '"><button class="mod">Modificar</button></a></td><td><a href="/panel/eliminar.php?id=' . $row["id"] . '"><button class="eliminar">Eliminar</button></td>';
                }
            } else {
                echo "No se encontraron usuarios";
            }
?>
    
    </table>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/footer.php' ?>