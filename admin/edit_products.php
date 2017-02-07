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
   	$_SESSION['urlpage'] = "<a href='index.php'>Головна</a> \ <a href='tovar.php?cat=all'>Товари</a> \ <a>Редагування товару</a>";
    include("include/db_connect.php");
    include("include/functions.php");

    $id = clear_string($_GET["id"]);
    
    $action = clear_string($_GET["action"]);
    if(isset($action))
    {
        switch($action)
        {
            case 'delete':
                if (file_exists("../uploads_images/".$_GET["img"]))
                {
                    unlink("../uploads_images/".$_GET["img"]);
                    $delete = mysql_query("UPDATE table_products SET image='' WHERE products_id='$id'", $link);
                }
                break;
        }
    }

    if ($_POST["submit_save"])
    {
        $error = array();
        if(!$_POST["form_title"])
        {
            $error[] = "Вкажіть назву товару";
        }
        if(!$_POST["form_price"])
        {
            $error[] = "Вкажіть ціну";
        }
        if(!$_POST["form_category"])
        {
            $result = mysql_query("SELECT brand FROM table_products WHERE products_id='$id'", $link);
            $row = mysql_fetch_array($result); 
            $selectbrand = $row["brand"];
            $brand_id = $row["brand_id"];

        }
        else
        {
            $result = mysql_query("SELECT brand FROM category WHERE id='{$_POST["form_category"]}'", $link);
            $row = mysql_fetch_array($result);
            $selectbrand = $row["brand"];
            $brand_id = $_POST["form_category"];
        }
        
        
        $result2 = mysql_query("SELECT * FROM table_products WHERE products_id='$id'", $link);
        $image_in_db = mysql_fetch_array($result2); 
        if (empty($image_in_db["image"]) && file_exists("../uploads_images/".$image_in_db["image"]))
        {
            include("actions/upload-image.php");
            unset($_POST["upload_image"]);
        }
        if(empty($_POST["galleryimg"]))
        {
            include("actions/upload-gallery.php");
            unset($_POST["galleryimg"]);
        }
        
        if ($_POST["chk_visible"])
        {
            $chk_visible = "1";
        }else {$chk_visible = "0";}

        if ($_POST["chk_new"])
        {
            $chk_new = "1";
        }else {$chk_new = "0";}

        if ($_POST["chk_leader"])
        {
            $chk_leader = "1";
        }else {$chk_leader = "0";}

        if ($_POST["chk_sale"])
        {
            $chk_sale = "1";
        }else {$chk_sale = "0";}

        if(count($error))
        {
            $_SESSION['message'] = "<p id='form-error'>".implode('<br/>', $error)."</p>";
        }
        else
        {
            $querynew = "title='{$_POST["form_title"]}',price='{$_POST["form_price"]}',brand='$selectbrand',seo_words='{$_POST["form_seo_words"]}',seo_description='{$_POST["form_seo_description"]}',mini_description='{$_POST["txt1"]}',description='{$_POST["txt2"]}',mini_features='{$_POST["txt3"]}',features='{$_POST["txt4"]}',new='$chk_new',leader='$chk_leader',sale='$chk_sale',visible='$chk_visible',type_tovara='{$_POST["form_type"]}',brand_id='$brand_id'";
            $update = mysql_query("UPDATE table_products SET $querynew WHERE products_id='$id'", $link);
            
            $_SESSION['message'] = "<p id='form-success'>Товар &quot;".$_POST['form_title']."&quot; успішно змінено!!!</p>";
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
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>

    <title>Панель керування</title>
</head>
<body>
    <div id="block-body">
<?php
    include("include/block-header.php");
?>
    <div id="block-content">
        <div id="block-parameters">
            <p id="title-page"><strong>Редагування товару</strong></p>
        </div>

<?php
    if(isset($_SESSION['message']))
    {
        echo $_SESSION['message'];
        unset ($_SESSION['message']);
    }
    if(isset($_SESSION['main_foto']))
    {
        echo $_SESSION['main_foto'];
        unset ($_SESSION['main_foto']);
    }
    if(isset($_SESSION['answer']))
    {
        echo $_SESSION['answer'];
        unset ($_SESSION['answer']);
    }

?>
<?php
    $result = mysql_query("SELECT * FROM table_products WHERE products_id = '$id'",$link);
    if(mysql_num_rows($result)>0)
    {
        $row = mysql_fetch_array($result);
        
        do
        {
            echo
            '
        <form enctype="multipart/form-data" method="post">
            <ul id="edit-tovar">
                <li>
                <label>Назва товару</label>
                <input type="text" name="form_title" value="'.$row["title"].'"/>
                </li>
                <li>
                    <label>Ціна</label>
                    <input type="text" name="form_price" value="'.$row["price"].'"/>
                </li>
                <li>
                    <label>Ключові слова</label>
                    <input type="text" name="form_seo_words" value="'.$row["seo_words"].'" />
                </li>
                <li>
                    <label>Короткий опис</label>
                    <textarea name="form_seo_description">'.$row["seo_description"].'</textarea>
                </li>
            ';
                    $category = mysql_query("SELECT * FROM category",$link);
                    if(mysql_num_rows($category) > 0)
                    {
                        $result_category = mysql_fetch_array($category);
                            
                            if ($row["type_tovara"] == "mobile") $type_mobile= "selected";
                            if ($row["type_tovara"] == "notebook") $type_notebook= "selected";
                            if ($row["type_tovara"] == "notepad") $type_notepad= "selected";
                        
                        echo 
                        '
                <li>
                    <label>Тип товару</label>
                    <select name="form_type" id="type" size="1">
                        <option '.$type_mobile.' value="mobile">Мобільні телефони</option>
                        <option '.$type_notebook.' value="notebook">Ноутбуки</option>
                        <option '.$type_notepad.' value="notepad">Планшети</option>
                    </select>
                 </li>
                 <li>
                    
                    <p>Вибрана категорія: <strong>'.$row["type_tovara"].'-'.$row["brand"].'</strong> </p>
                    <select name="form_category" size="10">
                        ';
                        do
                        {
                            echo
                            '
                                <option value="'.$result_category["id"].'">'.$result_category["type"].'-'.$result_category["brand"].'</option>
                            ';
                        }while($result_category = mysql_fetch_array($category));
                    }
                    echo
                    '
                      </select>
                 </li>
            </ul>
            ';
            
            if(strlen($row["image"]) > 0 && file_exists("../uploads_images/".$row["image"]))
            {
                $img_path = '../uploads_images/'.$row["image"];
                $max_width = 110;
                $max_height = 110;
                list($width,$height)= getimagesize($img_path);
                $ratioh = $max_height/$height;
                $ratiow = $max_width/$width;
                $ratio = min($ratioh, $ratiow);
                $width = intval($ratio*$width);
                $height = intval($ratio*$height);
                
                echo 
                '
                    <label class="stylelabel">Основна картинка</label>
                    <div id="baseimg">
                        <img src="'.$img_path.'" width = "'.$width.'" height = "'.$height.'" />
                        <a href="edit_products.php?id='.$row["products_id"].'&img='.$row["image"].'&action=delete"></a>
                    
                    </div>
                ';
            }
            else
            {
                echo 
                '
                <label class="stylelabel">Основна картинка</label>
                <div id="baseimg-upload">
                    <input type="hidden" name="MAX_FILE_SIZE" value="5000000"/>
                    <input type="file" name="upload_image"/>
                </div>
                ';               
            }
            echo '

            <h3 class="h3click">Короткий опис товару</h3>
            <div class="div-editor1">
                <textarea id="editor1" name="txt1" cols="100" rows="20">'.$row["mini_description"].'</textarea>
                <script type="text/javascript">
                    var ckeditor1 = CKEDITOR.replace("editor1");
                    AjexFileManager.init({
                        returnTo: "ckeditor",
                        editor: ckeditor1
                    });
                </script>
            </div>
            <h3 class="h3click">Опис товару</h3>
            <div class="div-editor2">
                <textarea id="editor2" name="txt2" cols="100" rows="20">'.$row["description"].'</textarea>
                <script type="text/javascript">
                    var ckeditor1 = CKEDITOR.replace("editor2");
                    AjexFileManager.init({
                        returnTo: "ckeditor",
                        editor: ckeditor1
                    });
                </script>
            </div>
            <h3 class="h3click">Короткі характеристики</h3>
            <div class="div-editor3">
                <textarea id="editor3" name="txt3" cols="100" rows="20">'.$row["mini_features"].'</textarea>
                <script type="text/javascript">
                    var ckeditor1 = CKEDITOR.replace("editor3");
                    AjexFileManager.init({
                        returnTo: "ckeditor",
                        editor: ckeditor1
                    });
                </script>
            </div>
            <h3 class="h3click">Характеристики</h3>
            <div class="div-editor4">
                <textarea id="editor4" name="txt4" cols="100" rows="20">'.$row["features"].'</textarea>
                <script type="text/javascript">
                    var ckeditor4 = CKEDITOR.replace("editor4");
                    AjexFileManager.init({
                        returnTo: "ckeditor",
                        editor: ckeditor1
                    });
                </script>
            </div>
            <label class="stylelabel">Галерея картинок</label>
            <div id="objects">
                <div id="addimage1" class="addimage">
                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>
                    <input type="file" name="galleryimg[]"/>
                </div>
            </div>
            <p id="add-input">Додати поле</p>
            <ul id="gallery-img">
            ';
            
            $query_img = mysql_query("SELECT * FROM uploads_images WHERE products_id = '$id'", $link);
            if(mysql_num_rows($query_img) > 0)
            {
                $result_img = mysql_fetch_array($query_img);
                do
                {
                    if(strlen($result_img["image"]) > 0 && file_exists("../uploads_images/".$result_img["image"]))
                    {
                        $img_path = '../uploads_images/'.$result_img["image"];
                        $max_width = 100;
                        $max_height = 100;
                        list($width,$height)= getimagesize($img_path);
                        $ratioh = $max_height/$height;
                        $ratiow = $max_width/$width;
                        $ratio = min($ratioh, $ratiow);
                        $width = intval($ratio*$width);
                        $height = intval($ratio*$height);
                    }
                    else
                    {
                        $img_path = '../images/noimages.png';
                        $width = 80;
                        $height = 70;
                    }
                    echo
                    '
                        <li id="del'.$result_img["id"].'">
                            <img src="'.$img_path.'" width = "'.$width.'" height = "'.$height.'" title = "'.$result_img["image"].'"/>
                            <a class="del-img" img_id="'.$result_img["id"].'"></a>
                        </li>
                    ';
                }while($result_img = mysql_fetch_array($query_img));
            }
            echo
            '
            </ul>
            ';
            
            if ($row["visible"] == "1") $checked1= "checked";
            if ($row["new"] == "1") $checked2= "checked";
            if ($row["leader"] == "1") $checked3= "checked";
            if ($row["sale"] == "1") $checked4= "checked";
            
            echo
            '
            <h3 class="h3title">Налаштування товару</h3>
            <ul id="chkbox">
                <li><input type="checkbox" name="chk_visible" id="chk_visible" '.$checked1.'/><label for="chk_visible">Показати товар</label></li>
                <li><input type="checkbox" name="chk_new" id="chk_new" '.$checked2.'/><label for="chk_new">Новий товар</label></li>
                <li><input type="checkbox" name="chk_leader" id="chk_leader" '.$checked3.'/><label for="chk_leader">Популяринй товар</label></li>
                <li><input type="checkbox" name="chk_sale" id="chk_sale" '.$checked4.'/><label for="chk_sale">Товар по знижці</label></li>
            </ul>
            <p align="right"><input type="submit" id="submit_form" name="submit_save" value="Зберегти"/></p>
         </div>
       </form>
                    ';
        } while($row = mysql_fetch_array($result));
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