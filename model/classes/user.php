<?
/**
* Класс для текущего пользователя. 
*/
class User
{
	/**
	 * Конструктор. Собирает основную информацию о пользователе и доступные заявки
	 * @param  $id ИД нужного пользователя. Если нужен текущий, то в этот параметр ничего не передавать.
	 */
	function __construct($id = 0)
	{
		global $db;
		if($id > 0){
			$params = $db->query('
			    SELECT 
			        * 
			    FROM 
			        users
			    JOIN
			        students 
			    ON
			        students.id_student = users.id_user AND
			        students.id_student = '.$id.'
			')->fetch_assoc();
		} else {
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
		}
		if(!empty($params)){
			$this->id = $params['id_student'];
			$this->name = $params['name'];
			$this->login = $params['login'];
			$this->password = $params['password'];
			$this->level = $params['level'];
			$this->photo = $params['photo'];
	        $this->CountNumNotes();
	    }
	}

	/**
	 * Собирает основную информацию о пользователе по его ИД
	 * @param  int    $id     ИД пользователя
	 * @param  array  $select необходимые поля
	 * @return array        массив с полученными значениями
	 */
	public static function getInfo(int $id, $select = array("*"))
	{
		global $db;
		return $db->Select(
			$select,
			"full_info",
			array("id_student" => $id)
		)->fetch();
	}

	/**
	 * ИД пользователя
	 * @var int
	 */
	protected $id;
	/**
	 * Фамилия
	 * @var string
	 */
	protected $surname;
	/**
	 * Имя
	 * @var string
	 */
	protected $name;
	/**
	 * Отчетство
	 * @var string
	 */
	protected $thirdName;
	/**
	 * Логин
	 * @var string
	 */
	protected $login;
	/**
	 * Зашифрованный пароль
	 * @var string
	 */
	protected $password;
	/**
	 * Хэш авторизации
	 * @var string
	 */
	protected $hash;
	/**
	 * Уровень доступа
	 * @var int
	 */
	protected $level;
	/**
	 * Группа
	 * @var string
	 */
	protected $groups;
	/**
	 * Факультет
	 * @var string
	 */
	protected $faculty;
	/**
	 * Форма обучения
	 * @var string
	 */
	protected $form;
	/**
	 * E-mail
	 * @var string
	 */
	protected $email;
	/**
	 * Коэффициент стипендии
	 * @var string
	 */
	protected $coef;
	/**
	 * Телефон
	 * @var string
	 */
	protected $phone;
	/**
	 * Список из ИД мероприятий, за которые ответсвеннен текущий пользователь
	 * @var array
	 */
	protected $eventsResponsible;
	/**
	 * Количество мероприятий, за которые ответсвеннен текущий пользователь
	 * @var int
	 */
	protected $eventsResponsibleCount;
	/**
	 * Список из ИД мероприятий, которые посетил текущий пользователь (не используется)
	 * @var array
	 */
	protected $eventsVisited;
	/**
	 * Список из ИД соц.стипендий, относящихся к текущему пользователю (не используется)
	 * @var array
	 */
	protected $socStips;
	/**
	 * Список из ИД соц.поддержек, относящихся к текущему пользователю (не используется)
	 * @var array
	 */
	protected $socSups;
	/**
	 * Заявки/оповещения
	 * @var array
	 */
	protected $numNotes;

	/**
	 * Название файла с аватаркой
	 * @var string
	 */
	public $photo;

	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * Возращает ИД текущего авторизованного пользователя (статическая функция, для созданного объекта нужно пользоваться @ref getId())
	 */
	public static function ID()
	{
		global $db;
		return $db->Select(
			array("id_user"),
			"users",
			array("login" => Main::get_cookie("LOG"), "hash" => md5(Main::get_cookie("HPS")))
		)->fetch()['id_user'];
	}

	/**
	 * @return string фамилия пользователя
	 */
	public function getSurname()
	{
		global $db;
		if(!isset($this->surname)){
			$this->surname = $db->Select(array("surname"), "students", array("id_student" => $this->id))->fetch()['surname'];
		}
		return $this->surname;
	}

	/**
	 * Устанавливает фамилию пользователя
	 * @param $surname нужная фамилия
	 */
	public function setSurname($surname)
	{
		$this->surname = $surname;
		return $this;
	}

	/**
	 * @return string имя пользователя
	 */
	public function getName()
	{
		global $db;
		if(!isset($this->name)){
			$this->name = $db->Select(array("name"), "students", array("id_student" => $this->id))->fetch()['name'];
		}
		return $this->name;
	}

	/**
	 * Устанавливает имя пользователя
	 * @param $name нужное имя
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string отчество пользователя
	 */
	public function getThirdName()
	{
		global $db;
		if(!isset($this->thirdName)){
			$this->thirdName = $db->Select(array("thirdName"), "students", array("id_student" => $this->id))->fetch()['thirdName'];
		}
		return $this->thirdName;
	}
	
	/**
	 * Устанавливает отчество пользователя
	 * @param $thirdName нужное отчество
	 */
	public function setThirdName($thirdName)
	{
		$this->thirdName = $thirdName;
		return $this;
	}

	/**
	 * @return string ФИО пользователя
	 */
	public function getFullName()
	{
		return $this->getSurname()." ".$this->getName()." ".$this->getThirdName();
	}

	/**
	 * @return string ФИ пользователя
	 */
	public function getSurnameName()
	{
		return $this->getSurname()." ".$this->getName();
	}

	/**
	 * @return string группа пользователя
	 */
	public function getGroups()
	{
		return $this->groups;
	}

	/**
	 * Устанавливает группу пользователя
	 * @param $groups нужная группа
	 */
	public function setGroups($groups)
	{
		$this->groups = $groups;
		return $this;
	}

	/**
	 * @return array массив с количеством каждого вида заявок
	 */
	public function getNumNotes()
	{
		return $this->numNotes;
	}

	/**
	 * @return string форма обучения студента
	 */
	public function getForm()
	{
		global $db;
		if(!isset($this->form)){
			$this->form = $db->Select(array("form_edu"), "students", array("id_student" => $this->id))->fetch()['form_edu'];
		}
		return $this->form;
	}
	
	/**
	 * Устанавливает форму обучения
	 * @param string $form нужная форма
	 */
	public function setForm($form)
	{
		$this->form = $form;
		return $this;
	}

	/**
	 * @return int коэффициент стипендии
	 */
	public function getCoef()
	{
		global $db;
		if(!isset($this->coef)){
			$this->coef = $db->Select(array("rating"), "students", array("id_student" => $this->id))->fetch()['rating'];
		}
		return $this->coef;
	}
	
	/**
	 * Устанавливает коэффициент стипендии
	 * @param string $coef нужный коэффициент стипендии
	 */
	public function setCoef($coef)
	{
		$this->coef = $coef;
		return $this;
	}

	/**
	 * @return string телефон
	 */
	public function getPhone()
	{
		global $db;
		if(!isset($this->phone)){
			$this->phone = $db->Select(array("phone_number"), "students", array("id_student" => $this->id))->fetch()['phone_number'];
		}
		return $this->phone;
	}
	
	/**
	 * Устанавливает телефон
	 * @param string $phone нужный телефон
	 */
	public function setPhone($phone)
	{
		$this->phone = $phone;
		return $this;
	}

	/**
	 * @return string e-mail
	 */
	public function getEmail()
	{
		global $db;
		if(!isset($this->email)){
			$this->email = $db->Select(array("email"), "users", array("id_user" => $this->id))->fetch()['email'];
		}
		return $this->email;
	}
	
	/**
	 * Устанавливает e-mail
	 * @param string $email нужный e-mail
	 */
	public function setEmail($email)
	{
		$this->email = $email;
		return $this;
	}

	/**
	 * @return string путь к файлу для отображения как аватарки
	 */
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

	/**
	 * @return string хэш авторизации
	 */
	public function getHash()
	{
		return $this->hash;
	}

	/**
	 * @return string факультет пользователя
	 */
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

	/**
	 * @return int уровень доступа пользователя
	 */
	public function getLevel()
	{
		return $this->level;
	}
	/**
	 * @return int уровень доступа пользователя
	 */
	public static function LEVEL()
	{
		global $db;
		return $db->Select(
			array("level"),
			"users",
			array("login" => Main::get_cookie("LOG"), "hash" => md5(Main::get_cookie("HPS")))
		)->fetch()['level'];
	}
	
	/**
	 * Устанавливает уровень доступа пользователя
	 * @param string $level нужный уровень доступа пользователя
	 */
	public function setLevel($level)
	{
		$this->level = $level;
		return $this;
	}

	/**
	 * @return int количество мероприятий, за которые пользователь ответственный
	 */
	public function getEventsResponsibleCount()
	{
		if(!isset($this->eventsResponsibleCount) or empty($this->eventsResponsibleCount))
			$this->CountEventsResponsible();
		return $this->eventsResponsibleCount;
	}

	/**
	 * @return array список из ИД мероприятий, за которые пользователь ответственный
	 */
	public function getEventsResponsible()
	{
		if(!isset($this->eventsResponsible) or empty($this->eventsResponsible))
			$this->CountEventsResponsible();
		return $this->eventsResponsible;
	}

	/**
	 * @return array список из ИД заявок на новые мероприятия
	 */
	public function getNewEvents()
	{
		if(!isset($this->newEvents)){
			$res = Event::getNew();
			$this->newEventsCount = $res['count'];
			$this->newEvents = $res['events'];
		}
		return $this->newEvents;
	}

	/**
	 * @return int количество заявок на новые мероприятия
	 */
	public function getNewEventsCount()
	{
		if(!isset($this->newEventsCount)){
			$res = Event::getNew();
			$this->newEventsCount = $res['count'];
			$this->newEvents = $res['events'];
		}
		return $this->newEventsCount;
	}

	/**
	 * Авторизует пользователя
	 * @param string $login    логин
	 * @param string $password пароль
	 */
	public static function LogIn(string $login, string $password)
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
	    		users.login = "'.$db->escape($login).'" OR
	    		users.email = "'.$db->escape($login).'"
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
	        	$db->query("
	        		UPDATE
	        			users
	        		SET
	        			hash = '".md5($savedHash)."'
	        		WHERE
	        			login = '$login' OR 
	        			email = '$login'
	        	");
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

	/**
	 * @return array массив со списком мероприятий, за которые пользователь ответственный, а так же их количество
	 */
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

	/**
	 * @return array массив со списком из ИД заявок на должности, а так же их количество
	 */
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
                      temp_table_posts.comment = posts_student.comment AND 
                      posts_student.id_student = '.$this->getId().' AND 
                      posts_student.id_post IN(9, 10, 11) AND 
                      NOT temp_table_posts.id_student = '.$this->getId().' 
			    ');
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
                      NOT temp_table_posts.id_post = 12 AND 
                      NOT temp_table_posts.id_student = '.$this->getId().' 
			    ');
			    break;
			case 1:
			    $ret = $db->Select(
			    	array("id"), 
			    	"temp_table_posts",
			    	["!id_student" => $this->getId()]
			    );
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

	/**
	 * @return array массив со списком из ИД заявок на посещение мероприятий, а так же их количество
	 */
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
						"!id_student" => $this->getId()
                	)
                );
			} elseif($this->level == 5) {
				return false;
			}
		} else {
			$ret = $db->Select(
		    	array("*"), 
		    	"temp_table_events",
			    ["!id_student" => $this->getId()]
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

	/**
	 * @return array массив со списком из ИД оповещений о заданиях, а так же их количество
	 */
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

	/**
	 * @return array массив со списком из ИД оповещений о соц.выплатах, а так же их количество
	 */
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

	/**
	 * @return array массив со всеми заявками/оповещениями, разбитыми по категориями
	 */
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
	* @param int $id ИД записи в БД.
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

	/**
	 * Меняет пароль для текущего пользователя
	 * @param string $old     старый пароль
	 * @param string $new     новый пароль
	 * @param string $newConf подтверждение нового пароля
	 */
	public function ChangePassword($old, $new, $newConf)
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

	/**
	 * Меняет пароль для пользователя, который хочет его восстановить. Соответственно сравнивать старый пароль не нужно и так же нельзя использовать эту функцию для простой смены пароля.
	 * @param string $new     новый пароль
	 * @param string $newConf подтверждение нового пароля
	 * @param string $hash хэш для подтверждения пользователя
	 */
	public static function RecoverPassword($new, $newConf, $hash)
	{
		global $db;
		if($new != $newConf){
	        Main::error("Пароли не совпадают!");
	    } else {
	    	$db->Update(
	    		"users", 
	    		array(
	    			"password" => password_hash($new, PASSWORD_BCRYPT)
	    		),
	    		array(
	    			"hash" => $hash
	    		)
	    	);
	    }
	}
}
?>