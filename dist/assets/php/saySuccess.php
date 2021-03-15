<?php
    $message='не задано';
    $userEmail='не задано';
    if(!empty($_REQUEST['message']))
    {
      $message=$_REQUEST['message'];    
    }
    if(!empty($_REQUEST['userEmail']))
    {
      $userEmail=$_REQUEST['userEmail'];      
    }
    echo '<p><u>Получил данные</u> :</p><p>message : '.$message.'</p><p> user email : '.$userEmail.'</p>';    
    //echo 'success';
?>