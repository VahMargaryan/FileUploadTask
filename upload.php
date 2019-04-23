<?php
require "config.php";
if (isset($_FILES['file'])) {

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    if (isset($_POST['folder'])) {
        $folderLoc = $_POST['folder'];
    }
    else {
        $folderLoc = $_GET['folder'];
    }
    preg_match_all('/[A-Za-z0-1]*\.[a-zA-Z0-1]*/', $fileName, $inMatch);
    $ext = end($inMatch);
    $deleted = array_pop($inMatch);
    array_pop($deleted);
    $imploder = implode($deleted);
    $endExt = end($ext);
    $i = 0;
    if (count($deleted) <= 1) {
        $exp = explode(".", $fileName);
        $end = end($exp);
        while (file_exists($folderLoc . $fileName)) {
            $i++;
            $fileName = reset($exp) . "_" . $i . "." . $end;
        }
        $name = $fileName;
        $result = move_uploaded_file($fileTmpName, $folderLoc . "/" . $name);
    }
    else {
        while (file_exists($folderLoc . $fileName)) {
            $i++;
            $fileName = $imploder . "_" . $i . $endExt;
        }
        $name = $fileName;
        $result = move_uploaded_file($fileTmpName, $folderLoc . "/" . $name);
    }
}
else {
    echo '<script>alert("Please choose file")</script>'  ;
}
    include "cont.php";
