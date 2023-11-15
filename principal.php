<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require 'base.php' ?>
    <?php  require 'producto.php'?>

</head>
<body>
<?php 
    session_start();
    if(isset($_SESSION["usuario"])) {
        $usuario = $_SESSION["usuario"];
    } else {
        //header('location: iniciar_sesion.php');
        $_SESSION["usuario"] = "invitado";
        $usuario = $_SESSION["usuario"];
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_producto = $_POST["idProducto"];
        echo "<p>El producto seleccionado es $id_producto</p>";

        $usuario = $_SESSION["usuario"];
        $sql1 = "SELECT idCesta FROM cestas WHERE usuario = '$usuario'";
        $res = $conexion -> query($sql1);

        if($res->num_rows > 0) {
            $filaCestas = $res->fetch_assoc();
            $id_cesta = $filaCestas["idCesta"];
        }  

        $sql2 = "SELECT * FROM productosCestas WHERE idProducto = '$id_producto' AND idCesta = '$id_cesta'";
        $comp = $conexion -> query($sql2);
              
        if($comp->num_rows > 0) {
            $filaCestas = $comp->fetch_assoc();
            $cantidad = $filaCestas["cantidad"];
            $cantidad += 1;
            $sql4 = "UPDATE productosCestas SET cantidad = '$cantidad' WHERE idProducto = '$id_producto' AND idCesta = '$id_cesta'";
            $conexion -> query($sql4);
        } else {
            $sql3 = "INSERT INTO productosCestas (idProducto, idCesta, cantidad)
            VALUES ($id_producto, $id_cesta, 1)";
            $conexion -> query($sql3);
        }

        
    }

    
    ?>
    <div class="container">
        <h1>Página principal</h1>
        <h2>Bienvenid@ <?php echo $usuario ?></h2>
        <a href="cerrar_sesion.php">Cerrar sesión</a>
    </div>

    <div class="container">
        <h1>Listado de productos</h1>
    </div>
    <?php
        $sql = "SELECT * FROM productos";
        $resultado = $conexion -> query($sql);
        $productos = [];

        while($fila = $resultado -> fetch_assoc()) {
            $nuevo_producto =
            new Producto($fila["idProducto"], 
            $fila["nombreProducto"], 
            $fila["precio"], 
            $fila["descripcion"],
            $fila["cantidad"],
            $fila["imagen"]);
            array_push($productos, $nuevo_producto);
        }
?>
    <table class="table table-striped">
            <thead class="table table-dark">
                <tr>
                    <th>ID Producto</th>
                    <th>Nombre</th>
                    <th>Precio Producto</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Imagen</th>
                    <th>Añadir</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach($productos as $producto) {
                echo "<tr>
                    <td>" . $producto -> idProducto . "</td>
                    <td>" . $producto -> nombreProducto . "</td>
                    <td>" . $producto -> precio . "</td>
                    <td>" . $producto -> descripcion . "</td>
                    <td>" . $producto -> cantidad . "</td>
                    <td>"?>
                    <img width="55" height="75" src="<?php echo $producto -> imagen ?>">
                    <?php echo "</td>
                    <td>"; ?>
                        <form action="" method="post">
                            <input type="hidden"
                            name="idProducto"
                            value="<?php echo $producto -> idProducto ?>">
                            <input class="btn btn-warning" type="submit" value="Añadir">
                        </form>
                    <?php
                    echo "</td></tr>";
            }
            ?>
            </tbody>
        </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>