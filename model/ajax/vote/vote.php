<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
$user = new User();
$vote = $db->Select(
	[],
	"vote",
	[
		"id" => $_POST['vote']
	]
)->fetchAll();

if(
	empty(
		$db->Select(
			[],
			"vote_given",
			[
				"id_student" => $user->getId(),
				"id_vote" => $_POST['vote']
			]
		)->fetchAll()
	)
){
	$student = new User($_POST['id']);
	if($vote[0]['is_faculty'] == 1 && $student->getFaculty() == $user->getFaculty()){
		echo 'В этой номинации нельзя голосовать за студента со своего факультета!';
		die();
	}
	$db->Add(
		"vote_given",
		[
			"id_vote" => $_POST['vote'],
			"id_student" => $user->getId(),
			"id_participant" => $_POST['id']
		]
	);
} else {
	echo 'Вы уже голосовали в этой номинации!';
}