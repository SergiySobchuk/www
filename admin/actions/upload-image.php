<?php
	defined('myeshop') or header('Location: ../not_found.php');
    $error_img = array();
    
    if ($_FILES['upload_image']['error'] > 0)
    {
        switch ($_FILES['upload_image']['error'])
        {
            case 1: $error_img[] = 'Розмір файлу перевищує допустиме значення UPLOAD_MAX_SIZE_FILE'; break;
            case 2: $error_img[] = 'Розмір файлу перевищує допустиме значення MAX_SIZE_FILE'; break;
            case 3: $error_img[] = 'Не вдалось завантажити частину файлу'; break;
            case 4: $error_img[] = 'Файл не був загружений'; break;
            case 6: $error_img[] = 'Відсутня тимчасова папка'; break;
            case 7: $error_img[] = 'Не вдається записати файл на диск'; break;
            case 8: $error_img[] = 'PHP-розширення зупинило завантаження файлу'; break;
        }
    }else
    {
        if ($_FILES['upload_image']['type'] == 'image/jpeg' || $_FILES['upload_image']['type'] == 'image/jpg'|| $_FILES['upload_image']['type'] == 'image/png')
        {
            $imgext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES['upload_image']['name']));
            //папка для загрузки
            $uploaddir = '../uploads_images/';
            //новое сгенерированное имя файла
            $newfilename = $_POST["form_type"].'-'.$id.rand(10,100).'.'.$imgext;
            //путь к файлу (папка.файл)
            $uploadfile = $uploaddir.$newfilename;
            //загружаем файл move_uploaded_file
            if (move_uploaded_file($_FILES['upload_image']['tmp_name'], $uploadfile))
            {
                $update = mysql_query("UPDATE table_products SET image='$newfilename' WHERE products_id = '$id'",$link);   
            }
            else
            {
                $error_img[] =  "Ошибка загрузки файла.";    
            }
        }
        else
        {
            $error_img[] =  'Файл основного зображення не завантежено, допустимі розширення: jpeg, jpg, png';
        }
        if($error_img)
        {
            $_SESSION['main_foto'] = "<p id='form-error'>".implode('<br/>', $error_img)."</p>";
        }
    }
?>