<?php
   //defined('myeshop') or die('code 404, page not found.');
    defined('myeshop') or header('Location: ../not_found.php');
?>
<!--Основний блок-->
<div id="block-header">
    <!--Верхний блок з навігацією-->
    <div id="heder-top-block">
        <!--Список з навігацією-->
        <ul type="none" id="heder-top-menu">
            <li>Ваше місто - <span>Львів</span></li>
            <li><a href="#">Про нас</a></li>
            <li><a href="#">Магазини</a></li>
            <li><a href="http://shop/feedback/">Зворотній звязок</a></li>
        </ul>
        <!--Вхід і регістрація-->
        <?php
            $s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
            $user = json_decode($s, true);
            //$user['network'] - соц. сеть, через которую авторизовался пользователь
            //$user['identity'] - уникальная строка определяющая конкретного пользователя соц. сети
            //$user['first_name'] - имя пользователя
            //$user['last_name'] - фамилия пользователя
            if (strlen($user['network']) > 0)
            {
               $_SESSION['auth'] == 'yes_auth';
               $_SESSION['auth_name'] == $user['first_name'];
            }        
                

            if ($_SESSION['auth'] == 'yes_auth')
            {
                echo '<p id="auth-user-info" align="right"><img src="/images/user.png" />Привіт, '.$_SESSION['auth_name'].'!</p>';   
            }
            else
            {
                echo 
                '
                    <p id="reg-auth-title" align="right"><a class="top-auth">Вхід</a><a href="http://shop/registration/">Регістрація</a></p>
                    <span id="soc-mer">Регістрація через соц. мережі:</span>
                    <script src="//ulogin.ru/js/ulogin.js"></script>
                    <div id="uLogin" data-ulogin="display=small;theme=classic;fields=first_name,last_name;providers=vkontakte,odnoklassniki,mailru,facebook;hidden=other;redirect_uri=http%3A%2F%2Fit-shop.zzz.com.ua%2Fblock-header.php;mobilebuttons=0;"></div>                
                ';   
            }
        ?>
        <div id="block-top-auth">
            <div class="corner"></div>
            <form method="post">
                <ul id="input-email-pass">
                    <h3>Вхід</h3>
                    <p id="message-auth">Невірний Логин і/або Пароль</p>
                    <li><center><input type="text" id="auth_login" placeholder="Логін або E-mail" /></center></li>
                    <li><center><input type="password" id="auth_pass" placeholder="Пароль" /><span id="button-pass-show-hide" class="pass-show"></span></center></li>
                    <ul id="list-auth">
                        <li><input type="checkbox" name="rememberme" id="rememberme" /><label for="rememberme">Запамятати меня</label></li>
                        <li><a id="remindpass" href="#">Забув пароль?</a></li>
                    </ul>
                    <p align="right" id="button-auth" ><a>Вхід</a></p>
                    <p align="right" class="auth-loading"><img src="/images/loading.gif" /></p>
                </ul>
            </form>
            <!--Область "забув пароль"-->
            <div id="block-remind">
                <h3>Відновлення <br/> пароля</h3>
                <p id="message-remind" class="message-remind-success"></p>
                <center><input type="text" id="remind-email" placeholder="Ваш E-mail"/></center>
                <p align="right" id="button-remind"><a>Готово</a></p>
                <p align="right" class="auth-loading"><img src="/images/loading.gif"/></p>
                <p id="prev-auth">Назад</p>
            </div>
        </div>
    </div>
    <!--Лінія-->
    <div id="top-line"></div>
    
    <div id="block-user">
        <div class="corner2"></div>
        <ul type="none">
            <li><img src="/images/user_info.png"/><a href="http://shop/profile/">Профіль</a></li>
            <li><img src="/images/logout.png" /><a id="logout">Вихід</a></li>
        </ul>
    </div>
    
    
    <!--Логотоп-->
    <img id="img-logo" src="/images/logo.png" />
    <!--Інформаційний блок-->
    <div id="personal-info">
        <p id="phone-free" align="right">Дзвінки безкоштовні</p> 
        <h3 align="right"> 0(800)937-99-92</h3>
        <img src="/images/phone-icon.png" />    
        <p align="right">Режим роботи:</p> 
        <p align="right">Будні дні: з 9:00 до 18:00</p>
        <p align="right">Субота, Неділя - вихідні.</p> 
        <img src="/images/time-icon.png" />   
    </div>
    <!--Пошук-->
    <div id="block-search">
        <form method="GET" action="http://shop/search.php?q=">
            <span></span>
            <input type="text" id="input-search" name="q" placeholder="Пошук серед більше 100 000 товарів" value="<?php echo $search ?>"/>
            <input type="submit" id="buttom-search" value="Пошук"/>
        </form>
        <ul type="none" id="result-search">
            
        </ul>
    </div>
</div>
<!--Верхнє меню-->
<div id="top-menu">
    <ul type="none">
        <li><img src="/images/shop.png" /><a href="http://shop/index/">Головна</a></li>
        <li><img src="/images/new-32.png" /><a href="http://shop/index/news">Новинки</a></li>
        <li><img src="/images/bestprice-32.png" /><a href="http://shop/index/leaders">Лідери продаж</a></li>
        <li><img src="/images/sale-32.png" /><a href="http://shop/index/sale">Розпродажі</a></li>
    </ul>
    <p align="right" id="block-basket"><img src="/images/cart-icon.png"/><a href="http://shop/cart/oneclick">Кошик пустий</a></p>
    <div id="nav-line"></div>
</div>