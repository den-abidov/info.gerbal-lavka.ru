<?php

  // 1 Определи ip посетителя
  $ip = $_SERVER['REMOTE_ADDR'];
  
  // 2 Узнай местоположение по ip
  include 'getAddressFromIP.php';
  $ipPlace=getAddressFromIP($ip);

  // 3 Сохрани полученные данные в виде объекта JSON
  $outputJSON;//вывод в виде объекта JSON
  $outputJSON = array(
      "ip"  =>  $ip,
      "ipPlace" => $ipPlace
  );

  // 4 Верни результат в виде объекта JSON
  echo json_encode($outputJSON, JSON_PRETTY_PRINT);  

?>
