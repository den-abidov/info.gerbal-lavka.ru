<?php

$sql="SELECT * FROM `product_hb`;";

include 'dbConnectionSettings.php';//параметры доступа к БД
  
//коннект к БД
$conn = new mysqli($host,$user,$password,$database);
//кодировка
$conn->set_charset("utf8");

$output;//полностью сформированный ответ скрипта, массив объектов JSON

//проверка коннекта
if ($conn->connect_error)
{
  die("No connection with database : ".$conn->connect_error);
}

//fill in the JSON obj array with defaults
$output[0]=array(
  "id" => "",
  "category" => "",
  "name" => "",  
  "visible" => "true",
  "price100" => "",
  "priceMinus25" => "",
  "priceMinus35" => "",
  //"priceMinus42" => "",      
  "priceMin" => "",
  "fileName" => "",
  //это искуственно добавленные переменные, которых нет в БД,
  //но которые должны присутствовать в JSON-объекте и будут использованы
  //в JS-коде для подсчёта состава и стоимости корзины
  "priceDiscounted" => 0,
  "quantity" => 0
);  

//обработай запросы
$result = $conn->query($sql); 
  
if ($result->num_rows > 0) 
{
  $no=0;
  // output data of each row
  while($row = $result->fetch_assoc()) 
  {      
    //fill in the JSON obj array
    $output[$no]=array(
      "id" => $row["id"],
      "category" => $row["category"],
      "name" => $row["name"],
      "visible" => $row["visible"],
      "price100" => $row["price100"],
      "priceMinus25" => $row["priceMinus25"],
      "priceMinus35" => $row["priceMinus35"],
      //"priceMinus42" => $row["priceMinus42"],
      "priceMin" => $row["priceMin"],            
      "fileName" => $row["fileName"],
      //комментарий про 2 следующие переменные см. выше
      "priceDiscounted" => 0,
      "quantity" => 0
    );  
    $no=$no+1; 
  } 
}
 
//2019.07.13 убери первый элемент из массива/таблицы (карту клиента)
//array_shift($output);

//отсоединись от БД
$conn->close();

echo json_encode($output, JSON_PRETTY_PRINT); 

?>
