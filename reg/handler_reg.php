<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
 define('myeshop', true);
 session_start();
 include("../include/db_connect.php");
 include("../functions/functions.php");
 
     $error = array();
         
        $login = iconv("UTF-8", "cp1251",strtolower(clear_string($_POST['reg_login']))); 
        $pass = iconv("UTF-8", "cp1251",strtolower(clear_string($_POST['reg_pass']))); 
        $surname = iconv("UTF-8", "cp1251",clear_string($_POST['reg_surname'])); 
        
        $name = iconv("UTF-8", "cp1251",clear_string($_POST['reg_name'])); 
        $patronymic = iconv("UTF-8", "cp1251",clear_string($_POST['reg_patronymic'])); 
        $email = iconv("UTF-8", "cp1251",clear_string($_POST['reg_email'])); 
        
        $phone = iconv("UTF-8", "cp1251",clear_string($_POST['reg_phone'])); 
        $address = iconv("UTF-8", "cp1251",clear_string($_POST['reg_address'])); 
 
 
    if (strlen($login) < 5 or strlen($login) > 15)
    {
       $error[] = "Логін має бути від 5 до 15 символів!"; 
    }
    else
    {   
     $result = mysql_query("SELECT login FROM reg_user WHERE login = '$login'",$link);
    If (mysql_num_rows($result) > 0)
    {
       $error[] = "Логін заянятий!";
    }
            
    }
     
    if (strlen($pass) < 7 or strlen($pass) > 15) $error[] = "Вкажіть пароль від 7 до 15 символів!";
    if (strlen($surname) < 3 or strlen($surname) > 20) $error[] = "Вкажіть фамілію від 3 до 20 символів.!";
    if (strlen($name) < 3 or strlen($name) > 15) $error[] = "Вкажіть Імя від 3 до 15 символів!";
    if (strlen($patronymic) < 3 or strlen($patronymic) > 25) $error[] = "Вкажіть по Батькові від 3 до 25 символів!";
    if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i",trim($email))) $error[] = "Вкажіть коректний email!";
    if (!$phone) $error[] = "Вкажіть номер телефона!";
    if (!$address) $error[] = "Необхідно вказати адресу доставки!";
    
    if($_SESSION['img_captcha'] != strtolower($_POST['reg_captcha'])) $error[] = "Невірний код з картинки!";
    unset($_SESSION['img_captcha']);
    
   if (count($error))
   {
    
 echo implode('<br />',$error);
     
   }else
   {   
        $pass   = md5($pass);
        $pass   = strrev($pass);
        $pass   = "dsfb4rf8".$pass."ds4s5";
        
        $ip = $_SERVER['REMOTE_ADDR'];
		
		mysql_query("	INSERT INTO reg_user(login,pass,surname,name,patronymic,email,phone,address,datetime,ip)
						VALUES(
						
							'".$login."',
							'".$pass."',
							'".$surname."',
							'".$name."',
							'".$patronymic."',
                            '".$email."',
                            '".$phone."',
                            '".$address."',
                            NOW(),
                            '".$ip."'							
						)",$link);

 echo true;
 }  
 }      
?>