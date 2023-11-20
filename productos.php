<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>.    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require 'base.php' ?>
</head>
<body>
    <?php
        function depurar($entrada) {
            $salida = htmlspecialchars($entrada);
            $salida = trim($salida);
            return $salida;
        }

    session_start();
    if($_SESSION["rol"] != "admin") {
        header("Location: principal.php");
    }
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $temp_nombre = depurar($_POST["nombreProducto"]);
        $temp_precio = depurar($_POST["precioProducto"]);
        $temp_descripcion = depurar($_POST["descripcion"]);
        $temp_cantidad = depurar($_POST["cantidad"]);

        $nombre_imagen = $_FILES["imagen"]["name"];
        $tipo_imagen = $_FILES["imagen"]["type"];
        $tamano_imagen = $_FILES["imagen"]["size"];
        $ruta_temporal = $_FILES["imagen"]["tmp_name"];
        $ruta_final = "imagenes/" . $nombre_imagen;
        move_uploaded_file($ruta_temporal, $ruta_final);

        //Validación del nombre
        if(strlen($temp_nombre) == 0) {
            $err_nombre = "El nombre es un campo obligatorio";
        } else {
            if(strlen($temp_nombre) > 40) {
                $err_nombre = "El nombre no puede tener más de 40 caracteres";
            } else {
                $patron = "/^[A-ZÑa-zñ0-9 ]+$/";
                if(!preg_match($patron, $temp_nombre)) {
                    $err_nombre = "El nombre debe estar compuesto por caracteres, números
                    y espacios en blanco.";
                } else {
                    $nombre = $temp_nombre;
                }
            }
        }

        //Validación del precio
        if(strlen($temp_precio) == 0) {
            $err_precio = "El precio es un campo obligatorio";
        } else {
            if(!is_numeric($temp_precio)) {
                $err_precio = "El precio tiene que ser un número.";
            } else {
                $temp_precio = (float)$temp_precio;
                if($temp_precio < 0) {
                    $err_precio = "El precio no puede ser negativo";
                } else {
                    if($temp_precio > 99999.99) {
                        $err_precio = "El precio no puede ser superior a 99999.99";
                    } else {
                        $precioProducto = $temp_precio;
                    }
                }
            }
        }

        //Validación de la descripción
        if(strlen($temp_descripcion) == 0) {
            $err_descripcion = "La descripción es un campo obligatorio";
        } else {
            if(strlen($temp_descripcion) > 255) {
                $err_descripcion = "La descripción no puede ser superior a 255 caracteres";
            } else {
                $descripcion = $temp_descripcion;
            }
        }

        //Validación de la cantidad
        if(strlen($temp_cantidad) == 0) {
            $err_cantidad = "La cantidad es un campo obligatorio";
        } else {
            if(filter_var($temp_cantidad, FILTER_VALIDATE_INT) === FALSE) {
                $err_cantidad = "La cantidad tiene que ser un número entero";
            } else {
                $temp_cantidad = (int)$temp_cantidad;
                if($temp_cantidad < 0) {
                    $err_cantidad = "La cantidad no puede ser negativa";
                } else {
                    if($temp_cantidad > 99999) {
                        $err_cantidad = "La cantidad no puede ser superior a 99999";
                    } else {
                        $cantidad = $temp_cantidad;
                    }
                }
            }
        }
        
        if(isset($nombre) && isset($precioProducto) && isset($descripcion) && isset($cantidad)) {
            $sql = "INSERT INTO productos
                    (nombreProducto, precio, descripcion, cantidad, imagen)
                    VALUES('$nombre',
                            '$precioProducto',
                            '$descripcion',
                            $cantidad,
                            '$ruta_final')";
            $conexion -> query($sql);
        }
    }
    
    ?>

<div class="container">
    <h1>Registrar producto</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Nombre Producto: </label>
            <input class="form-control" type="text" name="nombreProducto">
            <?php if(isset($err_nombre)) echo $err_nombre ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Precio: </label>
            <input class="form-control" type="number" name="precioProducto" step="0.01">
            <?php if(isset($err_precio)) echo $err_precio ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción: </label>
            <input class="form-control" type="text" name="descripcion">
            <?php if(isset($err_descripcion)) echo $err_descripcion ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Cantidad: </label>
            <input class="form-control" type="number" name="cantidad">
            <?php if(isset($err_precio)) echo $err_precio ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Imagen</label>
            <input class="form-control" type="file" name="imagen">
        </div>
        <input class="btn btn-primary" type="submit" value="Añadir">
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>