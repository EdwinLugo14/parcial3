<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    if (!isset($_SESSION['estado'])) {
        header("location: login.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listen Me!</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/jquery-1.11.1.min.js"></script>
    <style>
        :root {
            --reproductor_alto: 93px;
            --barra_lateral_ancho: 200px;
            --barra_lateral_alto: calc(100vh - 90px);
            --logo_size: 40px;
        }

        @font-face {
            font-family: "Fort Quinsy";
            src: url('FORTQUINSY.otf');
        }

        * {
            margin: 0;
            padding: 0;
            border: 0;
            vertical-align: baseline;
            font-family: "Century Gothic";
            font-size: 1rem;
        }

        body {
            height: 100vh;
            width: 100vw;
            color: white;
            overflow-y: hidden;
            overflow-x: hidden;
        }

        /* BARRA LATERAL */

        #barra_lateral_colapsada {
            background: black;
            position: absolute;
            left: 0;
            top: 0;
            overflow: hidden;
        }

        #barra_lateral_absoluto {
            background: black;
            position: absolute;
            left: 0;
            top: 0;
            overflow: hidden;
            z-index: 2;
        }

        #barra_lateral_relativo {
            position: relative;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .accesos_alineacion {
            padding-left: 15px;
            height: fit-content;
        }

        .acceso {
            margin-top: 12px;
        }

        .acceso a {
            text-decoration: none;
            font-size: 15px;
            color: rgba(255, 255, 255, 0.753);
            font-weight: bold;
        }

        .acceso a:hover {
            color: white;
        }

        .icon {
            height: 25px;
            width: 25px;
        }

        hr {
            background: rgba(255, 255, 255, 0.61);
            margin-right: 15px;
        }

        .listas_relativas {
            position: relative;
            overflow-y: auto;
            padding-right: 15px;
            padding-left: 15px;
        }

        .listas {
            margin-top: 6px;
        }

        .listas a {
            text-decoration: none;
            font-size: 16px;
            color: rgba(255, 255, 255, 0.753);
        }

        .listas a:hover {
            color: white;
        }

        /* REPRODUCTOR */
        #reproductor {
            position: absolute;
            bottom: 0;
            left: 0;
            background: rgb(14, 14, 14);
            display: flex;
            z-index: 3;
        }

        .player_portada {
            width: 60px;
            height: 60px;
            margin-top: 15px;
        }

        .player_datos {
            margin-top: 10px;
            font-weight: normal;
            text-overflow: ellipsis;
            font-size: 10px;
        }

        .icon_player {
            width: 40px;
            height: 40px;
            cursor: pointer;
        }

        #player_duracion {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.596);
            padding-top: 8px;
        }

        .musica_audio {
            display: flex;
            margin-top: 50px;
        }

        /* CONTENIDO GENERAL */

        #contenido_absoluto {
            position: absolute;
            right: 0;
            top: 0;
            overflow: hidden;
            z-index: 1;
        }

        #contenido_relativo {
            position: relative;
            overflow-y: auto;
            background: rgb(66, 66, 66);
            background: linear-gradient(180deg, rgba(66, 66, 66, 1) 0%, rgba(46, 46, 46, 1) 0%, rgba(13, 13, 13, 1) 100%);
        }

        .titulo {
            font-size: 20px;
            font-weight: bold;
            margin-left: 6vw;
            margin-top: 4vh;
            text-decoration: underline;
        }


        .lista_canciones {
            margin-left: 6vw;
            margin-top: 1vh;
            height: 280px;
            position: relative;
            overflow-y: hidden;
            display: flex;
        }

        .cancion {
            height: 280px;
            width: 200px;
            background: rgb(0, 0, 0);
            transition: 0.2s;
            border-radius: 2%;
            cursor: pointer;
            margin-left: 10px;
        }

        .cancion:hover {
            background: rgb(46, 46, 46);
            transition: 0.2s;
        }

        .cancion_portada {
            margin-left: 10px;
            margin-right: 10px;
            margin-top: 10px;
            width: 180px;
            height: 180px;
            border-radius: 4%;
        }

        .titulo_cancion {
            margin-left: 10px;
            margin-right: 10px;
            margin-top: 6px;
            font-size: 14px;
            color: white;
            font-weight: bold;
        }

        .autor_cancion {
            margin-left: 10px;
            margin-right: 10px;
            margin-top: 2px;
            font-size: 14px;
            color: rgb(196, 196, 196);
        }



        /* PLAYLIST */
        .playlist_cancion {
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .playlist_cancion:hover {
            background: rgb(46, 46, 46);
            transition: 0.2s;
        }

        /* CELULAR */
        @media screen and (max-width:768px) {
            :root {
                --reproductor_alto: 180px;
                --barra_lateral_ancho: 200px;
                --barra_lateral_alto: calc(100vh - 180px);
                --contenido_ancho: calc(100vw - 32px);
                --contenido_alto: calc(100vh - var(--reproductor_alto));
                --logo_size: 40px;
            }

            #barra_lateral_colapsada {
                width: fit-content;
                height: var(--barra_lateral_alto);
                display: block;
            }

            #barra_lateral_absoluto,
            #barra_lateral_relativo {
                width: var(--barra_lateral_ancho);
                height: var(--barra_lateral_alto);
                display: none;
            }

            .logo_alineacion {
                width: var(--barra_lateral_ancho);
                padding: 10px;
            }

            .logo {
                font-family: "Fort Quinsy";
                font-size: var(--logo_size);
                text-align: center;
            }

            .listas_relativas {
                width: var(--barra_lateral_ancho);
                height: fit-content;
            }

            #contenido_absoluto,
            #contenido_relativo {
                width: var(--contenido_ancho);
                height: var(--contenido_alto);
            }

            .lista_canciones {
                width: calc(100vw - (32px + 6vw) - 4vw);
            }


            #reproductor {
                height: var(--reproductor_alto);
                width: 100vw;
                display: unset;
            }

            .player_datos {
                height: var(--reproductor_alto/2);
            }

            .musica_datos {
                min-width: 300px;
                width: 100vw;
                height: calc(var(--reproductor_alto) / 2);
            }

            .musica_comandos {
                height: calc(var(--reproductor_alto) / 2);
                width: 100vw;
                padding-top: 15px;
            }

            #player_audio_icon1,
            #volumen1 {
                display: unset;
            }

            #player_audio_icon2,
            #volumen2 {
                display: none;
            }

            .playlist_top {
                margin-left: calc((var(--contenido_ancho) - 280px)/2);
                margin-right: calc((var(--contenido_ancho) - 280px)/2);

            }

            .playlist_img {
                width: 250px;
                height: 250px;
                margin-top: 6vh;
            }

            .playlist_datos {
                margin-top: 2vh;

            }

            .playlist_title {
                font-size: 30px;
                font-weight: bold;
            }

            .playlist_author {
                font-size: 20px;
                color: rgba(240, 248, 255, 0.733);
                margin-bottom: 10px;
            }

        }

        /* PC */
        @media screen and (min-width: 769px) {
            :root {
                --reproductor_alto: 90px;
                --barra_lateral_ancho: 200px;
                --barra_lateral_alto: calc(100vh - 90px);
                --contenido_ancho: calc(100vw - var(--barra_lateral_ancho));
                --contenido_alto: calc(100vh - var(--reproductor_alto));
                --logo_size: 40px;
            }

            #barra_lateral_colapsada {
                width: fit-content;
                height: var(--barra_lateral_alto);
                display: none;
            }

            #barra_lateral_absoluto,
            #barra_lateral_relativo {
                width: var(--barra_lateral_ancho);
                height: var(--barra_lateral_alto);
                display: unset;
                overflow-y: auto;
            }

            .logo_alineacion {
                width: var(--barra_lateral_ancho);
                padding: 10px;
            }

            .logo {
                font-family: "Fort Quinsy";
                font-size: var(--logo_size);
                text-align: center;
            }

            .listas_relativas {
                width: var(--barra_lateral_ancho);
                height: fit-content;
            }

            #contenido_absoluto,
            #contenido_relativo {
                width: var(--contenido_ancho);
                height: var(--contenido_alto);
            }

            .lista_canciones {
                width: calc(100vw - (var(--barra_lateral_ancho) + 6vw) - 4vw);
            }

            #reproductor {
                height: var(--reproductor_alto);
                width: 100vw;
                display: flex;
            }

            .player_datos {
                height: var(--reproductor_alto);
            }

            .musica_datos {
                min-width: 300px;
                width: 30vw;
                height: var(--reproductor_alto);
            }

            .musica_comandos {
                width: 40vw;
                height: var(--reproductor_alto);
                padding-top: 15px;
            }

            #player_audio_icon1,
            #volumen1 {
                display: none;
            }

            #player_audio_icon2,
            #volumen2 {
                display: unset;
            }

            .playlist_img {
                width: 250px;
                height: 250px;
                margin-left: 2vw;
                margin-top: 6vh;
            }

            .playlist_datos {
                margin-left: 2vw;
                margin-top: 6vh;
            }

            .playlist_title {
                font-size: 50px;
                font-weight: bold;
            }

            .playlist_author {
                font-size: 20px;
                color: rgba(240, 248, 255, 0.733);
                margin-bottom: 10px;
            }

            .buscador {
                min-width: calc(var(--contenido_ancho) * 0.8);
                max-width: calc(var(--contenido_ancho) * 0.8);
                margin-left: calc((var(--contenido_ancho) - (var(--contenido_ancho) * 0.8))/2);
                margin-right: calc((var(--contenido_ancho) - (var(--contenido_ancho) * 0.8))/2);
            }

            .pageNewSong_formulario {
                width: 400px;
                margin-left: calc((var(--contenido_ancho) - 400px)/2);
                margin-top: 2vh;
            }

        }

        #INICIO {
            display: unset;
        }

        .PLAYLIST {
            display: none;
        }

        .BUSCAR {
            display: none;
        }

        #pageNewSong {
            display: none;
        }

        .listasplaylist {
            position: absolute;
            width: 300px;
            margin-left: calc((100vw - 300px)/2);
            margin-right: calc((100vw - 300px)/2);
            margin-top: 2vh;
            background: rgba(0, 0, 0, 0.8);
            z-index: 10;
            text-align: center;
            border-radius: 10px;
        }

        .borrar_playlist {
            margin-top: 6vh;
        }
    </style>
