<?php
    $_servidor = 'localhost';
    $_usuario = 'root';
    $_contraseña = 'medac';
    $_base_de_datos = 'db_tienda';

    $conexion = new MySqli($_servidor, $_usuario, $_contraseña, $_base_de_datos)
        or die("Error de conexión");
?>