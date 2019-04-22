<?php
if (($_POST['path'])) {
    function delete_files($target) {
        if (is_dir($target . '/')) {
            $files = glob( $target . '/' . '*', GLOB_MARK );
            foreach ($files as $file ) {
                delete_files( $file );
            }
            rmdir( $target . '/' );
        }
        elseif (is_file($target)) {
            unlink( $target );
        }
    }
    $path = $_POST['path'];
    delete_files($path);
    include "cont.php";
}
?>
