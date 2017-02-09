<?php
    session_start();
    define('myeshop', true);
    include("include/db_connect.php");
    include("functions/functions.php");
    include("include/auth_cookie.php");

?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="css/reset.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="trackbar/trackbar.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="/js/jcarousellite_1.0.1.js"></script>
    <script type="text/javascript" src="/js/shop-script.js"></script>
    <script type="text/javascript" src="/js/jquery.cookie.min.js"></script>
    <script type="text/javascript" src="/trackbar/jquery.trackbar.js"></script>
    <script type="text/javascript" src="/js/TextChange.js"></script>
	<title>Інтернет-Магазин Цифрової Техніки</title>
</head>
<body>
    <div id="block-body">
        <?php
	       include("include/block-header.php");
           echo 
           '
           <p id="after-pay-info"><br/><br/><br/><br/>Вітаємо Ваше замовлення прийнято та оплачено.<br/> З Вами зявяжиться менеджер для уточнення деталей.<br/> Дякуюємо, що користуєтесь нашими послугами!!!<br/><br/><br/><br/><br/><br/><br/><br/></p>
           ';
	       include("include/block-footer.php");
        ?>
    </div>
</body>
</html>