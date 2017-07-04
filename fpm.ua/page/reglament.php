<?php Head('Регламент') ?>
<body>
<!-- Ниже PHP обработчик с БД -->
<?php
include_once("db.php");

// initialize
$aname = array();
$apos = array();
$anumb = array();

$tempone = array();
$countpar = array();
// end in...

$result = mysql_query("SELECT name,position,nomer FROM teachers");
while($rowone = mysql_fetch_array($result))
{
   array_push($aname,$rowone['name']);
   array_push($apos,$rowone['position']);
   array_push($anumb,$rowone['nomer']); 
}
// вывод преподов ток
for($i =0; $i<sizeof($mega[0]);$i++ )
{
	for($j=0;$j<3;$j++) 
	{
		echo $mega[$j][$i]."_";
	}
	echo '<br/>';
}
echo '<br/>';echo '<br/>';
//


echo "<br/>";
$resul = mysql_query("SELECT teacher,day,time,parity,lesson,classroom,selectedgroup FROM reglament");
$i = 0;
while($row = mysql_fetch_array($resul))
{

    //array_push($tempone[$i],$row['teacher'],$row['day'],$row['time'],$row['parity'],$row['lesson'],$row['classroom'],$row['selectedgroup']);
    $tempone[$i]["teacher"] = $row['teacher'];
    $tempone[$i]["day"] = $row['day'];
    $tempone[$i]["time"] = $row['time'];
    $tempone[$i]["parity"] = $row['parity'];
    $tempone[$i]["lesson"] = $row['lesson'];
    $tempone[$i]["classroom"] = $row['classroom'];
    $tempone[$i]["group"] = $row['selectedgroup'];
    $i += 1;
    
}

function maxus($p1,$p2 = array()) // считаем максимальное количество элементов пар у каждого
{
   $monday =0;$tuesday =0;$wednesday=0;$thursday=0;$friday=0;$saturday=0;
   $mixer = array();
   for($i=0;$i<sizeof($p2);$i++)
   {
     if($p2[$i]["teacher"] == $p1)
     { 
      if($p2[$i]["day"] == "monday") $monday++;
      if($p2[$i]["day"] == "tuesday") $tuesday++;
      if($p2[$i]["day"] == "wednesday") $wednesday++;
      if($p2[$i]["day"] == "thursday") $thursday++;
      if($p2[$i]["day"] == "friday") $friday++;
      if($p2[$i]["day"] == "saturday") $saturday++;

     }


   }
   
   array_push($mixer,$monday,$tuesday,$wednesday,$thursday,$friday,$saturday);
   $p3 = max($mixer);
   return $p3;
}

// сортировка массивов
/*
$massiveforsort = array();
foreach($tempone as $key=>$arr)
{
    $massiveforsort[$key]=$arr['teacher'];
    $massivesortday[$key]=$arr['day'];
}

array_multisort($massiveforsort,SORT_STRING,$massivesortday,SORT_DESC,$tempone);
*/

// end sort



//print_r($tempone);
mysql_close();
?>

<!-- konec) -->


<div class="osnova">
<div class="top">
<div class="toptext">
<p>МІНІСТЕРСТВО ОСВІТИ І НАУКИ УКРАЇНИ</p>
<p>ДНІПРОВСЬКИЙ НАЦІОНАЛЬНИЙ УНІВЕРСИТЕТ</p> 
<p>імені Олеся Гончара</p>
<b>
<p>РЕГЛАМЕНТ</p>
<p>Роботи науково-педагогічного складу кафедрки комп'ютерних технологій</p>
<p>на другий семестр 2016/17 навчального року</p>
</b>
</div>
<div class="microblock"><p>ЗАТВЕРДЖУЮ</p><p>Зав.кафедри</p><p><pre>/__/________</pre></p></div>
</div>

