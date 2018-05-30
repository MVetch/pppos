<?
	$result = array(
		array(
			"text" => "Группа",
			"value" => $settings['user']['groups']
		),
		array(
			"text" => "Факультет/институт",
			"value" => $settings['user']['faculty']." (профбюро ".$settings['user']['prof_faculty'].")"
		),
		array(
			"text" => "Форма обучения",
			"value" => $settings['user']['forma']
		),
		array(
			"text" => "Рейтинг",
			"value" => $settings['user']['rating']
		)
	);
?>