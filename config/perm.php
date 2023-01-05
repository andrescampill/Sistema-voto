<?php
if($_SESSION['perm'] == false || empty($_SESSION['perm'])){
    header('Location: /inicio.php');
} ?>