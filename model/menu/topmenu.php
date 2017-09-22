<?
$result = array();
$newEvents = -1;
switch ($settings['userLevel']) {
	case 3:
	case 4:
	case 5:
		$result[] = array(
			"name" => "Поиск студента",
			"link" => "/students/search",
			"isParent" => false,
		);
		$result[] = array(
			"name" => "Мероприятия",
			"isParent" => false,
			"link" => "/events/"
		);
		break;
	case 1:
		$newEvents = $user->getNewEventsCount();
	case 2:
		$result[] = array(
			"name" => "Студенты",
			"link" => "",
			"isParent" => true,
			"childs" => array(
				array(
					"name" => "Регистрация",
					"link" => "/students/new",
					"isParent" => false,
				),
				array(
					"name" => "Поиск",
					"link" => "/students/search",
					"isParent" => false,
				),
			)
		);
		$result[] = array(
			"name" => "Мероприятия",
			"isParent" => false,
			"link" => "/events/",
			"numReq" => $newEvents
		);
		$result[] = array(
			"name" => "Соц. выплаты",
			"isParent" => true,
			"numReq" => $settings['requests']['socSup']['count'] + $settings['requests']['socStip']['count'],
			"childs" => array(
				array(
					"name" => "Стипендии",
					"isParent" => true,
					"numReq" => $settings['requests']['socStip']['count'],
					"childs" => array(
						array(
							"name" => "Новая",
							"link" => "/soc/stip",
							"isParent" => false
						),
						array(
							"name" => "Оповещения",
							"link" => "/soc/stip/request",
							"isParent" => false,
							"numReq" => $settings['requests']['socStip']['count']
						),
					)
				),
				array(
					"name" => "Поддержки",
					"isParent" => true,
					"numReq" => $settings['requests']['socSup']['count'],
					"childs" => array(
						array(
							"name" => "Новая",
							"link" => "/soc/support",
							"isParent" => false
						),
						array(
							"name" => "Оповещения",
							"link" => "/soc/support/request",
							"isParent" => false,
							"numReq" => $settings['requests']['socSup']['count']
						)
					)
				),
				array(
					"name" => "Протоколы",
					"isParent" => false,
					"link" => "/soc/decree"
				)
			)
		);
		$result[] = array(
			"name" => "Задания",
			"link" => "/tasks",
			"numReq" => $settings['requests']['tasks']['count']
		);
}
if($settings['userLevel'] == 4){
	if($settings['requests']['tasks'] !== false){
		$result[] = array(
			"name" => "Задания",
			"link" => "/tasks",
			"numReq" => $settings['requests']['tasks']['count']
		);
	}
}