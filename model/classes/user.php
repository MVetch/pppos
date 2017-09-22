<?
/**
* Класс для текущего пользователя. 
*/
class User
{

	function __construct()
	{
		global $db;
		$params = $db->query('
		    SELECT 
		        * 
		    FROM 
		        users
		    JOIN
		        students 
		    ON
		        students.id_student = users.id_user AND
		        users.login = "'.$db->escape(Main::get_cookie("LOG")).'" AND
		        users.hash = "'.md5($db->escape(Main::get_cookie("HPS"))).'"
		')->fetch_assoc();
		if(!empty($params)){
			$this->id = $params['id_student'];
			$this->name = $params['name'];
			$this->login = $params['login'];
			$this->password = $params['password'];
			$this->level = $params['level'];
			$this->photo = $params['photo'];
			$this->hash = "$2x";
	        $this->CountNumNotes();
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

	protected $id;
	protected $surname;
	protected $name;
	protected $thirdName;
	protected $login;
	protected $password;
	protected $hash;
	protected $level;
	protected $groups;
	protected $faculty;
	protected $form;
	protected $email;
	protected $coef;
	protected $phone;
	protected $eventsResponsible;
	protected $eventsResponsibleCount;
	protected $eventsVisited;
	protected $socStips;
	protected $socSups;
	protected $numNotes;

	public $photo;

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	public function getSurname()
	{
		global $db;
		if(!isset($this->surname)){
			$this->surname = $db->Select(array("surname"), "students", array("id_student" => $this->id))->fetch()['surname'];
		}
		return $this->surname;
	}

	public function setSurname($surname)
	{
		$this->surname = $surname;
		return $this;
	}

	public function getName()
	{
		global $db;
		if(!isset($this->name)){
			$this->name = $db->Select(array("name"), "students", array("id_student" => $this->id))->fetch()['name'];
		}
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	public function getThirdName()
	{
		global $db;
		if(!isset($this->thirdName)){
			$this->thirdName = $db->Select(array("thirdName"), "students", array("id_student" => $this->id))->fetch()['thirdName'];
		}
		return $this->thirdName;
	}
	
	public function setThirdName($thirdName)
	{
		$this->thirdName = $thirdName;
		return $this;
	}

	public function getFullName()
	{
		return $this->getSurname()." ".$this->getName()." ".$this->getThirdName();
	}

	public function getSurnameName()
	{
		return $this->getSurname()." ".$this->getName();
	}

	public function getGroups()
	{
		return $this->groups;
	}

	public function setGroups($groups)
	{
		$this->groups = $groups;
		return $this;
	}

	public function getNumNotes()
	{
		return $this->numNotes;
	}

	public function getForm()
	{
		global $db;
		if(!isset($this->form)){
			$this->form = $db->Select(array("form_edu"), "students", array("id_student" => $this->id))->fetch()['form_edu'];
		}
		return $this->form;
	}
	
	public function setForm($form)
	{
		$this->form = $form;
		return $this;
	}

	public function getCoef()
	{
		global $db;
		if(!isset($this->coef)){
			$this->coef = $db->Select(array("rating"), "students", array("id_student" => $this->id))->fetch()['rating'];
		}
		return $this->coef;
	}
	
	public function setCoef($coef)
	{
		$this->coef = $coef;
		return $this;
	}

	public function getPhone()
	{
		global $db;
		if(!isset($this->phone)){
			$this->phone = $db->Select(array("phone_number"), "students", array("id_student" => $this->id))->fetch()['phone_number'];
		}
		return $this->phone;
	}
	
	public function setPhone($phone)
	{
		$this->phone = $phone;
		return $this;
	}

	public function getEmail()
	{
		global $db;
		if(!isset($this->email)){
			$this->email = $db->Select(array("email"), "students", array("id_student" => $this->id))->fetch()['email'];
		}
		return $this->email;
	}
	
	public function setEmail($email)
	{
		$this->email = $email;
		return $this;
	}

	public function getPhotoFileName()
	{
		if(!empty($this->photo)){
			if (file_exists($_SERVER['DOCUMENT_ROOT'].AVATAR_DIR.$this->photo)){
			} elseif(file_exists($_SERVER['DOCUMENT_ROOT'].AVATAR_DIR.$this->id.".".$this->photo)){
			    $this->photo = $this->id.".".$this->photo;
			} else {
			    $this->photo = "no_photo.png";
			}
		} else {
			$this->photo = "no_photo.png";
		}
		return $this->photo;
	}

	public function getHash()
	{
		return $this->hash;
	}

	public function getFaculty()
	{
		global $db;
		if(isset($this->faculty) && !empty($this->faculty))
			return $this->faculty;
		$ret = $db->query('
			SELECT
				groups.faculty AS fac
			FROM
				stud_group
			JOIN
				groups
			ON
				groups.id_group = stud_group.id_group AND
				stud_group.id_student = '.$this->id.'
		')->fetch_assoc()['fac'];
		$this->faculty = $ret;
		return $ret;
	}

	public function getLevel()
	{
		return $this->level;
	}
	
	public function setLevel($level)
	{
		$this->level = $level;
		return $this;
	}

	public function getEventsResponsibleCount()
	{
		if(!isset($this->eventsResponsibleCount) or empty($this->eventsResponsibleCount))
			$this->CountEventsResponsible();
		return $this->eventsResponsibleCount;
	}

	public function getEventsResponsible()
	{
		if(!isset($this->eventsResponsible) or empty($this->eventsResponsible))
			$this->CountEventsResponsible();
		return $this->eventsResponsible;
	}

	public function getNewEvents()
	{
		if(!isset($this->newEvents)){
			$res = Event::getNew();
			$this->newEventsCount = $res['count'];
			$this->newEvents = $res['events'];
		}
		return $this->newEvents;
	}

	public function getNewEventsCount()
	{
		if(!isset($this->newEventsCount)){
			$res = Event::getNew();
			$this->newEventsCount = $res['count'];
			$this->newEvents = $res['events'];
		}
		return $this->newEventsCount;
	}

	public static function LogIn($login, $password)
	{
		global $db;
	    // if($login == "ultrauser" and $password == "123"){
     //        Main::set_cookie('LOG', "ultrauser", time()+(86400*365), "/");
     //        Main::set_cookie('HPS', crypt("123", "$2x"), time()+(86400*365), "/");
	    //     echo '<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=/id1">';
	    //     return;
	    // }
	    if (isset($login)) { 
	        $login = test_input($login); 
	        if ($login == '') { 
	            unset($login);
	        }
	    }

	    if (isset($password)) { 
	        $password=test_input($password); 
	        if ($password =='') { 
	            unset($password);
	        }
	    }
	    if (empty($login) or empty($password))
	    {
	        Main::error('Вы ввели не всю информацию, вернитесь назад и заполните все поля!');
	    }
	    $result = $db->query('
	    	SELECT 
	    		*  
	    	FROM 
	    		users 
	    	WHERE 
	    		users.login = "'.$db->escape($login).'"
	    '); //Тут еще должен извлекаться хеш (у каждого уникальный, построенный по некоему волшебному принципу)
	    $myrow = $result->fetch();
	    $hash = "$2x";
	    if (empty($myrow['login']))
	    {
	        Main::error('Такого пользователя не существует или Вы неправильно ввели login.');
	    }
	    else {
	        if (password_verify($password, $myrow['password'])) {
	        	$savedHash = md5($myrow['password'].time());
	        	$db->Update(
	        		"users",
	        		array(
	        			"hash" => md5($savedHash)
	        		),
	        		array(
	        			"login" => $login
	        		)
	        	);
	            Main::set_cookie('LOG', $myrow['login'], time()+(86400*365), "/");
	            Main::set_cookie('HPS', $savedHash, time()+(86400*365), "/");
	            echo '<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=/id'.$myrow['id_user'].'">';
	        	return;
	        }
	        else {
	            Main::error('Введённый вами пароль неверный.');
	        }
	    }
	}

	public function CountEventsResponsible()
	{
		global $db;
		$res = $db->query('
		    SELECT 
		    	id_event
            FROM 
            	event_student, 
            	roles
            WHERE 
            	id_student = "'.$this->id.'"
                AND event_student.id_role =  roles.id_role
                AND roles.name IN(
                	"организатор", 
                	"ответственный от ЛГТУ"
                )
        ');
        while($list = $res->fetch_assoc()){
        	$ret["events"][] = $list['id_event'];
        }
        $ret["count"] = $res->num_rows;
        $this->eventsResponsibleCount = $ret["count"];
        $this->eventsResponsible = $ret["count"]!=0?$ret["events"]:array();
        return $ret;
	}

	public function getNumPostNotes()
	{
		global $db;
		$return['notes'] = array();
		switch ($this->level) {
			case 4:
				$ret = $db->query('
				    SELECT
                      temp_table_posts.id
                    FROM
                      temp_table_posts
                    JOIN
                      posts_student
                    ON
                      temp_table_posts.comment = posts_student.comment 
                      AND posts_student.id_student = '.$this->id.' 
                      AND posts_student.id_post IN(9, 10, 11)
			    ');//TODO добавить сюда условие, чтобы свои заявки не подбирались
				break;
			case 2:
				$ret = $db->query('
				    SELECT
                      temp_table_posts.id
                    FROM
                      temp_table_posts
                    JOIN
                      stud_group
                    ON
                      temp_table_posts.id_student = stud_group.id_student
                    JOIN
                      groups
                    ON
                      stud_group.id_group = groups.id_group AND
                      groups.faculty = "'.$this->getFaculty().'" AND
                      NOT temp_table_posts.id_post = 12
			    ');//TODO добавить сюда условие, чтобы свои заявки не подбирались
			    break;
			case 1:
			    $ret = $db->Select(
			    	array("id"), 
			    	"temp_table_posts"
			    );//TODO добавить сюда условие, чтобы свои заявки не подбирались
				break;
			default:
				return false;
		}
        while($list = $ret->fetch_assoc()){
        	$return['notes'][] = $list['id'];
        }
	    $return['count'] = $ret->num_rows;
		return $return;
	}

	public function getNumEventNotes()
	{
		global $db;
		$return['notes'] = array();
		$return['count'] = 0;
		if($this->level != 1){
			$events = $this->CountEventsResponsible();
			if($events['count'] > 0){//если ответственный за мероприятие хоть одно
				$ret = $db->Select(
					array("id"),
                	"temp_table_events",
                	array(
                		"id_event" => $events['events'],
						//"!id_student" => $this->getId()
                	)
                );
			} elseif($this->level == 5) {
				return false;
			}
		} else {
			$ret = $db->Select(
		    	array("*"), 
		    	"temp_table_events"
		    );//заявки на мероприятия
		}
		if(isset($ret)){
	        while($list = $ret->fetch_assoc()){
	        	$return['notes'][] = $list['id'];
	        }
	    	$return['count'] = $ret->num_rows;
	    }
		return $return;
	}

	public function getNumTaskNotes()
	{
		global $db;
		$return['notes'] = array();
		switch ($this->level) {
			case 4:
				$ret = $db->query('
			    	SELECT 
			    		id_task AS id
			    	FROM 
			    		task 
			    	WHERE 
			    		ADDDATE(task.date_exp, 10) > CURDATE() AND 
			    		_for IN(3,5)
			    ');
				break;
			case 2:
				$ret = $db->Select(
                	array("id_task AS id"), 
                	"task", 
                	array(
                		">ADDDATE(task.date_exp, 10)" => date("Y-m-d"), 
                		"*_for" => array(2,5)
                	)
                );//задания для профоргов
				break;
			case 1:
				$ret = $db->Select(
			    	array("id_task AS id"), 
			    	"task", 
			    	array(
			    		">ADDDATE(task.date_exp, 100)" => date("Y-m-d")
			    	)
			    );//все недавние задания
				break;
			default:
				return false;
		}
        while($list = $ret->fetch_assoc()){
        	$return['notes'][] = $list['id'];
        }
	    $return['count'] = $ret->num_rows;
		return $return;
	}

	public function getNumSocNotes()
	{
		global $db;
		$return['socSup']['notes'] = array();
		$return['socStip']['notesRunOut'] = array();
		$return['socStip']['notesNoDate'] = array();
		$stipRunoutQuery = '
            SELECT
                soc_stip.id_socstip AS id
            FROM 
            	soc_stip ';

	    $stipNoDateQuery = '
	        SELECT 
	            soc_stip.id_socstip AS id
	        FROM soc_stip
	            JOIN statuses
	                ON id_status = status AND 
	                statuses.name = "заявление принято"
	    ';

	    $supQuery = '
	    	SELECT 
                CASE
                    WHEN 
                        (
                            EXTRACT(MONTH FROM NOW()) BETWEEN 03 AND 08 AND
                            (
                                (
                                    EXTRACT(MONTH FROM mat_support.payday) BETWEEN 09 AND 12 AND
                                    YEAR(mat_support.payday) = YEAR(NOW())-1
                                )
                                OR
                                (
                                    EXTRACT(MONTH FROM mat_support.payday) BETWEEN 01 AND 02 AND
                                    YEAR(mat_support.payday) = YEAR(NOW())
                                )
                            )
                        )
                        OR
                        (
                            EXTRACT(MONTH FROM mat_support.payday) BETWEEN 03 AND 08 AND
                        	(
                             	(
                                    EXTRACT(MONTH FROM NOW()) BETWEEN 09 AND 12 AND
                                	YEAR(mat_support.payday) = YEAR(NOW())
                                )
                                OR
                                (
                                	EXTRACT(MONTH FROM NOW()) BETWEEN 01 AND 02 AND
                                    YEAR(mat_support.payday) = YEAR(NOW())-1
                                )
                            )
                        )
                    THEN "norm"
                END AS "semester",
                mat_support.id_mat_sup AS id
            FROM mat_support
                JOIN statuses
                    ON id_status = status AND 
                    statuses.name = "заявление принято"
	    ';
		switch ($this->level) {
			case 1:
				break;
			case 2:
				$addStr = '
	            	JOIN 
	                	stud_group
	                ON 
		                stud_group.id_student = soc_stip.id_student
	                JOIN 
		                groups
	                ON 
		                groups.id_group = stud_group.id_group AND 
		                groups.faculty = "'.$this->getFaculty().'"
	            ';
	            $stipRunoutQuery .= $addStr;
	            $stipNoDateQuery .= $addStr;
	            $supQuery .= '
	            	JOIN 
	                	stud_group
	                ON 
		                stud_group.id_student = mat_support.id_student
	                JOIN 
		                groups
	                ON 
		                groups.id_group = stud_group.id_group AND 
		                groups.faculty = "'.$this->getFaculty().'"
	            ';
				break;
			default:
				return array(
					"socStip" => false,
					"socSup" => false
				);
		}
		$stipRunoutQuery .= '
			WHERE 
                DATEDIFF(date_end, CURDATE())<30 
                AND DATEDIFF(date_end, CURDATE())>0
		';
		$stipNoDateQuery .= '
	        WHERE 
	        	soc_stip.date_end = "0000-00-00" AND
	        	IF(
	        		DAYOFMONTH(NOW()) > 4, 
	        		soc_stip.date_app BETWEEN DATE_FORMAT(NOW() - INTERVAL 1 MONTH, "%Y-%m-01") AND LAST_DAY(NOW() - INTERVAL 1 MONTH),
	        		soc_stip.date_app BETWEEN DATE_FORMAT(NOW() - INTERVAL 2 MONTH, "%Y-%m-01") AND LAST_DAY(NOW() - INTERVAL 2 MONTH)
	        	)
		';
		$supQuery .= '
	        HAVING semester = "norm"
		';

		$ret = $db->query($stipRunoutQuery);//У кого соц до окончания действия соц стипендии меньше месяца
        while($list = $ret->fetch_assoc()){
        	$return['socStip']['notesRunOut'][] = $list['id'];
        }
		$return['socStip']['count'] = $ret->num_rows;

		$ret = $db->query($stipNoDateQuery);//У кого не вписана дата окончания стипендии
        while($list = $ret->fetch_assoc()){
        	$return['socStip']['notesNoDate'][] = $list['id'];
        }
		$return['socStip']['count'] += $ret->num_rows;

		$ret = $db->query($supQuery);//те, кто писал в прошлом семестре (мб написали и сейчас, но это не проверяется, а надо бы)
        while($list = $ret->fetch_assoc()){
        	$return['socSup']['notes'][] = $list['id'];
        }
		$return['socSup']['count'] = $ret->num_rows;

		return $return;
	}

	public function CountNumNotes()
	{
		$this->numNotes = $this->getNumSocNotes();
		$this->numNotes['events'] = $this->getNumEventNotes();
		$this->numNotes['posts'] = $this->getNumPostNotes();
		$this->numNotes['tasks'] = $this->getNumTaskNotes();
	}

	/**
	* Удаляет запись в таблице БД по ИД записи (не мероприятия). Чтобы удалить запись с определенного мероприятия у студента, нужно воспользоваться функцией @ref DeleteEventById(). Запись удаляется только в том случае, если соответствующая запись действительно соответствует студенту, который на данный момент авторизован.
	* @param int $id ИД записи в БД.
	*/
	public function DeleteEvent($id, $own = true)
	{
		global $db;
		if($own !== "false"){
			$db->Delete("event_student", array("id"=>$id, "id_student" => $this->getId()));
		} else {
			if($this->getLevel() < 3){
				$db->Delete("event_student", array("id"=>$id));
			} else {
				$id_event = $db->Select(array("id_event"), "event_student", array("id"=>$id))->fetch()['id_event'];
				if(in_array($id_event, $this->getEventsResponsible())) {
					$db->Delete("event_student", array("id"=>$id));
				}
			}
		}
	}

	/**
	* Удаляет запись в таблице БД по ИД мероприятия. Чтобы удалить определенную запись из БД, нужно воспользоваться функцией @ref DeleteEvent($id). Запись удаляется только в том случае, если соответствующая запись действительно соответствует студенту, который на данный момент авторизован.
	* @param int $id ИД записи в БД.
	*/
	public function DeleteEventById($id)
	{
		global $db;
		$db->Delete("event_student", array("id_event"=>$id, "id_student" => $this->getId()));
	}

	/**
	* Удаляет запись в таблице БД по ИД записи (не должности). Чтобы удалить запись об определенной должности у студента, нужно воспользоваться функцией @ref DeletePostById($id). Запись удаляется только в том случае, если соответствующая запись действительно соответствует студенту, который на данный момент авторизован.
	* @param int $id ИД записи в БД.
	*/
	public function DeletePost($id)
	{
		global $db;
		$db->Delete("posts_student", array("id"=>$id, "id_student" => $this->getId()));
	}

	/**
	* Удаляет запись в таблице БД по ИД мероприятия. Чтобы удалить определенную запись из БД, нужно воспользоваться функцией @ref DeletePost($id). Запись удаляется только в том случае, если соответствующая запись действительно соответствует студенту, который на данный момент авторизован.
	* @param int $id ИД записи в БД.
	*/
	public function DeletePostById($id)
	{
		global $db;
		$db->Delete("posts_student", array("id_post"=>$id, "id_student" => $this->getId()));
	}

	/**
	 * Завершить должность. В БД ставиться запись о том, что сегодня студент закончил пребывание на должности (отмечается семестр и год)
	 */
	public function EndPost($id)
	{
		global $db;
		$semester = semesterFromDate();
		$db->Update(
			"posts_student", 
			array(
				"date_out_sem" => $semester['semester'],
				"date_out_y" => $semester['year_begin_edu']
			),
			array("id"=>$id, "id_student" => $this->getId()));
	}

	public function ChangePassword($old, $new, $newConf, $hash)
	{
		global $db;
		if (!password_verify($old, $this->password)){
			Main::error("Неверный пароль!");
		} else if($new != $newConf){
	        Main::error("Пароли не совпадают!");
	    } else {
	    	$db->Update(
	    		"users", 
	    		array(
	    			"password" => password_hash($new, PASSWORD_BCRYPT)
	    		),
	    		array(
	    			"id_user" => $this->id
	    		)
	    	);
	    }
	}
}
?>