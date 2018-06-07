<?
if(isset($_POST['registration'])){ 
    include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
    AUser::Add(
        array(
            "surname" => trim(mb_ucfirst($_POST['surname'])),
            "name" => trim(mb_ucfirst($_POST['name'])),
            "thirdName" => trim(mb_ucfirst($_POST['thirdName']))
        ),
        array(
            "id_group" => $_POST['group'],
            "year" => $_POST['step'],
            "magistratura" => intval(isset($_REQUEST['magistratura']))
        )
    );
    die('<META HTTP-EQUIV="REFRESH" CONTENT="0; URL='.$_SERVER['HTTP_REFERER'].'">');
}