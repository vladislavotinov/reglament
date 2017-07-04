<?php Head('Добавление преподователя 1') ?>
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
<form method="POST" action="/account/addone"> 
<br/><input type="text" name="name" placeholder="ФИО преподователя" required/>
<br/><input type="text" name="position" placeholder="Должность преподователя" required/>
<br/><input type="text" name="nomer" maxlength="25"  title="Только цифры." placeholder="Номер преподователя" required/>
<br/><input type="text" name="groups" placeholder="Группы" title="Только цифры." pattern="[0-9]{1,2}" required/><b>Введите количество групп, которым Вы преподаете!</b>
<br/><input type="text" name="discipline" placeholder="Дисциплины" title="Только цифры." pattern="[0-9]{1,2}" required/><b>Введите количество ВСЕВОЗМОЖНЫХ дисциплин, которые Вы преподаете! &nbsp;&nbsp;&nbsp; В том числе
 незабудьте и про : НМР , Библиотека и т.д. !</b>
<br/><br/><input type="submit" name="enter" value="Добавление"/> <input type="reset" value="Очистить"/>
<i><b> Не больше <h3>25</h3> групп/дисциплин возможно.</b></i>
</form>


</div>
</div>

<?php Footer() ?>
</div>
</body>
</html>