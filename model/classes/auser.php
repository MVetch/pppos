<?
/**
* Общий класс для пользователей.
*/
class AUser extends User
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

	public function getList($select, $ids)
	{
		# code...
	}

	public function Add($values)
	{
		global $db;
		$db->Add("students", $values);
	}
	
	public function getId()
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