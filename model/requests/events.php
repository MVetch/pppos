<?
if(isset($user->getNumNotes()['events']['notes'])){
	$prefix = 'events_';
	if($settings['pagination']){
	    $page = isset($_GET[$prefix . 'page'])?($_GET[$prefix . 'page']):1;
	    $limit = array(($page - 1) * PAGINATION_PER_PAGE / 2, PAGINATION_PER_PAGE / 2);
	} else {
	    $limit = array();
	}
	$res = $db->Select(
		array("*"),
		"event_student_names_requests",
		array(
			"id" => $user->getNumNotes()['events']['notes'],
			"!id_student" => $user->getId()
		),
		[],
		$limit
	);
	$result['pageNav'] = $settings['pagination']?$res->GeneratePageNav($page, $prefix):'';
	$result['requests'] = $res->fetchAll();
}