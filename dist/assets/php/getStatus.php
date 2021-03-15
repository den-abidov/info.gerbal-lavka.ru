<?php
    $fileUrl="status.txt";//Имя файла. Находится в той же директории, что и этот php-скрипт.
    $myfile = fopen($fileUrl, "r") or die("Unable to open file!");
    echo fgets($myfile);
    fclose($myfile);
?>