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
   	$_SESSION['urlpage'] = "<a href='index.php'>Головна</a> \ <a>Перегляд замовлення</a>";
    include("include/db_connect.php"); 
    include("include/functions.php"); 
    
    $id = clear_string($_GET["id"]);
    
    $action = $_GET["action"];
    if(isset($action))
    {
        switch ($action)
        {
            case 'accept':
                if ($_SESSION['accept_orders'] == '1')
                {
                    $update = mysql_query("UPDATE orders SET order_confirmed='yes' WHERE order_id='$id'", $link);
                }
                else
                {
                  $msgerror = 'У Вас немає прав на підтвердження замовлення!!!';
                };
            break;
            
            case 'no-accept':
                if ($_SESSION['accept_orders'] == '1')
                {
                    $update = mysql_query("UPDATE orders SET order_confirmed='no' WHERE order_id='$id'", $link);
                }
                else
                {
                  $msgerror = 'У Вас немає прав на зміну статусу замовлення!!!';
                };
            break;
            
            case 'delete':
                if($_SESSION['delete_orders'] == '1')
                {
                    $delete = mysql_query("DELETE FROM orders WHERE order_id='$id'",$link);
                    $delete1 = mysql_query("DELETE FROM buy_products WHERE buy_id_order='$id'",$link);
                    header("Location: orders.php");
                }
                else
                {
                    $msgerror = 'У Вас немає прав на видалення замовлення!!!';
                } 
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
    
    <title>Панель керування - Перегляд замовлення</title>
</head>
<body>
    <div id="block-body">
<?php
    include("include/block-header.php");
?>
    <div id="block-content">
        <div id="block-parameters">
            <p id="title-page"><strong>Перегляд замовлення</strong></p>
        </div>
        <?php
        if(isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';
        
        if($_SESSION['view_orders'] =='1')
        {
        
	       $result = mysql_query("SELECT * FROM orders WHERE order_id = '$id'", $link); 
           if (mysql_num_rows($result) > 0)
                    {
                        $row = mysql_fetch_array($result);
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
                                    <p class="view-order-link"><a class="green" href="view_order.php?id='.$row["order_id"].'&action=accept">Підтвердити</a> | <a class="orange" href="view_order.php?id='.$row["order_id"].'&action=no-accept">Доопрацювати</a> | <a class="delete" rel="view_order.php?id='.$row["order_id"].'&action=delete">Видалити замовлення</a></p>
                                    <p class="order-datetime">'.$row["order_datetime"].'</p>
                                    <p class="order-number">Заказ № '.$row["order_id"].' - '.$status.'</p>
                                </div> 
                                
                                    <table align-"center" cellpadding="10" width="100%">
                                        <tr>
                                            <th>№</th>
                                            <th>Найменування товару</th>
                                            <th>Ціна</th>
                                            <th>Кількість</th>
                                    </tr>
                             ';
                             $query_products = mysql_query("SELECT * FROM buy_products, table_products WHERE  buy_products.buy_id_order = '$id' AND table_products.products_id = buy_products.buy_id_product", $link);
                             $result_query = mysql_fetch_array($query_products);
                             do
                             {
                                 $price = $price + ($result_query["price"] * $result_query["buy_count_product"]);
                                 $index_count = $index_count + 1;
                                 echo
                                 '  
                                    <tr>
                                        <td align="center">'.$index_count.'</td>
                                        <td align="center">'.$result_query["title"].'</td>
                                        <td align="center">'.$result_query["price"].'</td>
                                        <td align="center">'.$result_query["buy_count_product"].'</td>
                                    </tr>  
                                 ';
                             }
                             while($result_query = mysql_fetch_array($query_products));
                             
                             if($row["order_pay"] == "accepted")
                             {
                                $statpay = '<span class="green">Оплачено</span>';
                             }
                             else
                             {
                                $statpay = '<span class="red">Не оплачено</span>';
                             }
                             echo
                             '
                                </table>
                                <ul id="info_order">
                                    <li> Загальна ціна - <span>'.$price.'</span> грн.</li>
                                    <li> Спосіб доставки - <span>'.$row["order_dostavka"].'</span></li>
                                    <li> Статус оплати - '.$statpay.'</li>
                                    <li> Тип оплати - <span>'.$row["order_type_pay"].'</span></li>
                                    <li> Дата оплати - <span>'.$row["order_datetime"].'</span></li>
                                </ul>  
                                
                                <table align-"center" cellpadding="10" width="100%">
                                    <tr>
                                        <th>ПІБ</th>
                                        <th>Адреса</th>
                                        <th>Контакти</th>
                                        <th>Примітки</th>
                                    </tr>
                                    <tr>
                                        <td align="center">'.$row["order_fio"].'</td>
                                        <td align="center">'.$row["order_address"].'</td>
                                        <td align="center">'.$row["order_phone"].'</td>
                                        <td align="center">'.$row["order_note"].'</td>
                                    </tr>
                                </table>
                             ';
                        }
                        while($row = mysql_fetch_array($result));
                    }
         }
         else
         {
            echo 
            '
                <p id="form-error" align="center">У Вас немає прав на перегляд даного розділу!!!</p>
            ';
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