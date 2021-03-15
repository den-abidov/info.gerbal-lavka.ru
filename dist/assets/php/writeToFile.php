<?php
    $fileUrl=$_GET['fileName'];//Имя файла. Находится в той же директории, что и этот php-скрипт.
    $content=$_GET["content"];
    $myfile = fopen($fileUrl, "w") or die("Unable to open file!");    
    fwrite($myfile, $content);    
    fclose($myfile);
    echo "Успешно записал ".$content." в файл ".$fileUrl;
?>