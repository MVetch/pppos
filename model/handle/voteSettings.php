<?
if(isset($_POST['id_student1'])){
    include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
    $db->Update(
        "vote_responsible",
        [
            "id" => $_POST['id_student1']
        ],
        []
    );
    die('<META HTTP-EQUIV="REFRESH" CONTENT="0; URL='.$_SERVER['HTTP_REFERER'].'">');
}