<?php

$conexion = mysqli_connect('localhost', 'root', '', 'listenme');

if ($conexion->connect_error) {
    die("Fallo la conexion al servidor, error: " . $conexion->connect_error);
}

$datos = mysqli_query($conexion, "SELECT id,titulo FROM lista where id_usuario={$_POST['id']}");
$playlists = '';
$listas = '';
$num = 0;
if ($datos->num_rows > 0) {
    while ($row = $datos->fetch_assoc()) {
        $playlists .= "<div class='listas'>
        <a href='#' onclick=\"cambiarVentana('PLAYLIST', '{$row['id']}')\"> {$row['titulo']} </a>
        </div>";
        $num++;
        $listas .= "<div class='listas'>
        <a href='#' onclick=\"agregarCancionPlaylist('{$row['id']}')\">{$num} - {$row['titulo']}</a>
        </div>";
    }
}
$gruposql = mysqli_query($conexion, "SELECT artista FROM canciones GROUP BY artista");
$contenido = '';

if ($gruposql->num_rows > 0) {
    while ($artistas = $gruposql->fetch_assoc()) {
        $sql = mysqli_query($conexion, "SELECT * FROM canciones WHERE artista='{$artistas['artista']}'");
        if ($sql->num_rows > 0) {
            $contenido .= "<div class='categoria'><div class='titulo'>{$artistas['artista']}</div><div class='lista_canciones'>";
            while ($row = $sql->fetch_assoc()) {
                $contenido .= "<div class='cancion' onclick=\"selectMusic('{$row['id']}','{$row['id_usuario']}', '{$row['ruta_cancion']}', '{$row['ruta_miniatura']}', '{$row['titulo']}', '{$row['artista']}'  )\">
            <img src=\"archivos/portadas/user_{$row['id_usuario']}/{$row['ruta_miniatura']}\" class='cancion_portada'>
            <div class='titulo_cancion'>
            {$row['titulo']}
            </div>
            <div class='autor_cancion'>
            {$row['artista']}
            </div>
            </div>";
            }
            $contenido .= "</div></div>";
        }
    }
}

$html = array();
$html[0] = $playlists;
$html[1] = $contenido;
$html[2] = $listas;


echo json_encode($html, JSON_UNESCAPED_UNICODE);
