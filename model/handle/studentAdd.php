<?
if(isset($_POST['registration'])){ 
    include $_SERVER['DOCUMENT_ROOT']."/model/start.php";

    $db->Add(
        "students",
        array(
            "surname" => $_POST['surname'],
            "name" => $_POST['name'],
            "thirdName" => $_POST['thirdName']
        )
    );
    $id = $db->insert_id;
    $db->Add(
        "stud_group",
        array(
            "id_student" => $id,
            "id_group" => $_POST['group'],
            "year" => $_POST['step'],
            "magistratura" => intval(isset($_REQUEST['magistratura']))
        )
    );
    die('<META HTTP-EQUIV="REFRESH" CONTENT="0; URL='.$_SERVER['PHP_SELF'].'">');
}