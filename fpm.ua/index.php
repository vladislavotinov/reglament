<?php
include_once 'setting.php';
session_start();
$CONNECT = mysqli_connect(HOST, USER, PASS, DB);


if ($_SERVER['REQUEST_URI'] == '/') {  // замена названия конечной страницы без '.php / .html'
$Page = 'index';
$Module = 'index';
} else {
$URL_Path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$URL_Parts = explode('/', trim($URL_Path, '/'));
$Page = array_shift($URL_Parts);
$Module = array_shift($URL_Parts);



if (!empty($Module)) {
$Param = array();
for ($i = 0; $i < count($URL_Parts); $i++) {
$Param[$URL_Parts[$i]] = $URL_Parts[++$i];
}
} else $Module = 'main';
}
// Функции
function MessageSend($p1,$p2) // создание ошибки
{
    if($p1 == 1) $p1 = 'Ошибка';
     else if($p1 == 2) $p1 = 'Подсказка';
      if($p1 == 3) $p1 = 'Информация';
    $_SESSION['message'] = "<div class='MessageBlock'><b>".$p1."</b>: ".$p2."</div> ";
    
    exit(header('Location:'.$_SERVER['HTTP_REFERER'])); // редирект на запрос
}

function MessageShow() // вывод ошибки
{
    if($_SESSION['message']) $Message = $_SESSION['message'];
    echo $Message;
    $_SESSION['message'] = array(); // clean
}
// Подключение страниц
if ($Page == 'index') include('page/index.php');
else if($Page == 'api') include('page/api.php'); // api доступ в разработке
else if($Page == 'add')include('page/add_stage_one.php');
else if ($Page == 'account') include('form/account.php'); // !! я этот файл просто вылюбил

else if($Page == 'pre_addtwo')include('page/pre_add_stage_two.php');
else if($Page == 'addtwo')include('page/add_stage_two.php');

else if ($Page == 'groups_n_discipline')include('page/groups_n_discipline.php');

else if ($Page == 'reglament')include('page/reglament.php');

else if($Page == 'pre_change')include('page/pre_change.php'); // разработка
else if($Page == 'change')include('page/change.php'); // разработка

else if($Page == 'delete')include('page/delete.php');
else NotFound();

function NotFound() { // страница не найдена/не сделана
header('HTTP/1.0 404 Not Found');
exit(include("page/404.php"));	
}


function FormChars ($p1) { // функция для преобразования вводимых данных
return nl2br(htmlspecialchars(trim($p1), ENT_QUOTES), false);
}


function Head($p1) {
echo '<!DOCTYPE html><html><head><meta charset="utf-8" /><title>'.$p1.'</title><meta name="keywords" content="" /><meta name="description" content="" />
<link href="resource/style.css?25" rel="stylesheet"></head>';
}


function Menu () {
echo '<div class="MenuHead"><a href="/"><div class="Menu">Главная</div></a><a href="/add"><div class="Menu">1-Добавить пр-а</div></a>
<a href="/pre_addtwo"><div class="Menu">2 - рас-е препода</div></a><a href="/delete"><div class="Menu">Удалить</div></a>
<a href="/change"><div class="Menu">Изменить</div></a><a href="/reglament"><div class="Menu">Регламент</div></a>
</div>';
}


function Footer () {
echo '<footer class="footer">Отинов Влад ПК-14-1 Курсовая Работа</footer>';
}



?>