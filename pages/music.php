<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JUKEBOX</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../assets/icon.png" />
</head>
<body>
    <script>
        let songCount = 0;
    </script>
    <div class="container">
        <div class="nav">
            <?php
                // url parameter
                $id = htmlspecialchars($_GET["id"]);
                // glazba iz trenutne kategorije
                $songs = array();
                $i = 0;

                // ime trenutne kategorije iz url ja
                $category = htmlspecialchars($_GET["category"]);
                echo '<div class="title"><a href="/seminar"><</a> <h1>' . $category . '</h1></div>';
                echo '<div class="list">';

                // glazba v direktoriju trenutne kategorije
                if ($handle = opendir('../client/' . $category . '/music')) {
                    while (false !== ($entry = readdir($handle))) {
                        if ($entry != "." && $entry != "..") {
                            // izpisemo vso glazbo
                            if ($id == $i) {
                                // ce je pesem trenutna dodamo klaso 'active'
                                echo '<a class="active" href="music.php?category=' . $category . '&id=' . $i . '">' . $entry . '</a>';
                                $current = $entry;
                            } else {
                                // ostalo
                                echo '<a href="music.php?category=' . $category . '&id=' . $i . '">' . $entry . '</a>';
                            }
                            array_push($songs,$entry);
                            $i++;
                            ?>
                            <script>
                                songCount++
                            </script>
                            <?php
                        }
                    }
                    closedir($handle);
                }
                echo '</div>';
            ?>
        </div>
        <div class="albums">
            <?php
                // direktoriji v client direktoriju kot kategorije
                $dirs = array_filter(glob('../client/*'), 'is_dir');

                // izpisemo na ekranu vse direktorije
                for ($i = 0; $i < count($dirs); $i++) {
                    $categoryName = substr($dirs[$i], strrpos($dirs[$i], '/') + 1);
                    $firstWord = strtok($categoryName, ' ');
                    if (is_dir('../client/' . substr($dirs[$i], strrpos($dirs[$i], '/') + 1) . '/music')) {
                        // ce obstaja direktorij 'music'
                        echo "<a href='music.php?category=" . substr($dirs[$i], strrpos($dirs[$i], '/') + 1) . "&id=0' style='background-image: url(../assets/covers/" . $firstWord . ".jpg)' class='album-category'>" . substr($dirs[$i], strrpos($dirs[$i], '/') + 1) . "</a>";
                    } else if (substr($dirs[$i], strrpos($dirs[$i], '/') + 1) == 'Admin') {
                        // ce je admin
                        echo '<a href="admin.php" style="background-image: url(../assets/covers/admin.jpg)" class="album-category">Admin</a>';
                    }
                }
            ?>
        </div>
        <div class="player">
            <?php
                // layout
                echo '<div class="cover" style="background-image: url(../assets/covers/' . strtok($category, ' ') . '.jpg)"></div>';
                echo '<h1 class="current">' . substr($current, 0, strrpos( $current, '.') ) . '</h1>';
                // audio source
                echo "<audio id='player' autoplay src='../client/" . $category . "//music/" . $songs[$id] . "'></audio>";
            ?>
            <div class="controls">
                <div style="background-image: url(../assets/previous.png)" class="previous" onclick="prev()"></div>
                <div style="background-image: url(../assets/pause.png)" class="pause" onclick="pause()"></div>
                <div style="background-image: url(../assets/play.png)" class="play" onclick="play()"></div>
                <div style="background-image: url(../assets/next.png)" class="next" onclick="next()"></div>
            </div>
            <script type="text/javascript">
                // skrijemo play gumb
                document.querySelector('.play').style.display = 'none'
                // player
                const player = document.getElementById('player')
                // url parametri
                const vars = {};
                // url parametri
                const parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
                    vars[key] = value;
                });
                // funkcija play
                function play() {
                    player.play()
                    document.querySelector('.play').style.display = 'none'
                    document.querySelector('.pause').style.display = 'block'
                }
                // funkcija pause
                function pause() {
                    player.pause()
                    document.querySelector('.pause').style.display = 'none'
                    document.querySelector('.play').style.display = 'block'
                }
                // funkcija next
                function next() {
                    if (songCount - 1 > vars.id) {
                        vars.id = Number(vars.id) + 1
                    } else {
                        vars.id = 0
                    }
                    // go to next song
                    window.location = `music.php?category=${vars.category}&id=${vars.id}`
                }
                // funkcija prev
                function prev() {
                    if (vars.id > 0) {
                        vars.id = Number(vars.id) - 1
                    } else {
                        vars.id = songCount - 1
                    }
                    // go to previous song
                    window.location = `music.php?category=${vars.category}&id=${vars.id}`
                }
            </script>
        </div>
    </div>
</body>
</html>