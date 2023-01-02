<?php
session_start();

if(isset($_SESSION['user'])){
    if($_SESSION['perm'] == true){
    } else {
        header('Location: /inicio.php');
    }
} else {
    header('Location: /');
}

?>
<?php include "inc/header-panel.php" ?>
<main class="contenido">
    
</main>
<?php include 'inc/footer.php'?>