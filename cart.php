<?php
    define('myeshop', true);
    session_start(); 
    include("include/db_connect.php");
    include("functions/functions.php");
    include("include/auth_cookie.php");
    
    $id = clear_string($_GET["id"]);
    $action = clear_string($_GET["action"]);
    
    switch ($action)
    {
        case 'clear':
        $clear = mysql_query("DELETE FROM cart WHERE cart_ip='{$_SERVER['REMOTE_ADDR']}'",$link);
        break;
        
        case 'delete':
        $delete = mysql_query("DELETE FROM cart WHERE cart_id ='$id' AND cart_ip='{$_SERVER['REMOTE_ADDR']}'",$link);   
        break;
    }

    if (isset($_POST["submitdata"]))
    {
        if ( $_SESSION['auth'] == 'yes_auth' ) 
        {
            mysql_query("INSERT INTO orders(order_datetime,order_dostavka,order_fio,order_address,order_phone,order_note,order_email)
						VALUES(	
                             NOW(),
                            '".$_POST["order_delivery"]."',					
							'".$_SESSION['auth_surname'].' '.$_SESSION['auth_name'].' '.$_SESSION['auth_patronymic']."',
                            '".$_SESSION['auth_address']."',
                            '".$_SESSION['auth_phone']."',
                            '".$_POST['order_note']."',
                            '".$_SESSION['auth_email']."'                              
						    )",$link);         

        }
        else
        {
            $_SESSION["order_delivery"] = $_POST["order_delivery"];
            $_SESSION["order_fio"] = $_POST["order_fio"];
            $_SESSION["order_email"] = $_POST["order_email"];
            $_SESSION["order_phone"] = $_POST["order_phone"];
            $_SESSION["order_address"] = $_POST["order_address"];
            $_SESSION["order_note"] = $_POST["order_note"];

            mysql_query("INSERT INTO orders(order_datetime,order_dostavka,order_fio,order_address,order_phone,order_note,order_email)
						VALUES(	
                             NOW(),
                            '".clear_string($_POST["order_delivery"])."',					
							'".clear_string($_POST["order_fio"])."',
                            '".clear_string($_POST["order_address"])."',
                            '".clear_string($_POST["order_phone"])."',
                            '".clear_string($_POST["order_note"])."',
                            '".clear_string($_POST["order_email"])."'                   
						    )",$link);    
        }
        $_SESSION["order_id"] = mysql_insert_id();                          
                            
        $result = mysql_query("SELECT * FROM cart WHERE cart_ip = '{$_SERVER['REMOTE_ADDR']}'",$link);
        If (mysql_num_rows($result) > 0)
        {
            $row = mysql_fetch_array($result);    

            do
            {
                mysql_query("INSERT INTO buy_products(buy_id_order,buy_id_product,buy_count_product)
						VALUES(	
                            '".$_SESSION["order_id"]."',					
							'".$row["cart_id_products"]."',
                            '".$row["cart_count"]."'                   
						    )",$link);

            } while ($row = mysql_fetch_array($result));
        }
                            
        header("Location: http://shop/cart/completion");
    }      

    $result = mysql_query("SELECT * FROM cart, table_products WHERE cart.cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND table_products.products_id = cart.cart_id_products", $link);    
    If (mysql_num_rows($result) > 0);
    {
        $row = mysql_fetch_array($result);
        do
        {
            $int = $int + ($row["cart_price"] * $row["cart_count"]);
        }
        while ($row = mysql_fetch_array($result));
        
        $itogpricecart = $int;
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
	<title>Кошик замовлень</title>
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
                $action = clear_string($_GET["action"]);
                switch ($action)
                {
                    case 'oneclick':
                    echo
                    '
                        <div id ="block-step">
                            <div id="name-step">
                                <ul type="none">
                                    <li>
                                        <a class="active">1. Кошик товарів</a>
                                    </li>
                                    <li>
                                        <span>&rarr;</span>
                                    </li>
                                    <li>
                                        <a>2. Контактна інформація</a>
                                    </li>
                                    <li>
                                        <span>&rarr;</span>
                                    </li>
                                    <li>
                                        <a>3. Завершення</a>
                                    </li>
                                </ul>
                            </div>
                            <p>крок 1 з 3</p>
                            <a href="http://shop/cart/clear">Очистити</a>
                        </div>
                    ';
                    
                    
                    $result = mysql_query("SELECT * FROM cart, table_products WHERE cart.cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND table_products.products_id= cart.cart_id_products", $link);
                    If (mysql_num_rows($result) > 0)
                    {
                          $row = mysql_fetch_array($result);
                        echo
                        '
                            <div id="header-list-cart">
                                <div id="head1">Зображення</div>
                                <div id="head2">Найменування товару</div>
                                <div id="head3">К-сть</div>
                                <div id="head4">Ціна</div>
                            </div>
                        ';
                        do 
                        {
                            $int =  $row["cart_price"]  *  $row["cart_count"];
                            $all_price = $all_price + $int;
                            if(strlen($row["image"]) > 0 && file_exists("./uploads_images/".$row["image"]))
                            {
                                $img_path = './uploads_images/'.$row["image"];
                                $max_width = 100;
                                $max_height = 100;
                                
                                list($width, $height) = getimagesize($img_path);
                                
                                $ratioh = $max_height/$height;
                                $ratiow = $max_width/$width;
                                $ratio = min($ratioh, $ratiow);
                                
                                $width = intval($ratio*$width);
                                $height = intval($ratio*$height);
                            }
                            else
                            {
                                $img_path = "/images/noimages.jpeg";
                                $width = 120;
                                $height = 105;                                    
                            }
                            echo
                            '
                                <div class="block-list-cart">
                                        <div class="img-cart">
                                            <p align="center"><img src="http://shop/'.$img_path.'" width= "'.$width.'" height="'.$height.'" /></p>
                                        </div>
                            
                                    <div class="title-cart">
                                        <p><a href="http://shop/goods/'.$row["products_id"].'-'.ftranslite($row["title"]).'">'.$row["title"].'</a></p>
                                        <p class="cart-mini-features">'.$row["mini_features"].'</p>
                                    </div>
                            
                                    <div class="count-cart">
                                        <ul type="none" class="input-count-style">
                                            <li>
                                                <p align="center" iid = "'.$row["cart_id"].'" class="count-minus">-</p>
                                            </li>
                                            <li>
                                                <p align="center"><input id="input-id'.$row["cart_id"].'" iid = "'.$row["cart_id"].'" class="count-input" maxlength="3" type="text" value='.$row["cart_count"].' /></p>
                                            </li>
                                            <li>
                                                <p align="center" class="count-plus" iid = "'.$row["cart_id"].'">+</p>
                                            </li>
                                        </ul>
                                    </div>
                            
                                    <div id="tovar'.$row["cart_id"].'" class="price-product"><h5><span class="span-count">'.$row["cart_count"].'</span> x <span>'.$row["cart_price"].'</span></h5><p price="'.$row["cart_price"].'">'.group_numerals($int).' грн</p></div>
                                    <div class="delete-cart"><a href="http://shop/cart/'.$row["cart_id"].'-delete"><img src="/images/bsk_item_del.png"/></a></div>
                                    <div id="bottom-cart-line"></div>
                                </div>
                    
                            ';
                        }
                        while ($row = mysql_fetch_array($result));
                        
                        echo
                        '
                            <h2 class="itog-price" align="right">Разом: <strong>'.group_numerals($all_price).'</strong> грн</h2>
                            <p align="right" class="button-next"><a href="http://shop/cart/confirm"> Далі</a></p>   
                        ';
                    
                    }
                    else
                    {
                        echo
                        '
                            <h3 id="clear-cart" align="center">Кошик пустий</h3>
                        ';
                    }
                    
                    
                         
                    break;
        
                    case 'confirm':
                    echo
                    '
                        <div id ="block-step">
                            <div id="name-step">
                                <ul type="none">
                                    <li>
                                        <a href="http://shop/cart/oneclick">1. Кошик товарів</a>
                                    </li>
                                    <li>
                                        <span>&rarr;</span>
                                    </li>
                                    <li>
                                        <a class="active">2. Контактна інформація</a>
                                    </li>
                                    <li>
                                        <span>&rarr;</span>
                                    </li>
                                    <li>
                                        <a>3. Завершення</a>
                                    </li>
                                </ul>
                            </div>
                            <p>крок 2 з 3</p>
                        </div>
                    ';
                    
                    
                    if($_SESSION['order_delivery']== "Поштою") $chck1 = "checked";
                    if($_SESSION['order_delivery']== "Курєром") $chck2 = "checked";
                    if($_SESSION['order_delivery']== "Самовивіз") $chck3 = "checked";
                                       
                    echo'
                        <h3 class="title-h3"> Спосіб доставки:</h3>
                        <form method="post">
                            <ul id="info-radio" type="none">
                                <li>
                                    <input type="radio" name="order_delivery" class="order_delivery" id="order_delivery1" value="Поштою" '.$chck1.' />
                                    <label class="label_delivery" for="order_delivery1">Поштою</label>
                                <li/>
                                <li>
                                    <input type="radio" name="order_delivery" class="order_delivery" id="order_delivery2" value="Курєром" '.$chck2.' />
                                    <label class="label_delivery" for="order_delivery2">Курєром</label>
                                <li/>
                                <li>
                                    <input type="radio" name="order_delivery" class="order_delivery" id="order_delivery3" value="Сомовивіз" '.$chck3.' />
                                    <label class="label_delivery" for="order_delivery3">Сомовивіз</label>
                                <li/>
                            </ul>
                            <h3 class="title-h3"> Інформація для доставки:</h3>
                            <ul id="info-order" type="none">
                                ';
                                if($_SESSION['auth'] != 'yes_auth')
                                {
                                echo'
                                <li>
                                    <label for="order_fio"><span>*</span>ПІБ</label> <input type="text" name="order_fio" id="order_fio" value="'.$_SESSION["order_fio"].'" /><span class="order_span_style">Наприклад: Пономаренко Андрій Олегович </span>
                                </li>
                                <li>
                                    <label for="order_email"><span>*</span>E-mail</label> <input type="text" name="order_email" id="order_email" value="'.$_SESSION["order_email"].'" /><span class="order_span_style">Наприклад: Ponomarenko@ukr.net </span>
                                </li>
                                <li>
                                    <label for="order_phone"><span>*</span>Телефон</label> <input type="text" name="order_phone" id="order_phone" value="'.$_SESSION["order_phone"].'" /><span class="order_span_style">Наприклад: +38063-43-332-534 </span>
                                </li>
                                <li>
                                    <label class="order_label_style_address" for="order_address"><span>*</span>Адреса <br/> доставки</label> <input type="text" name="order_address" id="order_address" value="'.$_SESSION["order_address"].'" /><span class="order_span_style_address">Наприклад: м.Київ, <br/> вул.Переможців, б 31, кв 14 </span>
                                </li>   
                                ';   
                                }                    
                                echo' 
                                <li>
                                    <label class="order_label_style" for="order_note">Примітки</label> <textarea name="order_note">'.$_SESSION["order_note"].' </textarea><span class= "order_span_style_note">Уточніть інформацію про замовлення.<br/> Наприклад, зручний час для дзвінка <br/> нашого менеджера.</span>
                                </li>
                                <p align="right"><input type="submit" name="submitdata" id="confirm-button-next" value="Далі"></p>           
                            </ul>
                        </form>
                    
                    ';
                    
                    break;

                    case 'completion':
                    echo
                        '
                            <div id ="block-step">
                                <div id="name-step">
                                    <ul type="none">
                                        <li>
                                            <a href="http://shop/cart/oneclick">1. Кошик товарів</a>
                                        </li>
                                        <li>
                                            <span>&rarr;</span>
                                        </li>
                                        <li>
                                            <a href="http://shop/cart/confirm">2. Контактна інформація</a>
                                        </li>
                                        <li>
                                            <span>&rarr;</span>
                                        </li>
                                        <li>
                                            <a class="active">3. Завершення</a>
                                        </li>
                                    </ul>
                                </div>
                                <p>крок 3 з 3</p>
                            </div>
                            <h3>Кінцева інформація:</h3>                    
                        ';                   
                      
                        if ( $_SESSION['auth'] == 'yes_auth' ) 
                        {
                            echo 
                                '
                                    <ul id="list-info" type="none">
                                        <li><strong>Спосіб доставки:</strong>'.$_SESSION['order_delivery'].'</li>
                                        <li><strong>Email:</strong>'.$_SESSION['auth_email'].'</li>
                                        <li><strong>ПІБ:</strong>'.$_SESSION['auth_surname'].' '.$_SESSION['auth_name'].' '.$_SESSION['auth_patronymic'].'</li>
                                        <li><strong>Адреса доставки:</strong>'.$_SESSION['auth_address'].'</li>
                                        <li><strong>Телефон:</strong>'.$_SESSION['auth_phone'].'</li>
                                        <li><strong>Примітка: </strong>'.$_SESSION['order_note'].'</li>
                                    </ul>
                                ';
                        }
                        else
                        {
                            echo '
                                <ul id="list-info" type="none">
                                    <li><strong>Спосіб доставки:</strong>'.$_SESSION['order_delivery'].'</li>
                                    <li><strong>Email:</strong>'.$_SESSION['order_email'].'</li>
                                    <li><strong>ПІБ:</strong>'.$_SESSION['order_fio'].'</li>
                                    <li><strong>Адреса доставки:</strong>'.$_SESSION['order_address'].'</li>
                                    <li><strong>Телефон:</strong>'.$_SESSION['order_phone'].'</li>
                                    <li><strong>Примітка: </strong>'.$_SESSION['order_note'].'</li>
                                </ul>

                            ';    
                        }
                        echo '
                            <h2 class="itog-price" align="right">Разом: <strong>'.$itogpricecart.'</strong> грн.</h2>
                            <form method="post" action="https://wl.walletone.com/checkout/checkout/Index" accept-charset="UTF-8">
                                <input type="hidden" name="WMI_MERCHANT_ID"    value="176679885394"/>
                                <input type="hidden" name="WMI_PAYMENT_AMOUNT" value="1"/>
                                <input type="hidden" name="WMI_CURRENCY_ID"    value="980"/>
                                <input type="hidden" name="WMI_PAYMENT_NO"     value="'.$_SESSION["order_id"].'"/>
                                <input type="hidden" name="WMI_DESCRIPTION"    value="Оплата демонстраційного замовлення"/>
                                <input type="hidden" name="WMI_PTENABLED"      value="WalletOneUAH"/>
                                <input type="hidden" name="WMI_PTENABLED"      value="LiqPayMoneyUAH"/>
                                <input type="hidden" name="WMI_PTENABLED"      value="PrivatbankUAH"/>
                                <input type="hidden" name="WMI_PTENABLED"      value="WebMoneyUAH"/>
                                <input type="hidden" name="WMI_PTENABLED"      value="CreditCardUAH"/>
                                <input type="hidden" name="WMI_SUCCESS_URL"    value="http://it-shop.zzz.com.ua/paid.php"/>
                                <input type="hidden" name="WMI_FAIL_URL"       value="http://it-shop.zzz.com.ua/fail.php"/>
                                <input type="submit" id="pay_buttom" value="Оплатити">
                            </form>
                        ';
                    break;
                    
                    default:
                    echo
                    '
                        <div id ="block-step">
                            <div id="name-step">
                                <ul type="none">
                                    <li>
                                        <a class="active">1. Кошик товарів</a>
                                    </li>
                                    <li>
                                        <span>&rarr;</span>
                                    </li>
                                    <li>
                                        <a>2. Контактна інформація</a>
                                    </li>
                                    <li>
                                        <span>&rarr;</span>
                                    </li>
                                    <li>
                                        <a>3. Завершення</a>
                                    </li>
                                </ul>
                            </div>
                            <p>крок 1 з 3</p>
                            <a href="http://shop/cart/clear">Очистити</a>
                        </div>
                    ';
                    
                    
                    $result = mysql_query("SELECT * FROM cart, table_products WHERE cart.cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND table_products.products_id= cart.cart_id_products", $link);
                    If (mysql_num_rows($result) > 0)
                    {
                          $row = mysql_fetch_array($result);
                        echo
                        '
                            <div id="header-list-cart">
                                <div id="head1">Зображення</div>
                                <div id="head2">Найменування товару</div>
                                <div id="head3">К-сть</div>
                                <div id="head4">Ціна</div>
                            </div>
                        ';
                        do 
                        {
                            $int =  $row["cart_price"]  *  $row["cart_count"];
                            $all_price = $all_price + $int;
                            if(strlen($row["image"]) > 0 && file_exists("./uploads_images/".$row["image"]))
                            {
                                $img_path = './uploads_images/'.$row["image"];
                                $max_width = 100;
                                $max_height = 100;
                                
                                list($width, $height) = getimagesize($img_path);
                                
                                $ratioh = $max_height/$height;
                                $ratiow = $max_width/$width;
                                $ratio = min($ratioh, $ratiow);
                                
                                $width = intval($ratio*$width);
                                $height = intval($ratio*$height);
                            }
                            else
                            {
                                $img_path = "/images/noimages.jpeg";
                                $width = 120;
                                $height = 105;                                    
                            }
                            echo
                            '
                                   <div class="block-list-cart">
                                        <div class="img-cart">
                                            <p align="center"><img src="http://shop'.$img_path.'" width= "'.$width.'" height="'.$height.'" /></p>
                                        </div>
                            
                                    <div class="title-cart">
                                        <p><a href="http://shop/goods/'.$row["products_id"].'-'.ftranslite($row["title"]).'">'.$row["title"].'</a></p>
                                        <p class="cart-mini-features">'.$row["mini_features"].'</p>
                                    </div>
                            
                                    <div class="count-cart">
                                        <ul type="none" class="input-count-style">
                                            <li>
                                                <p align="center" iid = "'.$row["cart_id"].'" class="count-minus">-</p>
                                            </li>
                                            <li>
                                                <p align="center"><input id="input-id'.$row["cart_id"].'" iid = "'.$row["cart_id"].'" class="count-input" maxlength="3" type="text" value='.$row["cart_count"].' /></p>
                                            </li>
                                            <li>
                                                <p align="center" class="count-plus" iid = "'.$row["cart_id"].'">+</p>
                                            </li>
                                        </ul>
                                    </div>
                            
                                    <div id="tovar'.$row["cart_id"].'" class="price-product"><h5><span class="span-count">'.$row["cart_count"].'</span> x <span>'.$row["cart_price"].'</span></h5><p price="'.$row["cart_price"].'">'.group_numerals($int).' грн</p></div>
                                    <div class="delete-cart"><a href="http://shop/cart/'.$row["cart_id"].'-delete"><img src="/images/bsk_item_del.png"/></a></div>
                                    <div id="bottom-cart-line"></div>
                                </div>
                                       
                            ';
                        }
                        while ($row = mysql_fetch_array($result));
                        
                        echo
                        '
                            <h2 class="itog-price" align="right">Разом: <strong>'.group_numerals($all_price).'</strong> грн</h2>
                            <p align="right" class="button-next"><a href="http://shop/cart/confirm"> Далі</a></p>   
                        ';
                    }
                    else
                    {
                        echo
                        '
                            <h3 id="clear-cart" align="center">Кошик пустий</h3>
                        ';
                    }
                    break;
                }
            ?>
        </div>
        <?php
	        include("include/block-footer.php");
        ?>
    </div>
</body>
</html>