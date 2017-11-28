<?
    include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
    
    if(!empty($_POST['id_student']))
        $id_student = $db->real_escape_string(test_input($_POST['id_student']));
    else {
        $id_student = $db->Select(
            array("id_student"), 
            "students", 
            array(
                "CONCAT(surname, ' ', name, ' ', thirdName)" => $_POST['fio']
            )
        )->fetch()["id_student"];
    }
    
    if(count($id_student)==0)
        die();
    
    if(isset($_POST['id'])){
        $db->Update(
            "soc_stip",
            array(
                "id_student" => $id_student,
                "date_app" => $_POST['dz'],
                "date_end" => $_POST['do'],
                "id_categ" => $_POST['categ'],
                "status" => $_POST['status'],
            ),
            array(
                "id_socstip" => $_POST['id']
            )
        );
    } elseif(isset($_POST['id_pod'])) {
        $db->Update(
            "mat_support",
            array(
                "id_student" => $id_student,
                "payday" => $_POST['dz'],
                "id_categ" => $_POST['categ'],
                "status" => $_POST['status'],
            ),
            array(
                "id_mat_sup" => $_POST['id_pod']
            )
        );
        if(!empty($_POST['reason'])){
            $db->Update(
                "compensation",
                array(
                    "reason" => $_POST['reason']
                ),
                array(
                    "id_mat_sup" => $_POST['id_pod']
                )
            );
        }
    }
?>