<?php

  // Местами код взят отсюда : https://www.codexworld.com/send-email-with-attachment-php/
  
  //Часть 1. Параметры письма

  // куда отправлять сообщение  
  $userEmail="herbal.me@yandex.ru";   // для теста и по умолчанию

  
  if(!empty($_REQUEST['userEmail']))
  {
    $userEmail=$_REQUEST['userEmail'];//извлекается из URL запроса
  }
  
  //получатель
  $to = $userEmail;

  //отправитель
  $from = 'herbal.me@yandex.ru';
  $fromName = 'продукция Гербалайф';

  //тема
  $subject = 'цены на Гербалайф со скидками'; 

  //вложение
  $file = "прайс_Гербалайф.pdf";  

  //email body content
  $htmlContent = '
  <div style="font-family: Roboto, Helvetica, Verdana, Sans-Serif;">
    <h3>Выгодные цены на продукцию Гербалайф</h3>
    <p>Здравствуйте!</p>
    <p>В этом письме все цены на продукцию Гербалайф.</p>
    <p>Прайс-лист и каталог товаров вложены в виде pdf-файлов.</p>
    <p>Ниже - цены на самые популярные позиции :</p>
    <!--ul>
      <li>коктейль Формула 1 - 1550 руб.</li>
      <li>вечерний коктейль - 1300 руб.</li>
      <li>протеиновая смесь Формула 3 - 1320 руб.</li>
      <li>травяной напиток (чай), 50 г - 1120 руб.</li>
      <li>концентрат Гербал Алоэ - 1420 руб.</li>
    </ul-->
    <table>
      <tr style="background-color:#80bb27;color:white;"><th style="width:230px;">продукт</th><th>цена</th></tr>
      <tr><td>вечерний коктейль</td><td>1300 руб</td></tr>
      <tr><td>коктейль Формула 1</td><td>1550 руб</td></tr>
      <tr><td>протеиновая смесь Формула 3</td><td>1320 руб</td></tr>
      <tr><td>травяной напиток (чай), 50 г</td><td>1120 руб</td></tr>
      <tr><td>концентрат Гербал Алоэ</td><td>1420 руб</td></tr>
    </table>
    <p>Есть бесплатная доставка. Подробности в прайслисте.</p>
    <p>Если захотите разместить заказ или задать вопросы,<br/>свяжитесь с нами по телефону : <b>84994907969</b></p>
    <p>Чтобы не тратить баланс телефона, Вы можете сделать дозвон (2-3 гудка) и мы сами Вам перезвоним.</p>
  </div>
  ';

  //Часть 2. Сборка письма

  //header for sender info
  $headers = "From: $fromName"." <".$from.">";

  //boundary 
  $semi_rand = md5(time()); 
  $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

  //headers for attachment 
  $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 

  //multipart boundary 
  $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
  "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 

  //preparing attachment
  if(!empty($file) > 0){
      if(is_file($file)){
          $message .= "--{$mime_boundary}\n";
          $fp =    @fopen($file,"rb");
          $data =  @fread($fp,filesize($file));

          @fclose($fp);
          $data = chunk_split(base64_encode($data));
          $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" . 
          "Content-Description: ".basename($file)."\n" .
          "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" . 
          "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
      }
  }
  $message .= "--{$mime_boundary}--";
  $returnpath = "-f" . $from;

  // Часть 3. Отправка письма
  $mail = @mail($to, $subject, $message, $headers, $returnpath);//возвращает 1 или true(письмо отправлено) или false(письмо не отправлено). Но обрабатывать не будем.

  
  // Часть 4. Обработка результата

  //выведи сообщение в зависимости от ответа
  $server_response="";

  if($mail)
  {
    $server_response="success";
  }
  else
  {
    $server_response="fail";
  }
  
  echo $server_response;
  
?>
