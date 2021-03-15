<?php

//получи входные данные
$sql=$_REQUEST["sql"]; 

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

//обработай запрос
$result = $conn->query($sql);    
if ($result === TRUE) 
{
  echo "Данные сохранены.";
} 
else 
{
  echo "Ошибка: " . $sql . "<br>" . $conn->error;
}
//отсоединись от БД
$conn->close();

?>
