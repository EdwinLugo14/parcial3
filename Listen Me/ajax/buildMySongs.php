<?php


$conexion = mysqli_connect('localhost', 'root', '', 'listenme');

if ($conexion->connect_error) {
    die("Fallo la conexion al servidor, error: " . $conexion->connect_error);
}
session_start();
$playlist_datos = "<div class='container'>
                        <div class='row'>
                            <div class='col-12 playlist_title'>
                                Mis Canciones
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-12 playlist_author'>
                                {$_SESSION['nombre_perfil']}
                            </div>
                        </div>
                    </div>";



$datos = mysqli_query($conexion, "SELECT id, titulo, artista, duracion, ruta_cancion, ruta_miniatura  FROM `canciones` WHERE id_usuario={$_SESSION['id']} ");
$playlist_canciones = '';
$num = 0;
if ($datos->num_rows > 0) {
    while ($row = $datos->fetch_assoc()) {
        $num++;
        $playlist_canciones .= "<div class='row playlist_cancion' ondblclick=\"selectMusic({$row['id']},{$_SESSION['id']}, '{$row['ruta_cancion']}', '{$row['ruta_miniatura']}', '{$row['titulo']}', '{$row['artista']}')\">
                <div class='col-1'>{$num}</div>
                <div class='col-5' style='text-overflow: ellipsis'>{$row['titulo']}</div>
                <div class='col-3'><a href='#' style='color: white;'>{$row['artista']}</a></div>
                <div class='col-2'>{$row['duracion']}</div>
                </div>";
    }
}

$html = array();
$html[0] = $playlist_datos;
$html[1] = $playlist_canciones;

echo json_encode($html, JSON_UNESCAPED_UNICODE);
