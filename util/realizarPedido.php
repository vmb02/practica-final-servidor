<?php
    require 'base.php';
    session_start();
    if(!isset($_SESSION["usuario"])) {
        header("Location: ../views/iniciar_sesion.php");
    }
    $usuario = $_SESSION["usuario"];
    $precioTotal = $_POST["precioTotal"];
    $idCesta = $_POST["idCesta"];
    $fechaActual = date('Y/m/d');
    $numeroProductos = $_POST["numeroProductos"];

    $sql = "INSERT INTO pedidos (usuario, precioTotal, fechaPedido)
    VALUES ('$usuario', '$precioTotal', '$fechaActual')";
    $conexion -> query($sql);

    $sql1 = "SELECT idPedido FROM pedidos WHERE usuario = '$usuario'
    AND precioTotal = '$precioTotal' AND fechaPedido = '$fechaActual'";
    $idPedido = $conexion -> query($sql1) -> fetch_assoc()["idPedido"];

    $sql2 = "SELECT idProducto, cantidad FROM productoscestas WHERE idCesta = '$idCesta'";
    $res = $conexion -> query($sql2);

    $idProductos = [];
    $cantidades = [];

    while($fila = $res -> fetch_assoc()) {
        array_push($idProductos, $fila["idProducto"]);
        array_push($cantidades, $fila["cantidad"]);
    }

    for($i = 0; $i < $numeroProductos; $i++) {
        $linea = $i + 1;
        $sqlAux = "SELECT precio FROM Productos WHERE idProducto = '$idProductos[$i]'";
        $precio = $conexion -> query($sqlAux) -> fetch_assoc()["precio"];
        $sql3 = "INSERT INTO lineasPedidos VALUES ('$linea', '$idProductos[$i]', '$idPedido', '$precio', '$cantidades[$i]')";
        $conexion -> query($sql3);
    }

    $cont = 0;
    while($cont < $numeroProductos) {
        $sql4 = "DELETE FROM productoscestas WHERE idProducto = $idProductos[$cont]";
        $conexion -> query($sql4);
        $cont++;
    }

    $sql5 = "UPDATE cestas SET precioTotal = '0.0' WHERE idCesta = '$idCesta'";
    $conexion -> query($sql5);
    header("Location: ../views/principal.php");
?>