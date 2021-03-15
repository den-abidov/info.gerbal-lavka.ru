<?php

//определение ip посетителя
//источник : https://www.codexworld.com/how-to/get-user-ip-address-php/

function getUserIpAddr()
{
  if(!empty($_SERVER['HTTP_CLIENT_IP']))
  {
    //ip from share internet
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  }
  elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
  {
    //ip pass from proxy
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
  else
  {
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}
//добавил 2018.08.05
function getHttpClientIp()
{
    $ip="нет значения";
    if(!empty($_SERVER['HTTP_CLIENT_IP']))
    {
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    else
    {
        $ip="нет значения";
    }
    return $ip;
}

function getHttpForwardedFor()
{
    $ip="нет значения";
    if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
        //ip from share internet
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip="нет значения";
    }
    return $ip;
}

function getRemoteAddr()
{
    $ip="нет значения";
    if(!empty($_SERVER['REMOTE_ADDR']))
    {
        //ip from share internet
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    else
    {
        $ip="нет значения";
    }
    return $ip;
}

function listIPs()
{
    $ip1=getHttpClientIp();
    $ip2=getHttpForwardedFor();
    $ip3=getRemoteAddr();
    echo "<p>getIP.php / <u>listIPs()</u> :</p>";
    echo "<p>HTTP_CLIENT_IP : ".$ip1."</p>";
    echo "<p>HTTP_X_FORWARDED_FOR : ".$ip2."</p>";
    echo "<p>REMOTE_ADDR : ".$ip3."</p>";
    echo "<br/>";
}

function detectBrowser()
{
    // Источник : http://mobiledetect.net/
    // Include and instantiate the class.
    require_once 'Mobile_Detect.php';
    $detect = new Mobile_Detect;
    $browserType="не определён";
    // Any mobile device (phones or tablets).
    if ( $detect->isMobile() ) {
        $browserType="телефон или планшет";
    }
    else
    {
        $browserType="десктоп";
    }
    
    // Any tablet device.
    if( $detect->isTablet() ){
        $browserType="планшет";
    }
    
    // Exclude tablets.
    if( $detect->isMobile() && !$detect->isTablet() ){
        $browserType="телефон";
    }
    
    echo "<p>Тип браузера : ".$browserType."</p>";

}

?>