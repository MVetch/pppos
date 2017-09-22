<?
    include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
    if(isset($_POST['id'])){
        $db->Delete(
            "soc_stip",
            array("id_socstip" => $_POST['id'])
        );
    }
    if(isset($_POST['id_pod'])){
        $db->Delete(
            "mat_support",
            array("id_mat_sup" => $_POST['id_pod'])
        );
    }
?>