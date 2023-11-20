<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cesta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require 'base.php'?>
</head>
<body>
    <?php
    session_start();
    if(isset($_SESSION["usuario"])) {
        $usuario = $_SESSION["usuario"];
        $sql1 = "SELECT * FROM cestas WHERE usuario = '$usuario'";
        $res = $conexion -> query($sql1);

        while($fila = $res -> fetch_assoc()) {
            $idCesta = $fila["idCesta"];
            $precioTotal = $fila["precioTotal"];
        }

        $sql2 = "SELECT p.idProducto as idProducto, p.nombreProducto as nombre, p.precio as precio, p.imagen as imagen, pc.cantidad as cantidad FROM productos p 
        JOIN productosCestas pc ON p.idProducto = pc.idProducto WHERE pc.idCesta = $idCesta";
        $res2 = $conexion -> query($sql2);

        $productos = [];
        while($fila = $res2 -> fetch_assoc()) {
            $nProducto = new Producto($fila["idProducto"], $fila["nombre"])
        }
    }


    ?>  

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>