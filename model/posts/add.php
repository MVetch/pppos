<?
$res = $db->Select(array("*"), 'posts');
$result['count'] = $res->num_rows;
$result['posts'] = $res->fetchAll();

$now = new DateTime();
$month = $now->format("m");
$year = $now->format("Y");
$day = $now->format("d");

$res = $db->Select(
	array("*"),
	"rg"
);

while ($list = $res->fetch()) {
	$result[$list['napravlenie']][] = test_input($list['name']);
}

if(isset($settings["id_student"])) {
	if($user->getLevel() < 3){
		include_once $_SERVER['DOCUMENT_ROOT'].FORM_HANDLER_DIR.'editpost.php';
		$result['postToEdit'] = $db->Select(array("*"), 'posts_student_names', array("id_student" => $settings["id_student"], "id" => $settings["id"]))->fetch();
	} else {
		Main::error403();
	}
} else {
	$settings["id_student"] = "";
	$settings["id"] = "";
}