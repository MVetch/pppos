<?
$result['menu'] = array(
	array(
		"name" => "Личный кабинет",
		"link" => "/id".$settings['userId']
	),
	array(
		"name" => "ПГАС",
		"link" => "/rate"
	)
);
if($user->getNumNotes()['posts'] !== false || $user->getNumNotes()['events'] !== false){
	$result['menu'][] = array(
		"name" => "Заявки",
		"numReq" => $user->getNumNotes()['posts']['count'] + $user->getNumNotes()['events']['count'],
		"link" => "/requests"
	);
}
if($user->getLevel() == 1 or $user->getId() == $vote->getResponsible()->getId()){
    $result['menu'][] = array(
        "name" => "ПрофАКТИВируйся",
        "link" => "/vote/settings"
    );
}
if($user->getLevel() == 1){
	$result['menu'][] = array(
		"name" => "Админка",
		"link" => "/admin"
	);
	$result['menu'][] = array(
		"name" => "Управление грантами",
		"link" => "/events/grant/newgrant"
	);
}
$result['menu'][] = array(
	"name" => "Связаться с нами",
	"link" => "/contact"
);
$result['menu'][] = array(
	"name" => "Что нового на сайте?",
	"link" => "/change"
);
$result['menu'][] = array(
	"name" => "Профактивность",
	"link" => "/rate_fac"
);
$result['menu'][] = array(
	"name" => "Выход",
	"link" => "/exit"
);

switch ($user->getLevel()) {
	case 1:
		$result['level'] = "Администратор";
		break;
	case 2:
		$result['level'] = "Профорг";
		break;
	case 3:
		$result['level'] = "Зам.профорга";
		break;
	case 4:
		$result['level'] = "Руководитель";
		break;
	default:
		$result['level'] = "Активист";
		break;
}
?>