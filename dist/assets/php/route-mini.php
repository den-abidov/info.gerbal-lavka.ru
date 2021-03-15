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
    // отправь уведомление на почту
    include 'sendVisitorInfo.php';
    sendVisitorInfo($ip);
  }
?>