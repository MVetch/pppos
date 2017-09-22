<?
if(isset($_POST['btn'])){
    include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
    if(!isset($_POST['id_student']) || empty($_POST['id_student'])){
        Main::error("Такого студента нет.");
    }
    $db->Add(
        "mat_support",
        array(
            "id_student" => $_POST['id_student'],
            "payday" => $_POST['dz'],
            "id_categ" => $_POST['kateg'],
            "status" => $_POST['status']
        )
    );
    if($_POST['kateg'] == 16){
        $db->Add(
            "compensation",
            array(
                "reason" => $_POST['reason'],
                "id_mat_sup" => $db->insert_id
            )
        );
    }
    Main::redirect("/soc/support");
}