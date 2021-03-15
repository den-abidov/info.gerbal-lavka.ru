<?php

//получи входные данные
$id=$_REQUEST["id"];

$sql="SELECT `person`.bonusAction FROM `person` WHERE id=".$id.";";

include 'dbConnectionSettings.php';//параметры доступа к БД
  
//коннект к БД
$conn = new mysqli($host,$user,$password,$database);

//кодировка
$conn->set_charset("utf8");


//проверка коннекта
if ($conn->connect_error)
{
  die("No connection with database : ".$conn->connect_error);
}

$output="";//по умолчанию
//обработай запрос
$result = $conn->query($sql);    
if ($result->num_rows > 0) 
{  
  // output data of each row
  while($row = $result->fetch_assoc()) 
  {
    $output=$row["bonusAction"];    
  } 
}

//отсоединись от БД
$conn->close();

echo $output;

?>
