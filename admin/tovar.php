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
   	$_SESSION['urlpage'] = "<a href='index.php'>Головна</a> \ <a href='tovar.php?cat=all'>Товари</a>";
    include("include/db_connect.php"); 
    include("include/functions.php"); 
    
    $cat = $_GET["cat"];
    $type = $_GET["type"];
    
    if(isset($cat))
    {
        switch ($cat)
        {
            case "all":
            $cat_name = 'всі товари';
            $url = "cat=all&";
            $cat = "";
            break;
            
            case "mobile":
            $cat_name = 'мобільні телефони';
            $url = "cat=mobile&";
            $cat = "WHERE type_tovara='mobile'";
            break;
            
            case "notebook":
            $cat_name = 'ноутбуки';
            $url = "cat=notebook&";
            $cat = "WHERE type_tovara='notebook'";
            break;
            
            case "notepad":
            $cat_name = 'планшети';
            $url = "cat=notepad&";
            $cat = "WHERE type_tovara='notepad'";
            break;
            
            default:
            $cat_name = $cat;
            If($type == "mobile")$type_name = " телефони \ ";
            If($type == "notebook")$type_name = " ноутбуки \ ";
            If($type == "notepad")$type_name = " планшети \ ";
            $url ="type=".clear_string($type)."&cat=".clear_string($cat)."&";
            $cat = "WHERE type_tovara='".clear_string($type)."' AND brand='".clear_string($cat)."'";
        }
    }
    $action = $_GET["action"];
    if (isset($action))
    {
        $id = (int)$_GET["id"];
        switch ($action)
        {
            case 'delete':
            $delete = mysql_query("DELETE FROM table_products WHERE products_id='$id'", $link);
            break;
        }
    }  
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="jquery_confirm/jquery_confirm.css" rel="stylesheet" type="text/css" />
    <link href="css/reset.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <script type="text/javascript" src="jquery_confirm/jquery_confirm.js"></script>
    
    <title>Панель керування</title>
</head>
<body>
    <div id="block-body">
<?php
    include("include/block-header.php");
    $all_counts = mysql_query("SELECT * FROM table_products", $link);
    $all_counts_result = mysql_num_rows($all_counts);
