<?
if($settings['pagination']){
    $page = isset($_GET['page'])?($_GET['page']):1;
    $limit = array(($page - 1) * PAGINATION_PER_PAGE, PAGINATION_PER_PAGE);
} else {
    $limit = array();
}

$res = $db->Select(
	array("id", "name", "fio", "faculty", "org_id"),
	"grant_project_names",
	array(),
	array(),//array("date" => "DESC"),
	$limit//array(0, PAGINATION_PER_PAGE)
);
$result['pageNav'] = $settings['pagination']?$res->GeneratePageNav($page):'';
$result['projects'] = $res->fetchAll();

$result['projectVoted'] = array_unique(
	$db->Select(
		[],
		"grant_project_rate",
		[
			"id_from" => $user->getLevel()
		]
	)->fetchAll("id_project")
);