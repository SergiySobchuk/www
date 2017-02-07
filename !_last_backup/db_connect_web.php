<?php

defined('myeshop') or header('Location: ../not_found.php');

$db_host='localhost';
$db_user='SergiySobchuk';
$db_pass='[jcnsyu';
$db_database='sergiysobchuk';

$link = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($db_database,$link) or die("Нема звязку в БД".mysql_error());
mysql_query("SET names utf-8");

?>