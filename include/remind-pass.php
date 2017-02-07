<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    define('myeshop', true);
    include("db_connect.php");
    include("../functions/functions.php");
    
    $email = clear_string($_POST["email"]);
    
    if ($email != "")
    {
        $result = mysql_query("SELECT email FROM reg_user WHERE email='$email'", $link);
        if(mysql_num_rows($result) > 0)
        {
            // генерація паролю функцією fungenpass
            $newpass = fungenpass();
            
            //шифрування нового паролю
            
            $pass   = md5($pass);
            $pass   = strrev($pass);
            $pass   = strtolower("dsfb4rf8".$pass."ds4s5");
            
            $update = mysql_query("UPDATE reg_user SET pass='$pass' WHERE email='$email'", $link);
            
            //віддправка нового паролю
            send_mail('noreply@shop.ru', 
                      $email, 
                      'Новий пароль для сайта Shop.ua', 
                      'Ваш пароль:'.$newpass);
            
            echo 1;
        }else
        {
            echo 'Данний E-mail не знайдено!';
        }
    }else
    {
       echo 'Вкажіть свій E-mail'; 
    } 
}
?>

        
        