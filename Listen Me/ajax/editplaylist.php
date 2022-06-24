<?php

$conexion = mysqli_connect('localhost', 'root', '', 'listenme');

if ($conexion->connect_error) {
    die("Fallo la conexion al servidor, error: " . $conexion->connect_error);
}

if (strlen($_POST['titulo']) > 0 && strlen($_POST['descripcion']) > 0) {
    mysqli_query($conexion, "UPDATE lista SET titulo= '{$_POST['titulo']}', descripcion= '{$_POST['descripcion']}' WHERE id={$_POST['id']} ");
    $datos = mysqli_query($conexion, "SELECT id,titulo FROM `lista` where id_usuario={$_POST['usuario']}");
    $nuevaplaylist = '';
    if ($datos->num_rows > 0) {
        while ($row = $datos->fetch_assoc()) {
            $nuevaplaylist .= "<div class='listas'><a href='#' onclick=\"cambiarVentana('PLAYLIST', '{$row['id']}')\"> {$row['titulo']} </a></div>";
        }
    }
    echo $nuevaplaylist;
}
