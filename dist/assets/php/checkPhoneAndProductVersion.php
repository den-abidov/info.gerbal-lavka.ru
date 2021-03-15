<?php

//получи входные данные
$userPhone=$_REQUEST["userPhone"];
$sql="SELECT `person`.*, `product-version`.version FROM `person`, `product-version` WHERE phone='".$userPhone."';";

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

//вывод в виде объекта JSON
//заполни значениями по умолчанию
$outputJSON=array(
  "id"  =>  "-1",
  "name" => "",
  "phone" => "",
  "priceModel" => "",
  "isValid"=>"false",  //есть доступ у этого пользователя ?
  "productVersion" => "" //версия прайслиста
);

//обработай запрос
$result = $conn->query($sql);    
if ($result->num_rows > 0) 
{  
  // output data of each row
  while($row = $result->fetch_assoc()) 
  {
    $id=$row["id"];
    $name=$row["name"];
    $phone=$row["phone"];
    $priceModel=$row["priceModel"];
    $productVersion=$row["version"];
  
    $outputJSON=array(
      "id"  =>  $id,
      "name" => $name,
      "phone" => $phone,
      "priceModel" => $priceModel,
      "isValid"=> "true",
      "productVersion" => $productVersion
    );   
  } 
}

//отсоединись от БД
$conn->close();

//echo $output;
echo json_encode($outputJSON, JSON_PRETTY_PRINT);

?>
