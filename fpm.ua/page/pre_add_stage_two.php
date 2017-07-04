<?php 
Head('Добавление преподователя 2') ?>
<body>
<div class="wrapper">
<div class="header"></div>
<div class="content">
<?php Menu();
MessageShow() 
?>
<div class="Page">
<!-- ПРОСТО НАПРОСТО КОСТЫЛИЩЕ -->

<form method="POST" action="/account/addstagetwo">

<?php
include_once("db.php");
$sotr = mysql_query("SELECT * FROM teachers ");
if ($sotr == true) { ?>
     <select name="chooseteacher">
     <? while ($s = mysql_fetch_array($sotr)) { ?>
          <option><?=$s['name']?></option>
     <?}?>
   </select>
<?}else echo 'Error! ( БД/Список пуст)';
mysql_close();
?>

<div class="Block">
	<p>Выберите количество лент(так званых полей) в определённый день для преподователя!</p><br/>
	<p>Оставьте поле пустым, если у преподователя в этот день нет пар!</p><br/>
	<p>Введите 0, если у преподователя в данный день пар нету!</p><br/>
</div>
<div class="miniblock">Понедельник &nbsp; <input type="text" name="monday" maxlength="1" pattern="[0-9]{1}" title="Только цифры" value="0" required/></div>
<div class="miniblock">Вторник &nbsp; <input type="text" name="tuesday" maxlength="1" pattern="[0-9]{1}" title="Только цифры" value="0" required/></div>
<div class="miniblock">Среда &nbsp; <input type="text" name="wednesday" maxlength="1" pattern="[0-9]{1}" title="Только цифры" value="0" required/></div>
<div class="miniblock">Четверг &nbsp; <input type="text" name="thursday" maxlength="1" pattern="[0-9]{1}" title="Только цифры" value="0" required/></div>
<div class="miniblock">Пятница &nbsp; <input type="text" name="friday" maxlength="1" pattern="[0-9]{1}" title="Только цифры" value="0" required/></div>
<div class="miniblock">Субота &nbsp; <input type="text" name="saturday" maxlength="1" pattern="[0-9]{1}" title="Только цифры" value="0" required/></div>



<input type="submit" name="enter" value="Далее" />
</form>
</div>
</div>

<?php Footer() ?>
</div>
</body>
</html>