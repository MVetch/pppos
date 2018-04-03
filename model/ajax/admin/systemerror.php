<?include $_SERVER['DOCUMENT_ROOT']."/model/start.php";

if(isset($_POST['id'])){
    $db->Delete(
        "error",
        [
            "id_error" =>  $_POST['id'] 
        ]
    );
}