<?php

  ini_set('display_errors',1);

  //подключение файла с функцией отправки SMS
  include 'sendSMS.php';

  //получи номер телефона с формы
  $userPhone=$_REQUEST['userPhone'];

  //сообщение в СМСку
  $SMStext="herbal-boutique.ru\nперезвони на\n".$userPhone;

  //вызов функции отправки СМС и перехват её echo ответа в переменную
  $server_return="";
  ob_start();
    echo sendSMS("api.smsfeedback.ru", 80, "sales-2010", "helloworld", "79539233275", $SMStext, "herbal");
    $server_return = ob_get_contents();
  ob_end_clean();

  //выведи сообщение в зависимости от ответа

  if(contains("accepted",$server_return))//ответ содержит 'accepted;A..' если СМС успешно отправлено на указанный номер
  {
    echo '<span style="color:#669932;">Отлично! Ожидайте нашего звонка.</span>';
  }
  elseif(contains("invalid",$server_return))//ответ содержит 'invalid mobile phone' если указан неверный номер
  {
    echo '<span style="color:red;">По какой-то причине не удалось передать заявку на обратный звонок. Пожалуйста обратитесь к консультанту в чате.</span>';
  }
  else //если ни одна из вышеперечисленных ошибок
  {
    echo '<span style="color:red;">По какой-то причине не удалось передать заявку на обратный звонок. Пожалуйста обратитесь к консультанту в чате.</span>';
  }

  //метод-утилита. Ищет substring в string'е.
  //если находит, возвращает 'true'
  function contains($needle, $haystack)
  {
      return strpos($haystack, $needle) !== false;
  }


?>
