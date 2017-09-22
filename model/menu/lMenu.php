<?
$result = array();
$showMenu = false;
switch ($settings['page']) {
	case '/account.php':
		$result = array(
			array(
				"id"=>"nothing",
				"text"=>$user->getName(),
				"active"=>true,
				"img_src"=>"/images/search.png"
			),
			array(
				"id"=>"events",
				"text"=>"Мероприятия",
				"active"=>false,
				"img_src"=>"/images/plus.png"
			),
			array(
				"id"=>"posts",
				"text"=>"Должности",
				"active"=>false,
				"img_src"=>"/images/setting.png"
			),
		);
		if($user->getId() == $_GET['id']){
			$result[] = array(
				"id"=>"requests",
				"text"=>"Мои заявки",
				"active"=>false,
				"img_src"=>"/images/setting.png"
			);
			$result[] =	array(
				"id"=>"accInfo",
				"text"=>"Данные аккаунта",
				"active"=>false,
				"img_src"=>"/images/setting.png"
			);
			$result[] =	array(
				"id"=>"soc",
				"text"=>"Социалка",
				"active"=>false,
				"img_src"=>"/images/setting.png"
			);
		}
		$showMenu = true;
		break;
	case "/events/list.php":
	case "/events/detail.php":
	case "/events/search.php":
	case "/events/add.php":
	case "/events/fill.php":
		$result = array(
			array(
				"text"=>"Найти мероприятие",
				"img_src"=>"/images/search.png",
				"link"=>"/events/search"
			),
			array(
				"text"=>"Добавить мероприятие",
				"img_src"=>"/images/plus.png",
				"link"=>"/events/new"
			)
		);
		if($user->getEventsResponsibleCount() != 0){
			$result[] = array(
				"text"=>"Регистрация участников",
				"img_src"=>"/images/setting.png",
				"link"=>"/events/fill"
			);
		}
		if($user->getLevel() == 1){
			$result[] = array(
				"text"=>"Новые мероприятия",
				"img_src"=>"/images/setting.png",
				"link"=>"/events/requests",
				"numReq" => $user->getNewEventsCount()
			);
		}
		$showMenu = true;
		break;
	case "/soc/stip/index.php":
	case "/soc/support/index.php":
	case "/soc/support/request.php":
	case "/soc/stip/request.php":
		$result = array(
			array(
				"text"=>"Стипендии",
				"img_src"=>"/images/search.png",
				"link"=>"/soc/stip"
			),
			array(
				"text"=>"Поддержка",
				"active"=>false,
				"img_src"=>"/images/plus.png",
				"link"=>"/soc/support"
			),
			array(
				"text"=>"Распечатать протоколы",
				"active"=>false,
				"img_src"=>"/images/setting.png",
				"link"=>"/soc/decree"
			),
		);
		$showMenu = true;
		break;
	case "/students/add.php":
	case "/students/search.php":
		if($user->getLevel() < 3)
			$result = array(
				array(
					"text"=>"Поиск студента",
					"img_src"=>"/images/search.png",
					"link"=>"/students/search"
				),
				array(
					"text"=>"Регистрация студента",
					"img_src"=>"/images/plus.png",
					"link"=>"/students/new"
				),
			);
		break;
	case "/tasks/index.php":
	case "/tasks/new.php":
	case "/tasks/check.php":
		if($user->getLevel() == 1){
			$result[] = array(
					"text"=>"Создать задание",
					"img_src"=>"/images/search.png",
					"link"=>"/tasks/new"
				);
		} 
		if(in_array($user->getLevel(), [1,2,4])) {
			$result[] = array(
				"text"=>"Выполнить",
				"img_src"=>"/images/plus.png",
				"link"=>"/tasks"
			);
			$result[] = array(
				"text"=>"Проверить выполнение",
				"img_src"=>"/images/setting.png",
				"link"=>"/tasks/check"
			);
		}
		$showMenu = true;
		break;
}
?>