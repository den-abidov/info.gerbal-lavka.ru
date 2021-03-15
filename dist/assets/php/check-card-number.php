<?php

  // получи номер карты
  $cardNumber = $_REQUEST["cardNumber"];

  $sql="SELECT * FROM `cards` WHERE card_number LIKE '%".$cardNumber."%';";

  //параметры доступа к БД
  include 'dbConnectionSettings.php';

  //коннект к БД
$conn = new mysqli($host,$user,$password,$database);

//кодировка
$conn->set_charset("utf8");


//проверка коннекта
if ($conn->connect_error)
{
  die("No connection with database : ".$conn->connect_error);
}

//вывод в виде объекта JSON
//заполни значениями по умолчанию
$outputJSON=array(
  "found"=>false,
  "valid"=>false
);

//обработай запрос
$result = $conn->query($sql);    
if ($result->num_rows > 0) 
{  
  // output data of each row
  while($row = $result->fetch_assoc()) 
  {
    $valid=$row["valid"]; 
  
    $outputJSON=array(
      "found" => true,
      "valid" => $valid  
    );   
  } 
}

//отсоединись от БД
$conn->close();

//echo $output;
echo json_encode($outputJSON, JSON_PRETTY_PRINT);
?>
