<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Domine" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
</head>

<body>
<?php
    if (isset($_POST['folder'])) {
        $dirname = $_POST['folder'];
    }
    else {
        $dirname = $_GET['folder'];
    }
function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    }
    elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    }
    else {
        $bytes = '0 bytes';
    }
    return $bytes;
}

$GLOBALS['limit'] = 5;
@$GLOBALS['page'] = (int)$_GET['page']?:0;
$GLOBALS['skip'] = $GLOBALS['limit'] * $GLOBALS['page'];
    if ($handle = opendir($dirname)) {
        $blacklist = array('.', '..', 'uploads', 'index.php','resize.php','upload.php','delete.php');
        $GLOBALS['skipped']  = 0;
    ?>
<div class="container">
    <div class="row">
        <table class="table">
            <thead>
               <tr>
                    <th>
                        <?php
                        if (@$_GET['type'] == "asc"){
                            $typing = "desc";
                        }
                        else {
                            $typing = "asc";
                        }
                        ?>
                        <a href="?folder=<?php echo @$_GET['folder'].'&page='.@$_GET['page'].'&sort=name&type='.$typing;?>">File Name</a>
                    </th>
                   <th>
                       <a href="?folder=<?php echo @$_GET['folder'].'&page='.@$_GET['page'].'&sort=type&type='.$typing;?>">File Type</a>
                   </th>
                    <th>
                        <a href="?folder=<?php echo @$_GET['folder'].'&page='.@$_GET['page'].'&sort=size&type='.$typing;?>">File Size</a>
                    </th>
                    <th>
                        <a href="?folder=<?php echo @$_GET['folder'].'&page='.@$_GET['page'].'&sort=date&type='.$typing;?>">File Upload Data</a>
                    </th>
                    <th>
                        Delete
                    </th>
               </tr>
            </thead>
        <tbody>
<?php
    while (false !== ($file = readdir($handle))) {
        if (!in_array($file, $blacklist)) {
            $GLOBALS['skipped']++;
            $explode = explode(".", $dirname. $file);
            $fileX =  end($explode);
            $size = filesize($dirname . "/" . $file);
            $fileTime= filemtime($dirname. "/" . $file);
            $files[] = array($file , $fileX , $size , $fileTime) ;
        }
    }

function is_dir_empty($dir) {
    if (!is_readable($dir)) return NULL;
    return (count(scandir($dir)) == 2);
}

if (is_dir_empty("compressed/")) {
    echo "";
}else{
    include "sortFunction.php";
}




$arrlen = @count($files);
if ($arrlen > $GLOBALS['limit']) {
    $length = $GLOBALS['page'] + $GLOBALS['limit'];
    $offset = $GLOBALS['page'] - $GLOBALS['limit'];
    $files = array_slice($files,$GLOBALS['skip'],$length,true);
}
    ?>
<?php if (!empty($files)): ?>
            <?php foreach($files as $data) : ?>
            <tr class="active" >
                <td class="focus">
                    <form onsubmit="form_rename(this,event)" enctype="multipart/form-data" class="form-rename">
                        <input class="myinput" autocomplete="off" onfocus="this.value = ''" name="rename" type="text"
                               value="<?= $data[0]?>"/>
                        <input style="width: 250px" type="hidden" class="hide" name="oldname" autocomplete="off"
                               value="<?php echo $data[0] ?>"/>
                        <button type="submit" style=" float:right ; font-family: 'ZCOOL XiaoWei', serif;" id="rename" name="submit">Rename</button>
                    </form>
                </td>
                <td>
                    <?php
                    if (is_dir($data[1])) {
                        echo "DIRECTORY"; ?>
                        <a href="<?php echo PATH . "?folder=". $data[1] . '/'."&page=0" ?>" class="direct"> View </a><?php
                    }
                    else {
                        echo $data[1];
                    }
                    ?>
                </td>
                <td>
                    <?php echo formatSizeUnits($data[2])?>
                </td>
                <td>
                    <p style="font-family: 'ZCOOL XiaoWei', serif;" class="card-text">
                    <?php echo $date = date("F d Y H:i:s.", $data[3]); ?>
                </td>
                <td>
                    <a onclick="remove(this,event)" id="delete" href="delete.php?path=<?php echo $data[0] ?>" class="btn btn-primary">Delete</a>
                </td>
            </tr>
<?php
                 endforeach;
?>
            </tbody>
        </table>
        <?php endif;?>
    </div>
</div>
<?php
}

$pages = (int)$GLOBALS['skipped'] / $GLOBALS['limit'];
    if ($GLOBALS['skip'] % $GLOBALS['limit']) {
        $pages ++;
    }
    $counter = 0;
    for ($i = 0; $i < $pages; $i++) {
        $class = '';
        $counter++;
    if ($GLOBALS['page'] == $i) {
        $class = 'class="active"';
    }
    ?>
    <ul class = "pagination shadow-sm">
        <li class = "page-item">
            <a class = "page-link" href = "?folder=<?= @$_GET['folder'];?>&sort=name&type=asc&page=<?= $i ?>" <?= $class ?>><?= $counter ?></a>
        </li>
    </ul>
</body>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</html>
    <?php
}
