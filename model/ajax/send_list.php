<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
if(isset($_FILES['upload'])){
    if($_FILES['upload']['size']<MAX_FILE_IN_MB*1024*1024){
        if($_FILES['upload']['type']=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" 
        || $_FILES['upload']['type']=="application/vnd.ms-excel" 
        || $_FILES['upload']['type']=="application/vnd.openxmlformats-officedocument.wordprocessingml.document"
        || $_FILES['upload']['type']=="application/msword"
        || $_FILES['upload']['type']=="text/plain"){
            $user = new User();
            switch ($user->getLevel()) {
                case 2:
                    $result['_from'] = $user->getFaculty();
                    break;
                case 4:
                    $result['_from'] = $db->Select(
                        array(),
                        "posts_student",
                        array(
                            "id_student" => $user->getId(),
                            "id_post" => array(9, 10, 11),
                            "date_out_y" => 0
                        ),
                        array(
                            "id_post" => "ASC"
                        )
                    )->fetchAll("comment")[0];//Рг это временно. Поэтому эта должность не в приоритете (c)Алена Щелкина (01.09.2017, 8:23pm)
                    break;
                default:
                    die;
            }
            TaskList::Add($result['_from'], $_POST['id']);
        }
        else echo 'Этот формат не поддерживается. Если вы уверены, что это удобно было бы проверять КМС, <a href="/contact/">напишите нам</a>';
    }
    else echo'Слишком большой файл';
}
?>