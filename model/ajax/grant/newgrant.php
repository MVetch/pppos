<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
if(User::LEVEL() >= 2) {
	Main::error403();
}
if(date("Y-m-d") > $_POST['date_start']){
	$_POST['date_start'] = date("Y-m-d");
}
if($_POST['duration_request'] < 3){
	$_POST['duration_request'] = 3;
}
if($_POST['duration_vote'] < 1){
	$_POST['duration_vote'] = 1;
}
if($_POST['duration_vote'] > 10){
	$_POST['duration_vote'] = 10;
}
$db->Add(
	"grants",
	[
		"date_start" => $_POST['date_start'],
		"duration_request" => $_POST['duration_request'],
		"duration_vote" => $_POST['duration_vote']
	]
);
echo "Грант успешно добавлен. Проекты можно будет загружать с момента начала их приема.";