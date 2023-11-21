<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require '../util/base.php' ?>
    <?php  require '../util/producto.php'?>
    <link rel="stylesheet" href="styles/estilo.css">

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

        $usuario = $_SESSION["usuario"];
        $sql1 = "SELECT * FROM cestas WHERE usuario = '$usuario'";
        $res = $conexion -> query($sql1);

        if($res->num_rows > 0) {
            $filaCestas = $res->fetch_assoc();
            $id_cesta = $filaCestas["idCesta"];
        }  

        $sql2 = "SELECT * FROM productosCestas WHERE idProducto = '$id_producto' AND idCesta = '$id_cesta'";
        $comp = $conexion -> query($sql2);
              
        $sql6 = "SELECT precio FROM productos WHERE idProducto = '$id_producto'";
        $res = $conexion -> query($sql6);
        $filaPrecio = $res -> fetch_assoc();
        $precioProducto = $filaPrecio["precio"];


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
        
        $sqlprecio = "UPDATE cestas SET precioTotal = precioTotal + '$precioProducto' WHERE usuario = '$usuario'";
        $conexion -> query($sqlprecio);
        $sqlCantidad = "UPDATE productos SET cantidad = cantidad - 1 WHERE idProducto = '$id_producto'";
        $conexion -> query($sqlCantidad);
    }

    
    ?>
    <header>
        <nav class="navigator">
            <ul>
                <li><a href="principal.php">INICIO</a></li>
                <?php
                    if (isset($_SESSION["rol"])) {
                        if ($_SESSION["rol"] == "admin"){
                            echo "<li><a href='productos.php'>Añadir Productos</a></li>";
                        }
                    }

                    if ($usuario == "invitado"){
                        echo "<li><a href='iniciar_sesion.php'>Iniciar Sesión</a></li>";
                        echo "<li><a href='usuario.php'>Añadir Usuario</a></li>";                    
                    }else{
                        echo "<li><a href='cesta.php'>Cesta</a></li>";
                        echo "<li><a href='cerrar_sesion.php'>Cerrar sesión</a></li>";
                    }
                ?>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h1>Página principal</h1>
        <h3>Bienvenid@ <?php echo $usuario ?></h3>
    </div><br>
    
    <div class="container">
        <h2>Listado de productos</h2>
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
<div class="container">
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
                    <?php if($usuario != "invitado") {?>
                        <form action="" method="post">
                            <input type="hidden"
                            name="idProducto"
                            value="<?php echo $producto -> idProducto ?>">
                            <input class="btn btn-warning" type="submit" value="Añadir">
                        </form>
                    <?php }
                    echo "</td></tr>";
            }
            ?>
            </tbody>
    </table>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>