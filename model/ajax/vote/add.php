<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
//dump($_POST, true);
$id_vote = $db->Add(
	"vote",
	[
		"name" => $_POST['name'],
		"is_faculty" => $_POST['faculty']==='true'?1:0,
		"for_faculty" => ($_POST['forfaculty']==='true' || $_POST['forsector']==='true')?1:0
	]
);
if($_POST['forfaculty']==='false'){
	if($_POST['forsector']==='false'){
		foreach ($_POST['ids'] as $id) {
			$db->Add(
				"vote_participants",
				[
					"id_vote" => $id_vote,
					"id_student" => $id
				]
			);
		}
	} else {
		$sectors = $db->Select(
			[],
			"rg",
			[
				"napravlenie" => ["направление", "сектор"]
			]
		)->fetchAll();

		foreach ($sectors as $sector) {
			$db->Add(
				"vote_participants",
				[
					"id_vote" => $id_vote,
					"id_faculty" => $sector['name']
				]
			);
		}
	}
} else {
	$facs = $db->Select(
		[],
		"faculty"
	)->fetchAll();
	
	foreach ($facs as $fac) {
		$db->Add(
			"vote_participants",
			[
				"id_vote" => $id_vote,
				"id_faculty" => $fac['name']
			]
		);
	}
}