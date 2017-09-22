<?
/**
* Основной класс для управления системой.
*/
class Main 
{
	const COOKIE_PREFIX = "PPPOS";

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
			"rtopmenu" => array(1,2,3,4,5),
			"topmenu" => array(1,2,3,4,5),
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
		),
		"students" => array(
			"add" => array(1,2,3,4,5),
			"search" => array(1,2,3,4,5),
		),
		"tasks" => array(
			"add" => array(1),
			"check" => array(1,2,4),
			"list" => array(1,2,4),
		),
		"contact" => array(
			"form" => array(1,2,3,4,5),
		)
	);

	/**
	* Подключает часть страницы типа $type (например: menu, requests) с именем $name. Это основная функция для отображения конетента страницы. Меню, разделы, отдельные страницы строятся с помощью этой функции. В файле /<B>model</B>/$type/$name.php выстраевается итоговый массив, который затем передается файлу /<B>view</B>/$type/$name.php для отображения итоговой части страницы. 
	* @param string $type Тип подключаемой части.
	* @param string $name Название подключаемой части.
	* @param array $settings Параметры для подключения. В зависимости от этих данных может меняться контент на странице.
	* @return array $result Полученный массив, который можно использовать далее на странице и передавать его (или его части) как параметр для следующего элемента (например, какие разделы показывать, исходя из доступных разделов меню)
	*/
	public static function IncludeThing($type, $name, $settings = array(), $unLoged = true)
	{
		global $user, $db;
		$result = array();
		if(!isset(self::$permissions[$type][$name]) || (isset($user) && !in_array($user->getLevel(), self::$permissions[$type][$name]) || !$unLoged)){
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

	public static function error($error)
	{
		global $db, $user;
		include $_SERVER['DOCUMENT_ROOT']."/headerreg.php";
        include $_SERVER['DOCUMENT_ROOT']."/view/error.php";
        include $_SERVER['DOCUMENT_ROOT']."/footer.php";
        die;
	}

	public static function error403()
	{
		global $db, $user;
        include $_SERVER['DOCUMENT_ROOT']."/403.php";
        die;
	}


	public static function errorMessage($error)
	{
		global $db, $user;
        include $_SERVER['DOCUMENT_ROOT']."/view/error.php";
        include $_SERVER['DOCUMENT_ROOT']."/footer.php";
        die;
	}

	public static function success($text, $url)
	{
		global $db, $user;
		include_once $_SERVER['DOCUMENT_ROOT']."/header.php";
        include $_SERVER['DOCUMENT_ROOT']."/view/success.php";
        include $_SERVER['DOCUMENT_ROOT']."/footer.php";
        die;
	}

	public static function redirect($link)
	{
		echo "<META HTTP-EQUIV='REFRESH' CONTENT='0; URL=$link'>";
		die;
	}

	/**
	* Возвращает куку по имени
	* @param $name Имя куки (без префикса)
	* @param $name_prefix Префикс
	*/
	public static function get_cookie($name, $name_prefix=self::COOKIE_PREFIX)
	{
		$name = $name_prefix."_".$name;
		return (isset($_COOKIE[$name])? $_COOKIE[$name] : "");
	}

	/**
	* Устанавливает куку
	* @param $name Имя куки
	* @param $value	Значение куки
	* @param $time Дата смерти куки
	* @param $folder Директория, по которой она доступна
	* @param $domain Домен, по которому она доступна
	* @param $secure Указывает на то, что значение cookie должно передаваться от клиента по защищенному HTTPS соединению
	* @param $name_prefix Префикс к имени
	*/
	public static function set_cookie($name, $value, $time=false, $folder="/", $domain=false, $secure=false, $name_prefix=self::COOKIE_PREFIX, $httpOnly=false)
	{
		if($time === false)
			$time = time()+60*60*24*30; // 30 days 

		$name = $name_prefix."_".$name;

		if($domain === false)
			$domain = $_SERVER['HTTP_HOST'];
		setcookie($name, $value, $time, $folder, $domain, $secure, $httpOnly);
	}

	public static function delete_cookie($name, $name_prefix=self::COOKIE_PREFIX)
	{
		self::set_cookie($name, " ", time()-1000);
	}

	public static function IncludeAddWindow($name, $settings = array())
	{
		if(file_exists($_SERVER['DOCUMENT_ROOT']."/view/addWindow/addWindow.php"))
			include $_SERVER['DOCUMENT_ROOT']."/view/addWindow/addWindow.php";
	}
}
?>