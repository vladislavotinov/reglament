<?php 
Head('Добавление преподователя 3') ?>
<body>
	<script type="text/javascript">
     function buttonClick(button) {
            alert("Не правильно: 8:00-9:20.    Правильно: 08:00-09:20.");
        };
	</script>
<div class="wrapper">
<div class="header"></div>
<div class="content">
<?php Menu();
MessageShow() 
?>
<div class="Page">
<!-- ПРОСТО НАПРОСТО КОСТЫЛИЩЕ x2 -->
<?php
echo "Преподователь выбран - <h2>"."$_SESSION[sitting_teacher]"."</h2>";
$tn = $_SESSION['sitting_teacher'];
include_once("db.php");
$sotr = mysql_query("SELECT * FROM teachers WHERE name = '$tn' ");
$row = mysql_fetch_array($sotr);

echo '<br/>';
echo "В понедельник пар:".$row['monday'];
echo '<br/>';
echo "Во вторник пар:".$row['tuesday'];
echo '<br/>';
echo "В среду пар:".$row['wednesday'];
echo '<br/>';
echo "В четверг пар:".$row['thursday'];
echo '<br/>';
echo "В пятницу пар:".$row['friday'];
echo '<br/>';
echo "В суботу пар:".$row['saturday'];
echo '<br/>';
echo "Количество групп,которым Вы преподаете:".$row['groups'];
echo '<br/>';
echo "<h2><b>ПРИБЛИЗИТЕЛЬНО всего часов - ".$row['fullworktime']."</b></h2><br/><br/>";

// подгрузка групп и дисциплин.

$result = mysql_query("SELECT * FROM groupsandlesson WHERE name = '$tn' ");
$group_array_new = array();
$discipline_array_new = array();
while($rowtwo = mysql_fetch_array($result))
{
    if($rowtwo['groups'] == '1') array_push($group_array_new,$rowtwo['this']);
    else if ($rowtwo['discipline'] == '1') array_push($discipline_array_new,$rowtwo['this']);
}
mysql_close(); // НОВАЯ________________________________________ВОЗМОЖНО К УДАЛЕНИЮ!!!!

// ПРОВЕРКИ
echo "<br/><br/>";
print_r($discipline_array_new);
echo "<br/><br/>";
// конец проверки
?>
<!--
ПЕРЕМЕННЫЕ ДЛЯ ОБРАБОТЧИКА в account.php
1)time_monday_1 - время пары // time - СТАТ.ПЕР. всегда. 1 - ДИНАМ.ПЕР. конкретно выбранная пара. monday - ДИНАМ.ПЕР. день.
2) parity_of_week_monday_1 - числитель или знаменатель // так само. 
3) about_lesson_monday_1 - поле для ввода о ПАРЕ
4) classroom_monday_1
 -->
<form method="POST" action="/account/addstagetwoprefinal">
<!-- START NEW DAY! -->
<input type="hidden" name="teacher" value="<? echo "$tn"; ?>" />
<h1>Понедельник</h1><br/>
<?php
$i=0;
$day_of_week = "monday_"; // вводить только так. в конце _
 while($i!=$row['monday']){ 
$i++;
 	echo "<h2>$i"." - пара</h2>";
    
 	 ?>
 	<div class="rasblock">
 <br/>
<input type="text" maxlength="11" pattern="[0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}" title="В формате 00:00-12:12" name="<?php echo "atime_".$day_of_week."$i"; ?>" placeholder="Ручной Ввод времени" />
<span>В формате  ' 00:00-24:24 '</span>
<br/> <!-- Аналогичный ввод времени -->
<select size="1" name="<?php echo "btime_".$day_of_week."$i"; ?>" >
  <option>0</option>
  <option>08:00-09:20</option>
  <option>09:30-10:50</option>
  <option>11:10-12:30</option>
  <option>12:40-14:00</option>
  <option>14:10-15:30</option>
  <option>15:40-17:00</option>
  <option>17:10-18:30</option>
  <option>18:40-20:00</option>
  <option>20:10-21:30</option>
  </select>
<input type="button" name="helptime" value="Подсказка" onclick="buttonClick (this)" />
<br/>
<p><b>Числитель или знаменатель?</b></p>
    <select size="1" name="<?php echo "parity_of_week_".$day_of_week."$i";?>">
    <option>0</option>
    <option>Числитель</option>
    <option>Знаминатель</option>
    <option>Всегда</option>
    </select>
<br/>
<h3>Ввод данных о паре</h3>
<textarea class="tarea" name="<?php echo "aabout_lesson_".$day_of_week."$i"; ?>" placeholder="Все о паре" /></textarea> <!-- required back -->
<br/><span>Список доступных Вам дисциплин:</span>
<select size="1" name="<?php echo "babout_lesson_".$day_of_week."$i";?>">
        <option>0</option>
         <?php 
            $o = 0;
            $oo = count($discipline_array_new);
            $oo *=1;
            while($o != $oo)
            {
              ?>
              <option><?=$discipline_array_new[$o]?></option>
              <?php
              $o++;
            }
         ?>
        </select>
<br/><span>Тип пары:</span>
<select size="1" name = "<?php echo "type_lesson_".$day_of_week."$i";?>" >
  <option></option>
  <option>,лекция</option>
  <option>,практика</option>
  <option>,лабараторная</option>
  </select>
<p><b>Выберите группу</b></p>
       <select size="1" name="<?php echo "selected_group_".$day_of_week."$i";?>">
        <option>0</option>
         <?php 
            $o = 0;
            $oo = count($group_array_new);
            $oo *=1;
            while($o != $oo)
            {
              ?>
              <option><?=$group_array_new[$o]?></option>
              <?php
              $o++;
            }
         ?>
        </select>

<br/><input type="text" name="<?php echo "classroom_".$day_of_week."$i"; ?>" placeholder="Аудитория/Пометка" /> <!-- required back -->
<hr/>
</div>
<?php 
 } ?>
