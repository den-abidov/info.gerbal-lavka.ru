<?php

  // Получи параметры из URL :
  $message="";
  if(!empty($_REQUEST['message']))
  {
    $message=$_REQUEST['message'];
  }

  // Использую PHPMailer : https://github.com/PHPMailer/PHPMailer
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require 'phpmailer/Exception.php';
  require 'phpmailer/PHPMailer.php';
  require 'phpmailer/SMTP.php';
  
  // Текст письма
  $htmlContent = '<div style="font-family: Roboto, Helvetica, Verdana, Sans-Serif;">'.$message.'</div>';

  $server_response="";

  // Отправь письмо себе
  $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
  try {
      //Server settings
      $mail->isSMTP();                                      // Set mailer to use SMTP
      $mail->Host = 'smtp.yandex.ru';                       // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'herbal.me@yandex.ru';              // SMTP username
      $mail->Password = 'helloworld';                       // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 465;                                    // TCP port to connect to, по умолчанию было 587

      //Recipients
      $mail->setFrom('herbal.me@yandex.ru', 'herbal-boutique.ru');
      $mail->addAddress('herbal.me@yandex.ru');              // Add a recipient
      $mail->addReplyTo('herbal.me@yandex.ru','herbal-boutique.ru');    
   
      //Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = 'добавлен комментарий';
      $mail->Body    = $htmlContent;
      $mail->AltBody = $htmlContent;

      $mail->send();
      //echo 'Письмо отправлено.';
      //echo 'success';//для обработки JS-кодом
      $server_response = "success";
  }catch(Exception $e){
      //echo 'Не получилось отправить письмо. Ошибка : ', $mail->ErrorInfo;
      //echo 'fail';//для обработки JS-кодом
      $server_response = "fail";
  }
  /*
  if($mail)
  {
    $server_response = "success";
  }*/ 
  echo $server_response;
  
?>
