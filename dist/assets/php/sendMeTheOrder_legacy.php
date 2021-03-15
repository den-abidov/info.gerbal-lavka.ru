<?php
  
  // Отправка писем с помощью PHP-функции mail()
  // Возвращает 'success', если успешно отправляет СМС о новой заявке
  // Это более быстрый метод отправки писем (сервер хостинга сам отправляет письма),
  // но зато опознаётся как ненадежный почтовыми сервисами.

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

  // Часть 1. Отправь письмо себе на почту
  $to = 'herbal.me@yandex.ru';
  $subject = "новый заказ";
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  $headers .= "From: herbal-boutique.ru<herbal.me@yandex.ru>" . "\r\n";
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

  // Часть 2. Отправь письмо покупателю
  if($userEmailGiven == true)
  {
    $to = $userEmail;
    $subject = "Ваш заказ Гербалайф";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: продукция Гербалайф<herbal.me@yandex.ru>" . "\r\n";
    $mail=mail($to,$subject,$htmlContent,$headers);//возвращает 1 или true(письмо отправлено) или false(письмо не отправлено). Но обрабатывать не будем.
  }


  //Часть 3. Теперь отправь СМС, что поступил новый заказ

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

  echo $server_response; // если всё хорошо, вернёт 'success' обратно в page5-proverka.js

  //метод-утилита. Ищет substring в string'е.
  //если находит, возвращает 'true'
  function contains($needle, $haystack)
  {
    return strpos($haystack, $needle) !== false;
  }
?>
