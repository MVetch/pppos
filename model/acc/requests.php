<?
$res_dolzh=$db->Select(
    array(
        "id_post",
        "name",
        "date_in_sem",
        "date_in_y",
        "date_out_sem",
        "date_out_y",
        "comment"
    ),
    "posts_student_names_requests",
    array(
        "id_student" => $settings['user']['id_student']
    )
);
$result['countPosts'] = $res_dolzh->num_rows;
$result['posts'] = $res_dolzh->fetchAll();

$res_mer=$db->Select(
    array(
        "id_event",
        "event",
        "date",
        "place",
        "role",
        "level"
    ),
    "event_student_names_requests",
    array(
        "id_student" => $settings['user']['id_student']
    )
);
$result['countEvents'] = $res_mer->num_rows;
$result['events'] = $res_mer->fetchAll();