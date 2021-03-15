<?php
$myFile = "status.json";
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = $_GET["data"];
fwrite($fh, $stringData);
fclose($fh);
echo "Новое значение записано в файл status.json на сервере.";
?>