</head>

<body>
    <div class="listasplaylist" style="display: none;">
        Playlists Disponibles
        <div class="listasUsuario">

        </div>
        <br>
        <button class="btn btn-danger btn-block" onclick="togglePlaylists()">Cerrar</button>
    </div>

    <!-- Barra de accesos rapidos -->
    <div id="barra_lateral_colapsada">
        <img id="openLateralBar" onclick="toggleLeftBar()" src="archivos/iconos/menu.png" alt="" class="icon" style="cursor: pointer; margin: 4px;">
    </div>
    <div id="barra_lateral_absoluto">
        <div id="barra_lateral_relativo">
            <div class="logo_alineacion">
                <div class="logo">Listen Me!</div>
            </div>
            <div class="accesos_alineacion">
                <div class="acceso">
                    <a href="#" onclick="cambiarVentana('INICIO', '')"><img src="archivos/iconos/home.png" class="icon"> &nbsp; Inicio</a>
                </div>
                <div class="acceso">
                    <a href="#" onclick="cambiarVentana('BUSCAR', '')"><img src="archivos/iconos/search.png" class="icon"> &nbsp; Buscar</a>
                </div>
                <div class="acceso">
                    <a href="#" onclick="cambiarVentana('MYSONGS', '')"><img src="archivos/iconos/library.png" class="icon"> &nbsp; Mis Canciones</a>
                </div>
                <br>
                <hr>
                <div class="acceso">
                    <a href="#" onclick="cambiarVentana('newsong', '')"><img src="archivos/iconos/add.png" class="icon"> &nbsp; Subir Cancion</a>
                </div>
                <div class="acceso">
                    <a href="#" onclick="newPlaylist()"><img src="archivos/iconos/add.png" class="icon"> &nbsp; Crear Lista</a>
                </div>
                <div class="acceso">
                    <a href="#" onclick="cambiarVentana('FAVORITOS',<?php echo $_SESSION['id'] ?>)"><img src="archivos/iconos/like.png" class="icon"> &nbsp; Favoritos</a>
                </div>
            </div>
            <br>
            <div class="listas_relativas">

            </div>
            <div class="acceso" style="padding-left: 15px;">
                <a href="ajax/cerrarSesion.php"><img src="archivos/iconos/exit.png" class="icon"> &nbsp; Cerrar Sesion</a>
            </div>
        </div>
    </div>

    <!-- Contenido -->

    <div id="contenido_absoluto">
        <div id="contenido_relativo">

            <div id="INICIO">

            </div>

            <div class="PLAYLIST">
                <div class="playlist_top">
                    <div class="container">
                        <div class="row">
                            <img src="archivos/portadas/playlist.png" class="playlist_img">
                            <div class="col playlist_datos">
                            </div>
                        </div>

                    </div>
                </div>
                <hr>
                <div class="container">
                    <div class="row">
                        <div class="col-1">#</div>
                        <div class="col-5">Titulo</div>
                        <div class="col-3">Artista</div>
                        <div class="col-2">Duracion</div>
                        <div class="col-1"></div>
                    </div>
                    <br>
                    <div class="playlist_canciones">
                    </div>
                </div>
                <div class="btn_borrarPlaylist">

                </div>

            </div>

            <div class="BUSCAR">
                <input type='search' class='form-control buscador' onchange="resultadosBuscador()" placeholder='Busca algun artista, cancion, playlist'>
                <div class="categorias">

                </div>
            </div>

            <div id="pageNewSong">
                <form action="ajax/insertarCancion.php" method="POST" enctype="multipart/form-data" class="pageNewSong_formulario">
                    <label>Titulo</label>
                    <input type="text" class="form-control" name="titulo" minlength="1">
                    <br>
                    <label>Artista</label>
                    <input type="text" class="form-control" name="artista" minlength="1">
                    <br>
                    <label>Miniatura</label>
                    <input type="file" class="form-control" name="miniatura" accept=".png, .jpg, .jpeg, .gif">
                    <br>
                    <label>Cancion</label>
                    <input type="file" class="form-control" name="cancion" accept=".mp3">
                    <br>
                    <input type="submit" class="btn btn-success btn-block" value="Subir Cancion">
                </form>
            </div>

        </div>
    </div>

    <!-- Reproductor -->

    <div id="reproductor">
        <div class="musica_datos">
            <div class="container">
                <div class="row">
                    <div class="col-auto"><img src="archivos/portadas/default.png" class="player_portada"></div>
                    <div class="col">
                        <table class="player_datos">
                            <tr>
                                <th style="font-size: 15px;" class="player_title"></th>
                            </tr>
                            <tr>
                                <th style="color: rgb(192, 192, 192); font-size: 14px;" class="player_author"></th>
                            </tr>
                            <tr>
                                <th style="display: flex">
                                    <img src="archivos/iconos/audio.png" onclick="" id="player_audio_icon1" class="icon" style=" cursor: pointer;">&nbsp;&nbsp;
                                    <input type="range" class="form-control-range" name="volumen1" id="volumen1" min="0" max="1" step="0.01" value="0.50">
                                </th>
                            </tr>
                        </table>
                    </div>
                    <div class="col-auto">
                        <button class="btn_like" style="background: none; margin-top: 15px; display: none;"><img class="icon img_like" src="archivos/iconos/like.png"></button>
                        <a href="#" class="btn_addplaylist" onclick="togglePlaylists()" style="background: none; margin-top: 15px; display: none;"><img class="icon" src="archivos/iconos/addtoplaylist.png"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="musica_comandos">
            <div class="container">
                <div class="row">
                    <div class="col-12" style="text-align: center;">
                        <img src="archivos/iconos/player_play.png" onclick="reproducir()" id="player_pause_icon" class="icon_player">&nbsp;&nbsp;
                    </div>
                </div>
                <div class="row">
                    <div class="col-12" style="display: flex;">
                        <label id="player_duration_start" style="padding-right: 5px;">0:00</label>
                        <input type="range" class="form-control-range" name="ProgressBar" id="ProgressBar" min="0" max="100" step="1" value="0">
                        <label id="player_duration_end" style="padding-left: 5px;">0:00</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="musica_audio">
            <img src="archivos/iconos/audio.png" onclick="mute()" id="player_audio_icon2" class="icon" style="margin-top: 5px; cursor: pointer;">&nbsp;&nbsp;
            <input type="range" class="form-control-range" name="volumen2" id="volumen2" min="0" max="1" step="0.01" value="0.50">
        </div>
    </div>

