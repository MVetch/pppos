<?
/**
 * Список грантов
 */
class GrantList
{
	static public function getActive()
	{
		global $db;
		$res = $db->Select(
			[], 
			"grants", 
			[
				"is_on" => 1,
				">=ADDDATE(date_start, duration_request)" => date("Y-m-d")
			]
		);
		if($res->num_rows > 0) {
			$result = $res->fetchAll()[0];
			return Grant::full($result['id'], $result['date_start'], $result['duration_request'], $result['duration_vote'], $result['is_on']);
		} else {
			return false;
		}
	}

	static public function getLast()
	{
		global $db;
		$res = $db->Select(
			[], 
			"grants", 
			["<=date_start" => date("Y-m-d")],
			["date_start" => "desc"]
		);
		if($res->num_rows > 0) {
			$result = $res->fetchAll()[0];
			return Grant::full($result['id'], $result['date_start'], $result['duration_request'], $result['duration_vote'], $result['is_on']);
		} else {
			return false;
		}
	}
}