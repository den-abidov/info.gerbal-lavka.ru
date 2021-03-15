<?php

function getAddressFromIP($ip)
{

  $query="https://suggestions.dadata.ru/suggestions/api/4_1/rs/detectAddressByIp?ip=".$ip;

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $query);

    //curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
    //curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

  $headers = array();
  $headers[] = "Accept: application/json";
  $headers[] = "Authorization: Token 717fec7c4e5cbb81a35820d2e060095fd8b918f3";//мой токен с dadata.ru
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $result = curl_exec($ch);//результат = объект JSON. Содержит много свойств/полей, но нам нужно только одно свойство 'city'
  if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
  }
  curl_close ($ch);

  //$result в формате JSON
  $arr = json_decode($result, true);//конвертация JSON => array
  
  $country=$arr['location']['data']['country'];
  $region=$arr['location']['data']['region_with_type'];
  $city=$arr['location']['data']['city_with_type'];

  $address=$country.", ".$region.", ".$city;
  return $address;
}
?>