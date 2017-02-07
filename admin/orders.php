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
   	$_SESSION['urlpage'] = "<a href='index.php'>Головна</a> \ <a href='orders.php'>Замовлення</a>";
    include("include/db_connect.php"); 
    include("include/functions.php"); 
    
    $id = clear_string($_GET["id"]);
    
    $sort = $_GET["sort"];
    switch ($sort)
    {
        case 'all-orders':
        $sort = "order_id DESC";
        $sort_name = 'Від А до Я';
        break;
    
        case 'confirmed':
        $sort = "order_confirmed= 'yes' DESC";
        $sort_name = 'Опрацьовані';
        break;
        
        case 'no-confirmed':
        $sort = "order_confirmed= 'no' DESC";
        $sort_name = 'Не опрацьовані';
        break;
        
        default:
        $sort = "order_id DESC";
        $sort_name = 'Від А до Я';
        break;
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
    
    <title>Панель керування - Замовлення</title>
</head>
<body>
    <div id="block-body">
<?php
    include("include/block-header.php");
    
    $all_count = mysql_query("SELECT * FROM orders", $link);
    $all_count_result = mysql_num_rows($all_count);
    
    $buy_count = mysql_query("SELECT * FROM orders WHERE order_confirmed = 'yes'", $link);
    $buy_count_result = mysql_num_rows($buy_count);
    
    $no_buy_count = mysql_query("SELECT * FROM orders WHERE order_confirmed = 'no'", $link);
    $no_buy_count_result = mysql_num_rows($no_buy_count);
    
    
    
?>
    <div id="block-content">
        <div id="block-parameters">
            <ul id="options-list">
                <li><strong>Фільтрація: </strong></li>
                <li><a id="select-links" href="#"><?php echo $sort_name ?></a>
                    <ul id="list-links-sort">
                        <li><a href="orders.php?sort=all-orders">Від А до Я</a></li>
                        <li><a href="orders.php?sort=confirmed">Опрацьовані</a></li>
                        <li><a href="orders.php?sort=no-confirmed">Не опрацьовані</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div id="block-info-review">
            <ul id="review-info-count">
                <li>Всього замовлень - <strong><?php echo $all_count_result; ?></strong></li>
                <li>Опрацьованих - <strong><?php echo $buy_count_result; ?></strong></li>
                <li>Не опрацьованих - <strong><?php echo $no_buy_count_result; ?></strong></li>
            </ul>
        </div>
        <?php
            $result = mysql_query("SELECT * FROM orders ORDER BY $sort", $link); 
            if(mysql_num_rows($result)>0)
            {
                $row=mysql_fetch_array($result);
                do
                {
                    if($row["order_confirmed"]=='yes')
                    {
                        $status = '<span class="green">Опрацьований</sapn>';
                    }
                    else
                    {
                        $status = '<span class="red">Не опрацьований</sapn>';
                    }
                    echo
                    '
                        <div class="block-order">
                            <p class="order-datetime">'.$row["order_datetime"].'</p>
                            <p class="order-number">Заказ № '.$row["order_id"].' - '.$status.'</p>
                            <p class="order-link"><a class="green" href="view_order.php?id='.$row["order_id"].'">Детально</a></p>
                        </div>
                    ';   
                }
                while($row=mysql_fetch_array($result));
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