<?php
    define('myeshop', true);
    session_start();    
    include("include/db_connect.php");
    include("functions/functions.php");
    include("include/auth_cookie.php");

    $cat = clear_string($_GET["cat"]);
    $type = clear_string($_GET["type"]);

    
    $sorting = $_GET["sort"];
    switch($sorting)
    {
        case 'priceasc';
        $sorting = 'price ASC';
        $sort_name = 'Від дешевих до дорогих';
        break;
        
        case 'pricedesc';
        $sorting = 'price DESC';
        $sort_name = 'Від дорогих до дешевих';
        break;
        
        case 'pricepopular';
        $sorting = 'count DESC';
        $sort_name = 'Популярне';
        break;
        
        case 'pricenews';
        $sorting = 'datetime DESC';
        $sort_name = 'Новинки';
        break;
        
        case 'pricebrand';
        $sorting = 'brand';
        $sort_name = 'Від А до Я';
        break;
        
        default:
        $sorting = 'products_id DESC';
        $sort_name = 'Нема сортування';
        break;
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
                if(!empty($cat) && !empty($type))
                {
                    $querycat = "AND brand='$cat' AND type_tovara = '$type'";
                    $catlink = "$cat-";
                }
                else
                {
                    if(!empty($type))
                    {
                         $querycat = "AND type_tovara = '$type'";
                    }
                    else
                    {
                        $querycat = "";
                    }
                    if(!empty($cat))
                    {
                         $catlink = "$cat";
                    }
                    else
                    {
                        $catlink = "";
                    }
                    
                }
//*************************
                $num = 6; //Кількість одиниць які виводяться на сторінку.
                $page = (int)$_GET['page'];
                $count = mysql_query("SELECT COUNT(*) FROM table_products WHERE visible = '1' $querycat", $link);
                $temp = mysql_fetch_array($count);
                if($temp[0] > 0)
                {
                    $tempcount = $temp[0];
                    //знаходимо загальну к-сть сторінок    
                    $total = (($tempcount-1)/$num)+1;
                    $total = intval($total);
                    
                    $page = intval($page);
                    
                    if (empty($page) or $page < 0) $page = 1;
                    if ($page > $total) $page = $total;
                    
                    //визначаємо з якого номера потрібно виводити товар
                    $start = $page * $num - $num;
                    $query_start_num = "LIMIT $start, $num";
                }
//*************************
            $result = mysql_query("SELECT * FROM table_products WHERE visible='1' $querycat ORDER BY $sorting $query_start_num",$link);
                if (mysql_num_rows($result)>0)
                {
                    echo '
                    <div id="block-sorting">
                        <p id="nav-breadcrumbs"><a>Головна сторінка</a>\<span>Всі товари</span></p>
                            <ul type="none" id="option-list">
                                <li>Вид:</li>
                                <li><img id="style-grid" src="/images/icon-grid.png" /></li>
                                <li><img id="style-list" src="/images/icon-list.png" /></li>
                                <li>Сортувати:</li>
                                <li><a id="select-sort">'.$sort_name.'</a>
                                    <ul type="none" id="sorting-list">
                                        <li><a href="http://shop/cat/'.$catlink.$type.'-priceasc">Від дешевих до дорогих</a></li>
                                        <li><a href="http://shop/cat/'.$catlink.$type.'-pricedesc">Від дорогих до дешевих</a></li>
                                        <li><a href="http://shop/cat/'.$catlink.$type.'-pricepopular">Популярні</a></li>
                                        <li><a href="http://shop/cat/'.$catlink.$type.'-pricenews">Новинки</a></li>
                                        <li><a href="http://shop/cat/'.$catlink.$type.'-pricebrand">Від А до Я</a></li>
                                    </ul>
                                </li>
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
                $result = mysql_query("SELECT * FROM table_products WHERE visible='1' $querycat ORDER BY $sorting $query_start_num",$link);
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
                
//***************************************************
                echo '</ul>';
                
                if ($page != 1) $pstr_prev = '<li><a class="pstr-prev" href="http://shop/cat/'.($page-1).'">&lt;</a></li>';
                if ($page != $total) $pstr_next = '<li><a class="pstr-next" href="http://shop/cat/'.($page+1).'">&gt;</a></li>';
                
                if($page - 5 > 0)$page5left = '<li><a href="http://shop/cat/'.($page-5).'">'.($page-5).'</a></li>';
                if($page - 4 > 0)$page4left = '<li><a href="http://shop/cat/'.($page-4).'">'.($page-4).'</a></li>';
                if($page - 3 > 0)$page3left = '<li><a href="http://shop/cat/'.($page-3).'">'.($page-3).'</a></li>';
                if($page - 2 > 0)$page2left = '<li><a href="http://shop/cat/'.($page-2).'">'.($page-2).'</a></li>';
                if($page - 1 > 0)$page1left = '<li><a href="http://shop/cat/'.($page-1).'">'.($page-1).'</a></li>';
                
                if($page + 5 <= $total) $page5right = '<li><a href="http://shop/cat/'.($page+5).'">'.($page+5).'</a></li>';
                if($page + 4 <= $total) $page4right = '<li><a href="http://shop/cat/'.($page+4).'">'.($page+4).'</a></li>';
                if($page + 3 <= $total) $page3right = '<li><a href="http://shop/cat/'.($page+3).'">'.($page+3).'</a></li>';
                if($page + 2 <= $total) $page2right = '<li><a href="http://shop/cat/'.($page+2).'">'.($page+2).'</a></li>';
                if($page + 1 <= $total) $page1right = '<li><a href="http://shop/cat/'.($page+1).'">'.($page+1).'</a></li>';
                
                if($page+5 < $total)
                {
                    $strtotal = '<li><p class="nav-point">...</p></li><li><a href="http://shop/cat/'.$total.'">'.$total.'</a></li>';
                }
                else
                {
                    $strtotal = "";
                }
                
                if($total > 1)
                {
                    echo 
                    '
                        <div class="pstrnav">
                            <ul type="none">
                    ';       
                    echo $pstr_prev.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='http://shop/cat/".$page."'>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$pstr_next;
                    echo
                    '
                            </ul>
                         </div>
                    ';
                }
//***************************************************                
                
                
            ?>
        </div>
        <?php
            include("include/block-random.php");
	        include("include/block-footer.php");
        ?>
    </div>
</body>
</html>