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
			"vote_given_names",
			[
				"id_from" => $user->getId(),
				"id_vote" => $_POST['vote']
			]
		)->fetchAll()
	)
){
	if($vote[0]['for_faculty'] == 0 and $vote[0]['is_faculty'] == 1){
		$id_student = $db->Select(
			["id_student"],
			"vote_participants",
			["id" => $_POST['id']]
		)->fetchAll("id_student");
		$student = new User($id_student[0]);
		if($vote[0]['is_faculty'] == 1 && $student->getFaculty() == $user->getFaculty()){
			echo 'В этой номинации нельзя голосовать за студента со своего факультета!';
			die();
		}
	} else {
		$faculty = $db->Select(
			["id_faculty"],
			"vote_participants",
			["id" => $_POST['id']]
		)->fetchAll("id_faculty");

		if($user->getFaculty() == $faculty[0]){
			echo 'В этой номинации нельзя голосовать за свой факультет!';
			die();
		}
	}
	$db->Add(
		"vote_given",
		[
			"id_from" => $user->getId(),
			"id_participant" => $_POST['id']
		]
	);
} else {
	echo 'Вы уже голосовали в этой номинации!';
}