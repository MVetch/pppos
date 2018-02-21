<?
if(isset($user->getNumNotes()['posts']['notes'])){
	if($settings['pagination']){
	    $page = isset($_GET['page'])?($_GET['page']):1;
	    $limit = array(($page - 1) * PAGINATION_PER_PAGE, PAGINATION_PER_PAGE);
	} else {
	    $limit = array();
	}
	$res = $db->Select(
		array("*"),
		"posts_student_names_requests",
		array(
			"id" => $user->getNumNotes()['posts']['notes'],
			"!id_student" => $user->getId()
		),
		[],
		$limit
	);
	$result['pageNav'] = $settings['pagination']?$res->GeneratePageNav($page):'';
	$result['requests'] = $res->fetchAll();
}