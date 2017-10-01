<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";

if(!isset($_FILES['upload'])){
    Main::errorAjax('Файл не загружен');
}
if($_FILES['upload']['size']>=MAX_PHOTO_IN_MB*1024*1024){
    Main::errorAjax('Слишком большой файл (не больше '.MAX_PHOTO_IN_MB.' МБ)');
}
if($_FILES['upload']['type']!="image/png" && $_FILES['upload']['type']!="image/jpeg" && $_FILES['upload']['type']!="image/gif"){
    Main::errorAjax('Этот формат не поддерживается. Если вы уверены, что это хорошо бы смотрелось у вас на автарке, <a href="/contact">напишите нам</a>');
}

$image = new Image();
$image->load($_FILES['upload']['tmp_name']);
if($image->getWidth() < 200 || $image->getHeight() < 200 || !between($image->getHeight()/$image->getWidth(), 0.5, 2)){
    Main::errorAjax('Размеры фотографии не соответствуют требованиям');
}

$id = User::ID();
$uploaddir = $_SERVER['DOCUMENT_ROOT'].AVATAR_DIR;
$fn = explode(".", $_FILES['upload']['name']);
$seed = md5($id.time());
$filename = strtolower($uploaddir.$seed.'.'.$fn[count($fn)-1]);
if (!move_uploaded_file($_FILES['upload']['tmp_name'], $filename)) {
    Main::errorAjax('Возможная атака с помощью файловой загрузки!\n');
}
$fnToLoad = strtolower(AVATAR_DIR.$seed.'.'.$fn[count($fn)-1]);
include $_SERVER['DOCUMENT_ROOT']."/view/addWindow/cropPhoto.php";
?>