<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    if (isset($_SESSION['estado'])) {
        header("location: index.php");
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/jquery-1.11.1.min.js"></script>
    <title>Registro</title>
    <style>
        @font-face {
            font-family: "Fort Quinsy";
            src: url('FORTQUINSY.otf');
        }

        body {
            display: flex;
            justify-content: center;
        }

        .logo {
            font-family: "Fort Quinsy";
            font-size: 50px;
            text-align: center;
            color: black;
            margin-bottom: 2vh;
        }

        form {
            margin-top: 5vh;
        }

        .crearcuenta {
            text-align: center;
        }

        @media screen and (max-width:556px) {
            form {
                width: 90vw;
            }

            .logo {
                width: 90vw;
            }

            .crearcuenta {
                width: 98vw;
            }
        }

        @media screen and (min-width: 557px) {
            form {
                width: 500px;
            }

            .logo {
                width: 500px;
            }

            .crearcuenta {
                width: 500px;
            }
        }
    </style>
</head>

<body>
    <form action="">
        <div class="logo">LISTEN ME!</div>
        <hr>
        <label id="error" style="color: red; font-weight: bold; display: none;">Los datos son Invalidos</label>
        <br>
        <label><b>Nombre</b></label>
        <input type="text" id="nombre" class="form-control" placeholder="Nombre" minlength="6">
        <br>
        <label><b>Correo Electronico</b></label>
        <input type="email" id="correo" class="form-control" placeholder="Correo electronico">
        <br>
        <label><b>Contraseña</b></label>
        <input type="password" id="contrasena" class="form-control" placeholder="*****" minlength="6">
        <br>
        <a href="#" onclick="crearcuenta()" class="btn btn-success btn-block" style="color: black; font-weight: bold;">Crear Cuenta</a>
        <br>
        <label class="crearcuenta">¿Tienes cuenta? Inicia Sesion</label>
        <a href="login.php" class="btn btn-secondary btn-block">Inicia Sesion</a>
    </form>
</body>

</html>

<script>
    function crearcuenta() {
        $.ajax({
            type: 'POST',
            url: 'ajax/crearCuenta.php',
            data: {
                nombre: $("#nombre").val(),
                correo: $("#correo").val(),
                contrasena: $("#contrasena").val()
            },
            success: function(res) {
                if (res == "error") {
                    $("#error").css("display", "unset");
                } else {
                    window.location.href = "login.php";
                }
            }
        });
    }
</script>