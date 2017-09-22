<?
if(isset($_POST['btn'])){
    include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
    if(!isset($_POST['id_student']) || empty($_POST['id_student'])){
        Main::error("Такого студента нет.");
    }
    $db->Add(
        "soc_stip",
        array(
            "id_student" => $_POST['id_student'],
            "date_app" => $_POST['dz'],
            "id_categ" => $_POST['kateg'],
            "status" => $_POST['status']
        )
    );
    echo '<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=/soc/stip">';
}