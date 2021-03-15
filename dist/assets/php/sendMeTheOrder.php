<?php

  /**
   * Отправка писем гибридным способом :
   * себе - с помощью PHP-функции mail(), а пользователю - с помощью PHPMailer.
   * Возвращает 'success', если успешно отправляет письмо о новой заявке.
   * Отправка через mail() - более быстрый способ, но полученное письмо опознаётся как из ненадежного источника,
   * Отправка с помощью PHPMailer - более медленный метод, т.к. письма отправляются через сервис Яндекса, зато
   * такие письма опознаются почтовыми сервисами как из надёжного источника.
   */
 
  // параметры
  $myPhone="79539233275";   // куда отправлять СМС
  $message="корзина пуста"; // описание заказа
  $userEmail = "";          // эл.почта пользователя. Копию письма отправить и ему.
  $userEmailGiven = false;
  
  // получи значения из URL : 
  if(!empty($_REQUEST['message']))
  {
    $message=$_REQUEST['message'];    
  }
  if(!empty($_REQUEST['userEmail']))
  {
    $userEmail=$_REQUEST['userEmail'];
    if(strlen($userEmail)>3)
    {
      $userEmailGiven = true;
    }
  }
   
  // текст письма
  $htmlContent = '<div style="font-family: Roboto, Helvetica, Verdana, Sans-Serif;">'.$message.'</div>';

  // Часть 1. Отправь письмо себе

  // использую PHPMailer : https://github.com/PHPMailer/PHPMailer
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require 'phpmailer/Exception.php';
  require 'phpmailer/PHPMailer.php';
  require 'phpmailer/SMTP.php';

  $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
  $mail->CharSet = "utf-8";    
  try 
  {
    //Server settings
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.yandex.ru';                       // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'herbal.me@yandex.ru';              // SMTP username
    $mail->Password = 'helloworld';                       // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to, по умолчанию 587. Для Яндекса рекомендуют 465.
        
    //Recipients
    $mail->setFrom('herbal.me@yandex.ru','herbal-boutique.ru');
    $mail->addAddress('herbal.me@yandex.ru');             // Add a recipient
    $mail->addReplyTo('herbal.me@yandex.ru','herbal-boutique.ru');    
    
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'новый заказ';
    $mail->Body    = $htmlContent;
    $mail->AltBody = $htmlContent;

    $mail->send();
    //echo 'Письмо отправлено.';
    echo 'success';//для обработки JS-кодом
  } catch (Exception $e) 
  {
    //echo 'Не получилось отправить письмо. Ошибка : ', $mail->ErrorInfo;
    echo 'fail';//для обработки JS-кодом
  }
  /* Раньше использовал этот код, но 2019.06.10 он перестал работать :
  $to = "herbal.me@yandex.ru";
  $subject = "новый заказ";
  $headers = "MIME-Version: 1.0"."\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
  $headers .= "From: herbal-boutique.ru<herbal.me@yandex.ru>"."\r\n";
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
  
  if($mail)
  {
    echo 'success';
  }
  else
  {
    echo 'fail';
  }*/

  //Часть 2. Теперь отправь СМС, что поступил новый заказ

  ini_set('display_errors',1);

  //подключение файла с функцией отправки SMS
  include 'sendSMS.php';
 
  $SMStext="herbal-boutique.ru:\nновый заказ\nпроверь почту";

  //вызов функции отправки СМС и перехват её echo ответа в переменную
  $server_return="";
  ob_start();
    echo sendSMS("api.smsfeedback.ru", 80, "sales-2010", "helloworld", $myPhone, $SMStext, "herbal");
    $server_return = ob_get_contents();
  ob_end_clean();

  //выведи сообщение в зависимости от ответа
  $server_response="";
  if(contains("accepted",$server_return))//ответ содержит 'accepted;A..' если СМС успешно отправлено на указанный номер
  {
    //отрапортуй в форму
    //$server_response='<span style="color:green;">Данные о Вашем заказе переданы. Мы скоро с Вами свяжемся, чтобы подтвердить заказ и уточнить его детали.</span>';
    $server_response="success";
  }
  elseif(contains("invalid",$server_return))//ответ содержит 'invalid mobile phone' если указан неверный номер
  {
    //отрапортуй в форму
    //$server_response='<span style="color:green;">Спасибо! Данные о Вашем заказе переданы. Если Вам не перезвонят в ближайшие 2 часа, пожалуйста свяжитесь с нами по контактам на сайте.</span>';
    $server_response="failure";
  }
  else //если ни одна из вышеперечисленных ошибок
  {
    //отрапортуй в форму
    //$server_response='<span style="color:green;">Спасибо! Данные о Вашем заказе переданы. Если Вам не перезвонят в ближайшие 2 часа, пожалуйста свяжитесь с нами по контактам на сайте.</span>';
    $server_response="unknown";
  }

  // Как и писал в "шапке", echo использую только один раз : чтобы отрапортовать успешную отправку заявки
  // echo $server_response;

  
  // Часть 3. Отправь письмо пользователю, ЕСЛИ задана его эл.почта.

  /* использую PHPMailer : https://github.com/PHPMailer/PHPMailer
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require 'phpmailer/Exception.php';
  require 'phpmailer/PHPMailer.php';
  require 'phpmailer/SMTP.php';*/
  
  if($userEmailGiven == true)
  {
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    $mail->CharSet = "utf-8";    
    try {
        //Server settings
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.yandex.ru';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'herbal.me@yandex.ru';              // SMTP username
        $mail->Password = 'helloworld';                       // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to, по умолчанию 587. Для Яндекса рекомендуют 465.
        
        //Recipients
        $mail->setFrom('herbal.me@yandex.ru','продукция Гербалайф');
        $mail->addAddress($userEmail);                        // Add a recipient
        $mail->addReplyTo('herbal.me@yandex.ru','продукция Гербалайф');    
    
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Ваш заказ Гербалайф';
        $mail->Body    = $htmlContent;
        $mail->AltBody = $htmlContent;

        $mail->send();
        //echo 'Письмо отправлено.';
        //echo 'success';//для обработки JS-кодом
    } catch (Exception $e) 
    {
        //echo 'Не получилось отправить письмо. Ошибка : ', $mail->ErrorInfo;
        //echo 'fail';//для обработки JS-кодом
    } 
  }
  
  // метод-утилита. Ищет substring в string'е.
  // если находит, возвращает 'true'
  function contains($needle, $haystack)
  {
    return strpos($haystack, $needle) !== false;
  }
?>
