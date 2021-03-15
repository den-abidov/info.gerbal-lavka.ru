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
  <div style="font-family: Roboto, Helvetica, Verdana, Sans-Serif; line-height:1.3rem;">
    <p style="text-align:center;"><img src="https://xn----8sbaa6act2a7bcuz8e.xn--p1ai/assets/img/zavtrak.jpg"></p>
    <div style="max-width:470px;margin:auto;">  
      <h3>Выгодные цены на продукцию Гербалайф</h3>
      <p>Прайс-лист и каталог товаров прилагаются.</p>
      <p>Цены на самые популярные позиции :</p>
    </div>
    <table style="margin:auto;">
        <tr style="background-color:#80bb27;color:white;"><th style="width:250px;">продукт</th><th>цена</th></tr>
        <tr><td>вечерний коктейль</td><td>1360 руб</td></tr>
        <tr><td>коктейль Формула 1</td><td>1630 руб</td></tr>
        <tr><td>протеиновая смесь Формула 3</td><td>1390 руб</td></tr>
        <tr><td>травяной напиток (чай), 50 г</td><td>1170 руб</td></tr>
        <tr><td>концентрат Гербал Алоэ</td><td>1470 руб</td></tr>
    </table>
    <div style="max-width:470px;margin:auto;">
      <p>Преимущества :</p>
      <ul>
        <li style="margin-bottom:10px;">Выгодные цены. Не нужна регистрация и карта клиента.</li>
        <li style="margin-bottom:10px;"><b>Быстрая бесплатная доставка</b> &#128640; по всей России.</li>        
        <li style="margin-bottom:10px;">Полный возврат денег за заказ + компенсация сверху, если заказ не был доставлен в контрольный срок.</li>
        <li style="margin-bottom:10px;">Товар 100% оригинал. Гарантии покупателям &#128195;</li>
        <li style="margin-bottom:10px;">При оплате у Вас сохраняется чек-квитанция.</li>
        <li style="margin-bottom:10px;">Бесплатные консультации нашим клиентам.</li>
      </ul>
      <p>Принимаем заказы от 5 тыс. руб.</p>
      <p>Если захотите разместить заказ или задать вопросы,<br/>свяжитесь с нами по телефону &#9742; <a href="tel:+74994907969">8 499 4907969</a></p>
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
      $mail->addAttachment('pricelist-Herbalife.pdf');         // Add attachments
      $mail->addAttachment('katalog-Herbalife.pdf');       // Add attachments
      
      //Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = 'каталог Гербалайф &#127807; с  выгодными ценами &#128578;';
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