</body>

<script>

</script>


<script>
    function togglePlaylists() {
        if ($(".listasplaylist").css("display") == "block") {
            $(".listasplaylist").css("display", "none");
        } else {
            $(".listasplaylist").css("display", "block");
        }
    }

    function resultadosBuscador() {
        $.ajax({
            type: 'POST',
            url: 'ajax/buildSearch.php',
            dataType: 'json',
            data: {
                buscar: $(".buscador").val()
            },
            success: function(res) {
                $(".categorias").html(res);
            }
        });
    }
</script>


</html>
<!-- CARGAR INICIO CANCIONES Y PLAYLIST -->
<script>
    $(document).ready(function() {
        buildInicio();
    });

    function buildInicio() {
        $.ajax({
            type: 'POST',
            url: 'ajax/buildInicio.php',
            dataType: 'json',
            data: "id=" + <?php echo $_SESSION['id'] ?>,
            success: function(res) {
                $(".listas_relativas").empty();
                $(".listasUsuario").empty();
                $("#INICIO").empty();

                $(".listas_relativas").append(res[0]);
                $("#INICIO").append(res[1]);
                $(".listasUsuario").append(res[2]);
            }
        });
    }
</script>

<!-- BORRAR PLAYLIST -->
<script>
    function borrarPlaylist(id) {
        if (confirm("¿Quiere borrar la Playlist?")) {
            $.ajax({
                type: 'POST',
                url: 'ajax/borrarPlaylist.php',
                data: "id=" + id,
                success: function() {
                    cambiarVentana("INICIO", "");
                }
            });
        }
    }

    function quitarCancionPlaylist(cancion, lista) {
        if (confirm("¿Quiere quitar la cancion de la playlist?")) {
            $.ajax({
                type: 'POST',
                url: 'ajax/quitarCancionPlaylist.php',
                data: {
                    id_cancion: cancion,
                    id_lista: lista
                },
                success: function(res) {
                    cambiarVentana("PLAYLIST", lista);
                }
            });
        }
    }
