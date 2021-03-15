<?php

  // Отправка писем с помощью PHP-функции mail()
  // Возвращает 'success', если письмо успешно отправлено
  
  //получи комментарий из URL
  $message="";
  if(!empty($_REQUEST['message']))
  {
    $message=$_REQUEST['message'];
  }
    
  //Часть 1. Отправь письмо себе на почту
  $to = "herbal.me@yandex.ru";
  $subject = "добавлен комментарий";
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  $headers .= "From: худеем-комфортно.рф<herbal.me@yandex.ru>" . "\r\n";
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
  
  //выведи сообщение в зависимости от ответа
  $server_response="";

  if($mail)
  {
    $server_response="success";
  }
  else
  {
    $server_response="fail";
  }
  
  echo $server_response;
  
?>
