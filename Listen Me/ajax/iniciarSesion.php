<?php
$conexion = mysqli_connect('localhost', 'root', '', 'listenme');

if ($conexion->connect_error) {
    die("Fallo la conexion al servidor, error: " . $conexion->connect_error);
}

if (strlen($_POST['correo']) > 10 && strlen($_POST['contrasena']) >= 6) {
    $cuentavalidasql = mysqli_query($conexion, "SELECT count(id) as total FROM usuarios WHERE correo_electronico='{$_POST['correo']}' AND contrasena='{$_POST['contrasena']}' ");
    $cuentavalida = mysqli_fetch_array($cuentavalidasql)['total'];
    if ($cuentavalida == 1) {
        $cuentadatossql = mysqli_query($conexion, "SELECT id,nombre_perfil FROM usuarios WHERE correo_electronico='{$_POST['correo']}' AND contrasena='{$_POST['contrasena']}' ");
        $cuentadatos = mysqli_fetch_assoc($cuentadatossql);
        session_start();
        $_SESSION['estado'] = TRUE;
        $_SESSION['id'] = $cuentadatos['id'];
        $_SESSION['nombre_perfil'] = $cuentadatos['nombre_perfil'];
    } else {
        echo "error";
    }
} else {
    echo "error";
}
