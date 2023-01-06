# Sistema de voto.
Aplicación creada para votar de forma remota, diseñada especialmente para la Federación Murciana de Asociaciones de Estudiantes.

---

## Descripción

Sistema de voto es una aplicación web sencilla, creada exclusivamente para la Federación Murciana de Asociaciones de Estudiantes. La funcionalidad principal es la habilidad de poder votar de forma remota, agragando simplicidad a las reuniones y asambleas que se realizen de forma online o semipresencial.

La idea de crear este programa viene de un problema sufrido dentro de la organización, la inexsistencia de una aplicación simple para votar dentro de las asambleas semipresenciales, esto causó problemas en el correcto desempeño de la votación.
Despues de sufrir este problema, me planteé crear esta aplicación, que a mi parecer mejorará esta situación. 

### ¿Con qué tecnologia está creado?
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white) ![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)
La tecnolgia principal utilizada es PHP, gracias a esto, ha sido facil poder programar las partes dinamicas de la aplicación. El programa está pensado para utilizarse junto a una base de datos MySQL; el progama usa la extensión de php ```mysqli```, por lo que no se puede user otro software de bases de datos.

## Instalación

Este programa no está diseñado para que el proceso de instalación sea intuitivo.
1. Crea una base de datos.
2. Edita el codigo de databse.php para que contenga los datos de tu base de datos, se encuenta en ```/config/database.php```. Codigo que tienes que editar:
```php
define('DB_HOST', '[TU HOST]');
define('DB_USER', '[TU USUARIO]');
define('DB_PASS', '[TU CONTRASÑEA]');
define('DB_NAME', '[TU BASE DE DATOS]');
```
3. Crea una tabla para los usuarios, desde phpMyAdmin o usando el siguiente comando SQL:
```SQL
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `nombre` text NOT NULL,
  `cont` varchar(255) NOT NULL,
  `perm` tinyint(1) NOT NULL,
  `por` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

4. Crea una tabla para las votaciones, desde phpMyAdmin o usando el siguiente comando SQL:
```SQL
CREATE TABLE `vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `texto` text NOT NULL,
  `si` int(11) NOT NULL,
  `no` int(11) NOT NULL,
  `abs` int(11) NOT NULL,
  `users` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`users`)),
  `activa` tinyint(1) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

5. Crea un usuario con permisos de manera manual en la tabla users. IMPORTANTE, en el campo ```perm``` debes poner ```1```, de esta forma tendra permisos de administrador

Con esto ya tienes toda la aplicación instalada, podras crear votaciones y usuarios desde el panel de administrador. Para acceder solo tendras que acceder a la URL raiz, como ```votar.tudominio.com/```

ATENCIÓN: es necesario que la aplicación tenga un certificado SSL y sea abireta usando HTTPS, si no se usa, algunas de las funciones podrian no funcioar, esto es una medida de seguridad.

## Versión
La versión actual es: v0.5.2-dev. 
Dev: el producto está siendo desarrollado por lo que no ha sido probado en un escenario real y puede contener grandes error.


---
## License / Licencia

[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://github.com/andrescampill/Sistema-voto/blob/main/LICENSE)
Este porgrama está bajo la licencia GNU General Public Licens v3 (GPLv3). Andrés Campillo y la Federación Murciana de Asociaciones de Estudiantes se guardan el derecho para cambiar la licencia utilizada. 
