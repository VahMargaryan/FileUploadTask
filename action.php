<?php
require "config.php";
if (isset($_POST['folder_button'])) {
    if (!file_exists($_POST["folder_name"])) {
        mkdir($_POST['path']."/".$_POST["folder_name"]);
        echo "folder created";
        header("location:".PATH."/?page=0&sort=name&type=desc&folder=".$_POST['path']);
        if ($_POST["folder_name"] === "") {
            return false;
        }
    }
}