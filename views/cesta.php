<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cesta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require '../util/base.php'?>
</head>
<body>
    <?php
    session_start();
    if(isset($_SESSION["usuario"])) {
        $usuario = $_SESSION["usuario"];
        $numeroProductos = 0;
        $sql1 = "SELECT * FROM cestas WHERE usuario = '$usuario'";
        $res = $conexion -> query($sql1);
        $fila = $res -> fetch_assoc();

        $id_cesta = $fila["idCesta"];
        $precioTotal = $fila["precioTotal"];

        $sql2 = "SELECT * FROM productoscestas WHERE idCesta = '$id_cesta'";
        $res2 = $conexion -> query($sql2);
        $filas_tabla = [];
        while ($fila = $res2->fetch_assoc()) {
            $id_producto = $fila['idProducto'];
            $sql3 = "SELECT * FROM productos WHERE idProducto = $id_producto";
            $res3 = $conexion -> query($sql3);
            $fila2 = $res3 -> fetch_assoc();
    
            $nombreProducto = $fila2['nombreProducto'];
            $precio = $fila2['precio'];
            $cantidad_en_cesta = $fila['cantidad'];
            $imagen = $fila2['imagen'];
           
            array_push($filas_tabla,[$nombreProducto, $precio, $cantidad_en_cesta, $imagen]);
           
            $numeroProductos++;
        }
    } else {
        header("Location: iniciar_sesion.php");
    }
    ?>  
    <div class="container">
        <h1>Cesta</h1>
        <?php 
            if(isset($_SESSION["usuario"])) {
                echo "<h2>BIENVENID@ " . $_SESSION["usuario"] . "</h2>";
            } else {
                header("Location: iniciar_sesion.php");
            }
        ?>
        <table class="table table-striped">
            <thead class="table table-dark">
                <tr>
                    <th>Nombre Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>imagen</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($filas_tabla as $fila_tabla) {
                        list($nombreProducto, $precio, $cantidad_en_cesta, $imagen) = $fila_tabla;
                        echo "<tr>
                            <td>" . $nombreProducto . " </td>
                            <td>" . $precio . "</td>
                            <td>" . $cantidad_en_cesta . "</td>
                            <td>"?>
                            <img width="55" height="75" src="<?php echo $imagen ?>">
                        <?php
                        echo "</td></tr>";
                    }
                ?>
            </tbody>
        </table>
        
        <?php echo $precioTotal ?>
        <?php echo $id_cesta ?>
        <?php echo $numeroProductos ?>


        <form method="post" action="realizarPedido.php">
            <input type="hidden" name="precioTotal" value="<?php echo $precioTotal ?>">
            <input type="hidden" name="idCesta" value="<?php echo $id_cesta ?>">
            <input type="hidden" name="numeroProductos" value="<?php echo $numeroProductos ?>">
            <input type="submit" name="ENVIAR" value="Realizar el pago" class="btn btn-success">          
    </form>

    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>