<?php 
echo '<br/>Выполнение обработчика<br/>';
if ($Module == 'addone' and $_POST['enter']) {
$_POST['name'] = FormChars($_POST['name']);
$_POST['position'] = FormChars($_POST['position']);
$_POST['number'] = FormChars($_POST['number']);

// new
$_POST['groups'] = FormChars($_POST['groups']);
$_POST['discipline'] = FormChars($_POST['discipline']); // +
// end new.
if (!$_POST['name'] or !$_POST['position'] or !$_POST['nomer'] or !$_POST['groups'] or !$_POST['discipline']) MessageSend(1,'Ошибка валидации формы.');


$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `name` FROM `teachers` WHERE `name` = '$_POST[name]'"));
if ($Row['name']) exit('Данный преподователь <b>'.$_POST['login'].'</b> уже есть в списках.');


$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `nomer` FROM `teachers` WHERE `nomer` = '$_POST[nomer]'"));
if ($Row['name']) exit('Номер <b>'.$_POST['number'].'</b> уже используеться.');
if(($_POST['groups'] > 0) AND ($_POST['discipline'] > 0) ){
mysqli_query($CONNECT, "INSERT INTO `teachers` VALUES ('', '$_POST[name]', '$_POST[position]', '$_POST[nomer]', NOW(),'','','','','','','','$_POST[groups]','$_POST[discipline]' )" );
echo 'PREPOD ADDED URAAAAAAAAAAAAAAAAAA!';
exit("<meta http-equiv='refresh' content='0; url= /pre_addtwo'>");//exit(header('Location: /index')); // !
}
else{
  exit("<meta http-equiv='refresh' content='0; url= /add_one'>");
}
}

if($Module == 'delete' and $_POST['enter'])
{
  $teacher = FormChars($_POST['delteacher']);
  $table = FormChars($_POST['deltablefromdb']);
  $pass = FormChars($_POST['passfordel']);
  $taketableforteacher = FormChars($_POST['tableforteacher']);
  echo "Препод -"."$teacher"."<br/>";
  echo "Номер таблы из которой удалить препода - "."$taketableforteacher"."<br/>";
  echo "Всю таблу - "."$table"."<br/>";
  echo "Пароль введенный -"."$pass"."<br/>";

 
  
  $Rowe = mysqli_fetch_assoc(mysqli_query($CONNECT,"SELECT pass FROM dellogs")); // "SELECT pass FROM dellogs WHERE 'name' = '$god'"
  // Осторожно! он считывает только перввую строку в этой табалице!
  
  print_r($Rowe);
  if($Rowe['pass'] == $pass) {
  if(empty($teacher) == 0) {
    if($taketableforteacher == "") exit('Таблица для преподователя не выбрана.');
    if($taketableforteacher == '0'){
      $Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id` FROM `teachers` WHERE `name` = '$teacher'")); // берём ид препода и по нему удаляем
      $id = $Row[id];
      mysqli_query($CONNECT,"DELETE FROM teachers WHERE id = '$id' ");
      $bomba=0;
      while($bomba != 30)
      {
            $id = 0;
            $Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id` FROM `reglament` WHERE `teacher` = '$teacher'")); // берём ид препода и по нему удаляем
            $id = $Row[id];
            mysqli_query($CONNECT,"DELETE FROM reglament WHERE id = '$id' ");
            $bomba++;
      }
      $bomba = 0;
      while($bomba != 20)
      {
            $id = 0;
            $Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id` FROM `groupsandlesson` WHERE `name` = '$teacher'")); // берём ид препода и по нему удаляем
            $id = $Row[id];
            mysqli_query($CONNECT,"DELETE FROM groupsandlesson WHERE id = '$id' ");
            $bomba++;
      }


      mysqli_query($CONNECT,"INSERT INTO dellogs VALUES ('','$teacher',NOW(),'полное удаление препода','')");
      echo "done 0";
    }
    if($taketableforteacher == '1') {
      $bomba = 0;
      while($bomba != 20)
      {
            $id = 0;
            $Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id` FROM `groupsandlesson` WHERE `name` = '$teacher'")); // берём ид препода и по нему удаляем
            $id = $Row[id];
            mysqli_query($CONNECT,"DELETE FROM groupsandlesson WHERE id = '$id' ");
            $bomba++;
      }
      echo "done 1";
      mysqli_query($CONNECT,"INSERT INTO dellogs VALUES ('','$teacher',NOW(),'из группы/дисциплины удаление препода','')");
    }
    if($taketableforteacher == '2') {
      $bomba=0;
      while($bomba != 30)
      {
            $id = 0;
            $Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id` FROM `reglament` WHERE `teacher` = '$teacher'")); // берём ид препода и по нему удаляем
            $id = $Row[id];
            mysqli_query($CONNECT,"DELETE FROM reglament WHERE id = '$id' ");
            $bomba++;
      }

      echo "done 2";
      mysqli_query($CONNECT,"INSERT INTO dellogs VALUES ('','$teacher',NOW(),'из регламента удаление препода','')");
    }
    if($taketableforteacher == '3') {
      $Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id` FROM `teachers` WHERE `name` = '$teacher'")); // берём ид препода и по нему удаляем
      $id = $Row[id];
      mysqli_query($CONNECT,"DELETE FROM teachers WHERE id = '$id' ");

      echo "done 3";
      mysqli_query($CONNECT,"INSERT INTO dellogs VALUES ('','$teacher',NOW(),'из данных о преподах удаление препода','')");
  }
  }
  if (empty($table) == 0) {
    if($table == '1') {
      mysqli_query($CONNECT,"TRUNCATE TABLE groupsandlesson");
      mysqli_query($CONNECT,"INSERT INTO 'dellogs' VALUES ('','admin',NOW(),'очистка групп/лекций','')");

    }
    if($table == '2') {
      mysqli_query($CONNECT,"TRUNCATE TABLE reglament");
      mysqli_query($CONNECT,"INSERT INTO 'dellogs' VALUES ('','admin',NOW(),'очистка регламента','')");

    }
    if($table == '3') {
      mysqli_query($CONNECT,"TRUNCATE TABLE teachers");
      mysqli_query($CONNECT,"INSERT INTO 'dellogs' VALUES ('','admin',NOW(),'очистка преподов','')");
    }
  }

  }
  else {
    exit('Пароль <b>'.$pass.'</b> введён не верно.');
  }
  //exit("<meta http-equiv='refresh' content='0; url= /index'>");
}

