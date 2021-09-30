<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type='text/css' href="css/style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JUKEBOX</title>
    <link rel="shortcut icon" href="assets/icon.png" />
</head>
<body>
    <div class="home-container">
        <div class="categories">
            <?php
                /*
                 * Avtor: Sanja Malovic
                 * Namen: Program za muziko
                 * Vhodi: Muzika
                 * Izhodi: Muzika
                 * Test: upload mp3 fajla
                 * 
                 */

                // direktoriji v client direktoriju
                $dirs = array_filter(glob('client/*'), 'is_dir');
                
                // izpisemo na ekranu vse direktorije
                for ($i = 0; $i < count($dirs); $i++) {
                    if (is_dir('client/' . substr($dirs[$i], strrpos($dirs[$i], '/') + 1) . '/music')) {
                        // ce obstaja direktorij 'music'
                        $categoryName = substr($dirs[$i], strrpos($dirs[$i], '/') + 1);
                        $firstWord = strtok($categoryName, ' ');
                        echo "<a href='pages/music.php?category=" . substr($dirs[$i], strrpos($dirs[$i], '/') + 1) . "&id=0' style='background-image: url(assets/covers/" . $firstWord . ".jpg)' class='category'>" . substr($dirs[$i], strrpos($dirs[$i], '/') + 1) . "</a>";
                    } else if (substr($dirs[$i], strrpos($dirs[$i], '/') + 1) == 'Admin') {
                        // ce je admin
                        echo '<a style="background-image: url(assets/covers/admin.jpg)" href="pages/admin.php">Admin</a>';
                    }
                }
            ?>
        </div>
        <div class="quotes">
            <p>
                <?php
                    // narekovaji
                    $quotes = array();
                    $handle = fopen("assets/quotes.txt", "r");
                    if ($handle) {
                        while (($line = fgets($handle)) !== false) {
                            array_push($quotes,$line);
                        }
                        fclose($handle);
                    } else {
                        // ce ni narekovajev
                        echo 'No quotes available.';
                    }
                    // nakljucno stevilo za nakljucne narekovaje
                    $ranNumb = rand(0, count($quotes) - 1);
                    // izpisemo narekovaj
                    echo $quotes[$ranNumb];
                ?>
            </p>
        </div>
    </div>
</body>
</html>