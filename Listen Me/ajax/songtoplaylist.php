<?php
$conexion = mysqli_connect('localhost', 'root', '', 'listenme');

if ($conexion->connect_error) {
    die("Fallo la conexion al servidor, error: " . $conexion->connect_error);
}


$cantidadsql = mysqli_query($conexion, "SELECT count(id) as total FROM `lista_cancion` WHERE id_lista={$_POST['id_lista']} AND id_cancion={$_POST['id_cancion']}  ");
$cantidad = mysqli_fetch_assoc($cantidadsql)['total'];
if ($cantidad == 0) {
    mysqli_query($conexion, "INSERT INTO `lista_cancion` (`id_lista`, `id_cancion`) VALUES ('{$_POST['id_lista']}', '{$_POST['id_cancion']}')");
}