if ($Module == 'addstagetwo' and $_POST['enter']){
	$_POST['chooseteacher'] = FormChars($_POST['chooseteacher']);
	$_POST['monday'] = FormChars($_POST['monday']);
	$_POST['tuesday'] = FormChars($_POST['tuesday']);
	$_POST['wednesday'] = FormChars($_POST['wednesday']);
	$_POST['thursday'] = FormChars($_POST['thursday']);
	$_POST['friday'] = FormChars($_POST['friday']);
	$_POST['saturday'] = FormChars($_POST['saturday']);
  $_SESSION['sitting_teacher'] = $_POST['chooseteacher'];
  

    $paramforsum = $_POST['monday'] + $_POST['tuesday'] + $_POST['wednesday'] + $_POST['thursday'] + $_POST['friday'] + $_POST['saturday'];
    $paramforsum = preg_replace("/[^0-9]/", '', $paramforsum); // полируем 
    

  
/*
    $Row = mysqli_fetch_assoc(mysqli_query($CONNECT,"SELECT 'monday','tuesday','wednesday','thursday','friday','saturday' FROM 'teachers' WHERE 'name' = '$_POST[chooseteacher]'  "));
    if($Row['monday'] >0 or $Row['tuesday']>0 or $Row['wednesday']>0 or $Row['thursday']>0 or $Row['friday']>0 or $Row['saturday']>0) 
    	MessageSend(3,'Для данного преподователя рассписание уже было выбрано!Попробуйте удалить');
  */  
    $paramforsum*=80; // переводим в минуты пары
    $paramforsum/=60; // мин в часы
//mysql_query(" UPDATE news SET title='$title',text='$text',author='$author',office='$office',logo='$logo',Contacts='$cont' WHERE id='$id' ");

    mysqli_query($CONNECT,"UPDATE teachers SET monday = '$_POST[monday]', tuesday = '$_POST[tuesday]',wednesday = '$_POST[wednesday]',
    thursday = '$_POST[thursday]',friday = '$_POST[friday]',saturday = '$_POST[saturday]',fullworktime = '$paramforsum' WHERE name = '$_POST[chooseteacher]' ");

   

  exit("<meta http-equiv='refresh' content='0; url= /groups_n_discipline'>"); // сделать потом переход на addtwo!

}


if($Module == 'groupsdis' and $_POST['enter'])
{
   $teacher = FormChars($_POST['teacher']);
   $pole_count_groups = FormChars($_POST['gs']);
   $pole_count_discipline = FormChars($_POST['ds']);
   if($pole_count_groups >= 25 ) MessageSend(1,'Я же попросил, не больше 25 групп');
   if($pole_count_discipline >= 25 ) MessageSend(1,'Я же попросил, не больше 25 дисциплин');

$Roweq = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `name` FROM `groupsandlesson` WHERE `name` = '$teacher'"));
if ($Roweq['name']) exit('Данный преподователь <b>'.$teacher.'</b> уже есть в списках.');

   if($pole_count_groups != '0' or $pole_count_groups != '' or $pole_count_groups != ' ' ) {
    $groups_1 = FormChars($_POST['groups_1']);
    $groups_2 = FormChars($_POST['groups_2']);
    $groups_3 = FormChars($_POST['groups_3']);
    $groups_4 = FormChars($_POST['groups_4']);
    $groups_5 = FormChars($_POST['groups_5']);
    $groups_6 = FormChars($_POST['groups_6']);
    $groups_7 = FormChars($_POST['groups_7']);
    $groups_8 = FormChars($_POST['groups_8']);
    $groups_9 = FormChars($_POST['groups_9']);
    $groups_10 = FormChars($_POST['groups_10']);
    $groups_11 = FormChars($_POST['groups_11']);
    $groups_12 = FormChars($_POST['groups_12']);
    $groups_13 = FormChars($_POST['groups_13']);
    $groups_14 = FormChars($_POST['groups_14']);
    $groups_15 = FormChars($_POST['groups_15']);
    $groups_16 = FormChars($_POST['groups_16']);
    $groups_17 = FormChars($_POST['groups_17']);
    $groups_18 = FormChars($_POST['groups_18']);
    $groups_19 = FormChars($_POST['groups_19']);
    $groups_20 = FormChars($_POST['groups_20']);
    $groups_21 = FormChars($_POST['groups_21']);
    $groups_22 = FormChars($_POST['groups_22']);
    $groups_23 = FormChars($_POST['groups_23']);
    $groups_24 = FormChars($_POST['groups_24']);
    $groups_25 = FormChars($_POST['groups_25']); // 25
   }
   if($pole_count_discipline != '0' or $pole_count_discipline != '' or $pole_count_discipline != ' ' ) {
    $discipline_1 = FormChars($_POST['discipline_1']); 
    $discipline_2 = FormChars($_POST['discipline_2']);
    $discipline_3 = FormChars($_POST['discipline_3']);
    $discipline_4 = FormChars($_POST['discipline_4']);
    $discipline_5 = FormChars($_POST['discipline_5']);
    $discipline_6 = FormChars($_POST['discipline_6']);
    $discipline_7 = FormChars($_POST['discipline_7']);
    $discipline_8 = FormChars($_POST['discipline_8']);
    $discipline_9 = FormChars($_POST['discipline_9']);
    $discipline_10 = FormChars($_POST['discipline_10']);
    $discipline_11 = FormChars($_POST['discipline_11']);
    $discipline_12 = FormChars($_POST['discipline_12']);
    $discipline_13 = FormChars($_POST['discipline_13']);
    $discipline_14 = FormChars($_POST['discipline_14']);
    $discipline_15 = FormChars($_POST['discipline_15']);
    $discipline_16 = FormChars($_POST['discipline_16']);
    $discipline_17 = FormChars($_POST['discipline_17']);
    $discipline_18 = FormChars($_POST['discipline_18']);
    $discipline_19 = FormChars($_POST['discipline_19']);
    $discipline_20 = FormChars($_POST['discipline_20']);
    $discipline_21 = FormChars($_POST['discipline_21']);
    $discipline_22 = FormChars($_POST['discipline_22']);
    $discipline_23 = FormChars($_POST['discipline_23']);
    $discipline_24 = FormChars($_POST['discipline_24']);
    $discipline_25 = FormChars($_POST['discipline_25']); // 25
   }
   // Загнали максимально возможное кол-во групп и дисциплин
   // теперь нужное кол-во заносим
   // ********* Подумать об оптимизации можно в принципе. к примеру удалить лишние переменные,но это довольно таки потом))))
   // Start massive
    $i=0;
  echo "Итерации групп<br/>";
  echo "|";
  $groups_array = array();
  while($pole_count_groups != $i)
  {
    $i++;
    if (empty(${'groups_'.$i}) == 0 )
    {   
      array_push($groups_array,"${'groups_'.$i} ");
    }
    echo "&#9; $i";
  }
  // КОНЕЦ ПЕРЕНОСА ДАННЫХ В МАССИВ
  print_r($groups_array);
  // Start massivе
   $i=0;
   echo "Итерации дисциплин<br/>";
  echo "|";
  $discipline_array = array();
  while($pole_count_discipline != $i)
  {
    $i++;
    if (empty(${'discipline_'.$i}) == 0 )
    {   
      array_push($discipline_array,"${'discipline_'.$i} ");
    }
    echo "&#9; $i";
  }
  print_r($discipline_array);
  // КОНЕЦ ПЕРЕНОСА ДАННЫХ В МАССИВ
$temp = "";
  if(count($groups_array) != 0)
  {

      for($j = 0; $j < count($groups_array); $j ++ )
      {
      $temp = $groups_array[$j];
      mysqli_query($CONNECT, "INSERT INTO `groupsandlesson` VALUES ('', '$teacher','1','0','$temp', NOW() )" ); // поле группа 1 . дис-а 0
      }
      mysqli_query($CONNECT, "INSERT INTO `groupsandlesson` VALUES ('', '-', '-', '-','-', NOW() )" );
  }
  else{
    MessageSend(1,'Ошибка подсчета/ввода кол-ва элементов преподоваемых ГРУПП. Или Вы вовсе ничего не ввели.');
    exit("<meta http-equiv='refresh' content='0; url= /groups_n_discipline'>");
  }
  if(count($discipline_array) != 0)
  {
      for($j = 0; $j < count($discipline_array); $j ++ )
      {
        $temp = $discipline_array[$j];
      mysqli_query($CONNECT, "INSERT INTO `groupsandlesson` VALUES ('', '$teacher','0','1', '$temp', NOW() )" ); // поле дис-а 1 . гр-а 0
      }
      mysqli_query($CONNECT, "INSERT INTO `groupsandlesson` VALUES ('', '-', '-', '-','-', NOW() )" );
  }
  else{
    MessageSend(1,'Ошибка подсчета/ввода кол-ва элементов преподоваемых ДИСЦИПЛИНЫ. Или Вы вовсе ничего не ввели.');
    exit("<meta http-equiv='refresh' content='0; url= /groups_n_discipline'>");
  }

  
  exit("<meta http-equiv='refresh' content='0; url= /addtwo'>");
}

if ($Module == 'addstagetwoprefinal' and $_POST['enter'])
{
   // из-за ПЛОХОГО кода в дальнейшем - это только отсутствие преобразования имени
   // переменной в ПОСТ-запросе. -_-
   $teacher = FormChars($_POST['teacher']);
   $pole_monday = FormChars($_POST['monday']);
   $pole_tuesday = FormChars($_POST['tuesday']);
   $pole_wednesday = FormChars($_POST['wednesday']);
   $pole_thursday = FormChars($_POST['thursday']);
   $pole_friday = FormChars($_POST['friday']);
   $pole_saturday = FormChars($_POST['saturday']);
 
 
  // пришлось пока что переменные в тупую переписывать

  // start day
  $field = 'monday_';
  if($pole_monday != '0' or $pole_monday != "" or $pole_monday != " ")
  {
    
    $atime = FormChars($_POST['atime_monday_1']); // ручной ввод
    $btime = FormChars($_POST['btime_monday_1']); // ввод из списка
    if(empty($atime) == 0 ) ${'time_'.$field.'1'} = $atime;
    else { ${'time_'.$field.'1'} = $btime;}
    
    //
    $atime = FormChars($_POST['atime_monday_2']); // ручной ввод
    $btime = FormChars($_POST['btime_monday_2']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'2'} = $atime;
    else { ${'time_'.$field.'2'} = $btime;}
    //
    $atime = FormChars($_POST['atime_monday_3']); // ручной ввод
    $btime = FormChars($_POST['btime_monday_3']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'3'} = $atime;
    else { ${'time_'.$field.'3'} = $btime;} 
    //
    $atime = FormChars($_POST['atime_monday_4']); // ручной ввод
    $btime = FormChars($_POST['btime_monday_4']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'4'} = $atime;
    else { ${'time_'.$field.'4'} = $btime; }
    //
    $atime = FormChars($_POST['atime_monday_5']); // ручной ввод
    $btime = FormChars($_POST['btime_monday_5']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'5'} = $atime;
    else  {${'time_'.$field.'5'} = $btime;} 
    //
    $atime = FormChars($_POST['atime_monday_6']); // ручной ввод
    $btime = FormChars($_POST['btime_monday_6']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'6'} = $atime;
    else { ${'time_'.$field.'6'} = $btime; }
    //
    $atime = FormChars($_POST['atime_monday_7']); // ручной ввод
    $btime = FormChars($_POST['btime_monday_7']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'7'} = $atime;
    else { ${'time_'.$field.'7'} = $btime; }
    //
    $atime = FormChars($_POST['atime_monday_8']); // ручной ввод
    $btime = FormChars($_POST['btime_monday_8']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'8'} = $atime;
    else  {${'time_'.$field.'8'} = $btime; }
    //
    $atime = FormChars($_POST['atime_monday_9']); // ручной ввод
    $btime = FormChars($_POST['btime_monday_9']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'9'} = $atime;
    else { ${'time_'.$field.'9'} = $btime;}
    /*  
     ${'time_'.$field.'1'} = FormChars($_POST['time_monday_1']); // will -> time_monday_1
     ${'time_'.$field.'2'} = FormChars($_POST['time_monday_2']);
     ${'time_'.$field.'3'} = FormChars($_POST['time_monday_3']);
     ${'time_'.$field.'4'} = FormChars($_POST['time_monday_4']);
     ${'time_'.$field.'5'} = FormChars($_POST['time_monday_5']);
     ${'time_'.$field.'6'} = FormChars($_POST['time_monday_6']);
     ${'time_'.$field.'7'} = FormChars($_POST['time_monday_7']);
     ${'time_'.$field.'8'} = FormChars($_POST['time_monday_8']);
     ${'time_'.$field.'9'} = FormChars($_POST['time_monday_9']);
     */
     ${'parity_of_week_'.$field.'1'}= FormChars($_POST['parity_of_week_monday_1']);
     ${'parity_of_week_'.$field.'2'}= FormChars($_POST['parity_of_week_monday_2']);
     ${'parity_of_week_'.$field.'3'}= FormChars($_POST['parity_of_week_monday_3']);
     ${'parity_of_week_'.$field.'4'}= FormChars($_POST['parity_of_week_monday_4']);
     ${'parity_of_week_'.$field.'5'}= FormChars($_POST['parity_of_week_monday_5']);
     ${'parity_of_week_'.$field.'6'}= FormChars($_POST['parity_of_week_monday_6']);
     ${'parity_of_week_'.$field.'7'}= FormChars($_POST['parity_of_week_monday_7']);
     ${'parity_of_week_'.$field.'8'}= FormChars($_POST['parity_of_week_monday_8']);
     ${'parity_of_week_'.$field.'9'}= FormChars($_POST['parity_of_week_monday_9']);


     $atime = FormChars($_POST['aabout_lesson_monday_1']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_monday_1']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'1'} = $atime;
     else { ${'about_lesson_'.$field.'1'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_monday_2']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_monday_2']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'2'} = $atime;
     else { ${'about_lesson_'.$field.'2'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_monday_3']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_monday_3']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'3'} = $atime;
     else { ${'about_lesson_'.$field.'3'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_monday_4']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_monday_4']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'4'} = $atime;
     else { ${'about_lesson_'.$field.'4'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_monday_5']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_monday_5']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'5'} = $atime;
     else { ${'about_lesson_'.$field.'5'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_monday_6']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_monday_6']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'6'} = $atime;
     else { ${'about_lesson_'.$field.'6'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_monday_7']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_monday_7']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'7'} = $atime;
     else { ${'about_lesson_'.$field.'7'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_monday_8']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_monday_8']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'8'} = $atime;
     else { ${'about_lesson_'.$field.'8'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_monday_9']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_monday_9']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'9'} = $atime;
     else { ${'about_lesson_'.$field.'9'} = $btime;}
     // 
     // контактенация строк из описания пары и типа ее
     // cont.
     $ctemp = FormChars($_POST['type_lesson_monday_1']);
     ${'about_lesson_'.$field.'1'} = ${'about_lesson_'.$field.'1'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_monday_2']);
      ${'about_lesson_'.$field.'2'} = ${'about_lesson_'.$field.'2'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_monday_3']);
      ${'about_lesson_'.$field.'3'} = ${'about_lesson_'.$field.'3'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_monday_4']);
      ${'about_lesson_'.$field.'4'} = ${'about_lesson_'.$field.'4'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_monday_5']);
      ${'about_lesson_'.$field.'5'} = ${'about_lesson_'.$field.'5'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_monday_6']);
      ${'about_lesson_'.$field.'6'} = ${'about_lesson_'.$field.'6'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_monday_7']);
      ${'about_lesson_'.$field.'7'} = ${'about_lesson_'.$field.'7'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_monday_8']);
      ${'about_lesson_'.$field.'8'} = ${'about_lesson_'.$field.'8'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_monday_9']);
      ${'about_lesson_'.$field.'9'} = ${'about_lesson_'.$field.'9'}.",".$ctemp;
     /*
     ${'about_lesson_'.$field.'1'}= FormChars($_POST['about_lesson_monday_1']);
     ${'about_lesson_'.$field.'2'}= FormChars($_POST['about_lesson_monday_2']);
     ${'about_lesson_'.$field.'3'}= FormChars($_POST['about_lesson_monday_3']);
     ${'about_lesson_'.$field.'4'}= FormChars($_POST['about_lesson_monday_4']);
     ${'about_lesson_'.$field.'5'}= FormChars($_POST['about_lesson_monday_5']);
     ${'about_lesson_'.$field.'6'}= FormChars($_POST['about_lesson_monday_6']);
     ${'about_lesson_'.$field.'7'}= FormChars($_POST['about_lesson_monday_7']);
     ${'about_lesson_'.$field.'8'}= FormChars($_POST['about_lesson_monday_8']);
     ${'about_lesson_'.$field.'9'}= FormChars($_POST['about_lesson_monday_9']);
     */
     ${'selected_group_'.$field.'1'}=FormChars($_POST['selected_group_monday_1']);
     ${'selected_group_'.$field.'2'}=FormChars($_POST['selected_group_monday_2']);
     ${'selected_group_'.$field.'3'}=FormChars($_POST['selected_group_monday_3']);
     ${'selected_group_'.$field.'4'}=FormChars($_POST['selected_group_monday_4']);
     ${'selected_group_'.$field.'5'}=FormChars($_POST['selected_group_monday_5']);
     ${'selected_group_'.$field.'6'}=FormChars($_POST['selected_group_monday_6']);
     ${'selected_group_'.$field.'7'}=FormChars($_POST['selected_group_monday_7']);
     ${'selected_group_'.$field.'8'}=FormChars($_POST['selected_group_monday_8']);
     ${'selected_group_'.$field.'9'}=FormChars($_POST['selected_group_monday_9']);

     ${'classroom_'.$field.'1'} = FormChars($_POST['classroom_monday_1']);
     ${'classroom_'.$field.'2'} = FormChars($_POST['classroom_monday_2']);
     ${'classroom_'.$field.'3'} = FormChars($_POST['classroom_monday_3']);
     ${'classroom_'.$field.'4'} = FormChars($_POST['classroom_monday_4']);
     ${'classroom_'.$field.'5'} = FormChars($_POST['classroom_monday_5']);
     ${'classroom_'.$field.'6'} = FormChars($_POST['classroom_monday_6']);
     ${'classroom_'.$field.'7'} = FormChars($_POST['classroom_monday_7']);
     ${'classroom_'.$field.'8'} = FormChars($_POST['classroom_monday_8']);
     ${'classroom_'.$field.'9'} = FormChars($_POST['classroom_monday_9']);
  }
  // end day
  // start day
  $field = 'tuesday_';
  if($pole_monday != '0' or $pole_monday != "" or $pole_monday != " ")
  {
    $atime = FormChars($_POST['atime_tuesday_1']); // ручной ввод
    $btime = FormChars($_POST['btime_tuesday_1']); // ввод из списка
    if(empty($atime) == 0 ) ${'time_'.$field.'1'} = $atime;
    else { ${'time_'.$field.'1'} = $btime;}
    
    //
    $atime = FormChars($_POST['atime_tuesday_2']); // ручной ввод
    $btime = FormChars($_POST['btime_tuesday_2']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'2'} = $atime;
    else { ${'time_'.$field.'2'} = $btime;}
    //
    $atime = FormChars($_POST['atime_tuesday_3']); // ручной ввод
    $btime = FormChars($_POST['btime_tuesday_3']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'3'} = $atime;
    else { ${'time_'.$field.'3'} = $btime;} 
    //
    $atime = FormChars($_POST['atime_tuesday_4']); // ручной ввод
    $btime = FormChars($_POST['btime_tuesday_4']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'4'} = $atime;
    else { ${'time_'.$field.'4'} = $btime; }
    //
    $atime = FormChars($_POST['atime_tuesday_5']); // ручной ввод
    $btime = FormChars($_POST['btime_tuesday_5']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'5'} = $atime;
    else  {${'time_'.$field.'5'} = $btime;} 
    //
    $atime = FormChars($_POST['atime_tuesday_6']); // ручной ввод
    $btime = FormChars($_POST['btime_tuesday_6']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'6'} = $atime;
    else { ${'time_'.$field.'6'} = $btime; }
    //
    $atime = FormChars($_POST['atime_tuesday_7']); // ручной ввод
    $btime = FormChars($_POST['btime_tuesday_7']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'7'} = $atime;
    else { ${'time_'.$field.'7'} = $btime; }
    //
    $atime = FormChars($_POST['atime_tuesday_8']); // ручной ввод
    $btime = FormChars($_POST['btime_tuesday_8']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'8'} = $atime;
    else  {${'time_'.$field.'8'} = $btime; }
    //
    $atime = FormChars($_POST['atime_tuesday_9']); // ручной ввод
    $btime = FormChars($_POST['btime_tuesday_9']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'9'} = $atime;
    else { ${'time_'.$field.'9'} = $btime;}

     ${'parity_of_week_'.$field.'1'}= FormChars($_POST['parity_of_week_tuesday_1']);
     ${'parity_of_week_'.$field.'2'}= FormChars($_POST['parity_of_week_tuesday_2']);
     ${'parity_of_week_'.$field.'3'}= FormChars($_POST['parity_of_week_tuesday_3']);
     ${'parity_of_week_'.$field.'4'}= FormChars($_POST['parity_of_week_tuesday_4']);
     ${'parity_of_week_'.$field.'5'}= FormChars($_POST['parity_of_week_tuesday_5']);
     ${'parity_of_week_'.$field.'6'}= FormChars($_POST['parity_of_week_tuesday_6']);
     ${'parity_of_week_'.$field.'7'}= FormChars($_POST['parity_of_week_tuesday_7']);
     ${'parity_of_week_'.$field.'8'}= FormChars($_POST['parity_of_week_tuesday_8']);
     ${'parity_of_week_'.$field.'9'}= FormChars($_POST['parity_of_week_tuesday_9']);

     $atime = FormChars($_POST['aabout_lesson_tuesday_1']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_tuesday_1']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'1'} = $atime;
     else { ${'about_lesson_'.$field.'1'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_tuesday_2']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_tuesday_2']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'2'} = $atime;
     else { ${'about_lesson_'.$field.'2'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_tuesday_3']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_tuesday_3']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'3'} = $atime;
     else { ${'about_lesson_'.$field.'3'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_tuesday_4']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_tuesday_4']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'4'} = $atime;
     else { ${'about_lesson_'.$field.'4'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_tuesday_5']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_tuesday_5']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'5'} = $atime;
     else { ${'about_lesson_'.$field.'5'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_tuesday_6']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_tuesday_6']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'6'} = $atime;
     else { ${'about_lesson_'.$field.'6'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_tuesday_7']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_tuesday_7']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'7'} = $atime;
     else { ${'about_lesson_'.$field.'7'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_tuesday_8']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_tuesday_8']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'8'} = $atime;
     else { ${'about_lesson_'.$field.'8'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_tuesday_9']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_tuesday_9']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'9'} = $atime;
     else { ${'about_lesson_'.$field.'9'} = $btime;}
     //
     $ctemp = FormChars($_POST['type_lesson_tuesday_1']);
     ${'about_lesson_'.$field.'1'} = ${'about_lesson_'.$field.'1'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_tuesday_2']);
      ${'about_lesson_'.$field.'2'} = ${'about_lesson_'.$field.'2'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_tuesday_3']);
      ${'about_lesson_'.$field.'3'} = ${'about_lesson_'.$field.'3'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_tuesday_4']);
      ${'about_lesson_'.$field.'4'} = ${'about_lesson_'.$field.'4'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_tuesday_5']);
      ${'about_lesson_'.$field.'5'} = ${'about_lesson_'.$field.'5'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_tuesday_6']);
      ${'about_lesson_'.$field.'6'} = ${'about_lesson_'.$field.'6'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_tuesday_7']);
      ${'about_lesson_'.$field.'7'} = ${'about_lesson_'.$field.'7'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_tuesday_8']);
      ${'about_lesson_'.$field.'8'} = ${'about_lesson_'.$field.'8'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_tuesday_9']);
      ${'about_lesson_'.$field.'9'} = ${'about_lesson_'.$field.'9'}.",".$ctemp;

     ${'selected_group_'.$field.'1'}=FormChars($_POST['selected_group_tuesday_1']);
     ${'selected_group_'.$field.'2'}=FormChars($_POST['selected_group_tuesday_2']);
     ${'selected_group_'.$field.'3'}=FormChars($_POST['selected_group_tuesday_3']);
     ${'selected_group_'.$field.'4'}=FormChars($_POST['selected_group_tuesday_4']);
     ${'selected_group_'.$field.'5'}=FormChars($_POST['selected_group_tuesday_5']);
     ${'selected_group_'.$field.'6'}=FormChars($_POST['selected_group_tuesday_6']);
     ${'selected_group_'.$field.'7'}=FormChars($_POST['selected_group_tuesday_7']);
     ${'selected_group_'.$field.'8'}=FormChars($_POST['selected_group_tuesday_8']);
     ${'selected_group_'.$field.'9'}=FormChars($_POST['selected_group_tuesday_9']);

     ${'classroom_'.$field.'1'} = FormChars($_POST['classroom_tuesday_1']);
     ${'classroom_'.$field.'2'} = FormChars($_POST['classroom_tuesday_2']);
     ${'classroom_'.$field.'3'} = FormChars($_POST['classroom_tuesday_3']);
     ${'classroom_'.$field.'4'} = FormChars($_POST['classroom_tuesday_4']);
     ${'classroom_'.$field.'5'} = FormChars($_POST['classroom_tuesday_5']);
     ${'classroom_'.$field.'6'} = FormChars($_POST['classroom_tuesday_6']);
     ${'classroom_'.$field.'7'} = FormChars($_POST['classroom_tuesday_7']);
     ${'classroom_'.$field.'8'} = FormChars($_POST['classroom_tuesday_8']);
     ${'classroom_'.$field.'9'} = FormChars($_POST['classroom_tuesday_9']);
  }
  // end day
  // start day
  $field = 'wednesday_';
  if($pole_monday != '0' or $pole_monday != "" or $pole_monday != " ")
  {
     $atime = FormChars($_POST['atime_wednesday_1']); // ручной ввод
    $btime = FormChars($_POST['btime_wednesday_1']); // ввод из списка
    if(empty($atime) == 0 ) ${'time_'.$field.'1'} = $atime;
    else { ${'time_'.$field.'1'} = $btime;}
    
    //
    $atime = FormChars($_POST['atime_wednesday_2']); // ручной ввод
    $btime = FormChars($_POST['btime_wednesday_2']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'2'} = $atime;
    else { ${'time_'.$field.'2'} = $btime;}
    //
    $atime = FormChars($_POST['atime_wednesday_3']); // ручной ввод
    $btime = FormChars($_POST['btime_wednesday_3']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'3'} = $atime;
    else { ${'time_'.$field.'3'} = $btime;} 
    //
    $atime = FormChars($_POST['atime_wednesday_4']); // ручной ввод
    $btime = FormChars($_POST['btime_wednesday_4']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'4'} = $atime;
    else { ${'time_'.$field.'4'} = $btime; }
    //
    $atime = FormChars($_POST['atime_wednesday_5']); // ручной ввод
    $btime = FormChars($_POST['btime_wednesday_5']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'5'} = $atime;
    else  {${'time_'.$field.'5'} = $btime;} 
    //
    $atime = FormChars($_POST['atime_wednesday_6']); // ручной ввод
    $btime = FormChars($_POST['btime_wednesday_6']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'6'} = $atime;
    else { ${'time_'.$field.'6'} = $btime; }
    //
    $atime = FormChars($_POST['atime_wednesday_7']); // ручной ввод
    $btime = FormChars($_POST['btime_wednesday_7']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'7'} = $atime;
    else { ${'time_'.$field.'7'} = $btime; }
    //
    $atime = FormChars($_POST['atime_wednesday_8']); // ручной ввод
    $btime = FormChars($_POST['btime_wednesday_8']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'8'} = $atime;
    else  {${'time_'.$field.'8'} = $btime; }
    //
    $atime = FormChars($_POST['atime_wednesday_9']); // ручной ввод
    $btime = FormChars($_POST['btime_wednesday_9']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'9'} = $atime;
    else { ${'time_'.$field.'9'} = $btime;}
     
     ${'parity_of_week_'.$field.'1'}= FormChars($_POST['parity_of_week_wednesday_1']);
     ${'parity_of_week_'.$field.'2'}= FormChars($_POST['parity_of_week_wednesday_2']);
     ${'parity_of_week_'.$field.'3'}= FormChars($_POST['parity_of_week_wednesday_3']);
     ${'parity_of_week_'.$field.'4'}= FormChars($_POST['parity_of_week_wednesday_4']);
     ${'parity_of_week_'.$field.'5'}= FormChars($_POST['parity_of_week_wednesday_5']);
     ${'parity_of_week_'.$field.'6'}= FormChars($_POST['parity_of_week_wednesday_6']);
     ${'parity_of_week_'.$field.'7'}= FormChars($_POST['parity_of_week_wednesday_7']);
     ${'parity_of_week_'.$field.'8'}= FormChars($_POST['parity_of_week_wednesday_8']);
     ${'parity_of_week_'.$field.'9'}= FormChars($_POST['parity_of_week_wednesday_9']);

     $atime = FormChars($_POST['aabout_lesson_wednesday_1']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_wednesday_1']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'1'} = $atime;
     else { ${'about_lesson_'.$field.'1'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_wednesday_2']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_wednesday_2']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'2'} = $atime;
     else { ${'about_lesson_'.$field.'2'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_wednesday_3']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_wednesday_3']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'3'} = $atime;
     else { ${'about_lesson_'.$field.'3'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_wednesday_4']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_wednesday_4']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'4'} = $atime;
     else { ${'about_lesson_'.$field.'4'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_wednesday_5']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_wednesday_5']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'5'} = $atime;
     else { ${'about_lesson_'.$field.'5'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_wednesday_6']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_wednesday_6']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'6'} = $atime;
     else { ${'about_lesson_'.$field.'6'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_wednesday_7']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_wednesday_7']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'7'} = $atime;
     else { ${'about_lesson_'.$field.'7'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_wednesday_8']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_wednesday_8']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'8'} = $atime;
     else { ${'about_lesson_'.$field.'8'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_wednesday_9']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_wednesday_9']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'9'} = $atime;
     else { ${'about_lesson_'.$field.'9'} = $btime;}
     //
     $ctemp = FormChars($_POST['type_lesson_wednesday_1']);
     ${'about_lesson_'.$field.'1'} = ${'about_lesson_'.$field.'1'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_wednesday_2']);
      ${'about_lesson_'.$field.'2'} = ${'about_lesson_'.$field.'2'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_wednesday_3']);
      ${'about_lesson_'.$field.'3'} = ${'about_lesson_'.$field.'3'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_wednesday_4']);
      ${'about_lesson_'.$field.'4'} = ${'about_lesson_'.$field.'4'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_wednesday_5']);
      ${'about_lesson_'.$field.'5'} = ${'about_lesson_'.$field.'5'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_wednesday_6']);
      ${'about_lesson_'.$field.'6'} = ${'about_lesson_'.$field.'6'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_wednesday_7']);
      ${'about_lesson_'.$field.'7'} = ${'about_lesson_'.$field.'7'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_wednesday_8']);
      ${'about_lesson_'.$field.'8'} = ${'about_lesson_'.$field.'8'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_wednesday_9']);
      ${'about_lesson_'.$field.'9'} = ${'about_lesson_'.$field.'9'}.",".$ctemp;

     ${'selected_group_'.$field.'1'}=FormChars($_POST['selected_group_wednesday_1']);
     ${'selected_group_'.$field.'2'}=FormChars($_POST['selected_group_wednesday_2']);
     ${'selected_group_'.$field.'3'}=FormChars($_POST['selected_group_wednesday_3']);
     ${'selected_group_'.$field.'4'}=FormChars($_POST['selected_group_wednesday_4']);
     ${'selected_group_'.$field.'5'}=FormChars($_POST['selected_group_wednesday_5']);
     ${'selected_group_'.$field.'6'}=FormChars($_POST['selected_group_wednesday_6']);
     ${'selected_group_'.$field.'7'}=FormChars($_POST['selected_group_wednesday_7']);
     ${'selected_group_'.$field.'8'}=FormChars($_POST['selected_group_wednesday_8']);
     ${'selected_group_'.$field.'9'}=FormChars($_POST['selected_group_wednesday_9']);

     ${'classroom_'.$field.'1'} = FormChars($_POST['classroom_wednesday_1']);
     ${'classroom_'.$field.'2'} = FormChars($_POST['classroom_wednesday_2']);
     ${'classroom_'.$field.'3'} = FormChars($_POST['classroom_wednesday_3']);
     ${'classroom_'.$field.'4'} = FormChars($_POST['classroom_wednesday_4']);
     ${'classroom_'.$field.'5'} = FormChars($_POST['classroom_wednesday_5']);
     ${'classroom_'.$field.'6'} = FormChars($_POST['classroom_wednesday_6']);
     ${'classroom_'.$field.'7'} = FormChars($_POST['classroom_wednesday_7']);
     ${'classroom_'.$field.'8'} = FormChars($_POST['classroom_wednesday_8']);
     ${'classroom_'.$field.'9'} = FormChars($_POST['classroom_wednesday_9']);
  }
  // end day
  // start day
  $field = 'thursday_';
  if($pole_monday != '0' or $pole_monday != "" or $pole_monday != " ")
  {
    $atime = FormChars($_POST['atime_thursday_1']); // ручной ввод
    $btime = FormChars($_POST['btime_thursday_1']); // ввод из списка
    if(empty($atime) == 0 ) ${'time_'.$field.'1'} = $atime;
    else { ${'time_'.$field.'1'} = $btime;}
    
    //
    $atime = FormChars($_POST['atime_thursday_2']); // ручной ввод
    $btime = FormChars($_POST['btime_thursday_2']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'2'} = $atime;
    else { ${'time_'.$field.'2'} = $btime;}
    //
    $atime = FormChars($_POST['atime_thursday_3']); // ручной ввод
    $btime = FormChars($_POST['btime_thursday_3']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'3'} = $atime;
    else { ${'time_'.$field.'3'} = $btime;} 
    //
    $atime = FormChars($_POST['atime_thursday_4']); // ручной ввод
    $btime = FormChars($_POST['btime_thursday_4']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'4'} = $atime;
    else { ${'time_'.$field.'4'} = $btime; }
    //
    $atime = FormChars($_POST['atime_thursday_5']); // ручной ввод
    $btime = FormChars($_POST['btime_thursday_5']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'5'} = $atime;
    else  {${'time_'.$field.'5'} = $btime;} 
    //
    $atime = FormChars($_POST['atime_thursday_6']); // ручной ввод
    $btime = FormChars($_POST['btime_thursday_6']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'6'} = $atime;
    else { ${'time_'.$field.'6'} = $btime; }
    //
    $atime = FormChars($_POST['atime_thursday_7']); // ручной ввод
    $btime = FormChars($_POST['btime_thursday_7']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'7'} = $atime;
    else { ${'time_'.$field.'7'} = $btime; }
    //
    $atime = FormChars($_POST['atime_thursday_8']); // ручной ввод
    $btime = FormChars($_POST['btime_thursday_8']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'8'} = $atime;
    else  {${'time_'.$field.'8'} = $btime; }
    //
    $atime = FormChars($_POST['atime_thursday_9']); // ручной ввод
    $btime = FormChars($_POST['btime_thursday_9']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'9'} = $atime;
    else { ${'time_'.$field.'9'} = $btime;}

     ${'parity_of_week_'.$field.'1'}= FormChars($_POST['parity_of_week_thursday_1']);
     ${'parity_of_week_'.$field.'2'}= FormChars($_POST['parity_of_week_thursday_2']);
     ${'parity_of_week_'.$field.'3'}= FormChars($_POST['parity_of_week_thursday_3']);
     ${'parity_of_week_'.$field.'4'}= FormChars($_POST['parity_of_week_thursday_4']);
     ${'parity_of_week_'.$field.'5'}= FormChars($_POST['parity_of_week_thursday_5']);
     ${'parity_of_week_'.$field.'6'}= FormChars($_POST['parity_of_week_thursday_6']);
     ${'parity_of_week_'.$field.'7'}= FormChars($_POST['parity_of_week_thursday_7']);
     ${'parity_of_week_'.$field.'8'}= FormChars($_POST['parity_of_week_thursday_8']);
     ${'parity_of_week_'.$field.'9'}= FormChars($_POST['parity_of_week_thursday_9']);

     $atime = FormChars($_POST['aabout_lesson_thursday_1']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_thursday_1']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'1'} = $atime;
     else { ${'about_lesson_'.$field.'1'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_thursday_2']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_thursday_2']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'2'} = $atime;
     else { ${'about_lesson_'.$field.'2'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_thursday_3']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_thursday_3']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'3'} = $atime;
     else { ${'about_lesson_'.$field.'3'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_thursday_4']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_thursday_4']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'4'} = $atime;
     else { ${'about_lesson_'.$field.'4'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_thursday_5']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_thursday_5']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'5'} = $atime;
     else { ${'about_lesson_'.$field.'5'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_thursday_6']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_thursday_6']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'6'} = $atime;
     else { ${'about_lesson_'.$field.'6'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_thursday_7']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_thursday_7']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'7'} = $atime;
     else { ${'about_lesson_'.$field.'7'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_thursday_8']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_thursday_8']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'8'} = $atime;
     else { ${'about_lesson_'.$field.'8'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_thursday_9']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_thursday_9']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'9'} = $atime;
     else { ${'about_lesson_'.$field.'9'} = $btime;}
     //
     $ctemp = FormChars($_POST['type_lesson_thursday_1']);
     ${'about_lesson_'.$field.'1'} = ${'about_lesson_'.$field.'1'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_thursday_2']);
      ${'about_lesson_'.$field.'2'} = ${'about_lesson_'.$field.'2'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_thursday_3']);
      ${'about_lesson_'.$field.'3'} = ${'about_lesson_'.$field.'3'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_thursday_4']);
      ${'about_lesson_'.$field.'4'} = ${'about_lesson_'.$field.'4'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_thursday_5']);
      ${'about_lesson_'.$field.'5'} = ${'about_lesson_'.$field.'5'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_thursday_6']);
      ${'about_lesson_'.$field.'6'} = ${'about_lesson_'.$field.'6'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_thursday_7']);
      ${'about_lesson_'.$field.'7'} = ${'about_lesson_'.$field.'7'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_thursday_8']);
      ${'about_lesson_'.$field.'8'} = ${'about_lesson_'.$field.'8'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_thursday_9']);
      ${'about_lesson_'.$field.'9'} = ${'about_lesson_'.$field.'9'}.",".$ctemp;

     ${'selected_group_'.$field.'1'}=FormChars($_POST['selected_group_thursday_1']);
     ${'selected_group_'.$field.'2'}=FormChars($_POST['selected_group_thursday_2']);
     ${'selected_group_'.$field.'3'}=FormChars($_POST['selected_group_thursday_3']);
     ${'selected_group_'.$field.'4'}=FormChars($_POST['selected_group_thursday_4']);
     ${'selected_group_'.$field.'5'}=FormChars($_POST['selected_group_thursday_5']);
     ${'selected_group_'.$field.'6'}=FormChars($_POST['selected_group_thursday_6']);
     ${'selected_group_'.$field.'7'}=FormChars($_POST['selected_group_thursday_7']);
     ${'selected_group_'.$field.'8'}=FormChars($_POST['selected_group_thursday_8']);
     ${'selected_group_'.$field.'9'}=FormChars($_POST['selected_group_thursday_9']);

     ${'classroom_'.$field.'1'} = FormChars($_POST['classroom_thursday_1']);
     ${'classroom_'.$field.'2'} = FormChars($_POST['classroom_thursday_2']);
     ${'classroom_'.$field.'3'} = FormChars($_POST['classroom_thursday_3']);
     ${'classroom_'.$field.'4'} = FormChars($_POST['classroom_thursday_4']);
     ${'classroom_'.$field.'5'} = FormChars($_POST['classroom_thursday_5']);
     ${'classroom_'.$field.'6'} = FormChars($_POST['classroom_thursday_6']);
     ${'classroom_'.$field.'7'} = FormChars($_POST['classroom_thursday_7']);
     ${'classroom_'.$field.'8'} = FormChars($_POST['classroom_thursday_8']);
     ${'classroom_'.$field.'9'} = FormChars($_POST['classroom_thursday_9']);
  }
  // end day
  // start day
  $field = 'friday_';
  if($pole_monday != '0' or $pole_monday != "" or $pole_monday != " ")
  {
     $atime = FormChars($_POST['atime_friday_1']); // ручной ввод
    $btime = FormChars($_POST['btime_friday_1']); // ввод из списка
    if(empty($atime) == 0 ) ${'time_'.$field.'1'} = $atime;
    else { ${'time_'.$field.'1'} = $btime;}
    
    //
    $atime = FormChars($_POST['atime_friday_2']); // ручной ввод
    $btime = FormChars($_POST['btime_friday_2']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'2'} = $atime;
    else { ${'time_'.$field.'2'} = $btime;}
    //
    $atime = FormChars($_POST['atime_friday_3']); // ручной ввод
    $btime = FormChars($_POST['btime_friday_3']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'3'} = $atime;
    else { ${'time_'.$field.'3'} = $btime;} 
    //
    $atime = FormChars($_POST['atime_friday_4']); // ручной ввод
    $btime = FormChars($_POST['btime_friday_4']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'4'} = $atime;
    else { ${'time_'.$field.'4'} = $btime; }
    //
    $atime = FormChars($_POST['atime_friday_5']); // ручной ввод
    $btime = FormChars($_POST['btime_friday_5']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'5'} = $atime;
    else  {${'time_'.$field.'5'} = $btime;} 
    //
    $atime = FormChars($_POST['atime_monday_6']); // ручной ввод
    $btime = FormChars($_POST['btime_monday_6']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'6'} = $atime;
    else { ${'time_'.$field.'6'} = $btime; }
    //
    $atime = FormChars($_POST['atime_friday_7']); // ручной ввод
    $btime = FormChars($_POST['btime_friday_7']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'7'} = $atime;
    else { ${'time_'.$field.'7'} = $btime; }
    //
    $atime = FormChars($_POST['atime_friday_8']); // ручной ввод
    $btime = FormChars($_POST['btime_friday_8']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'8'} = $atime;
    else  {${'time_'.$field.'8'} = $btime; }
    //
    $atime = FormChars($_POST['atime_friday_9']); // ручной ввод
    $btime = FormChars($_POST['btime_friday_9']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'9'} = $atime;
    else { ${'time_'.$field.'9'} = $btime;}

     ${'parity_of_week_'.$field.'1'}= FormChars($_POST['parity_of_week_friday_1']);
     ${'parity_of_week_'.$field.'2'}= FormChars($_POST['parity_of_week_friday_2']);
     ${'parity_of_week_'.$field.'3'}= FormChars($_POST['parity_of_week_friday_3']);
     ${'parity_of_week_'.$field.'4'}= FormChars($_POST['parity_of_week_friday_4']);
     ${'parity_of_week_'.$field.'5'}= FormChars($_POST['parity_of_week_friday_5']);
     ${'parity_of_week_'.$field.'6'}= FormChars($_POST['parity_of_week_friday_6']);
     ${'parity_of_week_'.$field.'7'}= FormChars($_POST['parity_of_week_friday_7']);
     ${'parity_of_week_'.$field.'8'}= FormChars($_POST['parity_of_week_friday_8']);
     ${'parity_of_week_'.$field.'9'}= FormChars($_POST['parity_of_week_friday_9']);

     $atime = FormChars($_POST['aabout_lesson_friday_1']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_friday_1']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'1'} = $atime;
     else { ${'about_lesson_'.$field.'1'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_friday_2']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_friday_2']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'2'} = $atime;
     else { ${'about_lesson_'.$field.'2'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_friday_3']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_friday_3']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'3'} = $atime;
     else { ${'about_lesson_'.$field.'3'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_friday_4']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_friday_4']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'4'} = $atime;
     else { ${'about_lesson_'.$field.'4'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_friday_5']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_friday_5']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'5'} = $atime;
     else { ${'about_lesson_'.$field.'5'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_friday_6']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_friday_6']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'6'} = $atime;
     else { ${'about_lesson_'.$field.'6'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_friday_7']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_friday_7']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'7'} = $atime;
     else { ${'about_lesson_'.$field.'7'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_friday_8']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_friday_8']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'8'} = $atime;
     else { ${'about_lesson_'.$field.'8'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_friday_9']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_friday_9']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'9'} = $atime;
     else { ${'about_lesson_'.$field.'9'} = $btime;}
     //
     $ctemp = FormChars($_POST['type_lesson_friday_1']);
     ${'about_lesson_'.$field.'1'} = ${'about_lesson_'.$field.'1'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_friday_2']);
      ${'about_lesson_'.$field.'2'} = ${'about_lesson_'.$field.'2'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_friday_3']);
      ${'about_lesson_'.$field.'3'} = ${'about_lesson_'.$field.'3'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_friday_4']);
      ${'about_lesson_'.$field.'4'} = ${'about_lesson_'.$field.'4'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_friday_5']);
      ${'about_lesson_'.$field.'5'} = ${'about_lesson_'.$field.'5'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_friday_6']);
      ${'about_lesson_'.$field.'6'} = ${'about_lesson_'.$field.'6'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_friday_7']);
      ${'about_lesson_'.$field.'7'} = ${'about_lesson_'.$field.'7'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_friday_8']);
      ${'about_lesson_'.$field.'8'} = ${'about_lesson_'.$field.'8'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_friday_9']);
      ${'about_lesson_'.$field.'9'} = ${'about_lesson_'.$field.'9'}.",".$ctemp;

     ${'selected_group_'.$field.'1'}=FormChars($_POST['selected_group_friday_1']);
     ${'selected_group_'.$field.'2'}=FormChars($_POST['selected_group_friday_2']);
     ${'selected_group_'.$field.'3'}=FormChars($_POST['selected_group_friday_3']);
     ${'selected_group_'.$field.'4'}=FormChars($_POST['selected_group_friday_4']);
     ${'selected_group_'.$field.'5'}=FormChars($_POST['selected_group_friday_5']);
     ${'selected_group_'.$field.'6'}=FormChars($_POST['selected_group_friday_6']);
     ${'selected_group_'.$field.'7'}=FormChars($_POST['selected_group_friday_7']);
     ${'selected_group_'.$field.'8'}=FormChars($_POST['selected_group_friday_8']);
     ${'selected_group_'.$field.'9'}=FormChars($_POST['selected_group_friday_9']);

     ${'classroom_'.$field.'1'} = FormChars($_POST['classroom_friday_1']);
     ${'classroom_'.$field.'2'} = FormChars($_POST['classroom_friday_2']);
     ${'classroom_'.$field.'3'} = FormChars($_POST['classroom_friday_3']);
     ${'classroom_'.$field.'4'} = FormChars($_POST['classroom_friday_4']);
     ${'classroom_'.$field.'5'} = FormChars($_POST['classroom_friday_5']);
     ${'classroom_'.$field.'6'} = FormChars($_POST['classroom_friday_6']);
     ${'classroom_'.$field.'7'} = FormChars($_POST['classroom_friday_7']);
     ${'classroom_'.$field.'8'} = FormChars($_POST['classroom_friday_8']);
     ${'classroom_'.$field.'9'} = FormChars($_POST['classroom_friday_9']);
  }
  // end day
  // start day
  $field = 'saturday_';
  if($pole_monday != '0' or $pole_monday != "" or $pole_monday != " ")
  {
     $atime = FormChars($_POST['atime_saturday_1']); // ручной ввод
    $btime = FormChars($_POST['btime_saturday_1']); // ввод из списка
    if(empty($atime) == 0 ) ${'time_'.$field.'1'} = $atime;
    else { ${'time_'.$field.'1'} = $btime;}
    
    //
    $atime = FormChars($_POST['atime_saturday_2']); // ручной ввод
    $btime = FormChars($_POST['btime_saturday_2']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'2'} = $atime;
    else { ${'time_'.$field.'2'} = $btime;}
    //
    $atime = FormChars($_POST['atime_saturday_3']); // ручной ввод
    $btime = FormChars($_POST['btime_saturday_3']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'3'} = $atime;
    else { ${'time_'.$field.'3'} = $btime;} 
    //
    $atime = FormChars($_POST['atime_saturday_4']); // ручной ввод
    $btime = FormChars($_POST['btime_saturday_4']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'4'} = $atime;
    else { ${'time_'.$field.'4'} = $btime; }
    //
    $atime = FormChars($_POST['atime_saturday_5']); // ручной ввод
    $btime = FormChars($_POST['btime_saturday_5']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'5'} = $atime;
    else  {${'time_'.$field.'5'} = $btime;} 
    //
    $atime = FormChars($_POST['atime_saturday_6']); // ручной ввод
    $btime = FormChars($_POST['btime_saturday_6']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'6'} = $atime;
    else { ${'time_'.$field.'6'} = $btime; }
    //
    $atime = FormChars($_POST['atime_saturday_7']); // ручной ввод
    $btime = FormChars($_POST['btime_saturday_7']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'7'} = $atime;
    else { ${'time_'.$field.'7'} = $btime; }
    //
    $atime = FormChars($_POST['atime_saturday_8']); // ручной ввод
    $btime = FormChars($_POST['btime_saturday_8']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'8'} = $atime;
    else  {${'time_'.$field.'8'} = $btime; }
    //
    $atime = FormChars($_POST['atime_saturday_9']); // ручной ввод
    $btime = FormChars($_POST['btime_saturday_9']); // ввод из списка
    if(empty($atime) == 0  ) ${'time_'.$field.'9'} = $atime;
    else { ${'time_'.$field.'9'} = $btime;}

     ${'parity_of_week_'.$field.'1'}= FormChars($_POST['parity_of_week_saturday_1']);
     ${'parity_of_week_'.$field.'2'}= FormChars($_POST['parity_of_week_saturday_2']);
     ${'parity_of_week_'.$field.'3'}= FormChars($_POST['parity_of_week_saturday_3']);
     ${'parity_of_week_'.$field.'4'}= FormChars($_POST['parity_of_week_saturday_4']);
     ${'parity_of_week_'.$field.'5'}= FormChars($_POST['parity_of_week_saturday_5']);
     ${'parity_of_week_'.$field.'6'}= FormChars($_POST['parity_of_week_saturday_6']);
     ${'parity_of_week_'.$field.'7'}= FormChars($_POST['parity_of_week_saturday_7']);
     ${'parity_of_week_'.$field.'8'}= FormChars($_POST['parity_of_week_saturday_8']);
     ${'parity_of_week_'.$field.'9'}= FormChars($_POST['parity_of_week_saturday_9']);

     $atime = FormChars($_POST['aabout_lesson_saturday_1']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_saturday_1']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'1'} = $atime;
     else { ${'about_lesson_'.$field.'1'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_saturday_2']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_saturday_2']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'2'} = $atime;
     else { ${'about_lesson_'.$field.'2'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_saturday_3']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_saturday_3']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'3'} = $atime;
     else { ${'about_lesson_'.$field.'3'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_saturday_4']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_saturday_4']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'4'} = $atime;
     else { ${'about_lesson_'.$field.'4'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_saturday_5']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_saturday_5']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'5'} = $atime;
     else { ${'about_lesson_'.$field.'5'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_saturday_6']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_saturday_6']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'6'} = $atime;
     else { ${'about_lesson_'.$field.'6'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_saturday_7']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_saturday_7']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'7'} = $atime;
     else { ${'about_lesson_'.$field.'7'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_saturday_8']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_saturday_8']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'8'} = $atime;
     else { ${'about_lesson_'.$field.'8'} = $btime;}
     //
     $atime = FormChars($_POST['aabout_lesson_saturday_9']); // взял эту же переменную, что и использовал выше.
     $btime = FormChars($_POST['babout_lesson_saturday_9']); 
     if(empty($atime) == 0  ) ${'about_lesson_'.$field.'9'} = $atime;
     else { ${'about_lesson_'.$field.'9'} = $btime;}
     //
     $ctemp = FormChars($_POST['type_lesson_saturday_1']);
     ${'about_lesson_'.$field.'1'} = ${'about_lesson_'.$field.'1'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_saturday_2']);
      ${'about_lesson_'.$field.'2'} = ${'about_lesson_'.$field.'2'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_saturday_3']);
      ${'about_lesson_'.$field.'3'} = ${'about_lesson_'.$field.'3'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_saturday_4']);
      ${'about_lesson_'.$field.'4'} = ${'about_lesson_'.$field.'4'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_saturday_5']);
      ${'about_lesson_'.$field.'5'} = ${'about_lesson_'.$field.'5'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_saturday_6']);
      ${'about_lesson_'.$field.'6'} = ${'about_lesson_'.$field.'6'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_saturday_7']);
      ${'about_lesson_'.$field.'7'} = ${'about_lesson_'.$field.'7'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_saturday_8']);
      ${'about_lesson_'.$field.'8'} = ${'about_lesson_'.$field.'8'}.$ctemp;
     // cont.
     $ctemp = FormChars($_POST['type_lesson_saturday_9']);
      ${'about_lesson_'.$field.'9'} = ${'about_lesson_'.$field.'9'}.",".$ctemp;

     ${'selected_group_'.$field.'1'}=FormChars($_POST['selected_group_saturday_1']);
     ${'selected_group_'.$field.'2'}=FormChars($_POST['selected_group_saturday_2']);
     ${'selected_group_'.$field.'3'}=FormChars($_POST['selected_group_saturday_3']);
     ${'selected_group_'.$field.'4'}=FormChars($_POST['selected_group_saturday_4']);
     ${'selected_group_'.$field.'5'}=FormChars($_POST['selected_group_saturday_5']);
     ${'selected_group_'.$field.'6'}=FormChars($_POST['selected_group_saturday_6']);
     ${'selected_group_'.$field.'7'}=FormChars($_POST['selected_group_saturday_7']);
     ${'selected_group_'.$field.'8'}=FormChars($_POST['selected_group_saturday_8']);
     ${'selected_group_'.$field.'9'}=FormChars($_POST['selected_group_saturday_9']);

     ${'classroom_'.$field.'1'} = FormChars($_POST['classroom_saturday_1']);
     ${'classroom_'.$field.'2'} = FormChars($_POST['classroom_saturday_2']);
     ${'classroom_'.$field.'3'} = FormChars($_POST['classroom_saturday_3']);
     ${'classroom_'.$field.'4'} = FormChars($_POST['classroom_saturday_4']);
     ${'classroom_'.$field.'5'} = FormChars($_POST['classroom_saturday_5']);
     ${'classroom_'.$field.'6'} = FormChars($_POST['classroom_saturday_6']);
     ${'classroom_'.$field.'7'} = FormChars($_POST['classroom_saturday_7']);
     ${'classroom_'.$field.'8'} = FormChars($_POST['classroom_saturday_8']);
     ${'classroom_'.$field.'9'} = FormChars($_POST['classroom_saturday_9']);
  }
  // end day

 // ПРОВЕРКА ПОЛУЧЕННЫХ ДАННЫХ И ОТСЕИВАНИЕ ПУСТЫХ ПОЛЕЙ/ПЕРЕМЕННЫХ
  // СТАРТ ПЕРЕНОСА ДАННЫХ В МАССИВ
  $i=0;
  echo "|";
  $field = 'monday_'; // выбранный день
  $time_monday_array = array();
  $parity_monday_array = array();
  $lesson_monday_array = array();
  $classroom_monday_array = array();
  $selectedgroup_monday_array = array();
  while($pole_monday != $i)
  {
    $i++;
    if (empty(${'time_'.$field.$i}) == 0 )
    {   
      array_push($time_monday_array,"${'time_'.$field.$i} ");
    }
    if (empty(${'parity_of_week_'.$field.$i}) == 0 )
    {   
      array_push($parity_monday_array,"${'parity_of_week_'.$field.$i} ");
    }
    if (empty(${'about_lesson_'.$field.$i}) == 0)
    {   
      array_push($lesson_monday_array,"${'about_lesson_'.$field.$i} ");
    }
    if (empty(${'selected_group_'.$field.$i}) == 0)
    {   
      array_push($selectedgroup_monday_array,"${'selected_group_'.$field.$i} ");
    }
    if (empty(${'classroom_'.$field.$i}) == 0 )
    {   
      array_push($classroom_monday_array,"${'classroom_'.$field.$i} ");
    }
    echo "&#9; $i";
  }
  // КОНЕЦ ПЕРЕНОСА ДАННЫХ В МАССИВ
  // СТАРТ ПЕРЕНОСА ДАННЫХ В МАССИВ
  $i=0;
  echo "|";
  $field = 'tuesday_'; // выбранный день
  $time_tuesday_array = array();
  $parity_tuesday_array = array();
  $lesson_tuesday_array = array();
  $classroom_tuesday_array = array();
  $selectedgroup_tuesday_array = array();
  while($pole_tuesday != $i)
  {
    $i++;
    if (empty(${'time_'.$field.$i}) == 0 )
    {   
      array_push($time_tuesday_array,"${'time_'.$field.$i} ");
    }
    if (empty(${'parity_of_week_'.$field.$i}) == 0 )
    {   
      array_push($parity_tuesday_array,"${'parity_of_week_'.$field.$i} ");
    }
    if (empty(${'about_lesson_'.$field.$i}) == 0)
    {   
      array_push($lesson_tuesday_array,"${'about_lesson_'.$field.$i} ");
    }
    if (empty(${'selected_group_'.$field.$i}) == 0)
    {   
      array_push($selectedgroup_tuesday_array,"${'selected_group_'.$field.$i} ");
    }
    if (empty(${'classroom_'.$field.$i}) == 0 )
    {   
      array_push($classroom_tuesday_array,"${'classroom_'.$field.$i} ");
    }
    echo "&#9; $i";
  }
  // КОНЕЦ ПЕРЕНОСА ДАННЫХ В МАССИВ
  // СТАРТ ПЕРЕНОСА ДАННЫХ В МАССИВ
  $i=0;
  echo "|";
  $field = 'wednesday_'; // выбранный день
  $time_wednesday_array = array();
  $parity_wednesday_array = array();
  $lesson_wednesday_array = array();
  $classroom_wednesday_array = array();
  $selectedgroup_wednesday_array = array();
  while($pole_wednesday != $i)
  {
    $i++;
    if (empty(${'time_'.$field.$i}) == 0 )
    {   
      array_push($time_wednesday_array,"${'time_'.$field.$i} ");
    }
    if (empty(${'parity_of_week_'.$field.$i}) == 0 )
    {   
      array_push($parity_wednesday_array,"${'parity_of_week_'.$field.$i} ");
    }
    if (empty(${'about_lesson_'.$field.$i}) == 0)
    {   
      array_push($lesson_wednesday_array,"${'about_lesson_'.$field.$i} ");
    }
    if (empty(${'selected_group_'.$field.$i}) == 0)
    {   
      array_push($selectedgroup_wednesday_array,"${'selected_group_'.$field.$i} ");
    }
   if (empty(${'classroom_'.$field.$i}) == 0 )
    {   
      array_push($classroom_wednesday_array,"${'classroom_'.$field.$i} ");
    }
    echo "&#9; $i";
  }
  // КОНЕЦ ПЕРЕНОСА ДАННЫХ В МАССИВ
  // СТАРТ ПЕРЕНОСА ДАННЫХ В МАССИВ
  $i=0;
  echo "|";
  $field = 'thursday_'; // выбранный день
  $time_thursday_array = array();
  $parity_thursday_array = array();
  $lesson_thursday_array = array();
  $classroom_thursday_array = array();
  $selectedgroup_thursday_array = array();
  while($pole_thursday != $i)
  {
    $i++;
    if (empty(${'time_'.$field.$i}) == 0 )
    {   
      array_push($time_thursday_array,"${'time_'.$field.$i} ");
    }
    if (empty(${'parity_of_week_'.$field.$i}) == 0 )
    {   
      array_push($parity_thursday_array,"${'parity_of_week_'.$field.$i} ");
    }
    if (empty(${'about_lesson_'.$field.$i}) == 0)
    {   
      array_push($lesson_thursday_array,"${'about_lesson_'.$field.$i} ");
    }
    if (empty(${'selected_group_'.$field.$i}) == 0)
    {   
      array_push($selectedgroup_thursday_array,"${'selected_group_'.$field.$i} ");
    }
    if (empty(${'classroom_'.$field.$i}) == 0 )
    {   
      array_push($classroom_thursday_array,"${'classroom_'.$field.$i} ");
    }
    echo "&#9; $i";
  }
  // КОНЕЦ ПЕРЕНОСА ДАННЫХ В МАССИВ
  // СТАРТ ПЕРЕНОСА ДАННЫХ В МАССИВ
  $i=0;
  echo "|";
  $field = 'friday_'; // выбранный день
  $time_friday_array = array();
  $parity_friday_array = array();
  $lesson_friday_array = array();
  $classroom_friday_array = array();
  $selectedgroup_friday_array = array();
  while($pole_friday != $i)
  {
    $i++;
    if (empty(${'time_'.$field.$i}) == 0 )
    {   
      array_push($time_friday_array,"${'time_'.$field.$i} ");
    }
    if (empty(${'parity_of_week_'.$field.$i}) == 0 )
    {   
      array_push($parity_friday_array,"${'parity_of_week_'.$field.$i} ");
    }
    if (empty(${'about_lesson_'.$field.$i}) == 0)
    {
      array_push($lesson_friday_array,"${'about_lesson_'.$field.$i} ");
    }
    if (empty(${'selected_group_'.$field.$i}) == 0)
    {   
      array_push($selectedgroup_friday_array,"${'selected_group_'.$field.$i} ");
    }
   if (empty(${'classroom_'.$field.$i}) == 0 )
    {   
      array_push($classroom_friday_array,"${'classroom_'.$field.$i} ");
    }
    echo "&#9; $i";
  }
  // КОНЕЦ ПЕРЕНОСА ДАННЫХ В МАССИВ
  // СТАРТ ПЕРЕНОСА ДАННЫХ В МАССИВ
  $i=0;
  echo "|";
  $field = 'saturday_'; // выбранный день
  $time_saturday_array = array();
  $parity_saturday_array = array();
  $lesson_saturday_array = array();
  $classroom_saturday_array = array();
  $selectedgroup_saturday_array = array();
  while($pole_saturday != $i)
  {
    $i++;
    if (empty(${'time_'.$field.$i}) == 0 )
    {   
      array_push($time_saturday_array,"${'time_'.$field.$i} ");
    }
    if (empty(${'parity_of_week_'.$field.$i}) == 0 )
    {   
      array_push($parity_saturday_array,"${'parity_of_week_'.$field.$i} ");
    }
    if (empty(${'about_lesson_'.$field.$i}) == 0)
    {   
      array_push($lesson_saturday_array,"${'about_lesson_'.$field.$i} ");
    }
    if (empty(${'selected_group_'.$field.$i}) == 0)
    {   
      array_push($selectedgroup_saturday_array,"${'selected_group_'.$field.$i} ");
    }
    if (empty(${'classroom_'.$field.$i}) == 0 )
    {   
      array_push($classroom_saturday_array,"${'classroom_'.$field.$i} ");
    }
    echo "&#9; $i";
  }
  // КОНЕЦ ПЕРЕНОСА ДАННЫХ В МАССИВ
  
 


  echo "<br/><br/>";
   print_r($time_monday_array); echo "<br/>";
   print_r($parity_monday_array);echo "<br/>";
   print_r($lesson_monday_array);echo "<br/>";
   print_r($classroom_monday_array);echo "<br/>";
echo "SUBOTA<br/>";
   print_r($parity_saturday_array);echo "<br/>";
   print_r($lesson_saturday_array);echo "<br/>";
   print_r($classroom_saturday_array);echo "<br/>";
   print_r($time_saturday_array);echo "<br/>";
   
   echo "<br/><br/>";


    // проверки конечно не топ, ну а что поделать.


    // загонять переменные в динам.массив
 

  echo "Кол-во полей выведенное на понедельник - "."$pole_monday<br/>";
  echo "1-"."$time_monday_1<br/>"; // +
  echo "2-"."$time_monday_2<br/>"; // +
  echo "3-"."$parity_of_week_monday_1<br/>"; // +
  echo "4-"."$parity_of_week_monday_2<br/>"; // +
  echo "5-"."$about_lesson_monday_1<br/>"; // +
  echo "6-"."$about_lesson_monday_2<br/>"; // +
  echo "7-"."$classroom_monday_1<br/>"; // +
  echo "8-"."$classroom_monday_2<br/>"; //  +
  echo "пустая переменная - "."$classroom_saturday_1<br/>";

  // Проверка на полность массивов изначально, а ЗАТЕМ ПЕРЕГОНКА ИХ В ДВУМЕРНЫЙ
  // Лучше выкинуть сразу :)
  
  if( (count($time_monday_array) != 0) AND (count($parity_monday_array) != 0) AND (count($lesson_monday_array) != 0) AND (count($classroom_monday_array) != 0)  ) {
    echo "<br/>Monday +<br/>";
    $monday_full = array($time_monday_array,$parity_monday_array,$lesson_monday_array,$classroom_monday_array,$selectedgroup_monday_array);
    // Вносим ПОНЕДЕЛЬНИК в БАЗУ ДАННЫХ
    
    
    

    for ($i = 0; $i < count($monday_full);$i++)
      {
        $temp = array();
        for($j=0; $j<5;$j++ )
        {
        if(!empty($monday_full[$j][$i])) $temp[$j] = $monday_full[$j][$i]; // array_push($temp,$monday_full[$j][$i]);
        }
        if(sizeof($temp) != 0 OR count($temp) != 0)
       mysqli_query($CONNECT, "INSERT INTO `reglament` VALUES ('', '$teacher', 'monday', '$temp[0]', '$temp[1]','$temp[2]','$temp[3]','$temp[4]' )" );
      }
      // mysqli_query($CONNECT, "INSERT INTO `reglament` VALUES ('', '', '-', '-', '-','-','-','-' )" );
  }
  else {
    echo '<br/>Ошибка вводимых данных! <br/>Скорее всего Вы пропустили какое-то поле,когда вводили данные.<br/>
      Попробуйте заново задать для преподователя поля так, как Вам нужно.<br/>
      [ПОНЕДЕЛЬНИК - ERROR].<br/><br/>
      ';
  }
  if( (count($time_tuesday_array) != 0) AND (count($parity_tuesday_array) != 0) AND (count($lesson_tuesday_array) != 0) AND (count($classroom_tuesday_array) != 0)  ) {
    echo "<br/>Tuesday +<br/>";
    $tuesday_full = array($time_tuesday_array,$parity_tuesday_array,$lesson_tuesday_array,$classroom_tuesday_array,$selectedgroup_tuesday_array);
    
for ($i = 0; $i < count($tuesday_full);$i++)
      {
        $temp = array();
        for($j=0; $j<5;$j++ )
        {
        if(!empty($tuesday_full[$j][$i]))$temp[$j] = $tuesday_full[$j][$i];
        }
        if(sizeof($temp) != 0 OR count($temp) != 0)
       mysqli_query($CONNECT, "INSERT INTO `reglament` VALUES ('', '$teacher', 'tuesday', '$temp[0]', '$temp[1]','$temp[2]','$temp[3]','$temp[4]' )" );
      }
      // mysqli_query($CONNECT, "INSERT INTO `reglament` VALUES ('', '', '-', '-', '-','-','-','-' )" );
  }
  else {
    echo '<br/>Ошибка вводимых данных! <br/>Скорее всего Вы пропустили какое-то поле,когда вводили данные.<br/>
      Попробуйте заново задать для преподователя поля так, как Вам нужно.<br/>
      [ВТОРНИК - ERROR].<br/><br/>
      ';
  }
  if( (count($time_wednesday_array) != 0) AND (count($parity_wednesday_array) != 0) AND (count($lesson_wednesday_array) != 0) AND (count($classroom_wednesday_array) != 0) ) {
    echo "<br/>Wednesday +<br/>";
    $wednesday_full = array($time_wednesday_array,$parity_wednesday_array,$lesson_wednesday_array,$classroom_wednesday_array,$selectedgroup_wednesday_array);
    print_r($wednesday_full);
    echo "<br/>";
     for ($i = 0; $i < count($wednesday_full);$i++)
      {
        $temp = array();
        for($j=0; $j<5;$j++ )
        {
        if(!empty($wednesday_full[$j][$i]))$temp[$j] = $wednesday_full[$j][$i];
        }
        if(sizeof($temp) != 0 OR count($temp) != 0)
       mysqli_query($CONNECT, "INSERT INTO `reglament` VALUES ('', '$teacher', 'wednesday', '$temp[0]', '$temp[1]','$temp[2]','$temp[3]','$temp[4]' )" );
      }
      // mysqli_query($CONNECT, "INSERT INTO `reglament` VALUES ('', '', '-', '-', '-','-','-','-' )" );
  }
  else {
    echo '<br/>Ошибка вводимых данных! <br/>Скорее всего Вы пропустили какое-то поле,когда вводили данные.<br/>
      Попробуйте заново задать для преподователя поля так, как Вам нужно.<br/>
      [СРЕДА - ERROR].<br/><br/>
      ';
  }
  if( (count($time_thursday_array) != 0) AND (count($parity_thursday_array) != 0) AND (count($lesson_thursday_array) != 0) AND (count($classroom_thursday_array) != 0) ) {
    echo "<br/>Thursday +<br/>";
    $thursday_full = array($time_thursday_array,$parity_thursday_array,$lesson_thursday_array,$classroom_thursday_array,$selectedgroup_thursday_array);
    
     for ($i = 0; $i < count($thursday_full);$i++)
      {
        $temp = array();
        for($j=0; $j<5;$j++ )
        {
        if(!empty($thursday_full[$j][$i]))$temp[$j] = $thursday_full[$j][$i];
        }
        if(sizeof($temp) != 0 OR count($temp) != 0)
       mysqli_query($CONNECT, "INSERT INTO `reglament` VALUES ('', '$teacher', 'thursday', '$temp[0]', '$temp[1]','$temp[2]','$temp[3]','$temp[4]' )" );
   }
      // mysqli_query($CONNECT, "INSERT INTO `reglament` VALUES ('', '', '-', '-', '-','-','-','-' )" );
  }
  else {
    echo '<br/>Ошибка вводимых данных! <br/>Скорее всего Вы пропустили какое-то поле,когда вводили данные.<br/>
      Попробуйте заново задать для преподователя поля так, как Вам нужно.<br/>
      [ЧЕТВЕРГ - ERROR]<br/><br/>.
      ';
  }
  if( (count($time_friday_array) != 0) AND (count($parity_friday_array) != 0) AND (count($lesson_friday_array) != 0) AND (count($classroom_friday_array) != 0) ) {
    echo "<br/>Friday +<br/>";
    $friday_full = array($time_friday_array,$parity_friday_array,$lesson_friday_array,$classroom_friday_array,$selectedgroup_friday_array);
    
     for ($i = 0; $i < count($friday_full);$i++)
      {
        $temp = array();
        for($j=0; $j<5;$j++ ) // цикл выполняется лишние кол-во раз. так что костыль)
        {
        if(!empty($friday_full[$j][$i]))$temp[$j] = $friday_full[$j][$i];
        }
        if(sizeof($temp) != 0 OR count($temp) != 0)
       mysqli_query($CONNECT, "INSERT INTO `reglament` VALUES ('', '$teacher', 'friday', '$temp[0]', '$temp[1]','$temp[2]','$temp[3]','$temp[4]' )" );
      }
       //mysqli_query($CONNECT, "INSERT INTO `reglament` VALUES ('', '', '-', '-', '-','-','-','-' )" );
  }
  else {
    echo '<br/>Ошибка вводимых данных! <br/>Скорее всего Вы пропустили какое-то поле,когда вводили данные.<br/>
      Попробуйте заново задать для преподователя поля так, как Вам нужно.<br/>
      [ПЯТНИЦА - ERROR]<br/><br/>
      ' ;
      
  }
  if( (count($time_saturday_array) != 0) AND (count($parity_saturday_array) != 0) AND (count($lesson_saturday_array) != 0) AND (count($classroom_saturday_array) != 0) ) {
    echo "<br/>Saturday +<br/>";
    $saturday_full = array($time_saturday_array,$parity_saturday_array,$lesson_saturday_array,$classroom_saturday_array,$selectedgroup_saturday_array);
     for ($i = 0; $i < count($saturday_full);$i++)
      {
        $temp = array();
        for($j=0; $j<5;$j++ )
        {
        if(!empty($saturday_full[$j][$i]))$temp[$j] = $saturday_full[$j][$i];
        }
        if(sizeof($temp) != 0 OR count($temp) != 0)
       mysqli_query($CONNECT, "INSERT INTO `reglament` VALUES ('', '$teacher', 'saturday', '$temp[0]', '$temp[1]','$temp[2]','$temp[3]','$temp[4]' )" );
      }
       //mysqli_query($CONNECT, "INSERT INTO `reglament` VALUES ('', '', '-', '-', '-','-','-','-' )" );
  }
  else {
    echo '<br/>Ошибка вводимых данных! <br/>Скорее всего Вы пропустили какое-то поле,когда вводили данные.<br/>
      Попробуйте заново задать для преподователя поля так, как Вам нужно.<br/>
      [СУББОТА - ERROR].<br/><br/>
      ';
  }



exit("<meta http-equiv='refresh' content='0; url= /reglament'>");
}


?>