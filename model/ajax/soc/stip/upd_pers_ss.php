<?include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
    
    $id_student = $mysqli->real_escape_string(test_input($_POST['id_student']);
    
    if(isset($_POST['id'])){
        if(!empty($_POST['do']))
            $mysqli->query('UPDATE soc_stip
                        SET date_end = "'.$mysqli->real_escape_string(test_input($_POST['do'])).'"
                        WHERE id_soсstip = '.$mysqli->real_escape_string(test_input($_POST['id']))) or die($mysqli->error);
        else echo'Дата не введена!';
    }
    else echo 'Не влезай!';
?>