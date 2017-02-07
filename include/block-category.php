<?php
	defined('myeshop') or header('Location: ../not_found.php');
?>
<div id="block-category">
    <p class="heder-title">Катерогії товарів</p>
    <ul type="none">
        <li><a id="index1"><img src="/images/mobile-icon.gif" id="mobile-images"/>Мобільні телефони</a>
            <ul type="none" class="category-section">
                <li>
                    <a href="view_cat.php?type=mobile"><strong>Всі моделі</strong></a>                
                </li>
            
            <?php
	               $result = mysql_query("SELECT * FROM category WHERE type='mobile'",$link);
                    if(mysql_num_rows($result) > 0)
                    {
                        $row = mysql_fetch_array($result);
                        do
                        {
                            echo'
                                                    
                            <li><a href="view_cat.php?cat='.strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li>
                            
                            ';    
                        }
                        while ($row = mysql_fetch_array($result));
                    }
            ?>
            
            </ul>
            
        </li>
    </ul>
    <ul type="none">
        <li><a id="index2"><img src="/images/book-icon.gif" id="book-images"/>Ноутбуки</a>
            <ul type="none" class="category-section">
                <li>
                    <a href="view_cat.php?type=notebook"><strong>Всі моделі</strong></a>                

            <?php
	               $result = mysql_query("SELECT * FROM category WHERE type='notebook'",$link);
                    if(mysql_num_rows($result) > 0)
                    {
                        $row = mysql_fetch_array($result);
                        do
                        {
                            echo'
                                                    
                            <li><a href="view_cat.php?cat='.strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li>
                            
                            ';    
                        }
                        while ($row = mysql_fetch_array($result));
                    }
            ?>

            </ul>
            
        </li>
    </ul>
    <ul type="none">
        <li><a id="index3"><img src="/images/table-icon.gif" id="table-images"/>Планшети</a>
            <ul type="none" class="category-section">
                <li>
                    <a href="view_cat.php?type=notepad"><strong>Всі моделі</strong></a>                
                </li>
            <?php
	               $result = mysql_query("SELECT * FROM category WHERE type='notepad'",$link);
                    if(mysql_num_rows($result) > 0)
                    {
                        $row = mysql_fetch_array($result);
                        do
                        {
                            echo'
                                                    
                            <li><a href="view_cat.php?cat='.strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li>
                            
                            ';    
                        }
                        while ($row = mysql_fetch_array($result));
                    }
            ?>

            </ul>
            
        </li>
    </ul>
</div>