</script>


<!-- LIKE -->
<script>
    function toggleLike(id) {
        $.ajax({
            type: 'POST',
            url: 'ajax/togglefavorite.php',
            data: {
                id_usuario: <?php echo $_SESSION['id'] ?>,
                id_cancion: id
            },
            success: function(res) {
                if (res == 1) {
                    $(".img_like").attr("src", "archivos/iconos/like_fill.png");
                } else {
                    $(".img_like").attr("src", "archivos/iconos/like.png");
                }
            }
        });
    }
</script>

<!-- CAMBIAR VENTANA Y BORRAR LAS ANTERIORES -->
<script>
    function cambiarVentana(ventana, id) {
        if (ventana == "INICIO") {
            cleanBeforePages();
            $(".PLAYLIST, #pageNewSong, .BUSCAR").css("display", "none");
            $("#INICIO").css("display", "unset");
            buildInicio();
        } else if (ventana == "PLAYLIST" && id != '') {
            cleanBeforePages();
            buildPlaylist(id);
            $(".borrar_playlist").attr("onclick", "borrarPlaylist('" + id + "')");
            $("#INICIO, #pageNewSong, .BUSCAR").css("display", "none");
            $(".PLAYLIST").css("display", "unset");
        } else if (ventana == "FAVORITOS" && id != '') {
            cleanBeforePages();
            buildPlaylistFavorite(id);
            $("#INICIO, #pageNewSong, .BUSCAR").css("display", "none");
            $(".PLAYLIST").css("display", "unset");
        } else if (ventana == "BUSCAR") {
            cleanBeforePages();
            $(".PLAYLIST, #INICIO, #pageNewSong").css("display", "none");
            $(".BUSCAR").css("display", "unset");
        } else if (ventana == "newsong") {
            cleanBeforePages();
            $(".PLAYLIST, #INICIO, .BUSCAR").css("display", "none");
            $("#pageNewSong").css("display", "unset");
        } else if (ventana == "MYSONGS") {
            cleanBeforePages();
            buildMySongs();
            $("#INICIO, #pageNewSong, .BUSCAR").css("display", "none");
            $(".PLAYLIST").css("display", "unset");
        }
    }

    function cleanBeforePages() {
        $(".playlist_datos, .playlist_canciones, .lista_canciones, .categorias").empty();
    }
