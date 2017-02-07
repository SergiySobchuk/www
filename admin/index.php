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
   	$_SESSION['urlpage'] = "<a href='index.php'>Головна</a>";
    include("include/db_connect.php");    
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/reset.css" rel="stylesheet" type="text/css" />
	<title>Панель керування</title>
</head>
<body>
    <div id="block-body">
<?php
    include("include/block-header.php");
    
    //загальна статистика
    $query1 = mysql_query("SELECT * FROM orders", $link);
    $result1 = mysql_num_rows($query1);
    
    $query2 = mysql_query("SELECT * FROM table_products", $link);
    $result2 = mysql_num_rows($query2);
    
    $query3 = mysql_query("SELECT * FROM table_reviews", $link);
    $result3 = mysql_num_rows($query3);
    
    $query4 = mysql_query("SELECT * FROM reg_user", $link);
    $result = mysql_num_rows($query4);
?>
    <div id="block-content">
        <div id="block-parameters">
            <p id="title-page"><strong>Загальна статистика</strong></p>
        </div>
        
        <ul id="general-statistics">
            <li><p>Замовлень - <span><?php echo $result1; ?></span></p></li>
            <li><p>Товарів - <span><?php echo $result2; ?></span></p></li>
            <li><p>Відгуків - <span><?php echo $result3; ?></span></p></li>
            <li><p>Клієнтів - <span><?php echo $result4; ?></span></p></li>
        </ul>
        
        <h3 id="title-statistics">Статистика продаж</h3>
        
        <table align="center" CELLPADDING="10" WIDTH="100%">
            <tr>
                <th>Дата</th>
                <th>Товар</th>
                <th>Цена</th>
                <th>Статус</th>
            </tr>
        <?php
            $result = mysql_query("SELECT * FROM orders, buy_products WHERE orders.order_pay = 'accepted' AND orders.order_id = buy_products.buy_id_order", $link);
            if(mysql_num_rows($result) > 0)
            {
                $row = mysql_fetch_array($result);
                $total_price = 0;
                do
                {
                    $result2 = mysql_query("SELECT * FROM table_products where products_id='{$row["buy_id_product"]}'", $link);
                    if(mysql_num_rows($result2)>0)
                    {
                        $row2 = mysql_fetch_array($result2);
                    }
                    $total_price = $total_price + $row2["price"];
                    $statuspay = "";
                    if ($row["order_pay"] == "accepted") $statuspay = "Оплачено";
                    echo
                    '
                        <tr>
                            <td align="center">'.$row["order_datetime"].'</td>
                            <td align="center">'.$row2["title"].'</td>
                            <td align="center">'.$row2["price"].'</td>
                            <td align="center">'.$statuspay.'</td>
                        </tr>
                    ';
                }
                while($row = mysql_fetch_array($result));
                echo 
                '
                        <tr id="total_price">
                            <td id align="right" colspan="2">Разом:</td>
                            <td align="center">'.$total_price.'</td>
                            <td align="left">грн.</td>
                        </tr>
                ';
            }
        ?> 
        </table>   
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