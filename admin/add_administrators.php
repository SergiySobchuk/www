<?php
    session_start();
if ($_SESSION['auth_admin'] == "yes_auth")
{
    define('myeshop', true);
    if(isset($_GET["logout"]))
    {
        unset($_SESSION['auth_admin']);
        header("Location: login.php");
    }
   	$_SESSION['urlpage'] = "<a href='index.php'>Головна</a> \ <a href='add_administrators.php'>Додавання адміністраторів</a>";
    include("include/db_connect.php"); 
    include("include/functions.php");
    
    if($_POST["submit_add"])
    {
    if($_SESSION['auth_admin_login'] == 'admin')
    {    
        $error = array();
        if($_POST["admin_login"])
        {
            $login = clear_string($_POST["admin_login"]);
            $guery = mysql_query("SELECT login FROM reg_admin WHERE login='$login'", $link);
            
            if(mysql_num_rows($guery) > 0)
            {
                $error[] = "Логін зайнято!";
            }
        }
        else
        {
            $error[] = "Вкажіть логін!";
        }
        if(!$_POST["admin_pass"]) $error[] = "Вкажіть пароль!";
        if(!$_POST["admin_fio"]) $error[] = "Вкажіть ПІБ!";
        if(!$_POST["admin_role"]) $error[] = "Вкажіть посаду!";
        if(!$_POST["admin_email"]) $error[] = "Вкажіть E-mail!";
        
        if (count($error))
        {
            $_SESSION['message'] = "<p id='form-error'>".implode('<br/>', $error)."</p>";
        }
        else
        {
            $pass   = md5(clear_string($_POST["admin_pass"]));
            $pass   = strrev($pass);
            $pass   = strtolower("dsfb4rf8".$pass."ds4s5");
            
            mysql_query("INSERT INTO reg_admin(login,pass,fio,role,email,phone,view_orders,accept_orders,delete_orders,add_tovar,edit_tovar,delete_tovar,accept_reviews,delete_reviews,view_clients,delete_clients,add_news,delete_news,add_category,delete_category,view_admin)
						VALUES(						
                            '".clear_string($_POST["admin_login"])."',
                            '".$pass."',
                            '".clear_string($_POST["admin_fio"])."',
                            '".clear_string($_POST["admin_role"])."',
                            '".clear_string($_POST["admin_email"])."',
                            '".clear_string($_POST["admin_phone"])."',
                            '".$_POST["view_orders"]."',
                            '".$_POST["accept_orders"]."',
                            '".$_POST["delete_orders"]."',							
                            '".$_POST["add_tovar"]."',
                            '".$_POST["edit_tovar"]."',                            
							'".$_POST["delete_tovar"]."',
                            '".$_POST["accept_reviews"]."',
                            '".$_POST["delete_reviews"]."',
							'".$_POST["view_clients"]."',
                            '".$_POST["delete_clients"]."',
							'".$_POST["add_news"]."',							
							'".$_POST["delete_news"]."',
							'".$_POST["add_category"]."',
							'".$_POST["delete_category"]."',
                            '".$_POST["view_admin"]."'
                                                                                                                            
						)",$link);

            $_SESSION['message'] = "<p id='form-success'>Адміністратор &quot;".$_POST['admin_login']."&quot; успішно додано!</p>";
        }
    }
    else
    {
        $msgerror = 'У Вас немає прав на додавання адміністраторів!!!';
    }
    }
    
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/reset.css" rel="stylesheet" type="text/css" />
    <link href="jquery_confirm/jquery_confirm.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <script type="text/javascript" src="jquery_confirm/jquery_confirm.js"></script>
	<title>Панель керування - Додавання адміністраторів</title>
</head>
<body>
    <div id="block-body">
<?php
    include("include/block-header.php");
?>
    <div id="block-content">
        <div id="block-parameters">
            <p id="title-page"><strong>Додавання адміністраторів</strong></p>
        </div>
        <?php
           if(isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>'; 
	       if(isset($_SESSION['message']))
           {
                echo $_SESSION['message'];
                unset ($_SESSION['message']);
           }
        ?>
        <form method="post" id="form-info">
            <ul id="info-admin">
                <li><label>Логін*</label><input type="text" name="admin_login" /></li>
                <li><label>Пароль*</label><input type="password" name="admin_pass" /></li>
                <li><label>ПІБ*</label><input type="text" name="admin_fio" /></li>
                <li><label>Посада*</label><input type="text" name="admin_role" /></li>
                <li><label>E-mail*</label><input type="text" name="admin_email" /></li>
                <li><label>№ телефона*</label><input type="text" name="admin_phone" /></li>
            </ul>
            <h3 id="title-privilege">Привілегії</h3>
            <p id="link-privilege"><a id="select-all">Вибрати все</a> | <a id="remove-all">Зняти все</a></p>
            <div class="block-privilege">
                <ul class="privilege">
                    <li><h3>Замовлення</h3></li>
                    <li>
                        <input type="checkbox" name="view_orders" id="view_orders" value="1"/>
                        <label for="view_orders">Перегляд замовлень</label>
                    </li>
                    <li>
                        <input type="checkbox" name="accept_orders" id="accept_orders" value="1"/>
                        <label for="accept_orders">Обробка замовлень</label>
                    </li>
                    <li>
                        <input type="checkbox" name="delete_orders" id="delete_orders" value="1"/>
                        <label for="delete_orders">Видалення замовлень</label>
                    </li>
                </ul>
                <ul class="privilege">
                    <li><h3>Товари</h3></li>
                    <li>
                        <input type="checkbox" name="add_tovar" id="add_tovar" value="1"/>
                        <label for="add_tovar">Додавання товару</label>
                    </li>
                    <li>
                        <input type="checkbox" name="edit_tovar" id="edit_tovar" value="1"/>
                        <label for="edit_tovar">Редагування товару</label>
                    </li>
                    <li>
                        <input type="checkbox" name="delete_tovar" id="delete_tovar" value="1"/>
                        <label for="delete_tovar">Видалення товару</label>
                    </li>
                </ul>
                <ul class="privilege">
                    <li><h3>Відгуки</h3></li>
                    <li>
                        <input type="checkbox" name="accept_reviews" id="accept_reviews" value="1"/>
                        <label for="accept_reviews">Модерація відгуків</label>
                    </li>
                    <li>
                        <input type="checkbox" name="delete_reviews" id="delete_reviews" value="1"/>
                        <label for="delete_reviews">Видалення відгуків</label>
                    </li>
                </ul>
            </div>
            <div class="block-privilege">
                <ul class="privilege">
                    <li><h3>Клієнти</h3></li>
                    <li>
                        <input type="checkbox" name="view_clients" id="view_clients" value="1"/>
                        <label for="view_clients">Перегляд клієнтів</label>
                    </li>
                    <li>
                        <input type="checkbox" name="delete_clients" id="delete_clients" value="1"/>
                        <label for="delete_clients">Видалення клієнтів</label>
                    </li>
                </ul>
                <ul class="privilege">
                    <li><h3>Новини</h3></li>
                    <li>
                        <input type="checkbox" name="add_news" id="add_news" value="1"/>
                        <label for="add_news">Додавання новин</label>
                    </li>
                    <li>
                        <input type="checkbox" name="delete_news" id="delete_news" value="1"/>
                        <label for="delete_news">Видалення новин</label>
                    </li>
                </ul>
                <ul class="privilege">
                    <li><h3>Категорії</h3></li>
                    <li>
                        <input type="checkbox" name="add_category" id="add_category" value="1"/>
                        <label for="add_category">Додавання категорій</label>
                    </li>
                    <li>
                        <input type="checkbox" name="delete_category" id="delete_category" value="1"/>
                        <label for="delete_category">Видалення категорій</label>
                    </li>
                </ul>
            </div>
            <div class="block-privilege">
                <ul class="privilege">
                    <li><h3>Адміністратори</h3></li>
                    <li>
                        <input type="checkbox" name="view_admin" id="view_admin" value="1"/>
                        <label for="view_admin">Перегляд адміністраторів</label>
                    </li>
                </ul>
            </div>
            <p align="right"><input type="submit" id="submit_form" name="submit_add" value="Додати" /></p>
        </form>
    </div>
    </div>
</body>
</html>
<?php
}
else
{
    header("Location: login.php");
}
?>