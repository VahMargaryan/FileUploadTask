<?php
    if ( isset($_POST['oldname']))
    {
        $rename = $_POST['newname'];
        $oldname = $_POST['oldname'];
        $remove[]= " ";
        $remove[]= "$";
        $remove[] = "%";
        $remove[] = '/';
        $remove[] = "|";
        $remove[] = "\\";
        $remove[] = '*';
        $remove[] = '<';
        $remove[] = '>';
        $sanitize = str_replace($remove, "", $rename);

    if ($sanitize === "" || $oldname === "" || empty($oldname) || empty($sanitize))
        {
            echo " Empty Fields";
        }
    else
        {

            $explode = explode(".", $oldname);
            $ext = end($explode);
            if (isset($_POST['folder']))
            {
                $dir = $_POST['folder'];
            }
            else
            {
                $dir = $_GET['folder'];
            }
            if (is_dir($dir.$oldname))
            {
                rename($dir . $oldname ,  $dir . $sanitize );
                echo $sanitize ;
            }
            else
            {
                rename($dir . $oldname ,  $dir . $sanitize . "." . $ext);
                echo $sanitize . "." . $ext;
            }
        }
    }


