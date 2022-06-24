<?php
$conexion = mysqli_connect('localhost', 'root', '', 'listenme');

if ($conexion->connect_error) {
    die("Fallo la conexion al servidor, error: " . $conexion->connect_error);
}

if (strlen($_POST['nombre']) >= 6 &&  strlen($_POST['correo']) > 10 && strlen($_POST['contrasena']) >= 6) {
    $cuentavalidasql = mysqli_query($conexion, "SELECT count(id) as total FROM usuarios WHERE correo_electronico='{$_POST['correo']}'");
    $cuentavalida = mysqli_fetch_assoc($cuentavalidasql)['total'];
    if ($cuentavalida == 0) {
        mysqli_query($conexion, "INSERT INTO `usuarios` (`nombre_perfil`, `correo_electronico`, `contrasena`) VALUES ('{$_POST['nombre']}', '{$_POST['correo']}', '{$_POST['contrasena']}')");
        $usuarionuevosql = mysqli_query($conexion, "SELECT id FROM usuarios WHERE correo_electronico='{$_POST['correo']}'");
        $usuarionuevo = mysqli_fetch_assoc($usuarionuevosql)['id'];
        mkdir("../archivos/musica/user_" . $usuarionuevo, 0777, TRUE);
        mkdir("../archivos/portadas/user_" . $usuarionuevo, 0777, TRUE);
        echo "c";
    } else {
        echo "error";
    }
} else {
    echo "error";
}
