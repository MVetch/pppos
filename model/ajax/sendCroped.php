<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
$image = new Image();
$filename = "/uploads/avatars/_X-JefsJaxg.jpg";
$image->load($_POST['file']);
$image->crop($_POST['x'], $_POST['y'], $_POST['size'], $_POST['size']);
$image -> save($_POST['file']);
?>
<img src="<?=$filename?>">
