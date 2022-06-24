<?php

$conexion = mysqli_connect('localhost', 'root', '', 'listenme');

if ($conexion->connect_error) {
    die("Fallo la conexion al servidor, error: " . $conexion->connect_error);
}

$sql = mysqli_query($conexion, "SELECT count(id) as total FROM megusta WHERE id_usuario = {$_POST['id_usuario']} AND id_cancion = {$_POST['id_cancion']}");
$cantidad = mysqli_fetch_array($sql)['total'];
if ($cantidad == 1) {
    echo 1;
} else {
    echo 0;
}
