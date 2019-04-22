<?php
$string = $_SERVER["REQUEST_URI"];
$plorp = substr(strrchr($string,'/'), 1);
$string = substr($string, 0, - strlen($plorp));
define("URL", $string);
    if (!isset($_GET['folder']) || $_GET['folder']==="/" || $_GET['folder']==="\\" || $_GET['folder']==="compressed" ||
        !isset($_GET['page']) || $_GET['page']==="/" || $_GET['page']==="\\" || $_GET['page']==="") {
        header('location: ' . URL .'/?page=0&sort=name&type=desc&folder=compressed/');
    }

    if (!is_dir("compressed")) {
        mkdir("compressed");
    }

function endsWith($haystack, $needle) {
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }
    return (substr($haystack, -$length) === $needle);
}
if (isset($_GET['folder'])) {
    if (!endsWith($_GET['folder'], "/")) {
        $boom = explode("/", $_GET['folder']);
        $newurl = end($boom);
        header('location: ' . URL .$newurl.'/');
    }
}
if (isset($_GET['folder'])) {
    if (!is_dir($_GET['folder'])) {
        header('location: /?folder=compressed/');
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/ico" href="images/favicon.png" />
    <title>Upload File Form</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="http://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body>
    <div class="container">
        <div class="row mx-0">
            <form id="form" action = "upload.php" method="POST" enctype="multipart/form-data">
                <input id="file" type="file" name="file">
                <input type="hidden" name="path" value="<?php echo $_GET['folder']; ?>"/>
                <button type="submit" name="submit" class="upload"><i class="fas fa-cloud-upload-alt"></i></button>
            </form>
            <form id="form" method="POST" action="action.php">
            <button type="button" name="create_folder" id="create_folder" data-toggle="modal" data-target="#folderModal" class="upload"><i class="fas fa-folder-open"></i></button>
                <div id="folderModal" class="modal fade" role="dialog" aria-labelledby="folderModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" style="right: 660px;">
                            <div class="modal-header" style="float: left">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body">
                                <p>Enter Folder Name
                                    <input type="text" name="folder_name" autocomplete="off" id="folder_name" class="form-control"/>
                                </p><br/>
                                <input type="hidden" name="action"  id="action"/>
                                <input type="hidden" name="old_name" id="old_name"/>
                                <input type="hidden" name="path" value="<?php echo $_GET['folder']; ?>"/>
                                <input type="submit" name="folder_button" id="folder_button" class="btn btn-info" value="Create"/>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="back">
        <?php
        if ($_GET['folder'] != 'compressed/') {
            $folder = $_GET['folder'];
            $exp = explode("/", $folder);
            $arr = [];
            foreach ($exp as $piece => $val) {
                $val = trim($val);
                if (!empty($val)) {
                    $arr[] = $val;
                }
            }
            $slice = array_slice($arr, 0, -1);
            $strImplode = implode("/", $slice);
            echo ' <a class="backbtn" href="?page=0&folder='.$strImplode.'/"> <i class="fas fa-arrow-left" style=""></i>
            </a>';
        }
        ?>
    </div>
        <div class="cont">
            <?php include "cont.php"?>
        </div>
    </body>
</html>




