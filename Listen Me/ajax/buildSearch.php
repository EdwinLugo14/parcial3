<?php

$conexion = mysqli_connect('localhost', 'root', '', 'listenme');

if ($conexion->connect_error) {
    die("Fallo la conexion al servidor, error: " . $conexion->connect_error);
}


$sql = mysqli_query($conexion, "SELECT * FROM canciones WHERE titulo LIKE '%{$_POST['buscar']}%'");
$contenido = "";
if ($sql->num_rows > 0) {
    $contenido .= "<div class='categoria'><div class='titulo'>Canciones</div><div class='lista_canciones'>";
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
$sql = mysqli_query($conexion, "SELECT * FROM canciones WHERE artista LIKE '%{$_POST['buscar']}%'");
if ($sql->num_rows > 0) {
    $contenido .= "<div class='categoria'><div class='titulo'>Artistas</div><div class='lista_canciones'>";
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


$sql2 = mysqli_query($conexion, "SELECT * FROM lista WHERE titulo LIKE '%{$_POST['buscar']}%'");
if ($sql2->num_rows > 0) {
    $contenido .= "<div class='categoria'><div class='titulo'>Playlist</div><div class='lista_canciones'>";
    while ($row = $sql2->fetch_assoc()) {
        $contenido .= "<div class='cancion' onclick=\"cambiarVentana('PLAYLIST',{$row['id']})\">
                            <img src=\"archivos/portadas/playlist.png\" class='cancion_portada'>
                            <div class='titulo_cancion'>
                                {$row['titulo']}
                            </div>
                        </div>";
    }
    $contenido .= "</div></div>";
}


$html = $contenido;

echo json_encode($html, JSON_UNESCAPED_UNICODE);
