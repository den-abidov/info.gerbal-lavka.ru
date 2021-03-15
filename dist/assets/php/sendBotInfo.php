<?php

function sendBotInfo($ip)
{
    // Узнай хост бота. Боты заходят с хостов **googlebot.com, **yandex.ru, **yandex.com, **yandex.net
    $name = gethostbyaddr($ip);
    
    // поиск слова Googlebot, yandex.ru, yandex.net, yandex.com в имени хоста $name
    // флаг i - регистронезависимый поиск совпадения
    // 1 - совпало, 0 - не совпало. 
    $pm1 = preg_match("/Googlebot/i",$name);
    $pm2 = preg_match("/yandex/i",$name);

    $botType="не определён";
    if($pm1) $botType="Google";
    if($pm2) $botType="Яндекс";

    // география захода
    include 'getAddressFromIP.php';
    $address=getAddressFromIP($ip);

    // на какую страницу зашёл
    $pageName="страница не определена";
    $pageUrl = $_SERVER['SCRIPT_FILENAME'];
    $pageName = pathinfo($pageUrl)['basename'];
 
    //отправь письмо себе на почту
    $to = "herbal.me@yandex.ru";
    $subject = $botType."-бот зашёл с ip ".$ip;
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: herbal-boutique.ru<herbal.me@yandex.ru>" . "\r\n";
    $htmlContent = "
    <html>
    <head>
       <meta charset='utf-8'>
    </head>
    <body style='font-family: Roboto, Helvetica, Verdana, Sans-Serif;'>
        <table>
            <tr><td>сайт</td><td>: herbal-boutique.ru</td></tr>
            <tr><td>страница</td><td>: ".$pageName."</td></tr>
            <tr><td>тип</td><td>: ".$botType."</td></tr>
            <tr><td>хост</td><td>: ".$name."</td></tr>
            <tr><td>ip</td><td>: ".$ip."</td></tr>
            <tr><td>откуда</td><td>: ".$address."</td></tr>
        </table>
    </body>
    </html>";
    $mail=mail($to,$subject,$htmlContent,$headers);//возвращает 1 или true(письмо отправлено) или false(письмо не отправлено). Но обрабатывать не будем.
}

?>