?>
    <div id="block-content">
        <div id="block-parameters">
            <ul id="options-list">
                <li><strong>Фільтрація: </strong></li>
                <li><a id="select-links" href="#"><?php echo $type_name.$cat_name ?></a></li>
            </ul>
            <div id="list-links">
                <ul>
                    <p><a href="tovar.php?cat=all">ВСІ ТОВАРИ</a></p>
                    <li><a href="tovar.php?cat=mobile"><strong>телефони </strong></a></li>
                    <?php
	                   $result1 = mysql_query("SELECT * FROM category WHERE type='mobile'", $link);
                        if(mysql_num_rows($result1) > 0)
                        {
                            $row1 = mysql_fetch_array($result1);
                            do
                            {
                                echo '<li><a href="tovar.php?type='.$row1["type"].'&cat='.$row1["brand"].'">'.$row1["brand"].'</a></li>';
                            } while($row1 = mysql_fetch_array($result1)); 
                        }
                    ?>
                </ul>
                <ul>
                    <li><a href="tovar.php?cat=notebook"><strong>ноутбуки </strong></a></li>
                    <?php
	                   $result1 = mysql_query("SELECT * FROM category WHERE type='notebook'", $link);
                        if(mysql_num_rows($result1) > 0)
                        {
                            $row1 = mysql_fetch_array($result1);
                            do
                            {
                                echo '<li><a href="tovar.php?type='.$row1["type"].'&cat='.$row1["brand"].'">'.$row1["brand"].'</a></li>';
                            } while($row1 = mysql_fetch_array($result1)); 
                        }
                    ?>
                </ul>
                <ul>
                    <li><a href="tovar.php?cat=notepad"><strong>планшети </strong></a></li>
                    <?php
	                   $result1 = mysql_query("SELECT * FROM category WHERE type='notepad'", $link);
                        if(mysql_num_rows($result1) > 0)
                        {
                            $row1 = mysql_fetch_array($result1);
                            do
                            {
                                echo '<li><a href="tovar.php?type='.$row1["type"].'&cat='.$row1["brand"].'">'.$row1["brand"].'</a></li>';
                            } while($row1 = mysql_fetch_array($result1)); 
                        }
                    ?>
                </ul>
            
            
            </div>
        </div>
        <div id="block-info">
            <p id="count-style">Всього товарів - <strong><?php echo $all_counts_result; ?></strong></p>
            <p id="add_style"><a href="add_product.php">Додати товар</a></p>
        </div>
        <ul id="block-tovar">
            <?php
                $num = 9; //Кількість одиниць які виводяться на сторінку.
                $page = (int)$_GET['page'];
                $count = mysql_query("SELECT COUNT(*) FROM table_products $cat", $link);
                $temp = mysql_fetch_array($count);
                $post = $temp[0];
                //знаходимо загальну к-сть сторінок  
                $total = (($post-1)/$num)+1;
                $total = intval($total);
                $page = intval($page);
                if (empty($page) or $page < 0) $page = 1;
                    if ($page > $total) $page = $total;
                    //визначаємо з якого номера потрібно виводити товар
                    $start = $page * $num - $num;
                 
                if($temp[0] > 0)
                {
                    $result = mysql_query("SELECT * FROM table_products $cat ORDER BY products_id DESC LIMIT $start, $num", $link); 
                    if (mysql_num_rows($result) > 0)
                    {
                        $row = mysql_fetch_array($result);
                        do
                        {
                            if(strlen($row["image"]) > 0 && file_exists("../uploads_images/".$row["image"]))
                            {
                                $img_path = '../uploads_images/'.$row["image"];
                                $max_width = 160;
                                $max_height = 160;
                                list($width, $height) = getimagesize($img_path);
                                $ratioh = $max_height/$height;
                                $ratiow = $max_width/$width;
                                $ratio = min($ratioh, $ratiow);
                                $width = intval($ratio * $width);
                                $height = intval($ratio * $height);
                            }
                            else
                            {
                                $img_path = "./images/no-image - 90.png";
                                $width = 90;
                                $height = 163;
                            }
                            echo 
                            '
                                <li>
                                    <p>'.$row["title"].'</p>
                                    <center><img src="'.$img_path.'" width="'.$width.'" height ="'.$height.'"/></center>
                                    <p align="center" class="link-action">
                                        <a class="green" href="edit_products.php?id='.$row["products_id"].'">Редагувати</a> | <a rel="tovar.php?'.$url.'id='.$row["products_id"].'&action=delete" class="delete">Видалити</a>                                    
                                    </p>
                                </li>
                            ';
                        }while ($row = mysql_fetch_array($result));
                    } 
                    
                } 
            ?>  
        </ul> 
            <?php       
            if ($page != 1) $pervpage = '<li><a class="pstr-prev" href="tovar.php?'.$url.'page='. ($page - 1) .'" />Назад</a></li>';
            if ($page != $total) $nextpage = '<li><a class="pstr-next" href="tovar.php?'.$url.'page='. ($page + 1) .'"/>Вперед</a></li>';

            // Находим две ближайшие станицы с обоих краев, если они есть
            if($page - 5 > 0) $page5left = '<li><a href="tovar.php?'.$url.'page='. ($page - 5) .'">'. ($page - 5) .'</a></li>';
            if($page - 4 > 0) $page4left = '<li><a href="tovar.php?'.$url.'page='. ($page - 4) .'">'. ($page - 4) .'</a></li>';
            if($page - 3 > 0) $page3left = '<li><a href="tovar.php?'.$url.'page='. ($page - 3) .'">'. ($page - 3) .'</a></li>';
            if($page - 2 > 0) $page2left = '<li><a href="tovar.php?'.$url.'page='. ($page - 2) .'">'. ($page - 2) .'</a></li>';
            if($page - 1 > 0) $page1left = '<li><a href="tovar.php?'.$url.'page='. ($page - 1) .'">'. ($page - 1) .'</a></li>';

            if($page + 5 <= $total) $page5right = '<li><a href="tovar.php?'.$url.'page='. ($page + 5) .'">'. ($page + 5) .'</a></li>';
            if($page + 4 <= $total) $page4right = '<li><a href="tovar.php?'.$url.'page='. ($page + 4) .'">'. ($page + 4) .'</a></li>';
            if($page + 3 <= $total) $page3right = '<li><a href="tovar.php?'.$url.'page='. ($page + 3) .'">'. ($page + 3) .'</a></li>';
            if($page + 2 <= $total) $page2right = '<li><a href="tovar.php?'.$url.'page='. ($page + 2) .'">'. ($page + 2) .'</a></li>';
            if($page + 1 <= $total) $page1right = '<li><a href="tovar.php?'.$url.'page='. ($page + 1) .'">'. ($page + 1) .'</a></li>';

            if ($page+5 < $total)
            {
                $strtotal = '<li><p class="nav-point">...</p></li><li><a href="tovar.php?'.$url.'page='.$total.'">'.$total.'</a></li>';
            }else
            {
                $strtotal = ""; 
            }
            ?>
            <div id="footerfix">
            <?php
                if($total > 1)
                {
                    echo 
                    '
                        <center>
                            <div class="pstrnav">
                                <ul>
                                ';
                                echo $pervpage.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='tovar.php?page=".$page."'>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$nextpage;
                                echo'
                                </ul>
                            </div>
                        </center>    
                    ';
                }
	
            ?>
            </div>

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