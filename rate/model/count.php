<?
$now = new DateTime();
$month = $now->format("m");
$year = $now->format("Y");
$day = $now->format("d");
if($month>=9 and $month<=12){
    $year_begin_edu = $year;//год, в котором начался учебный
    $semester=1;
}
else if ($month<=2){
    $year_begin_edu = $year-1;//год, в котором начался учебный
    $semester=1;
}
else {
    $year_begin_edu = $year-1;
    $semester=2;
}
$this_sem_start = $semester==1?$year_begin_edu.'-09-01':($year_begin_edu+1).'-02-01';
$this_sem_end = $semester==1?($year_begin_edu+1).'-01-31':($year_begin_edu+1).'-08-31';
$prev_sem_start = $semester==2?$year_begin_edu.'-09-01':$year_begin_edu.'-02-01';
$prev_sem_end = $semester==2?($year_begin_edu+1).'-01-31':$year_begin_edu.'-08-31';
$prev_prev_sem_start = $semester==1?($year_begin_edu-1).'-09-01':$year_begin_edu.'-02-01';
$prev_prev_sem_end = $semester==1?$year_begin_edu.'-01-31':$year_begin_edu.'-08-31';
$sum=0;

/*vvvvvvvvvv Расчет баллов за должности vvvvvvvvv*/
$result['posts'] = $db->query('
    SELECT 
        posts.name,
        posts_student.date_out_sem,
        posts_student.date_out_y,
        IF(
            posts_student.date_out_y = 0,
            posts.this,
            IF
            (
                posts_student.date_out_sem = '.$semester.',
                IF(
                    posts_student.date_out_y = '.$year_begin_edu.',
                    posts.this,
                    0
                ),
                IF(
                    posts_student.date_out_y = '.$year_begin_edu.' OR posts_student.date_out_y + posts_student.date_out_sem = '.($semester+$year_begin_edu).',
                    posts.past,
                    0
                )
            )
        ) AS score,
        posts_student.comment
    FROM 
        posts_student 
    JOIN 
        posts 
    ON 
        posts.id_post = posts_student.id_post 
    WHERE 
        id_student = "'.$user->getId().'" AND
        (
            posts_student.date_out_sem + posts_student.date_out_y > '.($semester+$year_begin_edu-3).' OR
            posts_student.date_out_y=0
        )
    ORDER BY 
        posts_student.date_in_sem + posts_student.date_in_y DESC
')->fetchAll();//за 3 последних семестра
/*^^^^^^^^^ Расчет баллов за должности ^^^^^^^^^^^*/

/*vvvvvvvv Расчет баллов за мероприятия vvvvvvvvv*/
$result['events'] = $db->query('
    SELECT 
        events.id_event,
        events.name AS event,
        events.date,
        roles.name AS role,
        event_levels.name AS level,
        COALESCE
            (
                IF(
                events.date BETWEEN "'.$this_sem_start.'" AND "'.$this_sem_end.'",
                event_points.this,
                IF(
                    events.date BETWEEN "'.$prev_sem_start.'" AND "'.$prev_sem_end.'",
                    event_points.past,
                    0
                )
            ),
            0
        ) AS score
    FROM 
        event_student 
    JOIN 
        events 
    ON 
        event_student.id_event = events.id_event  AND
        event_student.id_student = '.$user->getId().'
    JOIN 
        roles 
    ON 
        roles.id_role = event_student.id_role 
    JOIN 
        event_levels 
    ON 
        event_levels.id_level = events.level 
    LEFT JOIN 
        event_points 
    ON 
        event_points.id_role = roles.id_role AND 
        event_points.id_level = event_levels.id_level
    WHERE
        events.date > '.$prev_prev_sem_start.'
    ORDER BY 
        events.date DESC
')->fetchAll();
/*^^^^^^^ Расчет баллов за мероприятия ^^^^^^*/

$result['top'] = $db->query('
    SELECT 
        COALESCE(mer.id_student,dolzh.id_student) AS id,
        COALESCE(score_d,0) + COALESCE(score_m,0) AS score,
        COALESCE(score_d,0) AS score_dolzh,
        COALESCE(score_m,0) AS score_mer,
        CONCAT(
                students.surname,
                " ",
                students.name,
                " ",
                students.thirdName
        ) AS fio
    FROM
        students
    LEFT JOIN
    (
        SELECT 
            dolzh.id_student,
            SUM(score) AS score_d
        FROM
        (
            SELECT 
                posts_student.id_student,
                IF(
                    posts_student.date_out_y = 0,
                    posts.this,
                    IF
                    (
                        posts_student.date_out_sem = '.$semester.',
                        IF(
                            posts_student.date_out_y = '.$year_begin_edu.',
                            posts.this,
                            0
                        ),
                        IF(
                            posts_student.date_out_y = '.$year_begin_edu.' OR posts_student.date_out_y + posts_student.date_out_sem = '.($semester+$year_begin_edu).',
                            posts.past,
                            0
                        )
                    )
                ) AS score
            FROM 
                posts_student 
            JOIN 
                posts 
            ON 
                posts.id_post = posts_student.id_post 
            JOIN
                students
            ON 
                students.id_student = posts_student.id_student
            WHERE 
                (
                    posts_student.date_out_sem + posts_student.date_out_y > 2015 OR
                    posts_student.date_out_y = 0
                )
        ) AS dolzh
        GROUP BY 
            id_student
    ) AS dolzh
    ON 
        students.id_student = dolzh.id_student
    LEFT JOIN 
    (
        SELECT 
            mer.id_student,
            SUM(score) AS score_m
        FROM
        (
            SELECT 
                event_student.id_student,
                IF(
                    events.date BETWEEN "'.$this_sem_start.'" AND "'.$this_sem_end.'",
                    event_points.this,
                    IF(
                        events.date BETWEEN "'.$prev_sem_start.'" AND "'.$prev_sem_end.'",
                        event_points.past,
                        0
                    )
                ) AS score
            FROM 
                event_student 
            JOIN 
                events 
            ON 
                event_student.id_event = events.id_event
            JOIN 
                roles 
            ON 
                roles.id_role = event_student.id_role 
            JOIN 
                event_levels 
            ON 
                event_levels.id_level = events.level 
            LEFT JOIN 
                event_points 
            ON 
                event_points.id_role = roles.id_role AND 
                event_points.id_level = event_levels.id_level
        ) AS mer
        GROUP BY 
            id_student
    ) AS mer
    ON 
        mer.id_student = students.id_student
    ORDER BY
        score 
    DESC
    LIMIT 0,'.RATING_TOP.'
')->fetchAll();
$sum=0;
foreach($result['posts'] as $post) $sum+=$post['score'];
foreach($result['events'] as $event) $sum+=$event['score'];