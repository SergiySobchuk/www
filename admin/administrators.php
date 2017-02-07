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
   	$_SESSION['urlpage'] = "<a href='index.php'>Головна</a> \ <a href='administrators.php'>Адміністратори</a>";
    include("include/db_connect.php"); 
    include("include/functions.php");
    $id =  clear_string($_GET["id"]);
    $action = $_GET["action"];
    if (isset($action))
    {
        switch ($action)
        {
            case 'delete':
            $delete = mysql_query("DELETE FROM reg_admin WHERE id = '$id'",$link);
            break; 
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
	<title>Панель керування - Адміністратори</title>
</head>
<body>
    <div id="block-body">
<?php
    include("include/block-header.php");
?>
    <div id="block-content">
        <div id="block-parameters">
            <p id="title-page"><strong>Адміністратори</strong></p>
            <p align="right" id="add-style"><a href="add_administrators.php">Додати адміна</a></p>
        </div>
        <?php 
            $result = mysql_query("SELECT * FROM reg_admin ORDER BY id DESC", $link);
            if(mysql_num_rows($result)>0)
            {
                $row = mysql_fetch_array($result);
                do
                {
                    echo
                    '
                        <ul id="list-admin">
                            <li>
                                <h3>'.$row["fio"].'</h3>
                                <p><strong>Посада</strong> - '.$row["role"].'</p>
                                <p><strong>E-mail</strong> - '.$row["email"].'</p>
                                <p><strong>Телефон</strong> - '.$row["phone"].'</p>
                                <p class="link-actions" align="right"><a class="green" href="edit_administrators.php?id='.$row["id"].'">Редагувати</a> | <a class="delete" href="administrators.php?id='.$row["id"].'&action=delete">Видалити</a></p>
                            </li>
                        </ul>
                    ';
                }
                while($row = mysql_fetch_array($result));
            }
        ?>
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