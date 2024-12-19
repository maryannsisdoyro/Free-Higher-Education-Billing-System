<?php
$folderPath = 'backup';

if (is_dir($folderPath)) {
    if ($handle = opendir($folderPath)) {
        while (false !== ($file = readdir($handle))) {
            if ($file !== "." && $file !== "..") {
                echo $file . "<br>";
            }
        }
        closedir($handle);
    }
}
?>
