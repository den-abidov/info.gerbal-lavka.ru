<?php
    $fileUrl="status.txt";//Имя файла. Находится в той же директории, что и этот php-скрипт.
    $status=$_REQUEST["status"];
    $myfile = fopen($fileUrl, "w") or die("Unable to open file!");    
    fwrite($myfile, $status);    
    fclose($myfile);
    echo "Успешно записал ".$status." в файл ".$fileUrl;
?>