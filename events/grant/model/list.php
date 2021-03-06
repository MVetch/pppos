<?
if($settings['pagination']){
    $page = isset($_GET['page']) ? ($_GET['page']) : 1;
    $limit = array(($page - 1) * PAGINATION_PER_PAGE, PAGINATION_PER_PAGE);
} else {
    $limit = array();
}

$res = $db->Select(
	array("id", "name", "fio", "faculty", "rg_name", "org_id", "id_from"),
	"grant_project_names",
	array("id_grant" => $_GET['id']),
	array(),
	$limit
);

if($res->num_rows == 0) {
	Main::errorMessage("Проектов пока нет");
}

$result['pageNav'] = $settings['pagination'] ? $res->GeneratePageNav($page) : '';
$result['projects'] = $res->fetchAll();

$result['projectVoted'] = array_unique(
	$db->Select(
		[],
		"grant_project_rate",
		[
			"id_from" => $user->getId()
		]
	)->fetchAll("id_project")
);