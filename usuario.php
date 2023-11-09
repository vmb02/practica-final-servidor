<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario</title>
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

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $temp_usuario = depurar($_POST["usuario"]);
        $temp_contrasena = depurar($_POST["contrasena"]);
        $temp_fechaNacimiento = depurar($_POST["fechaNacimiento"]);

        //Validación del nombre de usuario
        if(strlen($temp_usuario) == 0) {
            $err_usuario = "El usuario es un campo obligatorio";
        } else {
            if(strlen($temp_usuario<=3) || strlen($temp_usuario)>12) {
                $err_usuario = "El nombre tiene que tener entre 4 y 12 caracteres";
            } else {
                $patron = "/^[A-Za-z_]+$/";
                if(!preg_match($patron, $temp_usuario)) {
                    $err_usuario = "El usuario debe estar compuesto por caracteres y barra baja";
                } else{
                    $usuario = $temp_usuario;
                }
            }
        }

        //Validación de la contraseña
        if(strlen($temp_contrasena) == 0) {
            $err_contrasena = "La contraseña es un campo obligatorio";
        } else {
            if(strlen($temp_contrasena) > 255) {
                $err_contrasena = "La contraseña no puede ser superior a 255 caracteres";
            } else {
                $contrasena = $temp_contrasena;
            }
        }

        //Validación de la fecha de nacimiento
        if(strlen($temp_fechaNacimiento) == 0) {
            $err_fecha = "La fecha de nacimiento es un campo obligatorio";
        } else {
            $fecha_actual = date("Y-m-d");
            list($anyo_actual, $mes_actual, $dia_actual) = explode('-', $fecha_actual);
            list($anyo, $mes, $dia) = explode('-', $temp_fechaNacimiento);
            if($anyo_actual - $anyo > 12) {
                if($anyo_actual - $anyo < 112) {
                    $fechaNacimiento = $temp_fechaNacimiento;
                } else if($anyo_actual - $temp_fechaNacimiento > 112) {
                    $err_fecha = "No puedes tener más de 112 años";
                } else {
                    if($mes_actual - $mes > 0) {
                        $err_fecha = "No puedes tener más de 112 años";
                    } else if($mes_actual - $mes > 0) {
                        $fechaNacimiento = $temp_fechaNacimiento;
                    } else {
                        if($dia_actual - $dia >= 0) {
                            $err_fecha = "No puedes tener más de 112 años";
                        } else {
                            $fechaNacimiento = $temp_fechaNacimiento;
                        }
                    }
                }
            } else if($anyo_actual - $temp_fechaNacimiento < 12) {
                $err_fecha = "No puedes ser menor de 12 años";
            } else {
                if($mes_actual - $mes > 0) {
                    $fechaNacimiento = $temp_fechaNacimiento;
                } else if($mes_actual - $mes < 0) {
                    $err_fecha = "No puedes ser menor de 12 años";
                } else {
                    if($dia_actual - $dia >= 0) {
                        $fechaNacimiento = $temp_fechaNacimiento;
                    } else {
                        $err_fecha = "No puedes ser menor de 12 años";
                    }
                }
            }
        }

        if(isset($usuario) && isset($contrasena) && isset($fechaNacimiento)) {
            $contrasena_cifrada = password_hash($contrasena, PASSWORD_DEFAULT);

            $sql1 = "INSERT INTO usuarios VALUES ('$usuario', '$contrasena_cifrada', '$fechaNacimiento')";
            $sql2 = "INSERT INTO cestas (usuario, precioTotal) VALUES ('$usuario', 0)";
            $conexion -> query($sql1);
            $conexion -> query($sql2);
        }
    }
    ?>

<div class="container">
    <h1>Registrar Usuario</h1>
    <form action="" method="post">
        <div class="mb-3">
            <label class="form-label">Usuario: </label>
            <input class="form-control" type="text" name="usuario">
            <?php if(isset($err_usuario)) echo $err_usuario ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Contraseña: </label>
            <input class="form-control" type="password" name="contrasena">
            <?php if(isset($err_contrasena)) echo $err_contrasena ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha Nacimiento: </label>
            <input class="form-control" type="date" name="fechaNacimiento">
            <?php if(isset($err_fecha)) echo $err_fecha ?>
        </div>
            <input class="btn btn-primary" type="submit" value="Registrarse">
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>