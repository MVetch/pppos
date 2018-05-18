<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
$user = new User();
$res = $db->Select(
	array("*"),
	"temp_table_posts",
	array("id" => $_POST['id'])
)->fetch();

if(!empty($res)) {
	if($db->Select(
				array("*"),
				"posts_student",
				array(
					"id_student" => $res['id_student'],
					"id_post" => $res['id_post'],
					"date_in_sem" => $res['date_in_sem'],
					"date_in_y" => $res['date_in_y'],
					"date_out_sem" => $res['date_out_sem'],
					"date_out_y" => $res['date_out_y'],
					"comment" => $res['comment']
				)
			)->num_rows == 0
		) {
		$db->Add(
			"posts_student",
			array(
				"id_student" => $res['id_student'],
				"id_post" => $res['id_post'],
				"date_in_sem" => $res['date_in_sem'],
				"date_in_y" => $res['date_in_y'],
				"date_out_sem" => $res['date_out_sem'],
				"date_out_y" => $res['date_out_y'],
				"comment" => $res['comment'],
				"accepted_by" => $user->getId()
			)
		);
	}

	Request::DeletePostById($_POST['id']);
}