<?php
    define('myeshop', true);
    session_start();
    include("include/db_connect.php");
    include("functions/functions.php");
    include("include/auth_cookie.php");
    
    //unset($_SESSION['auth']);//завершення сесії
    //setcookie('rememberme',' ',0, "/"); //обнулення кука
    
    if($_POST["send_message"])    
    {
        $error = array();
        if (!$_POST[feed_name]) $error[] = "Вкажіть своє імя!";
        if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i",trim($_POST["feed_email"]))) 
        {
            $error[] = "Вкажіть коректний email!";
        }
        if (!$_POST[feed_subject]) $error[] = "Вкажіть тему листа!";
        if (!$_POST[feed_text]) $error[] = "Вкажіть текст повідомлення!";
        if (strtolower($_POST["reg_captcha"]) != $_SESSION['img_captcha']) 
        {
            $error[] = "Не вірний код з картинки!"; 
        }
        if (count($error))
        {
            $_SESSION['message'] = "<p id='form-error'>".implode('</br>', $error)."</p>";
        }
        else
        {
            send_mail($_POST["feed_mail"],'SergiySobchuk@gmail.com', $_POST["feed_subject"], 'Від '.$_POST["feed_name"].'</br>'.$_POST["feed_text"]);
            $_SESSION['message'] = "<p id='form-success'>Ваше повідомлення успішно відправлено!</p>";
        }
        
    }

    

  
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="http://shop/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="http://shop/css/style.css" rel="stylesheet" type="text/css" />
    <link href="http://shop/trackbar/trackbar.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="http://shop/js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="http://shop/js/jcarousellite_1.0.1.js"></script>
    <script type="text/javascript" src="http://shop/js/shop-script.js"></script>
    <script type="text/javascript" src="http://shop/js/jquery.cookie.min.js"></script>
    <script type="text/javascript" src="http://shop/trackbar/jquery.trackbar.js"></script>
    <script type="text/javascript" src="http://shop/js/TextChange.js"></script>
	<title>Інтернет-Магазин Цифрової Техніки</title>
</head>
<body>
    <div id="block-body">
        <?php
	       include("include/block-header.php");
        ?>
        <div id="block-right">
            <?php
	           include("include/block-category.php");
               include("include/block-parametr.php");
               include("include/block-news.php");
            ?>
        </div>
        <div id="block-content">
            <?php
                if(isset($_SESSION['message']))
                {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
            ?>
            <form method="post">
                <div id="block-feedback">
                <ul id="feedback" type="none">
                    <li><label>Ваше Імя</label><input type="text" name="feed_name"/></a></li>
                    <li><label>Ваш E-mail</label><input type="text" name="feed_email"/></a></li>
                    <li><label>Тема</label><input type="text" name="feed_subject"/></a></li>
                    <li><label>Текст повідомлення</label><textarea name="feed_text"></textarea></li>
                    <li>
                        <label for="reg_captcha">Захистний код</label>
                        <div id="block-captcha">
                        <img src="/reg/reg_captcha.php"/>
                        <input type="text" name="reg_captcha" id="reg_captcha" />
                        <p id="reloadcaptcha">Оновити</p>
                        </div>
                    </li>
                </ul>
                </div>
                <p align="right"><input type="submit" name="send_message" id="form_submit"/></p>
            </form>
        </div>
        <?php
            include("include/block-random.php");
	        include("include/block-footer.php");
        ?>
    </div>
</body>
</html>





















