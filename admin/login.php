<?php
    session_start();
    define('myeshop', true);
    include("include/db_connect.php");
    include("include/functions.php");

    if($_POST["submit_enter"])
    {
        $login = clear_string($_POST["input_login"]);
        $pass = clear_string($_POST["input_pass"]);
    
        if($login && $pass)
        {
           $pass   = md5($pass);
           $pass   = strrev($pass);
           $pass   = strtolower("dsfb4rf8".$pass."ds4s5");
        
            $result = mysql_query("SELECT * FROM reg_admin WHERE login = '$login' AND pass = '$pass'", $link);
        
            if(mysql_num_rows($result)>0)
            {
                $row = mysql_fetch_array($result);
                $_SESSION['auth_admin'] = 'yes_auth'; 
                header("Location: index.php");
            }
            else
            {
                $msqerror = "Невірний ЛОГІН і(або) ПАРОЛЬ.";
            }
        }
        else
        {
            $msqerror = "Заповніть всі поля!!!";
        }
    }
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="css/style-login.css" rel="stylesheet" type="text/css" />
    <link href="css/reset.css" rel="stylesheet" type="text/css" />
	<title>Панель керування - вхід</title>
</head>

<body>
<div id="block-pass-login">
<?php
            if ($msqerror)
            {
                echo '<p id="msqerror">'.$msqerror.'</p>';
            }
?>
        <form method="post">
            <ul id="pass-login">
                <li><label>Логін</label><input type="text" name="input_login" /></li>
                <li><label>Пароль</label><input type="password" name="input_pass" /></li>
            </ul>
            <p align="right"><input type="submit" name="submit_enter" id="submit_enter" value="вхід" /></p>
        </form>
    </div>
</body>
</html>