<br />
<input type="hidden" name="monday" value="<? echo $row['monday']; ?>"/>

<!-- END NEW DAY! -->
<!-- START NEW DAY! -->

<h1>Вторник</h1><br/>
<?php
$i=0;
$day_of_week = "tuesday_"; // вводить только так. в конце _ ..... приставка выбранного дня
 while($i!=$row['tuesday']){ 
$i++;
 	echo "<h2>$i"." - пара</h2>";
    
 	 ?>
 	<div class="rasblock">
 <br/>
<input type="text" maxlength="11" pattern="[0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}" title="В формате 00:00-12:12" name="<?php echo "atime_".$day_of_week."$i"; ?>" placeholder="Ручной Ввод времени" />
<span>В формате  ' 00:00-24:24 '</span>
<br/> <!-- Аналогичный ввод времени -->
<select size="1" name="<?php echo "btime_".$day_of_week."$i"; ?>" >
  <option>0</option>
  <option>08:00-09:20</option>
  <option>09:30-10:50</option>
  <option>11:10-12:30</option>
  <option>12:40-14:00</option>
  <option>14:10-15:30</option>
  <option>15:40-17:00</option>
  <option>17:10-18:30</option>
  <option>18:40-20:00</option>
  <option>20:10-21:30</option>
  </select>
<input type="button" name="helptime" value="Подсказка" onclick="buttonClick (this)" />
<br/>
<p><b>Числитель или знаменатель?</b></p>
    <select size="1" name="<?php echo "parity_of_week_".$day_of_week."$i";?>">
   <option>0</option>
    <option>Числитель</option>
    <option>Знаминатель</option>
    <option>Всегда</option>
    </select>
<h3>Ввод данных о паре</h3>
<textarea class="tarea" name="<?php echo "aabout_lesson_".$day_of_week."$i"; ?>" placeholder="Все о паре" /></textarea> <!-- required back -->
<br/><span>Список доступных Вам дисциплин:</span>
<select size="1" name="<?php echo "babout_lesson_".$day_of_week."$i";?>">
        <option>0</option>
         <?php 
            $o = 0;
            $oo = count($discipline_array_new);
            $oo *=1;
            while($o != $oo)
            {
              ?>
              <option><?=$discipline_array_new[$o]?></option>
              <?php
              $o++;
            }
         ?>
        </select>
<br/><span>Тип пары:</span>
<select size="1" name = "<?php echo "type_lesson_".$day_of_week."$i";?>" >
  <option></option>
  <option>,лекция</option>
  <option>,практика</option>
  <option>,лабараторная</option>
  </select>
<p><b>Выберите группу</b></p>
       <select size="1" name="<?php echo "selected_group_".$day_of_week."$i";?>">
        <option>0</option>
         <?php 
            $o = 0;
            $oo = count($group_array_new);
            $oo *=1;
            while($o != $oo)
            {
              ?>
              <option><?=$group_array_new[$o]?></option>
              <?php
              $o++;
            }
         ?>
        </select>
<br/><input type="text" name="<?php echo "classroom_".$day_of_week."$i"; ?>" placeholder="Аудитория/Пометка" /> <!-- required back -->
<hr/>
</div>
<?php 
 } ?>
