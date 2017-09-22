<?
$res_dolzh=$db->Select(
    array(
        "id",
        "id_post",
        "name",
        "date_in_sem",
        "date_in_y",
        "date_out_sem",
        "date_out_y",
        "comment"
    ),
    "posts_student_names",
    array(
        "id_student" => $settings['user']['id_student']
    )
);
$result['count'] = $res_dolzh->num_rows;
$result['posts'] = $res_dolzh->fetchAll();