</script>

<!-- CREAR Y OBTENER PLAYLIST -->
<script>
    function actualizarPlaylistTop(id_lista) {
        $.ajax({
            type: 'POST',
            url: 'ajax/editPlaylist.php',
            data: {
                usuario: <?php echo $_SESSION['id'] ?>,
                id: id_lista,
                titulo: $(".playlist_title").text(),
                descripcion: $(".playlist_descripcion").text()
            },
            success: function(res) {
                $(".listas_relativas").empty();
                $(".listas_relativas").append(res);
            }
        });
    }

    function buildPlaylistFavorite(id) {
        var ruta = "id=" + id;
        $.ajax({
            type: 'POST',
            url: 'ajax/buildPlaylistFavorite.php',
            dataType: 'json',
            data: ruta,
            success: function(res) {
                $(".playlist_datos").append(res[0]);
                $(".playlist_canciones").append(res[1]);
                $(".playlist_img").attr("src", "archivos/portadas/favorite.png");
                $(".btn_borrarPlaylist").empty();
            }
        });
    }

    function buildMySongs() {
        $.ajax({
            type: 'POST',
            url: 'ajax/buildMySongs.php',
            dataType: 'json',
            success: function(res) {
                $(".playlist_datos").empty();
                $(".playlist_canciones").empty();
                $(".playlist_datos").append(res[0]);
                $(".playlist_canciones").append(res[1]);
                $(".playlist_img").attr("src", "archivos/portadas/playlist.png");
                $(".btn_borrarPlaylist").empty();
            }
        });
    }

    function buildPlaylist(id) {
        $.ajax({
            type: 'POST',
            url: 'ajax/obtenerplaylist.php',
            dataType: 'json',
            data: {
                id: id,
                visitor: <?php echo $_SESSION['id'] ?>
            },
            success: function(res) {
                $(".playlist_datos").empty();
                $(".playlist_canciones").empty();
                $(".playlist_datos").append(res[0]);
                $(".playlist_canciones").append(res[1]);
                $(".playlist_img").attr("src", res[2]);
                $(".btn_borrarPlaylist").empty();
                if (res[3] != 'undefined') {
                    $(".btn_borrarPlaylist").append(res[3]);
                }
            }
        });
    }

    function newPlaylist() {
        $.ajax({
            type: 'POST',
            url: 'ajax/newplaylist.php',
            data: "id=" + <?php echo $_SESSION['id'] ?>,
            success: function(res) {
                $(".listas_relativas").empty();
                $(".listas_relativas").append(res);
            }
        });
    }
