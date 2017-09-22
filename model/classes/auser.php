<?
/**
* Общий класс для пользователей.
*/
class AUser
{

	function __construct(array $info){
		foreach ($info as $key => $value)
		{
		    try{
		    	eval('$this->set'.ucfirst($key).'("'.$value.'");');
		    } catch (Exception $e) {
		    	Main::error($e->getMessage());
		    }
		}
	}
	
	public static function getInfo($id, $select = array("*"))
	{
		global $db;
		return $db->Select(
			$select,
			"full_info",
			array("id_student" => $id)
		)->fetch();
	}

	public static function getList($select, $ids)
	{
		# code...
	}

	public static function Add($values)
	{
		global $db;
		$db->Add("students", $values);
	}
	
	public static function getId()
	{
		global $db;
		if(isset($this)){
			if(!isset($this->id))
				return false;
			return $this->id;
		} else {
			return $db->Select(
				array("id_user"),
				"users",
				array("login" => Main::get_cookie("LOG"), "hash" => md5(Main::get_cookie("HPS")))
			)->fetch()['id_user'];
		}
	}
}