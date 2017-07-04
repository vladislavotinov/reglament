<?php 
Head('Удаление данных') ?>
<body>
<div class="wrapper">
<div class="header"></div>
<div class="content">
<?php Menu();
MessageShow() 
?>
<div class="Page">
<!-- ПРОСТО НАПРОСТО КОСТЫЛИЩЕ -->

<form method="POST" action="/account/delete">
<div class="Block">
	<p>1) Выберите преподователя,для того,чтобы удалить данные о нём со всех таблиц.</p>
	<p>2) Очистка <b>ВСЕХ</b> доступных таблиц базы данных</p>
	<p>3) Очищать таблицы просто так не нужно. Добром это не закончиться!</p>
</div>
<span>Удалить данные о преподователе - </span>
<?php
include_once("db.php");
$sotr = mysql_query("SELECT * FROM teachers ");
if ($sotr == true) { ?>
     <select name="delteacher">
     	<option></option>
     <? while ($s = mysql_fetch_array($sotr)) { ?>
          <option><?=$s['name']?></option>
     <?}?>
   </select>
<?}else echo 'Error! ( БД/Список пуст)';
mysql_close();
?>
<span>&nbsp; из -</span>
<select size="1" name="tableforteacher">
	<option></option>
	<option value="0">ВСЕХ</option>
	<option value="1">Таблица групп и дисциплин всех преподователей</option>
	<option value="2">Таблица регламента</option>
	<option value="3">Таблица данных о преподователе</option>
</select>
<br/><br/>
<p>Выберите таблицу,которую желаете очистить <b>ПОЛНОСТЬЮ</b>!</p>
<select size="1" name="deltablefromdb">
	<option></option>
	<option value="1">Таблица групп и дисциплин всех преподователей</option>
	<option value="2">Таблица регламента</option>
	<option value="3">Таблица данных о преподователе</option>
</select>
<br/>
<p>Введите пароль:</p>
<input type="password" name="passfordel" required>

<input type="submit" name="enter" value="Далее" />
</form>
</div>
</div>

<?php Footer() ?>
</div>
</body>
</html>