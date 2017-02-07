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
   	$_SESSION['urlpage'] = "<a href='index.php'>Головна</a> \ <a href='category.php'>Категорії</a>";
    include("include/db_connect.php");
    include("include/functions.php");
    
    if($_POST["submit_cat"])
    {
        if($_SESSION['add_category'] == '1')
        {
            $error = array();
            if(!$_POST["cat_type"]) $error[] = "Вкажіть тип товара!";
            if(!$_POST["cat_brand"]) $error[] = "Вкажіть бренд товара!";
        
            if(count($error))
            {
                $_SESSION['message'] = "<p id='form-error'>".implode("<br/>",$error)."</p>";
            }
            else
            {
                $cat_type = clear_string($_POST["cat_type"]);
                $cat_brand =  clear_string($_POST["cat_brand"]);
            
                mysql_query("INSERT INTO category (type,brand) VALUES ('".$cat_type."', '".$cat_brand."')", $link);  
                $_SESSION['message'] = "<p id='form-success'>Категорія &quot; ".$cat_type." - ".$cat_brand." &quot; успішно додана!</p>";
            }
        }
        else
        {
            $msgerror = 'У Вас немає прав на додавання категорій!!!';
        }
    }
        
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/reset.css" rel="stylesheet" type="text/css" />
   	<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
	<title>Панель керування - категорії</title>
</head>
<body>
    <div id="block-body">
<?php
    include("include/block-header.php");
?>
    <div id="block-content">
        <div id="block-parameters">
            <p id="title-page"><strong>Категорії</strong></p>
        </div>
        <?php
            if(isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';
        
            if(isset($_SESSION['message']))
            {
                echo $_SESSION['message'];
                unset ($_SESSION['message']);
            }
        ?>
        <form method="post">
            <ul id="cat_products">
                <li>
                    <label>Категорії</label>
                    <div>
                        <?php
                            if($_SESSION['delete_category'] == '1')
                            {
                                echo'<a class="delete-cat">Видалити</a>';
                            }
                        ?>
                    </div>
                    <select name="cat_type" id="cat_type" size="10">
                    <?php
                	   $result = mysql_query("SELECT * FROM category ORDER BY type DESC",$link);
                       if(mysql_num_rows($result)>0)
                       {
                        $row = mysql_fetch_array($result);
                        do
                        {
                            echo'
                                <option value="'.$row["id"].'">'.$row["type"].' - '.$row["brand"].'</option>
                            ';
                        }
                        while($row = mysql_fetch_array($result));
                       }
                    ?>    
                    </select>
                </li>
                <li>
                    <label>Тип товара</label>
                    <input type="text" name="cat_type"/>
                </li>
                <li>
                    <label>Бренд</label></label>
                    <input type="text" name="cat_brand"/>
                </li>
            </ul>
            <p align="right"><input type="submit" name="submit_cat" id="submit_form" value="Створити" /></p>        
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