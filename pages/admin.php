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
    <div class="container">
        <div class="header">
            <a href="/seminar">< BACK</a>
            <h1 class="admin-title">Admin</h1>
        </div>
        <div class="main">
            <div class="upload">
                <h3>UPLOAD FILE</h3>
                <!-- NALAGANJE GLASBE -->
                <form method="POST" enctype="multipart/form-data">
                    <select name="category" required>
                        <?php
                            // direktoriji v client direktoriju
                            $dirs = array_filter(glob('../client/*'), 'is_dir');
                                
                            // izpisemo na ekranu vse direktorije
                            for ($i = 0; $i < count($dirs); $i++) {
                                if (is_dir('../client/' . substr($dirs[$i], strrpos($dirs[$i], '/') + 1) . '/music')) {
                                    // ce obstaja direktorij 'music'
                                    echo '<option value="' . substr($dirs[$i], strrpos($dirs[$i], '/') + 1) . '">' . substr($dirs[$i], strrpos($dirs[$i], '/') + 1) . '</option>';
                                }
                            }
                        ?>
                    </select>
                    <input type="file" name="music" required />
                    <input type="submit"/>
                </form>
                <?php
                    // upload info
                    if(isset($_FILES['music'])){
                        $errors= array();
                        $file_name = $_FILES['music']['name'];
                        $file_size = $_FILES['music']['size'];
                        $file_tmp = $_FILES['music']['tmp_name'];
                        $file_ext=strtolower(end(explode('.', $_FILES['music']['name'])));
                        
                        // dovoljeni formati
                        $extensions= array("mp3", "ogg", "wav");
                        
                        // ce je uploadan format ki ni dovoljen
                        if(in_array($file_ext, $extensions) === false){
                            $errors[]="Extension not allowed, please choose a mp3, wav or ogg file.";
                        }
                        
                        // ce je uploadan fajl ki je vecji kot 10 MB
                        if($file_size > 10485760) {
                            $errors[]='File size must be less than 10 MB.';
                        }
                        
                        $category = $_POST['category'];
                        
                        if(empty($errors)==true) {
                            // on upload
                            move_uploaded_file($file_tmp, "../client/" . $category . "//music/" . $file_name);
                            echo "File uploaded.";
                        }else{
                            // error
                            print_r($errors);
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>