<?
if (isset($_GET['search'])){
    $search_fio = $_GET['search'];
    $search_group = $_GET['group']; 
    $search_fac = $_GET['fac']; 
    $search_form = $_GET['forma']; 
    $search_rait = $_GET['rait'];
    if($settings['pagination']){
        $page = isset($_GET['page'])?($_GET['page']):1;
        $limit = array(($page - 1) * PAGINATION_PER_PAGE, PAGINATION_PER_PAGE);
    } else {
        $limit = array();
    }
    $res = $db->Select(
        array(),
        "full_info",
        array(
            '~CONCAT(surname, " ", name, " ", thirdName)' => "%$search_fio%",
            "~faculty" => "%$search_fac%",
            "~rating" => "%$search_rait%",
            "~forma" => "%$search_form%",
            "~groups" => "%$search_group%"
        ),
        array(),
        $limit
    );
    $result['pageNav'] = $settings['pagination']?$res->GeneratePageNav($page):'';
    $result['count'] = $res->num_rows;
    $result['students'] = $res->fetchAll();
} else {
    $result['count'] = -1;
}
//dump($result);
//dump($page);