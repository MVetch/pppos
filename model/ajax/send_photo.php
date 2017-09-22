<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";

if(isset($_FILES['upload'])){
    $id = AUser::getId();
    if($_FILES['upload']['size']<1*1024*1024){
        if($_FILES['upload']['type']=="image/png" || $_FILES['upload']['type']=="image/jpeg" || $_FILES['upload']['type']=="image/gif"){
            $uploaddir = $_SERVER['DOCUMENT_ROOT'].AVATAR_DIR;
            $fn = explode(".", $_FILES['upload']['name']);
            $seed = md5($id.time());
            $filename = $uploaddir.$seed.'.'.$fn[count($fn)-1];
            $image = new Image();
            if (move_uploaded_file($_FILES['upload']['tmp_name'], $filename)) {
                $image -> load($filename);
                $image -> resizeToWidth(200);
                $image -> save($filename);
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
                    array("photo" => $seed.'.'.$fn[count($fn)-1]),
                    array("id_student" => $id)
                );
                echo '<div style="font-size:11px; padding:10px 0">Фото успешно загружено</div>
                <meta http-equiv="refresh" content = "0; url=/id'.$id.'">';
            } 
            else {
                echo "Возможная атака с помощью файловой загрузки!\n";
            }
        }
        else echo 'Этот формат не поддерживается. Если вы уверены, что это хорошо бы смотрелось у вас на автарке, <a href="contact.php">напишите нам</a>';
    }
    else echo'Слишком большой файл (не больше 1 МБ)';
}
else echo 'Файл не загружен';
?>