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
                $_SESSION['auth_admin_login'] = $row["login"];
                //Посада
                $_SESSION['admin_role'] = $row["role"];
              
              //Привілегії  
                //Закази
                $_SESSION['accept_orders'] = $row["accept_orders"];
                $_SESSION['delete_orders'] = $row["delete_orders"];
                $_SESSION['view_orders'] = $row["view_orders"];
                //Товари
                $_SESSION['add_tovar'] = $row["add_tovar"];
                $_SESSION['edit_tovar'] = $row["edit_tovar"];
                $_SESSION['delete_tovar'] = $row["delete_tovar"];
                //Відгуки
                $_SESSION['accept_reviews'] = $row["accept_reviews"];
                $_SESSION['delete_reviews'] = $row["delete_reviews"];
                //Клієнти
                $_SESSION['view_clients'] = $row["view_clients"];
                $_SESSION['delete_clients'] = $row["delete_clients"];
                //Новини
                $_SESSION['add_news'] = $row["add_news"];
                $_SESSION['delete_news'] = $row["delete_news"];
                //Категорії
                $_SESSION['add_category'] = $row["add_category"];
                $_SESSION['delete_category'] = $row["delete_category"];
                //Перегляд адмінів
                $_SESSION['view_admin'] = $row["view_admin"];
                                
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