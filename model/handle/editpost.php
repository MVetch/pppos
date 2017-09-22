<?
if (isset($_POST['registration'])){
    include_once $_SERVER['DOCUMENT_ROOT']."/model/start.php";
    if(empty($_POST['fadedates'][0]) || empty($_POST['fadedatey'][0])){
        $_POST['fadedates'][0]="";
        $_POST['fadedatey'][0]="";
    }
    if($db->Select(
            array("*"),
            "temp_table_posts",
            array(
                "id_student" => $_GET['id'],
                "id_post" => $_POST['currole'][0],
                "date_in_sem" => $_POST['indates'][0],
                "date_in_y" => $_POST['indatey'][0],
                "date_out_sem" => $_POST['fadedates'][0],
                "date_out_y" => $_POST['fadedatey'][0],
                "comment" => $_POST['comment'][0]
            )
        )->num_rows == 0 && 
        $db->Select(
            array("*"),
            "posts_student",
            array(
                "id_student" => $_GET['id'],
                "id_post" => $_POST['currole'][0],
                "date_in_sem" => $_POST['indates'][0],
                "date_in_y" => $_POST['indatey'][0],
                "date_out_sem" => $_POST['fadedates'][0],
                "date_out_y" => $_POST['fadedatey'][0],
                "comment" => $_POST['comment'][0]
            )
        )->num_rows == 0
    ) {
        $db->Update(
            "posts_student",
            array(
                "id_student" => $_GET['id'],
                "id_post" => $_POST['currole'][0],
                "date_in_sem" => $_POST['indates'][0],
                "date_in_y" => $_POST['indatey'][0],
                "date_out_sem" => $_POST['fadedates'][0],
                "date_out_y" => $_POST['fadedatey'][0],
                "comment" => $_POST['comment'][0]
            ),
            array("id" => $_GET['post'])
        );
        Main::success("Должность успешно обновлена.", '/id'.$_GET['id']);
    } else {
    	Main::error("Вы ничего не изменили или такая должность уже отмечена");
    }
	//User::LogIn($_POST['login'], $_POST['password']);
}