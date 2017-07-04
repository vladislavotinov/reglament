<?php
	$connect = mysql_connect("localhost","dbfpm","12345678");
$db = mysql_select_db("dbkt");

if(!$connect || !$db )
{
    mysql_error();
    echo "БД не подключена! Или подключена не корректно";
}

?>