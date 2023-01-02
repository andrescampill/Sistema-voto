<?php include 'config/database.php' ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de voto - FEMAE</title>
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon.ico">
    <link rel="stylesheet" href="/styles/header-panel.css">
    <script src="/tools/reloj.js"></script>
</head>
<body>
    <nav class="navbar">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="/panel/usuarios.php" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                    </svg>
                    <span class="link-text">Usuarios</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/panel/vote.php" class="nav-link">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-analytics" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                    <line x1="9" y1="17" x2="9" y2="12"></line>
                    <line x1="12" y1="17" x2="12" y2="16"></line>
                    <line x1="15" y1="17" x2="15" y2="14"></line>
                </svg>
                <span class="link-text">Votaciones</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/logout.php" class="nav-link">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                    <path d="M7 12h14l-3 -3m0 6l3 -3"></path>
                </svg>
                <span class="link-text">Cerrar sesión</span>
                </a>
            </li>
        </ul>
    </nav>

