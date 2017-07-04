<?php Head('Добавление групп и дисциплин') ?>
<body>
<div class="wrapper">
<div class="header"></div>
<div class="content">
<?php  Menu();
MessageShow()
 ?>
<div class="Page">
<b>for prepod</b> <br/>
<!-- в екшене form - ссылка на исполняющий файл
add_stage_one - модуль
 -->
 <div class="Block">
	<p>Введите названия дисциплин, которые Вы преподаете ( Абсолютно всевозможные)</p><br/>
	<p>Введите названия групп, которым Вы преподаете.</p><br/>
</div>
<form method="POST" action="/account/groupsdis"> 
<?php
echo "<h3>Преподователь выбран - </h3><h2>"."$_SESSION[sitting_teacher]"."</h2>";
$tn = $_SESSION['sitting_teacher'];
include_once("db.php");
$sotr = mysql_query("SELECT * FROM teachers WHERE name = '$tn' ");
$row = mysql_fetch_array($sotr);
//echo "$row[groups]";
// $row['discipline']
$gr = $row['groups'];
$ds = $row['discipline'];
mysql_close();
$i = 0;
while($i != $row['groups'])
{$i++;  ?>
 <div class="miniblock">Группа <?php echo "<b>".$i."</b>"; ?><input type="text" name="<?php echo "groups_"."$i";?>" maxlength="14" title="Имя группы" placeholder="Имя группы" required/>
 </div>
 <br/>
<?php
}
$i = 0;
?>
<hr/><hr/><hr/>
<?php
while($i != $row['discipline'])
{$i++;  ?>
<div class="miniblock">Дисциплина <?php echo "<b>".$i."</b>"; ?><input type="text" name="<?php echo "discipline_"."$i";?>" maxlength="30" title="Название дисциплины" placeholder="Название дисциплины" required/>
 </div>
 <br/>
<?php
}
?>
<input type="hidden" name="teacher" value="<? echo "$tn"; ?>" />
<input type="hidden" name="gs" value="<? echo "$gr"; ?>" /> <!-- передаем общее кол-во групп -->
<input type="hidden" name="ds" value="<? echo "$ds"; ?>" />
<input type="submit" name="enter" value="Далее" />
</form>


</div>
</div>

<?php Footer() ?>
</div>
</body>
</html>