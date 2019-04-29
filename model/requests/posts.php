<?
if(isset($user->getNumNotes()['posts']['notes'])){
	$prefix = 'posts_';
	if($settings['pagination']){
	    $page = isset($_GET[$prefix . 'page'])?($_GET[$prefix . 'page']):1;
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
	$result['pageNav'] = $settings['pagination']?$res->GeneratePageNav($page, $prefix):'';
	$result['requests'] = $res->fetchAll();
}