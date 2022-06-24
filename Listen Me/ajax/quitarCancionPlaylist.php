<?php

$conexion = mysqli_connect('localhost', 'root', '', 'listenme');

if ($conexion->connect_error) {
    die("Fallo la conexion al servidor, error: " . $conexion->connect_error);
}
$sql = mysqli_query($conexion, "SELECT count(id) as total FROM lista_cancion WHERE id_lista = {$_POST['id_lista']} AND id_cancion = {$_POST['id_cancion']}");
$cantidad = mysqli_fetch_array($sql)['total'];
if ($cantidad == 1) {
    mysqli_query($conexion, "DELETE FROM `lista_cancion` WHERE id_lista = {$_POST['id_lista']} AND id_cancion = {$_POST['id_cancion']}");
    echo "ahuevo";
} else {
    echo "que ?";
}