<br />
<input type="hidden" name="tuesday" value="<? echo $row['tuesday']; ?>"/>

<!-- END NEW DAY! -->
<!-- START NEW DAY! -->

<h1>Среда</h1><br/>
<?php
$i=0;
$day_of_week = "wednesday_"; // вводить только так. в конце _
 while($i!=$row['wednesday']){ 
$i++;
 	echo "<h2>$i"." - пара</h2>";
    
 	 ?>
 	<div class="rasblock">
 <br/>
<input type="text" maxlength="11" pattern="[0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}" title="В формате 00:00-12:12" name="<?php echo "atime_".$day_of_week."$i"; ?>" placeholder="Ручной Ввод времени" />
<span>В формате  ' 00:00-24:24 '</span>
<br/> <!-- Аналогичный ввод времени -->
<select size="1" name="<?php echo "btime_".$day_of_week."$i"; ?>" >
  <option>0</option>
  <option>08:00-09:20</option>
  <option>09:30-10:50</option>
  <option>11:10-12:30</option>
  <option>12:40-14:00</option>
  <option>14:10-15:30</option>
  <option>15:40-17:00</option>
  <option>17:10-18:30</option>
  <option>18:40-20:00</option>
  <option>20:10-21:30</option>
  </select>
<input type="button" name="helptime" value="Подсказка" onclick="buttonClick (this)" />
<br/>
<p><b>Числитель или знаменатель?</b></p>
    <select size="1" name="<?php echo "parity_of_week_".$day_of_week."$i";?>">
       <option>0</option>
    <option>Числитель</option>
    <option>Знаминатель</option>
    <option>Всегда</option>
    </select>
<h3>Список доступных Вам дисциплин:</h3>
<textarea class="tarea" name="<?php echo "aabout_lesson_".$day_of_week."$i"; ?>" placeholder="Все о паре" /></textarea> <!-- required back -->
<br/><span>Ручной ввод</span>
<select size="1" name="<?php echo "babout_lesson_".$day_of_week."$i";?>">
        <option>0</option>
         <?php 
            $o = 0;
            $oo = count($discipline_array_new);
            $oo *=1;
            while($o != $oo)
            {
              ?>
              <option><?=$discipline_array_new[$o]?></option>
              <?php
              $o++;
            }
         ?>
        </select>
<br/><span>Тип пары:</span>
<select size="1" name = "<?php echo "type_lesson_".$day_of_week."$i";?>" >
  <option></option>
  <option>,лекция</option>
  <option>,практика</option>
  <option>,лабараторная</option>
  </select>
<p><b>Выберите группу</b></p>
       <select size="1" name="<?php echo "selected_group_".$day_of_week."$i";?>">
        <option>0</option>
         <?php 
            $o = 0;
            $oo = count($group_array_new);
            $oo *=1;
            while($o != $oo)
            {
              ?>
              <option><?=$group_array_new[$o]?></option>
              <?php
              $o++;
            }
         ?>
        </select>
<br/><input type="text" name="<?php echo "classroom_".$day_of_week."$i"; ?>" placeholder="Аудитория/Пометка" /> <!-- required back -->
<hr/>
</div>
<?php 
 } ?>
<br />
<input type="hidden" name="wednesday" value="<? echo $row['wednesday']; ?>"/>

<!-- END NEW DAY! -->
<!-- START NEW DAY! -->

