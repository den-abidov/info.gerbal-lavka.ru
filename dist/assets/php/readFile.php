<?php
    $fileUrl=$_GET['fileName'];
    //$fileUrl="promo.json";//Имя файла. Находится в той же директории, что и этот php-скрипт.
    $str = file_get_contents($fileUrl);//считай файл и всё его содержимое передай в строку
    echo $str;
?>