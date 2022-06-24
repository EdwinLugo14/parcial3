<?php

$conexion = mysqli_connect('localhost', 'root', '', 'listenme');

if ($conexion->connect_error) {
    die("Fallo la conexion al servidor, error: " . $conexion->connect_error);
}

$sql = mysqli_query($conexion, "SELECT count(id) as total FROM megusta WHERE id_usuario = {$_POST['id_usuario']} AND id_cancion = {$_POST['id_cancion']}");
$cantidad = mysqli_fetch_array($sql)['total'];
if ($cantidad == 0) {
    mysqli_query($conexion, "INSERT INTO `megusta` (`id_usuario`, `id_cancion`) VALUES ('{$_POST['id_usuario']}', '{$_POST['id_cancion']}');");
    echo 1;
} else {
    mysqli_query($conexion, "DELETE FROM `megusta` WHERE id_usuario = {$_POST['id_usuario']} AND id_cancion = {$_POST['id_cancion']}");
    echo 0;
}
