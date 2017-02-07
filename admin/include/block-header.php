<?php
	defined('myeshop') or header('Location: ../not_found.php');
    
    $result1 = mysql_query("SELECT * FROM orders WHERE order_confirmed='no'", $link);
    $count1 = mysql_num_rows($result1);
    
    if($count1 > 0) {$count_str1 = '<p>+'.$count1.'</p>';} else {$count_str1 = '';}
    
    $result2 = mysql_query("SELECT * FROM table_reviews WHERE moderat='0'", $link);
    $count2 = mysql_num_rows($result2);
    
    if($count2 > 0) {$count_str2 = '<p>+'.$count2.'</p>';} else {$count_str2 = '';}
    
?>
<div id="block-header">
    <div id="block-header1">
        <h3>IT-SHOP. Панель керування</h3>
        <p id="link-nav"><?php
	                       echo $_SESSION['urlpage'];
                        ?>
        </p>
    </div>
    
    <div id="block-header2">
        <p align="right"><a href="administrators.php">Адміністратори</a> | <a href="?logout">ВИХІД</a></p>
        <p align="right">Ви - 5354353452345<span></span></p>
    </div>
</div>
<div id="left-nav">
    <ul>
        <li><a href="orders.php">Замовлення</a><?php echo $count_str1 ?></li>
        <li><a href="tovar.php?cat=all">Товари</a></li>
        <li><a href="reviews.php">Відгуки</a><?php echo $count_str2 ?></li>
        <li><a href="category.php">Категорії</a></li>
        <li><a href="clients.php">Клієнти</a></li>
        <li><a href="news.php">Новини</a></li>
    </ul>
</div>
