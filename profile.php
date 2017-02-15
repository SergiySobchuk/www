<?php
define('myeshop', true);
session_start();

if ($_SESSION['auth'] == 'yes_auth')
{	
   include("include/db_connect.php");
   include("functions/functions.php");
 
   if ($_POST["save_submit"])
     {
        
    $_POST["info_surname"] = clear_string($_POST["info_surname"]);
    $_POST["info_name"] = clear_string($_POST["info_name"]);
    $_POST["info_patronymic"] = clear_string($_POST["info_patronymic"]);
    $_POST["info_address"] = clear_string($_POST["info_address"]);
    $_POST["info_phone"] = clear_string($_POST["info_phone"]);
    $_POST["info_email"] = clear_string($_POST["info_email"]);     
              
    $error = array();
	
        $pass   = md5($_POST["info_pass"]);
        $pass   = strrev($pass);
        $pass   = "dsfb4rf8".$pass."ds4s5";
    
	if($_SESSION['auth_pass'] != $pass)
	{
		$error[]='Невірний поточний пароль!';
	}else
    {
        
      if($_POST["info_new_pass"] != "")
	{
		        if(strlen($_POST["info_new_pass"]) < 7 || strlen($_POST["info_new_pass"]) > 15)
            	{
		           $error[]='Вкажіть новий пароль від 7 до 15 символів!';
	            }else
                {
                     $newpass   = md5(clear_string($_POST["info_new_pass"]));
                     $newpass   = strrev($newpass);
                     $newpass   = "dsfb4rf8".$newpass."ds4s5";
                     $newpassquery = "pass='".$newpass."',";
                }
	}
    
    
    
        if(strlen($_POST["info_surname"]) < 3 || strlen($_POST["info_surname"]) > 15)
	{
		$error[]='Вкажіть Прізвище від 3 до 15 символів!';
	}
    
    
        if(strlen($_POST["info_name"]) < 3 || strlen($_POST["info_name"]) > 15)
	{
		$error[]='Вкажіть Імя від 3 до 15 символів!';
	}
    
    
        if(strlen($_POST["info_patronymic"]) < 3 || strlen($_POST["info_patronymic"]) > 25)
	{
		$error[]='Вкафіть по Батькові від 3 до 25 символів!';
	}  
    
    
        if(!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i",trim($_POST["info_email"])))
	{
		$error[]='Вкажіть коректний email!';
	}
    
      if(strlen($_POST["info_phone"]) == "")
	{
		$error[]='Вкажіть номер телефона!';
	} 
    
      if(strlen($_POST["info_address"]) == "")
	{
		$error[]='Вкажіть адресу доставки!';
	}      
    
    
        
    }
    
  if(count($error))
	{
		$_SESSION['msg'] = "<p align='left' id='form-error'>".implode('<br />',$error)."</p>";
	}else
    {
        $_SESSION['msg'] = "<p align='left' id='form-success'>Данні успішно збережені!</p>";
           
     $dataquery = $newpassquery."surname='".$_POST["info_surname"]."',name='".$_POST["info_name"]."',patronymic='".$_POST["info_patronymic"]."',email='".$_POST["info_email"]."',phone='".$_POST["info_phone"]."',address='".$_POST["info_address"]."'";      
     $update = mysql_query("UPDATE reg_user SET $dataquery WHERE login = '{$_SESSION['auth_login']}'",$link);
      
    if ($newpass){ $_SESSION['auth_pass'] = $newpass; } 
    
    
    $_SESSION['auth_surname'] = $_POST["info_surname"];
    $_SESSION['auth_name'] = $_POST["info_name"];
    $_SESSION['auth_patronymic'] = $_POST["info_patronymic"];
    $_SESSION['auth_address'] = $_POST["info_address"];
    $_SESSION['auth_phone'] = $_POST["info_phone"];
    $_SESSION['auth_email'] = $_POST["info_email"];    
        
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
            <h3 class="title-h3">Зміна профіля</h2>
            
            <?php  
                	if($_SESSION['msg'])
                    {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
            ?>            
            
            
            <form method="post">
                <ul type="none" id="info-profile">
                        <li>
                            <label id="info_pass">Поточний пароль</label>
                            <span class="star">*</span>
                            <input type="text" name="info_pass" id="info_pass" value=""/>
                        </li>
                         <li>
                            <label id="info_new_pass">Новий пароль</label>
                            <span class="star">*</span>
                            <input type="text" name="info_new_pass" id="info_new_pass" value=""/>
                        </li>
                         <li>
                            <label id="info_surname">Прізвище</label>
                            <span class="star">*</span>
                            <input type="text" name="info_surname" id="info_surname" value="<?php echo $_SESSION['auth_surname']; ?>"/>
                        </li>
                        <li>
                            <label id="info_name">Імя</label>
                            <span class="star">*</span>
                            <input type="text" name="info_name" id="info_name" value="<?php echo $_SESSION['auth_name']; ?>"/>
                        </li>
                         <li>
                            <label id="info_patronymic">По батькові</label>
                            <span class="star">*</span>
                            <input type="text" name="info_patronymic" id="info_patronymic" value="<?php echo $_SESSION['auth_patronymic']; ?>"/>
                        </li>
                        <li>
                            <label id="info_email">E-mail</label>
                            <span class="star">*</span>
                            <input type="text" name="info_email" id="info_email" value="<?php echo $_SESSION['auth_email']; ?>"/>
                        </li>
                        <li>
                            <label id="info_phone">Мобільний номер</label>
                            <span class="star">*</span>
                            <input type="text" name="info_phone" id="info_phone" value="<?php echo $_SESSION['auth_phone']; ?>"/>
                        </li>
                        <li>
                            <label id="info_address">Адреса доставки</label>
                            <span class="star">*</span>
                            <textarea name="info_address"><?php echo$_SESSION['auth_address']; ?></textarea>
                        </li>
                    </ul>
                </div>
                <p align="right"><input type="submit" id="form_submit" name="save_submit" value="Зберегти"/></p>
            </form>
        </div>
        <?php
	        include("include/block-footer.php");
        ?>
    </div>
</body>
</html>
<?php
} else 
    {
        header("Location: index.php");
    }
?>