<?
$result = $db->Select(
	[],
	"messages_names"
)->fetchAll();
foreach ($result as $key => $student) {
	Main::IncludeAddWindow("messageBox", 
		array_merge(["id" => $student['id_message']], $student)
	);
}