<?php

// значения по умолчанию
$to = "herbal-zakaz.ru@yandex.ru";
$fromName = "хз";
$fromEmail = "herbal-zakaz.ru@yandex.ru";
$subject = "хз";
$message = "хз";

// получи новые значения из URL-запроса
$to = $_REQUEST['to'];;
$fromName = $_REQUEST['fromName'];;
$fromEmail = $_REQUEST['fromEmail'];;
$subject = $_REQUEST['subject'];;
$message = $_REQUEST['message'];;

// собери письмо
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From:".$fromName."<".$fromEmail.">" . "\r\n";
$htmlContent = "
<html>
<head>
  <meta charset='utf-8'>
</head>
<body style='font-family: Roboto, Helvetica, Verdana, Sans-Serif;'>
    ".$message."
</body>
</html>";

$mail=mail($to,$subject,$htmlContent,$headers);//возвращает 1 или true(письмо отправлено) или false(письмо не отправлено). Но обрабатывать не будем.

?>