<h1>Четверг</h1><br/>
<?php
$i=0;
$day_of_week = "thursday_"; // вводить только так. в конце _
 while($i!=$row['thursday']){ 
$i++;
 	echo "<h2>$i"." - пара</h2>";
    
 	 ?>
 	<div class="rasblock">
 <br/>
<input type="text" maxlength="11" pattern="[0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}" title="В формате 00:00-12:12" name="<?php echo "atime_".$day_of_week."$i"; ?>" placeholder="Ручной Ввод времени" />
<span>В формате  ' 00:00-24:24 '</span>
<br/> <!-- Аналогичный ввод времени -->
<select size="1" name="<?php echo "btime_".$day_of_week."$i"; ?>" >
  <option>0</option>
  <option>08:00-09:20</option>
  <option>09:30-10:50</option>
  <option>11:10-12:30</option>
  <option>12:40-14:00</option>
  <option>14:10-15:30</option>
  <option>15:40-17:00</option>
  <option>17:10-18:30</option>
  <option>18:40-20:00</option>
  <option>20:10-21:30</option>
  </select>
<input type="button" name="helptime" value="Подсказка" onclick="buttonClick (this)" />
<br/>
<p><b>Числитель или знаменатель?</b></p>
    <select size="1" name="<?php echo "parity_of_week_".$day_of_week."$i";?>">
        <option>0</option>
    <option>Числитель</option>
    <option>Знаминатель</option>
    <option>Всегда</option>
    </select>
<h3>Ввод данных о паре</h3>
<textarea class="tarea" name="<?php echo "aabout_lesson_".$day_of_week."$i"; ?>" placeholder="Все о паре" /></textarea> <!-- required back -->
<br/><span>Список доступных Вам дисциплин:</span>
<select size="1" name="<?php echo "babout_lesson_".$day_of_week."$i";?>">
        <option>0</option>
         <?php 
            $o = 0;
            $oo = count($discipline_array_new);
            $oo *=1;
            while($o != $oo)
            {
              ?>
              <option><?=$discipline_array_new[$o]?></option>
              <?php
              $o++;
            }
         ?>
        </select>
<br/><span>Тип пары:</span>
<select size="1" name = "<?php echo "type_lesson_".$day_of_week."$i";?>" >
  <option></option>
  <option>,лекция</option>
  <option>,практика</option>
  <option>,лабараторная</option>
  </select>
<p><b>Выберите группу</b></p>
       <select size="1" name="<?php echo "selected_group_".$day_of_week."$i";?>">
        <option>0</option>
         <?php 
            $o = 0;
            $oo = count($group_array_new);
            $oo *=1;
            while($o != $oo)
            {
              ?>
              <option><?=$group_array_new[$o]?></option>
              <?php
              $o++;
            }
         ?>
        </select>
<br/><input type="text" name="<?php echo "classroom_".$day_of_week."$i"; ?>" placeholder="Аудитория/Пометка" /> <!-- required back -->
<hr/>
</div>
<?php 
 } ?>
<br />
<input type="hidden" name="thursday" value="<? echo $row['thursday']; ?>"/>

<!-- END NEW DAY! -->
<!-- START NEW DAY! -->

<h1>Пятница</h1><br/>
<?php
$i=0;
$day_of_week = "friday_"; // вводить только так. в конце _
 while($i!=$row['friday']){ 
$i++;
 	echo "<h2>$i"." - пара</h2>";
    
 	 ?>
 	<div class="rasblock">
 <br/>
<input type="text" maxlength="11" pattern="[0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}" title="В формате 00:00-12:12" name="<?php echo "atime_".$day_of_week."$i"; ?>" placeholder="Ручной Ввод времени" />
<span>В формате  ' 00:00-24:24 '</span>
<br/> <!-- Аналогичный ввод времени -->
<select size="1" name="<?php echo "btime_".$day_of_week."$i"; ?>" >
  <option>0</option>
  <option>08:00-09:20</option>
  <option>09:30-10:50</option>
  <option>11:10-12:30</option>
  <option>12:40-14:00</option>
  <option>14:10-15:30</option>
  <option>15:40-17:00</option>
  <option>17:10-18:30</option>
  <option>18:40-20:00</option>
  <option>20:10-21:30</option>
  </select>
<input type="button" name="helptime" value="Подсказка" onclick="buttonClick (this)" />
<br/>
<p><b>Числитель или знаменатель?</b></p>
    <select size="1" name="<?php echo "parity_of_week_".$day_of_week."$i";?>">
       <option></option>
    <option>Числитель</option>
    <option>Знаминатель</option>
    <option>Всегда</option>
    </select>
<h3>Ввод данных о паре</h3>
<textarea class="tarea" name="<?php echo "aabout_lesson_".$day_of_week."$i"; ?>" placeholder="Все о паре" /></textarea> <!-- required back -->
<br/><span>Список доступных Вам дисциплин:</span>
<select size="1" name="<?php echo "babout_lesson_".$day_of_week."$i";?>">
        <option>0</option>
         <?php 
            $o = 0;
            $oo = count($discipline_array_new);
            $oo *=1;
            while($o != $oo)
            {
              ?>
              <option><?=$discipline_array_new[$o]?></option>
              <?php
              $o++;
            }
         ?>
        </select>
<br/><span>Тип пары:</span>
<select size="1" name = "<?php echo "type_lesson_".$day_of_week."$i";?>" >
  <option></option>
  <option>,лекция</option>
  <option>,практика</option>
  <option>,лабараторная</option>
  </select>
<p><b>Выберите группу</b></p>
       <select size="1" name="<?php echo "selected_group_".$day_of_week."$i";?>">
        <option>0</option>
         <?php 
            $o = 0;
            $oo = count($group_array_new);
            $oo *=1;
            while($o != $oo)
            {
              ?>
              <option><?=$group_array_new[$o]?></option>
              <?php
              $o++;
            }
         ?>
        </select>
<br/><input type="text" name="<?php echo "classroom_".$day_of_week."$i"; ?>" placeholder="Аудитория/Пометка" /> <!-- required back -->
<hr/>
</div>
<?php 
 } ?>
