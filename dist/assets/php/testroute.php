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
      
    $me = ($ip=="109.227.196.184")||($ip=="212.188.11.146"); // я?
    
    echo "<p>текущий ip : {$ip}</p>";
    echo "<p>Это не бот.</p>";

    if(!$me) // не я
    {
      echo "<p>И не я.</p>";
      
      //Проверь настройки в config.json на необходимость фильтрации
      $fileUrl="config.json";//Имя файла. Находится в той же директории, что и этот php-скрипт.
      $str = file_get_contents($fileUrl);//считай файл и всё его содержимое передай в строку
      $obj = json_decode($str);

      //Считает значения в виде строковых true или false.
      //Внимание! Для PHP это всё ещё не булевые, а просто строковые значения.
      $siteIsOn = $obj->{'siteIsOn'};
      $filterIp = $obj->{'filterIp'};
      $mobileOnly = $obj->{'mobileOnly'};
      
      //преобразуем строковые true / false => булевые true(1) / false() 
      $siteIsOn = formatToBool($siteIsOn);
      $filterIp = formatToBool($filterIp);
      $mobileOnly = formatToBool($mobileOnly);
            
      //чтобы увидеть булевые 1 и () при выводе, можно их явно преобразовать в true и false :
      //$res = $res ? 'true' : 'false';

      echo "<p>Проверка условий.</p>";

      $ban1 = !$siteIsOn;//сайт закрыт ?
      if($ban1)
      {
        echo "<p>ban1 : {$ban1}</p>";
        echo "<p>Сайт закрыт. Перенаправлю на 404.</p>";
        exit();
        //redirect404();
      }
      
      // Определи тип браузера
      // Источник : http://mobiledetect.net/      
      require_once 'Mobile_Detect.php';
      $detect = new Mobile_Detect;

      $isLargeDevice = !$detect->isMobile();
      $ban2 = $mobileOnly && $isLargeDevice;   
      
      if($ban2)
      {
        echo "<p>ban2 : {$ban2}</p>";
        echo "<p>Разрешено только на телефонах, а ты на компьютере. Перенаправлю на 404.</p>";
        exit();
        //redirect404();
      }

      // фильтрация по ip локации
      // подключи зависимости
      include 'getCityFromIP.php';

      // определи город посетителя
      $city=getCityFromIP($ip);      
      
      $isBannedCity = ($city=="Москва" || $city=="Томск" || $city=="не Россия");
      
      $ban3 = $filterIp && $isBannedCity;
      
      if($ban3)
      {
        echo "<p>ban3 : {$ban3}</p>";
        echo "<p>местоположение ip : {$city}</p>"; 
        echo "<p>Запрет на Москву/Томск/не Россию. Перенаправлю на 404.</p>";
        exit();
        //redirect404();
      }
      echo "<p>Хоть и не ты, запреты не сработали. Доступ разрешен.</p>";      
    }
    else
    {
      //ничего не делай
      echo "<p>Это ведь я. Мне всё разрешено.</p>";
      exit();
    }    
  }

  function redirect404()
  {
    // редирект на PHP
    header("Location: 404.html", true, 200);
    // на всякий случай - редирект и на Javascript
    echo "<script>window.location.href = '404.html';</script>";
    // справка : what status code is what : https://www.rapidtables.com/web/dev/url-redirect.html
    exit();
  }

  function formatToBool($s)
  {
    $result;

    if(strtoupper($s)=="TRUE")
    {
      $result = true;
    }
    if(strtoupper($s)=="FALSE")
    {
      $result = false;
    }
    return $result;
  }
?>