<div class="osntable">
	<table >
            <tr>
            	<th class="tcolumn-1" rowspan="3">№</th>
                <th class="tcolumn-2" rowspan="3">Прізвище,ім'я та по батькові,посада</th>
                <th class="tcolumn-3" rowspan="3">Номер</th>
                <th class="tcolumn-4" colspan="18">ДНІ ТИЖНЯ</th>
            </tr>
            <tr>
                <th class="daycolumn" colspan="3">Понеділок</th>
                <th class="daycolumn" colspan="3">Вівторок</th>
                <th class="daycolumn" colspan="3">Середа</th>
                <th class="daycolumn" colspan="3">Четвер</th>
                <th class="daycolumn" colspan="3">П'ятниця</th>
                <th class="daycolumn" colspan="3">Субота</th>
            </tr>
            <tr>
                <th class="mcolumn-1">Час/За неделею</th>
                <th class="mcolumn-2">Вид роботи</th>
                <th class="mcolumn-3">Місце роботи</th>
                <th class="mcolumn-1">Час/За неделею</th>
                <th class="mcolumn-2">Вид роботи</th>
                <th class="mcolumn-3">Місце роботи</th>
                <th class="mcolumn-1">Час/За неделею</th>
                <th class="mcolumn-2">Вид роботи</th>
                <th class="mcolumn-3">Місце роботи</th>
                <th class="mcolumn-1">Час/За неделею</th>
                <th class="mcolumn-2">Вид роботи</th>
                <th class="mcolumn-3">Місце роботи</th>
                <th class="mcolumn-1">Час/За неделею</th>
                <th class="mcolumn-2">Вид роботи</th>
                <th class="mcolumn-3">Місце роботи</th>
                <th class="mcolumn-1">Час/За неделею</th>
                <th class="mcolumn-2">Вид роботи</th>
                <th class="mcolumn-3">Місце роботи</th>
            </tr>
            <!-- ЗАПОЛНЕНИЕ СТАРТАНУЛО -->
            
                <?php
                    $kirk = 0 ;
                    for($bor=0;$bor<sizeof($aname);$bor++) // count tempone 7
                      { 
                       $name = $aname[$bor]; // записали имя
                                       if(maxus($name,$tempone) > 0) 
                                     {
                                              $kirk++;
                                              $zorka = maxus($name,$tempone);
                                              
                                              //echo "<br/><br/> Роуспан для человека - ";echo maxus($name,$tempone); echo "<br/><br/>";

                                             ?>
                                                 <tr>
                                                 <td class="tdzapolnenie" rowspan="<?php echo $zorka; ?>"><?php echo $kirk; ?></td>
                                                 <td class="tdzapolnenie" rowspan="<?php echo $zorka; ?>"><?php echo $name."&nbsp;".$apos[$bor];  ?></td>
                                                 <td class="tdzapolnenie" rowspan="<?php echo $zorka; ?>"><?php echo $anumb[$bor]; ?></td>
                                                 
                                                 <?php

                                      }
                                   //  $perke = maxus($name,$tempone); // максимальное количество пар в определенный день
                                    $monday_array = array();
                                    $tuesday_array = array();
                                    $wednesday_array = array();
                                    $thursday_array = array();
                                    $friday_array = array();
                                    $saturday_array = array();
                                                   for ($j=0; $j < sizeof($tempone); $j++)   // общее количество записей принятых с бд
                                                   {
                                                       if($tempone[$j]["teacher"] == $name && $tempone[$j]["day"] == "monday")
                                                       {
                                                        $emme = sizeof($monday_array);
                                                        $monday_array[$emme]["day"] = $tempone[$j]["day"];
                                                        $monday_array[$emme]["time"] = $tempone[$j]["time"];
                                                        $monday_array[$emme]["parity"] = $tempone[$j]["parity"];
                                                        $monday_array[$emme]["lesson"] = $tempone[$j]["lesson"];
                                                        $monday_array[$emme]["classroom"] = $tempone[$j]["classroom"];
                                                        $monday_array[$emme]["group"] = $tempone[$j]["group"];
                                                       }
                                                       if($tempone[$j]["teacher"] == $name && $tempone[$j]["day"] == "tuesday")
                                                       {
                                                         $emme = sizeof($tuesday_array);
                                                        $tuesday_array[$emme]["day"] = $tempone[$j]["day"];
                                                        $tuesday_array[$emme]["time"] = $tempone[$j]["time"];
                                                        $tuesday_array[$emme]["parity"] = $tempone[$j]["parity"];
                                                        $tuesday_array[$emme]["lesson"] = $tempone[$j]["lesson"];
                                                        $tuesday_array[$emme]["classroom"] = $tempone[$j]["classroom"];
                                                        $tuesday_array[$emme]["group"] = $tempone[$j]["group"];
                                                       }
                                                       if($tempone[$j]["teacher"] == $name && $tempone[$j]["day"] == "wednesday")
                                                       {
                                                        $emme = sizeof($wednesday_array);
                                                        $wednesday_array[$emme]["day"] = $tempone[$j]["day"];
                                                        $wednesday_array[$emme]["time"] = $tempone[$j]["time"];
                                                        $wednesday_array[$emme]["parity"] = $tempone[$j]["parity"];
                                                        $wednesday_array[$emme]["lesson"] = $tempone[$j]["lesson"];
                                                        $wednesday_array[$emme]["classroom"] = $tempone[$j]["classroom"];
                                                        $wednesday_array[$emme]["group"] = $tempone[$j]["group"];
                                                       }
                                                       if($tempone[$j]["teacher"] == $name && $tempone[$j]["day"] == "thursday")
                                                       {
                                                        $emme = sizeof($thursday_array);
                                                        $thursday_array[$emme]["day"] = $tempone[$j]["day"];
                                                        $thursday_array[$emme]["time"] = $tempone[$j]["time"];
                                                        $thursday_array[$emme]["parity"] = $tempone[$j]["parity"];
                                                        $thursday_array[$emme]["lesson"] = $tempone[$j]["lesson"];
                                                        $thursday_array[$emme]["classroom"] = $tempone[$j]["classroom"];
                                                        $thursday_array[$emme]["group"] = $tempone[$j]["group"];
                                                       }
                                                       if($tempone[$j]["teacher"] == $name && $tempone[$j]["day"] == "friday")
                                                       {
                                                        $emme = sizeof($friday_array);
                                                        $friday_array[$emme]["day"] = $tempone[$j]["day"];
                                                        $friday_array[$emme]["time"] = $tempone[$j]["time"];
                                                        $friday_array[$emme]["parity"] = $tempone[$j]["parity"];
                                                        $friday_array[$emme]["lesson"] = $tempone[$j]["lesson"];
                                                        $friday_array[$emme]["classroom"] = $tempone[$j]["classroom"];
                                                        $friday_array[$emme]["group"] = $tempone[$j]["group"];
                                                       }
                                                       if($tempone[$j]["teacher"] == $name && $tempone[$j]["day"] == "saturday")
                                                       {
                                                        $emme = sizeof($saturday_array);
                                                        $saturday_array[$emme]["day"] = $tempone[$j]["day"];
                                                        $saturday_array[$emme]["time"] = $tempone[$j]["time"];
                                                        $saturday_array[$emme]["parity"] = $tempone[$j]["parity"];
                                                        $saturday_array[$emme]["lesson"] = $tempone[$j]["lesson"];
                                                        $saturday_array[$emme]["classroom"] = $tempone[$j]["classroom"];
                                                        $saturday_array[$emme]["group"] = $tempone[$j]["group"];
                                                       }
                                                   }

                                                  
                         // ВЫВОД В ТАБЛУ
                                   $maks_kol_par_prepoda = maxus($name,$tempone);
                                   
                                         for ($i=0; $i <$maks_kol_par_prepoda ; $i++) 
                                         { 
                                          
                                           if($i == 0) 
                                            { ?>
                                          
                                           <td class="tdzapolnenie-1"><?php echo $monday_array[$i]["time"]; ?><br/><hr/> <?php echo $monday_array[$i]["parity"]; ?></td>
                                           <td class="tdzapolnenie-2"><?php echo $monday_array[$i]["lesson"]."<br/>".$monday_array[$i]["group"]; ?></td>
                                           <td class="tdzapolnenie-3"><?php echo $monday_array[$i]["classroom"]; ?></td>

                                           <?php } else 
                                           { ?>
                                                       <tr>
                                                       <td class="tdzapolnenie"><?php echo $monday_array[$i]["time"]; ?><br/><hr/> <?php echo $monday_array[$i]["parity"]; ?></td>
                                                       <td class="tdzapolnenie-2"><?php echo $monday_array[$i]["lesson"]."<br/>".$monday_array[$i]["group"]; ?></td>
                                                       <td class="tdzapolnenie-3"><?php echo $monday_array[$i]["classroom"]; ?></td>
                                                       
                                           
                                        <?php }
                                       
                                         
                                          // _________
                                      //______
                                   
                                    
                                     if($i == 0) 
                                      {  ?>
                                     <td class="tdzapolnenie-1"><?php echo $tuesday_array[$i]["time"]; ?><br/><hr/> <?php echo $tuesday_array[$i]["parity"]; ?></td>
                                     <td class="tdzapolnenie-2"><?php echo $tuesday_array[$i]["lesson"]."<br/>".$tuesday_array[$i]["group"]; ?></td>
                                     <td class="tdzapolnenie-3"><?php echo $tuesday_array[$i]["classroom"]; ?></td>

                                     <?php } else 
                                     { ?>
                                                 
                                                 <td class="tdzapolnenie-1"><?php echo $tuesday_array[$i]["time"]; ?><br/><hr/> <?php echo $tuesday_array[$i]["parity"]; ?></td>
                                                 <td class="tdzapolnenie-2"><?php echo $tuesday_array[$i]["lesson"]."<br/>".$tuesday_array[$i]["group"]; ?></td>
                                                 <td class="tdzapolnenie-3"><?php echo $tuesday_array[$i]["classroom"]; ?></td>
                                                 
                                     
                                  <?php }
                                 
                                   
                                    // _________
                                      //______
                                   
                                    
                                             if($i == 0) 
                                              { ?>
                                             <td class="tdzapolnenie-1"><?php echo $wednesday_array[$i]["time"]; ?><br/><hr/> <?php echo $wednesday_array[$i]["parity"]; ?></td>
                                             <td class="tdzapolnenie-2"><?php echo $wednesday_array[$i]["lesson"]."<br/>".$wednesday_array[$i]["group"]; ?></td>
                                             <td class="tdzapolnenie-3"><?php echo $wednesday_array[$i]["classroom"]; ?></td>

                                             <?php } else 
                                             { ?>
                                                         
                                                         <td class="tdzapolnenie-1"><?php echo $wednesday_array[$i]["time"]; ?><br/><hr/> <?php echo $wednesday_array[$i]["parity"];?></td>
                                                         <td class="tdzapolnenie-2"><?php echo $wednesday_array[$i]["lesson"]."<br/>".$wednesday_array[$i]["group"]; ?></td>
                                                         <td class="tdzapolnenie-3"><?php echo $wednesday_array[$i]["classroom"]; ?></td>
                                                         
                                             
                                          <?php }
                                 
                                   
                                    // _________
                                      //______
                                   
                                    
                                     if($i == 0) 
                                      { ?>
                                     <td class="tdzapolnenie-1"><?php echo $thursday_array[$i]["time"]; ?><br/><hr/> <?php echo $thursday_array[$i]["parity"]; ?></td>
                                     <td class="tdzapolnenie-2"><?php echo $thursday_array[$i]["lesson"]."<br/>".$thursday_array[$i]["group"]; ?></td>
                                     <td class="tdzapolnenie-3"><?php echo $thursday_array[$i]["classroom"]; ?></td>

                                     <?php } else 
                                     { ?>
                                                 
                                                 <td class="tdzapolnenie-1"><?php echo $thursday_array[$i]["time"]; ?><br/><hr/> <?php echo $thursday_array[$i]["parity"]; ?></td>
                                                 <td class="tdzapolnenie-2"><?php echo $thursday_array[$i]["lesson"]."<br/>".$thursday_array[$i]["group"]; ?></td>
                                                 <td class="tdzapolnenie-3"><?php echo $thursday_array[$i]["classroom"]; ?></td>
                                                 
                                     
                                  <?php }
                                 
                                   
                                    // _________
                                      //______
                                   
                                    
                                     if($i == 0) 
                                      { ?>
                                     <td class="tdzapolnenie-1"><?php echo $friday_array[$i]["time"]; ?><br/><hr/> <?php echo $friday_array[$i]["parity"]; ?></td>
                                     <td class="tdzapolnenie-2"><?php echo $friday_array[$i]["lesson"]."<br/>".$friday_array[$i]["group"]; ?></td>
                                     <td class="tdzapolnenie-3"><?php echo $friday_array[$i]["classroom"]; ?></td>

                                     <?php } else 
                                     { ?>
                                                 
                                                 <td class="tdzapolnenie-1"><?php echo $friday_array[$i]["time"]; ?><br/><hr/> <?php echo $friday_array[$i]["parity"]; ?></td>
                                                 <td class="tdzapolnenie-2"><?php echo $friday_array[$i]["lesson"]."<br/>".$friday_array[$i]["group"]; ?></td>
                                                 <td class="tdzapolnenie-3"><?php echo $friday_array[$i]["classroom"]; ?></td>
                                                 
                                     
                                  <?php }
                                 
                                   
                                    // _________
                                      //______
                                   
                                    
                                     if($i == 0) 
                                      { ?>
                                     <td class="tdzapolnenie-1"><?php echo $saturday_array[$i]["time"]; ?><br/><hr/> <?php echo $saturday_array[$i]["parity"]; ?></td>
                                     <td class="tdzapolnenie-2"><?php echo $saturday_array[$i]["lesson"]."<br/>".$saturday_array[$i]["group"]; ?></td>
                                     <td class="tdzapolnenie-3"><?php echo $saturday_array[$i]["classroom"]; ?></td>
                                      </tr>
                                     <?php } else 
                                     { ?>
                                                 
                                                 <td class="tdzapolnenie-1"><?php echo $saturday_array[$i]["time"]; ?><br/><hr/> <?php echo $saturday_array[$i]["parity"]; ?></td>
                                                 <td class="tdzapolnenie-2"><?php echo $saturday_array[$i]["lesson"]."<br/>".$saturday_array[$i]["group"]; ?></td>
                                                 <td class="tdzapolnenie-3"><?php echo $saturday_array[$i]["classroom"]; ?></td>
                                                 </tr>
                                     
                                  <?php }
                                 
                                   }
                                    // _________
                                  
                       }

                 ?>


	</table>
</div>
</div>
</body>
</html>