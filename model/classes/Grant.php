<?
/**
* Класс, описывающий гранты
*/
class Grant
{
	private $id, $dateStart, $durationRequest, $durationVote, $isOn;
	private $dateEndRequests;
	private $dateStartVote;
	private $dateEndVote;

	public function __construct()
	{

	}

	static public function full($_id, $_dateStart, $_durationRequest, $_durationVote, $_isOn)
	{
		$instance = new self();
		$instance->id = $_id;
		$instance->dateStart = new DateTime($_dateStart);
		$instance->durationRequest = $_durationRequest;
		$instance->durationVote = $_durationVote;
		$instance->isOn = $_isOn;

		$instance->dateEndRequests = (clone $instance->dateStart)->add(new DateInterval('P'.$instance->durationRequest.'D'));
		$instance->dateStartVote   = (clone $instance->dateEndRequests)->add(new DateInterval('P1D'));
		$instance->dateEndVote     = (clone $instance->dateStartVote)->add(new DateInterval('P'.$instance->durationVote.'D'));
		return $instance;
	}

	static public function fromID($id) 
	{
		global $db;
		$res = $db->Select([], "grants", ["id" => $id]);
		if($res->num_rows > 0){
			extract($res->fetchAll()[0]);
			return self::full($id, $date_start, $duration_request, $duration_vote, $is_on);
		} else {
			return new self();
		}
	}

	public function isActive()
	{
		return $this->isOn and $this->getDateEndRequests("Y-m-d") > date("Y-m-d");
	}
	public function isOn()
	{
		return (bool)$this->isOn;
	}

	public function isActivatable()
	{
		return $this->getDateEndRequests("Y-m-d") > date("Y-m-d");
	}

	public function getId()
	{
		return $this->id;
	}

	public function getDateStart($format = null)
	{
		if(isset($format)){
			return $this->dateStart->format($format);
		} else {
			return $this->dateStart;
		}
	}

	public function getDurationRequest()
	{
		return $this->durationRequest;
	}

	public function getDurationVote()
	{
		return $this->durationVote;
	}

	public function getDateEndRequests($format = null)
	{
		if(isset($format)){
			return $this->dateEndRequests->format($format);
		} else {
			return $this->dateEndRequests;
		}
	}

	public function getDateStartVote($format = null)
	{
		if(isset($format)){
			return $this->dateStartVote->format($format);
		} else {
			return $this->dateStartVote;
		}
	}

	public function getDateEndVote($format = null)
	{
		if(isset($format)){
			return $this->dateEndVote->format($format);
		} else {
			return $this->dateEndVote;
		}
	}
}