</script>

<!-- BARRA LATERAL -->
<script>
    // BARRA LATERAL
    function toggleLeftBar() {
        if ($("#barra_lateral_colapsada").css("display") == "block") {
            $("#barra_lateral_colapsada").css("display", "none");
            $("#barra_lateral_absoluto").css("display", "block");
            $("#barra_lateral_relativo").css("display", "block");
        }
    }
    $(document).on("click", function(e) {
        if (screen.width < 768) {
            if (!$("#barra_lateral_absoluto").is(e.target) && !$("#openLateralBar").is(e.target) && $("#barra_lateral_absoluto").has(e.target).length === 0 && $("#barra_lateral_absoluto").css("display") == "block") {
                $("#barra_lateral_absoluto").css("display", "none");
                $("#barra_lateral_relativo").css("display", "none");
                $("#barra_lateral_colapsada").css("display", "block");
            }
        }
    });
</script>

<script>
    // CONTROL DEL REPRODUCTOR
    var reproductor = new Audio();
    var cancion_actual = undefined;
    var cancion_tiempo;
    var portada;

    function agregarCancionPlaylist(id) {
        $.ajax({
            type: 'POST',
            url: 'ajax/songtoplaylist.php',
            data: {
                id_cancion: cancion_actual,
                id_lista: id
            },
            success: function() {
                $(".listasplaylist").css("display", "none");
            }
        });
    }

    function selectMusic(id_cancion, id, archivo, portada, titulo, artista) {
        reproductor.src = "archivos/musica/user_" + id + "/" + archivo;
        $(".player_portada").attr("src", "archivos/portadas/user_" + id + "/" + portada);
        cancion_actual = id_cancion;
        $(".player_title").text(titulo);
        $(".player_author").text(artista);
        $(".btn_like").css("display", "unset");
        $(".btn_like").attr("onclick", "toggleLike(" + id_cancion + ")");
        $(".btn_addplaylist").css("display", "unset");
        $.ajax({
            type: 'POST',
            url: 'ajax/needfavorite.php',
            data: {
                id_usuario: <?php echo $_SESSION['id'] ?>,
                id_cancion: id_cancion
            },
            success: function(res) {
                if (res == 1) {
                    $(".img_like").attr("src", "archivos/iconos/like_fill.png");
                } else {
                    $(".img_like").attr("src", "archivos/iconos/like.png");
                }
            }
        });
    }

    function reproducir() {
        if (cancion_actual != undefined) {
            if (reproductor.paused) {
                $("#player_pause_icon").attr("src", "archivos/iconos/player_pause.png");
                cancion_tiempo = window.setInterval(function() {
                    updateProgress();
                }, 1000);
                reproductor.play();
            } else {
                $("#player_pause_icon").attr("src", "archivos/iconos/player_play.png");
                clearInterval(cancion_tiempo);
                reproductor.pause();
            }
        }
    }

    document.getElementById("ProgressBar").addEventListener('click', alterprogress);
    document.getElementById("ProgressBar").addEventListener('touchstart', alterprogressphone);

    function alterprogress(e) {
        const advanceTime = (e.offsetX / document.getElementById("ProgressBar").offsetWidth) * reproductor.duration;
        reproductor.currentTime = advanceTime;
    }

    function alterprogressphone(e) {
        const rect = e.target.getBoundingClientRect();
        const advanceTime = ((e.touches[0].clientX - window.pageXOffset - rect.left) / document.getElementById("ProgressBar").offsetWidth) * reproductor.duration;
        reproductor.currentTime = advanceTime;
    }

    function updateProgress() {
        if (reproductor.currentTime > 0) {
            document.getElementById("ProgressBar").value = (reproductor.currentTime / reproductor.duration) * 100;
            $("#player_duration_start").text(secondsToString(reproductor.currentTime.toFixed(0)));
            $("#player_duration_end").text(secondsToString(reproductor.duration.toFixed(0)));
        }
        if (reproductor.ended) {
            clearInterval(cancion_tiempo);
            $("#player_pause_icon").attr("src", "archivos/iconos/player_play.png");
        }
    }

    function mute() {
        if (reproductor.muted) {
            $("#player_audio_icon1").attr("src", "archivos/iconos/audio.png");
            $("#player_audio_icon2").attr("src", "archivos/iconos/audio.png");
            reproductor.muted = false;
        } else {
            $("#player_audio_icon1").attr("src", "archivos/iconos/mute.png");
            $("#player_audio_icon2").attr("src", "archivos/iconos/mute.png");
            reproductor.muted = true;
        }
    }
    const volumen = document.getElementById("volumen1");
    const volumen2 = document.getElementById("volumen2");
    volumen.oninput = (e) => {
        const vol = e.target.value
        $("#volumen2").attr("value", vol)
        reproductor.volume = vol
    }
    volumen2.oninput = (e) => {
        const vol = e.target.value
        $("#volumen1").attr("value", vol)
        reproductor.volume = vol
    }


    function secondsToString(seconds) {
        var hour = "";
        if (seconds > 3600) {
            hour = Math.floor(seconds / 3600);
            hour = (hour < 10) ? '0' + hour : hour;
            hour += ":"
        }
        var minute = Math.floor((seconds / 60) % 60);
        minute = (minute < 10) ? '0' + minute : minute;
        var second = seconds % 60;
        second = (second < 10) ? '0' + second : second;
        return hour + minute + ':' + second;
    }
</script>