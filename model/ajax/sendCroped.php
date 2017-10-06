<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
$image = new Image();
$id = User::ID();
$filename = $_POST['file'];
if(file_exists($_SERVER['DOCUMENT_ROOT'].$filename)){
	$image->load($_SERVER['DOCUMENT_ROOT'].$filename);
	$image->crop((int)$_POST['x'], (int)$_POST['y'], (int)$_POST['size'], (int)$_POST['size']);
	$image->resizeToWidth(200);
	$image->save($_SERVER['DOCUMENT_ROOT'].$filename);
	$photoName = substr($filename, strlen(TEMP_AVATAR_DIR));
	rename($_SERVER['DOCUMENT_ROOT'].$filename, $_SERVER['DOCUMENT_ROOT'].AVATAR_DIR.$photoName);

	$uploaddir = $_SERVER['DOCUMENT_ROOT'].AVATAR_DIR;
	$oldImage = $db->Select(
	    array("photo"),
	    "students",
	    array("id_student" => $id)
	)->fetch()['photo'];
	if(file_exists($uploaddir.$oldImage)){
	    unlink($uploaddir.$oldImage);
	} elseif(file_exists($uploaddir.$id.'.'.$oldImage)){
	    unlink($uploaddir.$id.'.'.$oldImage);
	}
	$db->Update(
	    "students",
	    array("photo" => $photoName),
	    array("id_student" => $id)
	);
	Main::redirect('/id'.$id);
}
?>
