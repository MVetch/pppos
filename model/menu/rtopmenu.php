<?
$result = array(
	array(
		"name" => "Личный кабинет",
		"link" => "/id".$settings['userId']
	),
	array(
		"name" => "945",
		"link" => "/rate"
	)
);
if($user->getNumNotes()['posts'] !== false && $user->getNumNotes()['events'] !== false){
	$result[] = array(
		"name" => "Заявки",
		"numReq" => $user->getNumNotes()['posts']['count'] + $user->getNumNotes()['events']['count'],
		"link" => "/requests"
	);
}
$result[] = array(
	"name" => "Связаться с нами",
	"link" => "/contact"
);
$result[] = array(
	"name" => "Что нового на сайте?",
	"link" => "/change"
);
$result[] = array(
	"name" => "Профактивность",
	"link" => "/rate_fac"
);
$result[] = array(
	"name" => "Выход",
	"link" => "/exit"
);
?>