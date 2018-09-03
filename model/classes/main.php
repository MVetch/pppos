<?
/**
* Основной класс для управления системой.
*/
class Main 
{
	const COOKIE_PREFIX = "PPPOS";

	/**
	 * Здесь указаны уровни пользователей, которым доступен тот или иной компонент 
	 * @var array
	 */
	public static $permissions = array(
		"events" => array(
			"add" => array(1,2,3,4,5),
			"detail" => array(1,2,3,4,5),
			"edit" => array(1,2,3,4,5),
			"list" => array(1,2,3,4,5),
			"newparticipant" => array(1,2,3,4,5),
			"search" => array(1,2,3,4,5),
			"requests" => array(1),
		),
		"events/grant" => array(
			"newgrant" => array(1),
		),
		"acc" => array(
			"nothing" => array(1,2,3,4,5),
			"accInfo" => array(1,2,3,4,5),
			"edit" => array(1,2,3,4,5),
			"events" => array(1,2,3,4,5),
			"info" => array(1,2,3,4,5),
			"posts" => array(1,2,3,4,5),
			"requests" => array(1,2,3,4,5),
			"soc" => array(1,2,3,4,5),
		),
		"menu" => array(
			"lMenu" => array(1,2,3,4,5),
			"rtopmenu" => array(null, 1,2,3,4,5),
			"topmenu" => array(null, 1,2,3,4,5),
		),
		"posts" => array(
			"add" => array(1,2,3,4,5),
		),
		"reg" => array(
			"chooseGroup" => array(1,2,3,4,5),
			"fullRegistration" => array(1,2,3,4,5),
			"errorRegistration" => array(1,2,3,4,5)
		),
		"requests" => array(
			"events" => array(1,2,3,4,5),
			"posts" => array(1,2,3,4,5)
		),
		"rate" => array(
			"count" => array(1,2,3,4,5),
			"faculty" => array(1,2,3,4,5)
		),
		"soc" => array(
			"decree" => array(1,2),
			"newStip" => array(1,2),
			"newSup" => array(1,2),
			"requestStip" => array(1,2),
			"requestSup" => array(1,2),
			"calcStip" => array(null,1,2,3,4,5),
		),
		"students" => array(
			"add" => array(1,2,3,4,5),
			"search" => array(1,2,3,4,5),
			"alcometer" => array(null,1,2,3,4,5),
		),
		"tasks" => array(
			"add" => array(1),
			"check" => array(1,2,4),
			"list" => array(1,2,4),
		),
		"contact" => array(
			"form" => array(1,2,3,4,5),
		),
		"admin" => array(
			"messages" => array(1),
			"errors" => array(1),
			"systemerrors" => array(1),
		)
	);

	/**
	* Подключает часть страницы типа $type (например: menu, requests) с именем $name. Это основная функция для отображения контента страницы. Меню, разделы, отдельные страницы строятся с помощью этой функции. В файле /<B>model</B>/$type/$name.php выстраевается итоговый массив, который затем передается файлу /<B>view</B>/$type/$name.php для отображения итоговой части страницы. 
	* @param string $type тип подключаемой части.
	* @param string $name название подключаемой части.
	* @param array $settings параметры для подключения. В зависимости от этих данных может меняться контент на странице.
	* @return array $result полученный массив, который можно использовать далее на странице и передавать его (или его части) как параметр для следующего элемента (например, какие разделы показывать, исходя из доступных разделов меню)
	*/
	public static function includeThing($type, $name, $settings = array())
	{
		global $user, $db;
		$result = array();
		if(isset(self::$permissions[$type][$name]) && (isset($user) && !in_array($user->getLevel(), self::$permissions[$type][$name]))){
			include $_SERVER['DOCUMENT_ROOT']."/403.php";
		}
		if(file_exists($_SERVER['DOCUMENT_ROOT']."/$type/model/$name.php"))
			include $_SERVER['DOCUMENT_ROOT']."/$type/model/$name.php";
		elseif(file_exists($_SERVER['DOCUMENT_ROOT']."/model/$type/$name.php"))
			include $_SERVER['DOCUMENT_ROOT']."/model/$type/$name.php";
		if(file_exists($_SERVER['DOCUMENT_ROOT']."/$type/view/$name.php"))
			include $_SERVER['DOCUMENT_ROOT']."/$type/view/$name.php";
		elseif(file_exists($_SERVER['DOCUMENT_ROOT']."/view/$type/$name.php"))
			include $_SERVER['DOCUMENT_ROOT']."/view/$type/$name.php";
		return $result;
	}

	/**
	 * Выводит пользователю сообщение об ошибке с возможностью вернуться на предыдующую страницу
	 * @param  string $error текст сообщения
	 */
	public static function error(string $error)
	{
		global $db, $user;
		include $_SERVER['DOCUMENT_ROOT']."/headerreg.php";
        include $_SERVER['DOCUMENT_ROOT']."/view/error.php";
        include $_SERVER['DOCUMENT_ROOT']."/footer.php";
        die;
	}

	/**
	 * Симуляция 403 ошибки
	 */
	public static function error403()
	{
		global $db, $user;
        include $_SERVER['DOCUMENT_ROOT']."/403.php";
        die;
	}


