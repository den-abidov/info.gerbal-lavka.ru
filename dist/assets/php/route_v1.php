<?php

  // 1 Определи ip посетителя
  $ip = $_SERVER['REMOTE_ADDR'];
  
  // 2 Проверка : это бот или нет
  include 'isBotIP.php';

  $isBot = isBotIP($ip);
  
  if($isBot)
  {
    // это бот
    // ничего не делай
    // можно добавить show-for-medium
    
    // или отправить уведомление на почту
    include 'sendBotInfo.php';
    sendBotInfo($ip);   
  }
  else
  {
    // это не бот

    //Проверь настройки в config.json на необходимость фильтрации
    $fileUrl="assets/php/config.json";//Имя файла. Находится в той же директории, что и этот php-скрипт.
    $str = file_get_contents($fileUrl);//считай файл и всё его содержимое передай в строку
    $obj = json_decode($str);
    $filterIp=$obj->{'filterIp'};

    if($filterIp=="true")
    {
      // фильтрация по ip ВКЛ
      
      // подключи зависимости
      include 'getCityFromIP.php';
    
      // определи город посетителя
      $city=getCityFromIP($ip);
    
      // Определи тип браузера
      // Источник : http://mobiledetect.net/
      require_once 'Mobile_Detect.php';
      $detect = new Mobile_Detect;
      /**
       * Объяснение условия : ip запрещён, если выполняются 
       * 1. посетитель из Москвы / Томска / не России
       * 2. ip =/= моему ip 1 
       * 3. ip =/= моему ip 2
       * 4. не с телефона, т.е. с планшета или с компьютера
       */
      if(($city=="Москва" || $city=="Томск" || $city=="не Россия")&&($ip!="109.227.196.184")&&($ip!="212.188.11.146")&&(!$detect->isMobile()))    
      {
        // ip запрещён
	      // если этот нативный php-код не сработает
	      header("Location: 404.html", true, 200);  
	      // сделай редирект через Javascript !   
	      echo "<script>window.location.href = '404.html';</script>";  
        // What Status Code Is What : https://www.rapidtables.com/web/dev/url-redirect.html
        exit();
      }
      else
      {
        // ip разрешён
      }
    }
    else
    {
      // фильтрация по ip ОТКЛ
    }

  }
?>
