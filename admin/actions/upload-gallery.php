<?php
    defined('myeshop') or header('Location: ../not_found.php');
    if ($_FILES['galleryimg']['name'][0])
    {
        for($i = 0; $i < count($_FILES['galleryimg']['name']); $i++)
        {
            $error_gallery = "";
            if($_FILES['galleryimg']['name'][$i])
            
            $galleryImgType =  $_FILES['galleryimg']['type'][$i];
            $types = array("image/gif", "image/png", "image/jpg", "image/jpeg");
            $imgext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES['galleryimg']['name'][$i]));
            $uploaddir = '../uploads_images/';
            $newfilename = $_POST['form_type'].'-'.$id.rand(100,300).'.'.$imgext;
            $uploadfile = $uploaddir.$newfilename;
            
            if(!in_array($galleryImgType, $types))
            {
                $error_gallery = "<p id='form-error'>Файл/файли галереї не завантажено, допустимі розширення файлів: jpeg, jpg, png, gif</p>";
                $_SESSION['answer'] = $error_gallery;
                continue;
            }
            if(empty($error_gallery))
            {
                if(@move_uploaded_file($_FILES['galleryimg']['tmp_name'][$i], $uploadfile))
                {
                    mysql_query("INSERT INTO uploads_images(products_id, image)
                            VALUES(
                                '".$id."',
                                '".$newfilename."'
                            )", $link);
                }
                else
                {
                    $_SESSION['answer'] = "Помилка завантаження файла.";
                }
            }
        }
    } 

?>