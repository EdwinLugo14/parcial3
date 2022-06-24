<?php
$conexion = mysqli_connect('localhost', 'root', '', 'listenme');

if ($conexion->connect_error) {
    die("Fallo la conexion al servidor, error: " . $conexion->connect_error);
}

mysqli_query($conexion, "INSERT INTO `lista` (`id_usuario`, `titulo`, `descripcion`) VALUES ('{$_POST['id']}', 'Nueva Playlist', 'Añade una descripcion')");
$datos = mysqli_query($conexion, "SELECT id,titulo FROM `lista` where id_usuario={$_POST['id']}");
$nuevaplaylist = '';
if ($datos->num_rows > 0) {
    while ($row = $datos->fetch_assoc()) {
        $nuevaplaylist .= "<div class='listas'>
            <a href='#' onclick=\"cambiarVentana('PLAYLIST', '{$row['id']}')\"> {$row['titulo']} </a>
            </div>";
    }
}
echo $nuevaplaylist;
