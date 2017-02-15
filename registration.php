<?php
    define('myeshop', true);
    session_start();    
    include("include/db_connect.php");
    include("functions/functions.php");
    include("include/auth_cookie.php");
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
    <script type="text/javascript" src="http://shop/js/jquery.form.js"></script> 
    <script type="text/javascript" src="http://shop/js/jquery.validate.js"></script>
    <script type="text/javascript" src="http://shop/js/TextChange.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        $('#form_reg').validate(
        {
             //Правила перевірки
             rules:
             {
                "reg_login":{
                    required: true,
                    minlength: 5,
                    maxlength: 15,
                    remote:{
                        type: "post", 
                        url: "/reg/check_login.php"   
                    }
                },
                "reg_pass":{
                    required: true,
                    minlength: 5,
                    maxlength: 15,
                },
                "reg_surname":{
                    required: true,
                    minlength: 3,
                    maxlength: 20,
                },
                "reg_name":{
                    required: true,
                    minlength: 3,
                    maxlength: 15,
                },
                "reg_patronymic":{
                    required: true,
                    minlength: 3,
                    maxlength: 25,
                },
                 "reg_email":{
                    required: true,
                    email: true,
                },
                 "reg_phone":{
                    required: true
                },
                 "reg_address":{
                    required: true
                },
                 "reg_captcha":{
                    required: true,
                    remote:{
                        type: "post",
                        url: "/reg/check_captcha.php"
                    }
                }
           }, 
            // вивід повідомлень при порушені правил
            messages:
              {
                "reg_login":{
                    required: "Вкажіть Логін!",
                    minlength: "Від 5 до 15 символів!",
                    maxlength: "Від 5 до 15 символів!",
                    remote: "Логін зайнятий!"
                },
                "reg_pass":{
                    required: "Вкажіть Пароль!",
                    minlength: "Від 5 до 15 символів!",
                    maxlength: "Від 5 до 15 символів!"
                },
                "reg_surname":{
                    required: "Вкажіть Вашу фамілію!",
                    minlength: "Від 3 до 20 символів!",
                    maxlength: "Від 3 до 20 символів!" 
                },
                "reg_name":{
                    required: "Вкажіть Ваше імя!",
                    minlength: "Від 3 до 15 символів!",
                    maxlength: "Від 3 до 15 символів!" 
                },
                "reg_patronymic":{
                    required: "Вкажіть як Вас по батькові!",
                    minlength: "Від 3 до 25 символів!",
                    maxlength: "Від 3 до 25 символів!"  
                },
                 "reg_email":{
                    required: "Вкажіть свій E-mail!",
                    remote: "Не коректний E-mail", 
                },
                "reg_phone":{
                    required: "Вкажіть номер телефону!"
                },
                "reg_address":{
                    required: "Необхідно вказати адресу доставки!"
                },
                "reg_captcha":{
                    required: "Введіть код з картинки!",
                    remote: "Не вірний код перевірки!"
                }
              },
            
	submitHandler: function(form){
	$(form).ajaxSubmit({
	success: function(data) { 								 
        if (data == true)
    {
       $("#block-form-registration").fadeOut(300,function() {
        $("#reg_message").addClass("reg_message_good").fadeIn(400).html("Ви успішно зарегістровані!");
        $("#form_submit").hide();  
       });
         
    }
    else
    {
       $("#reg_message").addClass("reg_message_error").fadeIn(400).html(data); 
    }
		} 
			}); 
			}
			});
    	});
    </script>




	<title>Регістрація</title>
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
            <h2 class="h2-title">Регістрація</h2>
            <form method="post" id="form_reg" action="/reg/handler_reg.php">
                <p id="reg_message"></p>
                <div id="block-form-registration">
                    <ul type="none" id="form-registration">
                        <li>
                            <label>Логін</label>
                            <span class="star">*</span>
                            <input type="text" name="reg_login" id="reg_login"/>
                        </li>
                        <li>
                            <label>Пароль</label>
                            <span class="star">*</span>
                            <input type="text" name="reg_pass" id="reg_pass"/>
                            <span id="genpass">Згенерувати</span>
                        </li>
                         <li>
                            <label>Прізвище</label>
                            <span class="star">*</span>
                            <input type="text" name="reg_surname" id="reg_surname"/>
                        </li>
                        <li>
                            <label>Імя</label>
                            <span class="star">*</span>
                            <input type="text" name="reg_name" id="reg_name"/>
                        </li>
                         <li>
                            <label>По батькові</label>
                            <span class="star">*</span>
                            <input type="text" name="reg_patronymic" id="reg_patronymic"/>
                        </li>
                        <li>
                            <label>E-mail</label>
                            <span class="star">*</span>
                            <input type="text" name="reg_email" id="reg_email"/>
                        </li>
                        <li>
                            <label>Мобільний номер</label>
                            <span class="star">*</span>
                            <input type="text" name="reg_phone" id="reg_phone"/>
                        </li>
                        <li>
                            <label>Адреса доставки</label>
                            <span class="star">*</span>
                            <input type="text" name="reg_address" id="reg_address"/>
                        </li>
                        <li>
                            <div id="block-captcha">
                                <img src="/reg/reg_captcha.php" />
                                <input type="text" name="reg_captcha" id="reg_captcha"/>
                                <p id="reloadcaptcha">Обновити</p> 
                            </div>
                        </li>
                    </ul>
                </div>
                <p align="right"><input type="submit" name="reg_submit" id="form_submit" value="Регістрація"/></p>
            </form>
        
            
        </div>
        <?php
	        include("include/block-footer.php");
        ?>
    </div>
</body>
</html>