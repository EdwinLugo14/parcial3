<?php


$conexion = mysqli_connect('localhost', 'root', '', 'listenme');

if ($conexion->connect_error) {
    die("Fallo la conexion al servidor, error: " . $conexion->connect_error);
}

$SQL = mysqli_query($conexion, "SELECT l.id, l.titulo, u.id as id_usuario, u.nombre_perfil, l.descripcion FROM `lista` l, `usuarios` u where l.id={$_POST['id']} AND l.id_usuario=u.id");
$datos_top = mysqli_fetch_assoc($SQL);
if ($_POST['visitor'] == $datos_top['id_usuario']) {
    $visitante = 1;
} else {
    $visitante = 0;
}

if ($visitante) {
    $playlist_datos = "<div class='container'>
                        <div class='row'>
                            <div class='col-12 playlist_title' contenteditable='true' onblur=\"actualizarPlaylistTop({$datos_top['id']})\">{$datos_top['titulo']}</div>
                        </div>
                        <div class='row'>
                            <div class='col-12 playlist_author'>
                                {$datos_top['nombre_perfil']}
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-12 playlist_descripcion' style='width: 200px; white-space:normal;' contenteditable='true' onblur=\"actualizarPlaylistTop({$datos_top['id']})\">{$datos_top['descripcion']}</div>
                        </div>
                    </div>";
} else {
    $playlist_datos = "<div class='container'>
                        <div class='row'>
                            <div class='col-12 playlist_title'>
                                {$datos_top['titulo']}
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-12 playlist_author'>
                                {$datos_top['nombre_perfil']}
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-12 playlist_descripcion' style='width: 200px; white-space:normal;'>
                                {$datos_top['descripcion']}
                            </div>
                        </div>
                    </div>";
}


$datos = mysqli_query($conexion, "SELECT c.titulo,c.artista,c.duracion,c.ruta_cancion, c.ruta_miniatura, u.id, c.id as id_cancion, l.id as id_lista  FROM `usuarios` u,`canciones` c, `lista_cancion` lc, `lista` l WHERE l.id={$_POST['id']} AND lc.id_lista=l.id AND lc.id_cancion=c.id AND c.id_usuario=u.id ");
$playlist_canciones = '';
$num = 0;
$rutaportada = "archivos/portadas/playlist.png";
if ($datos->num_rows > 0) {
    while ($row = $datos->fetch_assoc()) {
        $num++;
        if ($num == 1) {
            $rutaportada = "archivos/portadas/user_" . $row['id'] . "/" . $row['ruta_miniatura'];
        }
        $playlist_canciones .= "<div class='row playlist_cancion' ondblclick=\"selectMusic('{$row['id_cancion']}','{$row['id']}', '{$row['ruta_cancion']}', '{$row['ruta_miniatura']}', '{$row['titulo']}', '{$row['artista']}')\">
                <div class='col-1'>{$num}</div>
                <div class='col-5' style='text-overflow: ellipsis'>{$row['titulo']}</div>
                <div class='col-3'><a href='#' style='color: white;'>{$row['artista']}</a></div>
                <div class='col-2'>{$row['duracion']}</div>";
        if ($visitante) {
            $playlist_canciones .= "<div class='col-1'><button class='btn btn-outline-danger btn-block' onclick=\"quitarCancionPlaylist('{$row['id_cancion']}','{$row['id_lista']}')\">X</button></div>
            </div>";
        } else {
            $playlist_canciones .= "</div>";
        }
    }
}

$html = array();
$html[0] = $playlist_datos;
$html[1] = $playlist_canciones;
$html[2] = $rutaportada;
if ($visitante) {
    $html[3] = "<button class='btn btn-outline-danger btn-block borrar_playlist'>Borrar Playlist</button>";
}

echo json_encode($html, JSON_UNESCAPED_UNICODE);
