<?
if(isset($_POST['registration'])){
    include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
    $id = AUser::getId();
    for($i=0, $cnt=count($_POST['currole']); $i <= $cnt; $i++){
        if(!empty($_POST['currole'][$i])){
            if(empty($_POST['fadedates'][$i]) || empty($_POST['fadedatey'][$i])){
                $_POST['fadedates'][$i]="";
                $_POST['fadedatey'][$i]="";
            }
            if($db->Select(
                    array("*"),
                    "temp_table_posts",
                    array(
                        "id_student" => $id,
                        "id_post" => $_POST['currole'][$i],
                        "date_in_sem" => $_POST['indates'][$i],
                        "date_in_y" => $_POST['indatey'][$i],
                        "date_out_sem" => $_POST['fadedates'][$i],
                        "date_out_y" => $_POST['fadedatey'][$i],
                        "comment" => $_POST['comment'][$i]
                    )
                )->num_rows == 0 && 
                $db->Select(
                    array("*"),
                    "posts_student",
                    array(
                        "id_student" => $id,
                        "id_post" => $_POST['currole'][$i],
                        "date_in_sem" => $_POST['indates'][$i],
                        "date_in_y" => $_POST['indatey'][$i],
                        "date_out_sem" => $_POST['fadedates'][$i],
                        "date_out_y" => $_POST['fadedatey'][$i],
                        "comment" => $_POST['comment'][$i]
                    )
                )->num_rows == 0
            ) {
                $db->Add(
                    "temp_table_posts",
                    array(
                        "id_student" => $id,
                        "id_post" => $_POST['currole'][$i],
                        "date_in_sem" => $_POST['indates'][$i],
                        "date_in_y" => $_POST['indatey'][$i],
                        "date_out_sem" => $_POST['fadedates'][$i],
                        "date_out_y" => $_POST['fadedatey'][$i],
                        "comment" => $_POST['comment'][$i]
                    )
                );
            }
        }
    }
    Main::success("Вы успешно оставили заявку. Профорг Вашего факультета ее скоро рассмотрит.", '/id'.$id);
}