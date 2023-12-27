<?php include 'config/database.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de voto - FEMAE</title>
  <link rel="icon" type="image/x-icon" href="/assets/img/favicon.ico">
  <script src="/tools/reloj.js"></script>
  <link rel="stylesheet" href="/styles/header.css">
  <link rel="manifest" href="manifest.json">
  <meta name="theme-color" content="#ffffff" />
</head>

<body>
  <script>
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register(
        '/sw.js'
      );
    }
  </script>

  <p id="hora" onload="reloj()">Hora</p>
  <a href="/logout.php"><button id="cerrar">Cerrar sesión</button></a>