<?php
if (isset($_POST['titulo']) && isset($_POST['artista'])) {
    if (isset($_FILES['miniatura']['tmp_name']) && $_FILES['miniatura']['tmp_name'] !== '' && isset($_FILES['cancion']['tmp_name']) && $_FILES['cancion']['tmp_name'] !== '') {
        if ($_FILES['miniatura']['size'] < 10000000 && $_FILES['cancion']['size'] < 100000000) {
            if ($_FILES['cancion']['type'] == 'audio/mpeg' || $_FILES['cancion']['type'] == 'audio/mpeg3' || $_FILES['cancion']['type'] == 'audio/x-mpeg-3') {
                $conexion = mysqli_connect("localhost", "root", "", "listenme");
                if ($conexion->connect_error) {
                    die("Fallo la conexion al servidor, error: " . $conexion->connect_error);
                }
                $_POST['titulo'] = mysqli_real_escape_string($conexion, $_POST['titulo']);
                $_POST['artista'] = mysqli_real_escape_string($conexion, $_POST['artista']);
                $miniatura_original = $_FILES['miniatura']['tmp_name'];
                switch ($_FILES['miniatura']['type']) {
                    case 'image/jpg':
                        $original = imagecreatefromjpeg($miniatura_original);
                        break;
                    case 'image/jpeg':
                        $original = imagecreatefromjpeg($miniatura_original);
                        break;
                    case 'image/png':
                        $original = imagecreatefrompng($miniatura_original);
                        break;
                    case 'image/gif':
                        $original = imagecreatefromgif($miniatura_original);
                        break;
                }
                $max_alto = 250;
                $max_ancho = 250;
                list($ancho, $alto) = getimagesize($miniatura_original);
                $x_ratio = $max_ancho / $ancho;
                $y_ratio = $max_alto / $alto;
                if (($ancho <= $max_ancho) && ($alto <= $max_alto)) {
                    $ancho_final = $ancho;
                    $alto_final = $alto;
                } else if (($x_ratio * $alto) < $max_alto) {
                    $alto_final = ceil($x_ratio * $alto);
                    $ancho_final = $max_ancho;
                } else {
                    $ancho_final = ceil($y_ratio * $ancho);
                    $alto_final = $max_alto;
                }
                $lienzo = imagecreatetruecolor($ancho_final, $alto_final);
                imagecopyresampled($lienzo, $original, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho, $alto);
                imagedestroy($original);
                session_start();
                $usuario = "user_" . $_SESSION['id'];

                $sql = mysqli_query($conexion, "SELECT MAX(ruta_cancion) as RC_OLD FROM canciones WHERE id_usuario = {$_SESSION['id']} ");
                $datos = mysqli_fetch_array($sql);
                echo $datos['RC_OLD'];
                if ($datos['RC_OLD'] == null) {
                    $src_archivo = "s" . $_SESSION['id'] . "_1";
                } else {
                    $textnum = explode("s" . $_SESSION['id'] . "_", $datos['RC_OLD'])[1];
                    $src_archivotemp = explode(".", $textnum)[0];
                    $src_archivotemp += 1;
                    $src_archivo = "s" . $_SESSION['id'] . "_" . $src_archivotemp;
                }
                include_once '../archivos/getID3/getid3/getid3.php';

                $getID3 = new getID3();
                $ThisFileInfo = $getID3->analyze($_FILES['cancion']['tmp_name']);
                $duracion_cancion = $ThisFileInfo['playtime_string'];

                $directorio_cancion = '../archivos/musica/' . $usuario . "/" . $src_archivo . '.' . pathinfo($_FILES['cancion']['name'], PATHINFO_EXTENSION);
                $directorio_miniatura = '../archivos/portadas/' . $usuario . '/' . $src_archivo . '.' . pathinfo($_FILES['miniatura']['name'], PATHINFO_EXTENSION);
                if (move_uploaded_file($_FILES['cancion']['tmp_name'], $directorio_cancion) && imagejpeg($lienzo, $directorio_miniatura)) {
                    $dir_cancion = $src_archivo . '.' . pathinfo($_FILES['cancion']['name'], PATHINFO_EXTENSION);
                    $dir_miniatura = $src_archivo . '.' . pathinfo($_FILES['miniatura']['name'], PATHINFO_EXTENSION);
                    $sql_canciones = "INSERT INTO canciones (`titulo`, `artista`, `duracion`, `id_usuario`, `ruta_miniatura`, `ruta_cancion`) VALUES ('{$_POST['titulo']}', '{$_POST['artista']}', '{$duracion_cancion}',{$_SESSION['id']},'{$dir_miniatura}', '{$dir_cancion}')";
                    if ($conexion->query($sql_canciones) == TRUE) {
                        header("location: ../index.php");
                    }
                }
            }
        }
    }
}
header("location: ../index.php");
