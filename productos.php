<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
</head>
<body>
    <?php
        function depurar($entrar) {
            $salida = htmlspecialchars($entrada);
            $salida = trim($salida);
            return $salida;
        }
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $temp_nombre = depurar($_POST["nombreProducto"]);
        $temp_precio = depurar($_POST["precioProducto"]);
        $temp_descripcion = depurar($_POST["descripcion"]);
        $temp_cantidad = depurar($_POST["cantidad"]);

        //Validación del nombre
        if(strlen($temp_nombre) == 0) {
            $err_nombre = "El nombre es un campo obligatorio";
        } else {
            if(strlen($temp_nombre) > 40) {
                $err_nombre = "El nombre no puede tener más de 40 caracteres";
            } else {
                $patron = "/^[A-Za-z0-9 ]+$/";
                if(!preg_match($patron, $temp_nombre)) {
                    $err_nombre = "El nombre debe estar compuesto por caracteres, números
                    y espacios en blanco.";
                } else {
                    $nombre = $temp_nombre;
                }
            }
        }
    }
    
    
    ?>

<form action="" method="post">
    <fieldset>
        <label>Nombre Producto: </label>
        <input type="text" name="nombreProducto">
        <br><br>
        <label>Precio: </label>
        <input type="number" name="precioProducto">
        <br><br>
        <label>Descripción: </label>
        <input type="text" name="descripcion">
        <br><br>
        <label>Cantidad: </label>
        <input type="number" name="cantidad">
        <br><br>
        <input type="submit" value="Añadir">
    </fieldset>
</form>

</body>
</html>