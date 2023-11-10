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
                    <?php echo "</td></tr>";
            }
            ?>
            </tbody>
        </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>