	/**
	 * Выводит пользователю сообщение об ошибке при обработке на уже загруженной странице
	 * @param string $error текст сообщения
	 */
	public static function errorMessage(string $error)
	{
		global $db, $user;
        include $_SERVER['DOCUMENT_ROOT']."/view/error.php";
        include $_SERVER['DOCUMENT_ROOT']."/footer.php";
        die;
	}

	/**
	 * Выводит пользователю сообщение об ошибке при асинхронном запросе (просто текст)
	 * @param string $error текст сообщения
	 */
	public static function errorAjax(string $error)
	{
        include $_SERVER['DOCUMENT_ROOT']."/view/error.php";
        die;
	}

	/**
	 * Выводит пользователю сообщение об успешной операции и пересылает его на другую страницу
	 * @param  string $text текст сообщения
	 * @param  string $url  URL страницы, на которую нужно перенаправить пользователя
	 */
	public static function success(string $text, string $url, int $time = 2, bool $unloged = false)
	{
		global $db, $user;
		if($unloged) include_once $_SERVER['DOCUMENT_ROOT']."/headerreg.php"; else include_once $_SERVER['DOCUMENT_ROOT']."/header.php";
        include $_SERVER['DOCUMENT_ROOT']."/view/success.php";
        include $_SERVER['DOCUMENT_ROOT']."/footer.php";
        die;
	}

	/**
	 * Пересылает пользователя на указанную страницу
	 * @param  string $link URL страницы, на которую нужно перенаправить пользователя
	 */
	public static function redirect(string $link, int $delay = 0)
	{
		echo "<META HTTP-EQUIV='REFRESH' CONTENT='".$delay."; URL=$link'>";
		die;
	}

	/**
	* Возвращает куку по имени
	* @param $name имя куки (без префикса)
	* @param $name_prefix префикс
	*/
	public static function get_cookie($name, $name_prefix=self::COOKIE_PREFIX)
	{
		$name = $name_prefix."_".$name;
		return (isset($_COOKIE[$name])? $_COOKIE[$name] : "");
	}

	/**
	* Устанавливает куку. При не указаной дате смерти куки, она ставится на 30 дней
	* @param $name имя куки
	* @param $value	значение куки
	* @param $time дата смерти куки
	* @param $folder директория, по которой она доступна
	* @param $domain домен, по которому она доступна
	* @param $secure указывает на то, что значение cookie должно передаваться от клиента по защищенному HTTPS соединению
	* @param $name_prefix префикс к имени
	*/
	public static function set_cookie(
		$name, 
		$value, 
		$time=false, 
		$folder="/", 
		$domain=false, 
		$secure=false, 
		$name_prefix=self::COOKIE_PREFIX, 
		$httpOnly=false)
	{
		if($time === false)
			$time = time()+60*60*24*30; // 30 days 

		$name = $name_prefix."_".$name;

		if($domain === false)
			$domain = $_SERVER['HTTP_HOST'];
		setcookie($name, $value, $time, $folder, $domain, $secure, $httpOnly);
	}

	/**
	 * Удаляет куку  с указанным именем
	 * @param $name имя куки
	 * @param $name_prefix префикс к имени
	 */
	public static function delete_cookie(string $name, string $name_prefix=self::COOKIE_PREFIX)
	{
		self::set_cookie($name, " ", time()-1000);
	}

	/**
	 * Подключает на страницу дополнительное всплывающее окошко. Верстка внутреннего наполнения этого окна задается в файле "/view/addWindow/$name.php". На самой странице необходимо иметь кнопку или другой триггер для появления на экране этого окна. В вызываемой javascript функции должна присутствовать строка "document.getElementById(<b>$name</b>).style.display ='block';"
	 * @param string $name     название страницы с версткой
	 * @param array  $settings параметры, передаваемые для генерации внутреннего наполнения окошка
	 */
	public static function IncludeAddWindow(string $name, $settings = array())
	{
		if(file_exists($_SERVER['DOCUMENT_ROOT']."/view/addWindow/addWindow.php"))
			include $_SERVER['DOCUMENT_ROOT']."/view/addWindow/addWindow.php";
	}

	public static function Month($format = "m")
	{
		return date($format);
	}

	public static function Year($format = "Y")
	{
		return date($format);
	}

	public static function Day($format = "d")
	{
		return date($format);
	}

	public static function Mail($email_to, 
								$email_subject, 
								$email_message, 
								$headers = [], 
								$additional_parameters = '-fprofcom@xn--c1anddibeiyke.xn--p1acf'
							)
	{
		$headers = array_merge(array(
								    "From: ".NOREPLY_EMAIL,
								    "Reply-to: ".NOREPLY_EMAIL,
								    'X-Mailer: PHP/'.phpversion(),
								    'MIME-Version: 1.0',
								    'Content-type: text/html;',
								    "mailed-by:	xn--c1anddibeiyke.xn--p1acf"
								), $headers);
		$headers = implode("\r\n", $headers);
		return mail($email_to, $email_subject, wordwrap($email_message, 70, "\r\n"), $headers, $additional_parameters);
	}
}
?>