<?php

  // получи из URL :
  $userEmail = $_REQUEST['userEmail'];
  
  // Использую PHPMailer : https://github.com/PHPMailer/PHPMailer
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require 'phpmailer/Exception.php';
  require 'phpmailer/PHPMailer.php';
  require 'phpmailer/SMTP.php';

  // Текст письма
  $htmlContent = '
  <div style="font-family: Roboto, Helvetica, Verdana, Sans-Serif;">
    <div style="max-width:470px;margin:auto;">  
      <h3>Выгодные цены на продукцию Гербалайф</h3>
      <p>Прайс-лист и каталог товаров вложены в виде pdf-файлов.</p>
      <p>Цены на самые популярные позиции :</p>
    </div>
    <table style="margin:auto;">
        <tr style="background-color:#80bb27;color:white;"><th style="width:250px;">продукт</th><th>цена</th></tr>
        <tr><td>вечерний коктейль</td><td>1330 руб</td></tr>
        <tr><td>коктейль Формула 1</td><td>1590 руб</td></tr>
        <tr><td>протеиновая смесь Формула 3</td><td>1350 руб</td></tr>
        <tr><td>травяной напиток (чай), 50 г</td><td>1150 руб</td></tr>
        <tr><td>концентрат Гербал Алоэ</td><td>1450 руб</td></tr>
    </table>
    <div style="max-width:470px;margin:auto;">
      <p><b>Быстрая бесплатная доставка</b> &#128640; по всей России.</p>
      <p>Товар 100% оригинал. Гарантии покупателям &#128195;</p>
      <p>Если захотите разместить заказ или задать вопросы,<br/>свяжитесь с нами по телефону <a href="tel:+74994907969">8 499 4907969</a></p>
        <p style="color:grey;">Чтобы не тратить баланс телефона, Вы можете сделать дозвон (2-3 гудка) и мы сами Вам перезвоним.</p>
    </div>
  </div>';

  $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
  $mail->CharSet = "utf-8";
  try {
      //Server settings
      $mail->isSMTP();                                      // Set mailer to use SMTP
      $mail->Host = 'smtp.yandex.ru';                       // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'herbal.me@yandex.ru';              // SMTP username
      $mail->Password = 'helloworld';                       // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 587;                                    // TCP port to connect to, по умолчанию было 587

      //Recipients
      $mail->setFrom('herbal.me@yandex.ru', 'продукция Гербалайф');
      $mail->addAddress($userEmail);                        // Add a recipient
      $mail->addReplyTo('herbal.me@yandex.ru','продукция Гербалайф');    

      //Attachments
      $mail->addAttachment('прайс Гербалайф.pdf');         // Add attachments
      $mail->addAttachment('каталог Гербалайф.pdf');       // Add attachments
      
      //Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = 'цены на Гербалайф со скидками';
      $mail->Body    = $htmlContent;
      $mail->AltBody = 'Каталог и прайслист с ценами на продукцию Гербалайф прилагаются. Приём заказов по тел: 84994907969 или на сайте https://хочу-заказать.рф';

      $mail->send();
      //echo 'Письмо отправлено.';
      echo 'success';//для обработки JS-кодом
  } catch (Exception $e) 
  {
      //echo 'Не получилось отправить письмо. Ошибка : ', $mail->ErrorInfo;
      echo 'fail';//для обработки JS-кодом
  } 
?>
