<?php

$conexion = mysqli_connect('localhost', 'root', '', 'listenme');

if ($conexion->connect_error) {
    die("Fallo la conexion al servidor, error: " . $conexion->connect_error);
}
session_start();
$sql = mysqli_query($conexion, "SELECT count(id) as total FROM lista WHERE id = {$_POST['id']} AND id_usuario = {$_SESSION['id']}");
$cantidad = mysqli_fetch_array($sql)['total'];
if ($cantidad == 1) {
    mysqli_query($conexion, "DELETE FROM `lista` WHERE id_usuario = {$_SESSION['id']} AND id = {$_POST['id']}");
}
