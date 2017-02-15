<?php
    define('myeshop', true);
    session_start();
    include("include/db_connect.php");
    include("functions/functions.php");
    include("include/auth_cookie.php");
    $cat = clear_string($_GET["cat"]);
    $type = clear_string($_GET["type"]);

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
	<title>Пошук по параметрах</title>
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
                if($_GET["brand"])
                {
                    $check_brand = implode(',',$_GET["brand"]);
                } 
                $start_price = (int)$_GET["start_price"];
                $end_price = (int)$_GET["end_price"];
                
                if(!empty($check_brand) OR !empty($end_price))
                {
                    if (!empty($check_brand)) $query_brand = " AND brand_id IN($check_brand)";
                    if (!empty($end_price)) $query_price = " AND price BETWEEN $start_price AND $end_price";                    
                }
                
                    
                $result = mysql_query("SELECT * FROM table_products WHERE visible='1' $query_brand $query_price ORDER BY products_id DESC",$link);
                if (mysql_num_rows($result)>0)
                {
                    echo '
                    <div id="block-sorting">
                        <p id="nav-breadcrumbs"><a href="index.php">Головна сторінка</a>\<span>Всі товари</span></p>
                            <ul type="none" id="option-list">
                                <li>Вид:</li>
                                <li><img id="style-grid" src="/images/icon-grid.png" /></li>
                                <li><img id="style-list" src="/images/icon-list.png" /></li>
                            </ul>
                    </div>
        <ul id="block-tovar-grid" type="none">  
                    ';
                    $row = mysql_fetch_array($result);
                    do 
                    {
                        if($row["image"] != "" && file_exists("./uploads_images/".$row["images"]))
                        {
                            $img_path='./uploads_images/'.$row["image"];
                            $max_width = 200;
                            $max_height = 200;
                            list($width, $height) = getimagesize($img_path);
                            $ratioh = $max_height/$height;
                            $ratiow = $max_width/$width;
                            $ratio = min($ratioh,$ratiow);
                            $width = intval($ratio*$width);
                            $height = intval($ratio*$height);
                        }
                        else
                        {
                            $img_path = "/images/no-image.png";
                            $width = 110;
                            $height = 200;
                        }
                        
                        //Кількість відгуків
                        $query_reviews = mysql_query("SELECT * FROM table_reviews WHERE products_id = '{$row["products_id"]}' AND moderat = '1' ",$link);
                        $count_reviews = mysql_num_rows($query_reviews);
                        
                        echo'
                                <li>
                                    <div class="block-images-grid">
                                        <img src="http://shop'.$img_path.'" width="'.$width.'" height = ".$height." />
                                    </div>
                                    <p class="style-title-grid"><a href="http://shop/goods/'.$row["products_id"].'-'.ftranslite($row["title"]).'">'.$row["title"].'</a></p>
                                    <ul class="reviews-and-counts-grid" type="none">
                                        <li>
                                            <img src="/images/eye-icon.png"/>
                                            <p>'.$row["count"].'</p>
                                        </li>
                                        <li>
                                            <img src="/images/comment-icon.png"/>
                                            <p>'.$count_reviews.'</p>
                                        </li>
                                    </ul>
                                    <a class="add-cart-style-grid" tid = "'.$row["products_id"].'"></a>
                                    <p class="style-price-grid"><strong>'.$row["price"].'</strong> грн.</p>
                                    <div class="mini-features">
                                        '.$row["mini_features"].'
                                    </div>
                                </li>
                            ';
                    }
                    while($row = mysql_fetch_array($result));
                
            ?>
        </ul>  
        
        
        <!--Вивід товару, варіант списком-->
        <ul id="block-tovar-list" type="none">  
            <?php
                $result = mysql_query("SELECT * FROM table_products WHERE visible='1' $query_brand $query_price ORDER BY products_id DESC",$link);
                if (mysql_num_rows($result)>0)
                {
                    $row = mysql_fetch_array($result);
                    do 
                    {
                        if($row["image"] != "" && file_exists("./uploads_images/".$row["images"]))
                        {
                            $img_path='./uploads_images/'.$row["image"];
                            $max_width = 150;
                            $max_height = 150;
                            list($width, $height) = getimagesize($img_path);
                            $ratioh = $max_height/$height;
                            $ratiow = $max_width/$width;
                            $ratio = min($ratioh,$ratiow);
                            $width = intval($ratio*$width);
                            $height = intval($ratio*$height);
                        }
                        else
                        {
                            $img_path = "/images/noimages80x70.png";
                            $width = 80;
                            $height = 70;
                        }
                        //Кількість відгуків
                        $query_reviews = mysql_query("SELECT * FROM table_reviews WHERE products_id = '{$row["products_id"]}' AND moderat = '1' ",$link);
                        $count_reviews = mysql_num_rows($query_reviews);
                     
                        echo'
                                <li>
                                    <div class="block-images-list">
                                        <img src="http://shop'.$img_path.'" width="'.$width.'" height = ".$height." />
                                    </div>
                                    
                                    <ul class="reviews-and-counts-list" type="none">
                                        <li>
                                            <img src="/images/eye-icon.png"/>
                                            <p>'.$row["count"].'</p>
                                        </li>
                                        <li>
                                            <img src="/images/comment-icon.png"/>
                                            <p>'.$count_reviews.'</p>
                                        </li>
                                    </ul>
                                    <p class="style-title-list"><a href="http://shop/goods/'.$row["products_id"].'-'.ftranslite($row["title"]).'">'.$row["title"].'</a></p>
                                    <a class="add-cart-style-list" tid = "'.$row["products_id"].'"></a>
                                    <p class="style-price-list"><strong>'.$row["price"].'</strong> грн.</p>
                                    <div class="style-text-list">
                                        '.$row["mini_description"].'
                                    </div>
                                </li>
                            ';
                    }
                    while($row = mysql_fetch_array($result));
                }
                } 
                else
                {
                    echo '<h3>Категорія не доступна або не створена!!!</h3>';
                }
            ?>
        </ul>  
        </div>
        <?php
            include("include/block-random.php");
	        include("include/block-footer.php");
        ?>
    </div>
</body>
</html>