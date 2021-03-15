<?php

  $ip="";
  
  // 1 Узнай ip
 
  if(isset($_GET['ip']))
  {
    // если задан как параметр в URL
    $ip = $_GET['ip'];
    echo "<p>Из URL получен ip : ".$ip."</p>";
  }
  else
  {
    // если нет, то определи

    include "getIP.php";
    detectBrowser();
    listIPs();
    $ip=getUserIpAddr();

    // по простому, "в лоб"
    // $ip = $_SERVER['REMOTE_ADDR'];
    echo "<p>ip определён как : ".$ip."</p>";
  }
	 
  // 2 Откуда этот ip
  // подключи зависимости
  include 'getCityFromIP.php';
    
  // определи город посетителя
  $city=getCityFromIP($ip);
  echo "<p>Город определён как : ".$city."</p>";
      
  // 3 Проверка : это бот или нет
  include 'isBotIP.php';
  
  $isBot = isBotIP($ip);
  
  if($isBot)
  {
    // это бот
    echo "<p>Это ip Яндекс или Google-бота.</p>";
    // ничего не делай
    // можно добавить show-for-medium
    
    // или отправить уведомление на почту
    include 'sendBotInfo.php';
    sendBotInfo($ip);   
  }
  else
  {
    // это не бот
    echo "<p>Этот ip <u>не</u> относится к Яндекс или Google-боту.</p>";
    //Проверь настройки в config.json на необходимость фильтрации
    $fileUrl="assets/php/config.json";//Имя файла. Находится в той же директории, что и этот php-скрипт.
    $str = file_get_contents($fileUrl);//считай файл и всё его содержимое передай в строку
    $obj = json_decode($str);
    $filterIp=$obj->{'filterIp'};

    echo "<p>Фильтр по ip включён : ".$filterIp."</p>";

    if($filterIp=="true")    
    {
      // фильтрация по ip ВКЛ
      echo "<p>Фильтр по ip ВКЛючён.</p>";
      // подключи зависимости
      include 'getCityFromIP.php';
    
      // определи город посетителя
      $city=getCityFromIP($ip);
    
      if(($city=="Москва" || $city=="Томск" || $city=="не Россия")&&($ip!="109.227.196.184"))    
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
        echo "<p>Этот ip разрешён.</p>";
      }
    }
    else
    {
      // фильтрация по ip ОТКЛ
      echo "<p>Фильтр по ip ОТКЛючён.</p>";
    }
  }

?>
