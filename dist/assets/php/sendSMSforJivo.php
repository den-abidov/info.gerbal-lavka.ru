<?php

  //куда отправлять сообщение
  $myPhone="79539233275";

  ini_set('display_errors',1);

  //подключение файла с функцией отправки SMS
  include 'sendSMS.php';

  $SMStext="herbal-boutique.ru:\nJivoSite\nсрочно проверь";

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
    $server_response="success";
  }
  elseif(contains("invalid",$server_return))//ответ содержит 'invalid mobile phone' если указан неверный номер
  {
    //отрапортуй в форму
    $server_response="failure";
  }
  else //если ни одна из вышеперечисленных ошибок
  {
    //отрапортуй в форму
    $server_response="unknown";
  }

  echo $server_response;
  //метод-утилита. Ищет substring в string'е.
  //если находит, возвращает 'true'
  function contains($needle, $haystack)
  {
    return strpos($haystack, $needle) !== false;
  }
?>