<br />
<input type="hidden" name="friday" value="<? echo $row['friday']; ?>"/>

<!-- END NEW DAY! -->
<!-- START NEW DAY! -->

<h1>Суббота</h1><br/>
<?php
$i=0;
$day_of_week = "saturday_"; // вводить только так. в конце _
 while($i!=$row['saturday']){ 
$i++;
 	echo "<h2>$i"." - пара</h2>";
    
 	 ?>
 	<div class="rasblock">
 <br/>
<input type="text" maxlength="11" pattern="[0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}" title="В формате 00:00-12:12" name="<?php echo "atime_".$day_of_week."$i"; ?>" placeholder="Ручной Ввод времени" />
<span>В формате  ' 00:00-24:24 '</span>
<br/> <!-- Аналогичный ввод времени -->
<select size="1" name="<?php echo "btime_".$day_of_week."$i"; ?>" >
  <option>0</option>
  <option>08:00-09:20</option>
  <option>09:30-10:50</option>
  <option>11:10-12:30</option>
  <option>12:40-14:00</option>
  <option>14:10-15:30</option>
  <option>15:40-17:00</option>
  <option>17:10-18:30</option>
  <option>18:40-20:00</option>
  <option>20:10-21:30</option>
  </select>
<input type="button" name="helptime" value="Подсказка" onclick="buttonClick (this)" />
<br/>
<p><b>Числитель или знаменатель?</b></p>
    <select name="<?php echo "parity_of_week_".$day_of_week."$i";?>">
       <option></option>
    <option>Числитель</option>
    <option>Знаминатель</option>
    <option>Всегда</option>
    </select>
<h3>Ввод данных о паре</h3>
<textarea class="tarea" name="<?php echo "aabout_lesson_".$day_of_week."$i"; ?>" placeholder="Все о паре" /></textarea> <!-- required back -->
<br/><span>Список доступных Вам дисциплин:</span>
<select size="1" name="<?php echo "babout_lesson_".$day_of_week."$i";?>">
        <option>0</option>
         <?php 
            $o = 0;
            $oo = count($discipline_array_new);
            $oo *=1;
            while($o != $oo)
            {
              ?>
              <option><?=$discipline_array_new[$o]?></option>
              <?php
              $o++;
            }
         ?>
        </select>
<br/><span>Тип пары:</span>
<select size="1" name = "<?php echo "type_lesson_".$day_of_week."$i";?>" >
  <option></option>
  <option>,лекция</option>
  <option>,практика</option>
  <option>,лабараторная</option>
  </select>
<p><b>Выберите группу</b></p>
       <select size="1" name="<?php echo "selected_group_".$day_of_week."$i";?>">
        <option>0</option>
         <?php 
            $o = 0;
            $oo = count($group_array_new);
            $oo *=1;
            while($o != $oo)
            {
              ?>
              <option><?=$group_array_new[$o]?></option>
              <?php
              $o++;
            }
         ?>
        </select>
<br/><input type="text" name="<?php echo "classroom_".$day_of_week."$i"; ?>" placeholder="Аудитория/Пометка" /> <!-- required back -->
<hr/>
</div>
<?php 
 } ?>
<br />
<input type="hidden" name="saturday" value="<? echo $row['saturday']; ?>"/>

<!-- END NEW DAY! -->
<input type="submit" name="enter" value="Подтвердить" /> 




</form>






</div>
</div>

<?php Footer() ?>
</div>
</body>
</html>