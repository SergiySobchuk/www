<!DOCTYPE HTML>
<html>
<head>
    <title>Парсинг</title>
    <style>
        .green{
            font-size: 8px sans-serif;
            color: green;
            margin: 2px;
            padding: 1px;
            border: 1px solid green;
            width: 1024px;
        }
        .green a{
            text-decoration: none;
            color: black;
        }
        .green > p.product-info{
            color: darkblue;
        }
        .green > p.description-info{
            color: chocolate;
        }
        .red{
            font-size: 8px sans-serif;
            color: red;
            margin: 2px;
            padding: 1px;
            border: 1px solid red;
            width: 1024px;
        }
    </style>
</head>
<body>
<?php
    $id = array( 453891, 475167, 487119, 44566040);
    require_once 'simple_html_dom.php'; // библиотека для парсинга
    for($i=0;$i<count($id);$i++)
    {
        $html = file_get_html('http://deshevshe.ua/search/?utf8=%E2%9C%93&commit=+&q='.$id[$i]);
        $url = $html->find('a.name', 0)->href; // парсинг url
        if (isset($url))
        {
            $url_plus = 'http://deshevshe.ua'.$url;
            $html = file_get_html("$url_plus");

            //************************* парсинг name ****************************
            $name = $html->find('div.wareTitle', 0)->find('h1',0)->innertext;
            //************************* парсинг price*****************************
            $price = $html->find('div.pr-uah', 0)->find('span',0)->innertext;
            //*************** парсинг mini_description and mini_features**********
            $mini_description = strip_tags($html->find('div.ware-descr-short', 0)->innertext);

            echo
                '
                    <div class="green">
                        <p>Сторінку з  id='.$id["$i"].' знайдено!</p>
                        <p>URL: <a href="'.$url_plus.'" target="_blank">' . $url_plus . '</a></p>
                        <p class="product-info">Назва товару: '.$name.'</p>
                        <p class="product-info">Ціна: '.$price.'</p>
                        <p>*********************************************************************</p>
                ';

            if ($html->find('div.addPhotoBlock'))
            {
                $id_url_gallery = $html->find('div.addPhotoBlock',0)->find('img');
                for ($j = 0; $j < count($id_url_gallery); $j++)
                {
                    $img_gallery = $html->find('div[id=ware-photos-iteams]', 0)->find('img', $j);

                    $img_url_gallery = $html->find('div[id=ware-photos-iteams]', 0)->find('img', $j)->src;
                    $img_url_gallery_original = stristr($img_url_gallery, '?', true);
                    $img_url_gallery_original = str_replace(".s.jpg", ".o.jpg", $img_url_gallery_original);
                    $img_url_gallery_original = str_replace(".m.jpg", ".o.jpg", $img_url_gallery_original);
                    $img_url_gallery_original = str_replace(".b.jpg", ".o.jpg", $img_url_gallery_original);
                    $img_url_gallery_original = str_replace(".l.jpg", ".o.jpg", $img_url_gallery_original);

                    $img_gallery_original =  $html->find('div[id=ware-photos-iteams]', 0)->find('img', $j);//->scr = '$img_url_gallery_original';
                    echo
                        '    
                        <p class="description-info">URL галереї зображень: <a target="_blank" href="' . $img_url_gallery . '">' . $img_url_gallery . '</a> </p>
                        <p class="description-info">Зображеня: <a target="_blank" href="' . $img_url_gallery . '">' . $img_gallery . '</a> </p>
                        <p class="description-info">URL оригінала галереї зображень: <a target="_blank" href="' . $img_url_gallery_original . '">' . $img_url_gallery_original . '</a> </p>
                        <p class="description-info">*******************************************************************</p>                        
                ';
                }
            }
            $img = $html->find('div.warePhotoHolder', 0)->find('img', 0);
                $img_url = $html->find('div.warePhotoHolder', 0)->find('img', 0)->src;
                echo
                '
                    <p class="product-info">URL основного малюнку: <a  target="_blank" href="'.$img_url.'" >'.$img_url.'</a></p>
                    <p class="product-info">Основний малюнок: <a  target="_blank" href="'.$img_url.'" >'.$img.'</a></p>
                        
                ';
                $img_url_original = stristr($img_url, '?', true);
                $img_url_original = str_replace(".s.jpg", ".o.jpg", $img_url_original);
                $img_url_original = str_replace(".m.jpg", ".o.jpg", $img_url_original);
                $img_url_original = str_replace(".b.jpg", ".o.jpg", $img_url_original);
                $img_url_original = str_replace(".l.jpg", ".o.jpg", $img_url_original);
                $html->find('div.warePhotoHolder', 0)->find('img', 0)->src=$img_url_original;
                $img_original = $html->find('div.warePhotoHolder', 0)->find('img', 0);
                echo
                '
                        <p class="product-info">URL основного оригінального малюнку: <a  target="_blank" href="'.$img_url_original.'" >'.$img_url_original.'</a></p>
                        <p class="product-info">Основний оригінальний малюнок: <a  target="_blank" href="'.$img_url_original.'" >'.$img_original.'</a></p>
                        <p class="product-info">***************************************</p>
                        <p class="product-info">Міні опис/характеристики: '.$mini_description.'</p>
                        <p class="product-info">Характеристики: </p>
                ';

            //************************* парсинг description and features
            foreach ($html->find('li.clearfix') as $article)
            {
                $option1 = $article->find('div.fname',0);
                $option2 = $article->find('div.fvalue',0);

                if(isset($option1, $option2))
                {
                    $description1 = strip_tags($article->find('div.fname',0)->innertext);
                    $description2 = strip_tags($article->find('div.fvalue',0)->innertext);
                }
                else
                {
                    $description1 = strip_tags($article->innertext);
                    $description2 = "";
                }
                echo'
                        <p class="description-info">'.$description1.':'.$description2.' </p>
                    ';
            }
            echo
                '
                    </div>
                ';
       }
        else
        {
            echo
                '
                    <div class="red">
                        <p>Сторінку з  id= '.$id["$i"].' НЕ знайдено!</p>
                    </div>
                ';
        }

    }
    $html->clear(); // подчищаем за собой
    unset($html);
?>
</body>
</html>
