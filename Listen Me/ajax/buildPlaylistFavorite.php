<?php


$conexion = mysqli_connect('localhost', 'root', '', 'listenme');

if ($conexion->connect_error) {
    die("Fallo la conexion al servidor, error: " . $conexion->connect_error);
}

$SQL = mysqli_query($conexion, "SELECT nombre_perfil FROM usuarios where id={$_POST['id']}");
$datos_top = mysqli_fetch_assoc($SQL);
$playlist_datos = "<div class='container'>
                        <div class='row'>
                            <div class='col-12 playlist_title'>
                                FAVORITOS
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-12 playlist_author'>
                                {$datos_top['nombre_perfil']}
                            </div>
                        </div>
                    </div>";

$datos = mysqli_query($conexion, "SELECT c.titulo,c.artista,c.duracion,c.ruta_miniatura,c.ruta_cancion, u.id, c.id as id_cancion FROM `canciones` c, `usuarios` u, `megusta` m  WHERE m.id_usuario={$_POST['id']} AND c.id = m.id_cancion AND u.id = {$_POST['id']}");
$playlist_canciones = '';
$num = 0;
if ($datos->num_rows > 0) {
    while ($row = $datos->fetch_assoc()) {
        $num++;
        $playlist_canciones .= "<div class='row playlist_cancion' ondblclick=\"selectMusic('{$row['id_cancion']}', '{$row['id']}', '{$row['ruta_cancion']}', '{$row['ruta_miniatura']}', '{$row['titulo']}', '{$row['artista']}')\">
                <div class='col-1'>{$num}</div>
                <div class='col-5' style='text-overflow: ellipsis'>{$row['titulo']}</div>
                <div class='col-3'><a href='#' style='color: white;'>{$row['artista']}</a></div>
                <div class='col-3'>{$row['duracion']}</div>
            </div>";
    }
}

$html = array();
$html[0] = $playlist_datos;
$html[1] = $playlist_canciones;

echo json_encode($html, JSON_UNESCAPED_UNICODE);
