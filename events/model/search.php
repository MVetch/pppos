<?
if (isset($_GET['search'])){
    $search = $_GET['search'];
    switch ($_GET['kakIskat']) {
        case 'По названию':
            $where = array("~name" => "%$search%");
            break;
        case 'По дате':
            $search=$_GET['search1']."-".$_GET['search'];
            $where = array("~date" => "%$search%");
            break;
        case 'По уровню':
            $where = array("level" => "$search");
            break;
        case 'По ответственному':
            $where = array("~fioOrg" => "%$search%");
            break;
        default:
            $where = array();
            break;
    }

    switch ($_GET['orderBy']) {
        case 'По названию':
            $order = array("name" => "ASC");
            break;
        case 'По дате':
            $order = array("date" => "DESC");
            break;
        case 'По ответственному':
            $order = array("respFio" => "ASC");
            break;
        default:
            $order = array();
            break;
    }

    if($settings['pagination']){
        $page = isset($_GET['page'])?($_GET['page']):1;
        $limit = array(($page - 1) * PAGINATION_PER_PAGE, PAGINATION_PER_PAGE);
    } else {
        $limit = array();
    }

    $res = $db->Select(
        array("*"),
        "event_names_resp",
        $where,
        $order,
        $limit
    );
    
    $result['pageNav'] = $settings['pagination']?$res->GeneratePageNav($page):'';

    $result['count'] = $res->num_rows;
    $result['events'] = $res->fetchAll();
    $res = $db->Select(
        array("id_event"),
        "event_student",
        array("id_student" => $user->getId())
    );

    $result['checkedIn'] = array();

    while($list = $res->fetch())
        $result['checkedIn'][] = $list['id_event'];

    $res = $db->Select(
        array("id_event"),
        "temp_table_events",
        array("id_student" => $user->getId())
    );

    while($list = $res->fetch())
        $result['checkedIn'][] = $list['id_event'];

    $result['roles'] = $db->Select(
        array("*"),
        "roles"
    )->fetchAll(); 
    Main::includeAddWindow("chooseLevel", array("roles" => $result['roles']));
} else {
    $result['count'] = -1;
}
$now = new DateTime();
$year = $now->format("Y");
$result['levels']=$db->Select(array("*"), "event_levels")->fetchAll();