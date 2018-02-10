<?
$now = new DateTime();
$month = $now->format('m');
$year = $now->format('Y');
$day = $now->format('d');

$from = (isset($_GET['f']) and strtotime($_GET['f']))?$_GET['f']:date('Y-m-d', mktime(0,0,0,$month-1,$day,$year));
$to = (isset($_GET['t']) and strtotime($_GET['t']))?$_GET['t']:date('Y-m-d', mktime(0,0,0,$month,$day,$year));
$result['from'] = $from;
$result['to'] = $to;
if($from > $to){
    $from = $to;
}

$result['raw'] = $db->query("
SELECT
    faculty.name,
    COALESCE(faculty.studCount, 0) AS studCount,
    COALESCE(faculty.budgCount, 0) AS budgCount,
    COALESCE(sp.count_soc_pod, 0) AS count_soc_pod,
    COALESCE(ss.count_soc_stip, 0) AS count_soc_stip,
    COALESCE(soc_stip_renewOrNot.count_ss_runs_out, 0) AS count_ss_runs_out,
    COALESCE(soc_stip_renewOrNot.new_ss, 0) AS new_ss,
    COALESCE(ss_otkazniki.count_ss_otkazniki, 0) AS count_ss_otkazniki,
    COALESCE(sp_otkazniki.count_sp_otkazniki, 0) AS count_sp_otkazniki,
    COALESCE(epf.count_event_people_fac, 0) AS count_event_people_fac,
    COALESCE(epu.count_event_people_univer, 0) AS count_event_people_univer,
    COALESCE(p.count_posts, 0) AS count_posts,
    COALESCE(p.count_posts_kf, 0) AS count_posts_kf,
    COALESCE(resp.count_responsible, 0) AS count_responsible,
    COALESCE(fac_meet.count_fac_meet, 0) AS count_fac_meet,
    COALESCE(rukOnMeet.count_rukOnMeet, 0) AS count_rukOnMeet,
    COALESCE(PPOS_meet.count_PPOS_meet, 0) AS count_PPOS_meet,
    COALESCE(koef_spiski.count_koef_spiski, 0) AS count_koef_spiski,
    COALESCE(old_act_mer.count_old_act_mer, 0) AS count_old_act_mer,
    COALESCE(old_act_dolzh.count_old_act_dolzh, 0) AS count_old_act_dolzh
FROM
(
    SELECT
        COUNT(*) AS count_PPOS_meet
    FROM
        events
    JOIN
        event_levels
    ON
        event_levels.id_level = events.level AND 
        event_levels.name = 'Собрание ППОС' AND 
        events.date BETWEEN '$from' AND '$to'
) AS PPOS_meet,
faculty
LEFT JOIN
(
    SELECT
        faculty.name,
        COUNT(*) AS count_soc_pod
    FROM
        students
    JOIN
        stud_group
    ON
        stud_group.id_student = students.id_student
    JOIN
        groups
    ON
        groups.id_group = stud_group.id_group
    JOIN
        faculty
    ON
        faculty.name = groups.faculty
    JOIN
        mat_support
    ON
        mat_support.id_student = students.id_student AND 
        mat_support.payday BETWEEN '$from' AND '$to'
    GROUP BY
        faculty.name
) AS sp
ON
    sp.name = faculty.name
LEFT JOIN 
(
    SELECT
        ss_runs_out.count_ss_runs_out,
        ss_runs_out.name,
        ss_new.new_ss
    FROM
    (
        SELECT
            faculty.name,
            COUNT(*) AS count_ss_runs_out
        FROM
            soc_stip
        JOIN
            students
        ON
            students.id_student = soc_stip.id_student AND 
            soc_stip.date_end BETWEEN CAST(CONCAT(YEAR('$from'), '-', (MONTH('$from')-1), '-', 1) AS DATE) AND '$to'
        JOIN
            stud_group
        ON
            stud_group.id_student = students.id_student
        JOIN
            groups
        ON
            groups.id_group = stud_group.id_group
        JOIN
            faculty
        ON
            faculty.name = groups.faculty
        JOIN
            soc_stip_categories
        ON
            soc_stip_categories.id_categ = soc_stip.id_categ
        JOIN
            statuses
        ON
            id_status = status
        GROUP BY
            faculty.name
    ) AS ss_runs_out
    LEFT JOIN
    (
        SELECT
            COUNT(*) AS new_ss,
            ss_ro.name
        FROM
        (
            SELECT
                soc_stip.id_student,
                faculty.name
            FROM
                soc_stip
            JOIN
                students
            ON
                students.id_student = soc_stip.id_student AND 
                soc_stip.date_end BETWEEN CAST(CONCAT(YEAR('$from'), '-', (MONTH('$from')-1), '-', 1) AS DATE) AND '$to'
            JOIN
                stud_group
            ON
                stud_group.id_student = students.id_student
            JOIN
                groups
            ON
                groups.id_group = stud_group.id_group
            JOIN
                faculty
            ON
                faculty.name = groups.faculty
            JOIN
                soc_stip_categories
            ON
                soc_stip_categories.id_categ = soc_stip.id_categ
            JOIN
                statuses
            ON
                id_status = status
        ) AS ss_ro
        JOIN
        (
            SELECT
                soc_stip.date_app,
                soc_stip.id_student
            FROM
                soc_stip
            WHERE
                soc_stip.date_app BETWEEN CAST(CONCAT(YEAR('$from'), '-', (MONTH('$from')-1), '-', 1) AS DATE) AND '$to'
        ) AS ss_new
        ON
            ss_new.id_student = ss_ro.id_student
        GROUP BY
            ss_ro.name
    ) AS ss_new
    ON
        ss_new.name = ss_runs_out.name
) AS soc_stip_renewOrNot 
ON 
	soc_stip_renewOrNot.name = faculty.name
LEFT JOIN
(
    SELECT
        faculty.name,
        COUNT(*) AS count_ss_otkazniki
    FROM
        soc_stip
    JOIN
        students
    ON
        students.id_student = soc_stip.id_student AND 
        soc_stip.date_app BETWEEN '$from' AND '$to'
    JOIN
        stud_group
    ON
        stud_group.id_student = students.id_student
    JOIN
        groups
    ON
        groups.id_group = stud_group.id_group
    JOIN
        faculty
    ON
        faculty.name = groups.faculty
    JOIN
        statuses
    ON
        statuses.id_status = soc_stip.status AND 
        statuses.name = 'отказано'
    GROUP BY 
        faculty.name
) AS ss_otkazniki
ON 
    ss_otkazniki.name = faculty.name
LEFT JOIN
(
    SELECT
        faculty.name,
        COUNT(*) AS count_sp_otkazniki
    FROM
        mat_support
    JOIN
        students
    ON
        students.id_student = mat_support.id_student AND 
        mat_support.payday BETWEEN '$from' AND '$to'
    JOIN
        stud_group
    ON
        stud_group.id_student = students.id_student
    JOIN
        groups
    ON
        groups.id_group = stud_group.id_group
    JOIN
        faculty
    ON
        faculty.name = groups.faculty
    JOIN
        statuses
    ON
        statuses.id_status = mat_support.status AND 
        statuses.name = 'отказано'
    GROUP BY 
        faculty.name
) AS sp_otkazniki
ON 
    sp_otkazniki.name = faculty.name
LEFT JOIN
(
    SELECT
        faculty.name,
        COUNT(*) AS count_soc_stip
    FROM
        students
    JOIN
        stud_group
    ON
        stud_group.id_student = students.id_student
    JOIN
        groups
    ON
        groups.id_group = stud_group.id_group
    JOIN
        faculty
    ON
        faculty.name = groups.faculty
    JOIN
        soc_stip
    ON
        soc_stip.id_student = students.id_student AND
        soc_stip.date_app BETWEEN '$from' AND '$to'
    GROUP BY
        faculty.name
) AS ss
ON
    ss.name = faculty.name
LEFT JOIN
(
    SELECT
        faculty.name,
        COUNT(*) AS count_event_people_fac
    FROM
        events
    JOIN
        faculty
    ON
        events.name LIKE CONCAT('%', faculty.name) AND 
        events.date BETWEEN '$from' AND '$to'
    JOIN
        event_student
    ON
        event_student.id_event = events.id_event
    JOIN
        event_levels
    ON
        event_levels.id_level = events.level AND 
        event_levels.name = 'Факультетское'
    GROUP BY
        faculty.name
) AS epf
ON
    epf.name = faculty.name
LEFT JOIN
(
    SELECT
        koef_fac_roli.name,
        SUM(count_event_people_univer) AS count_event_people_univer
    FROM
    (
        SELECT
            faculty.name,
            COUNT(*) * event_points.past / 10 AS count_event_people_univer
        FROM
            students
        JOIN
            stud_group
        ON
            stud_group.id_student = students.id_student
        JOIN
            groups
        ON
            groups.id_group = stud_group.id_group
        JOIN
            faculty
        ON
            faculty.name = groups.faculty
        JOIN
            event_student
        ON
            event_student.id_student = students.id_student
        JOIN
            events
        ON
            events.id_event = event_student.id_event AND 
            events.date BETWEEN '$from' AND '$to'
        JOIN
            event_levels
        ON
            event_levels.id_level = events.level AND 
            NOT event_levels.name = 'Факультетское'
        JOIN
            event_points
        ON
            event_points.id_level = event_levels.id_level AND
            event_points.id_role = event_student.id_role
        JOIN
            roles
        ON
            roles.id_role = event_points.id_role AND
            NOT roles.name = 'организатор'
        GROUP BY
            faculty.name,
            event_levels.name
    ) AS koef_fac_roli
    GROUP BY 
        koef_fac_roli.name
) AS epu
ON
    epu.name = faculty.name
LEFT JOIN
(
    SELECT 
        koef_fac_roli.name,
        SUM(koef_fac_roli.count_posts) AS count_posts,
        SUM(koef_fac_roli.count_posts_kf) AS count_posts_kf
    FROM
    (   
        SELECT
            faculty.name,
            COUNT(*) AS count_posts,
            COUNT(*) * posts.past / 10 AS count_posts_kf
        FROM
            students
        JOIN
            stud_group
        ON
            stud_group.id_student = students.id_student
        JOIN
            groups
        ON
            groups.id_group = stud_group.id_group
        JOIN
            faculty
        ON
            faculty.name = groups.faculty
        JOIN
            posts_student
        ON
            posts_student.id_student = students.id_student AND 
            (
                '$from' BETWEEN 
                CAST(
                    IF(
                        posts_student.date_in_sem = 1,
                        CONCAT(
                            posts_student.date_in_y,
                            '-08-01'
                        ),
                        CONCAT(
                            posts_student.date_in_y+1,
                            '-02-01'
                        )
                    ) AS DATE
                ) AND 
                CAST(
                    IF(
                        posts_student.date_out_sem = 1,
                        CONCAT(
                            posts_student.date_out_y + 1,
                            '-01-31'
                        ),
                        IF(
                            posts_student.date_out_sem = 2,
                            CONCAT(
                                posts_student.date_out_y+1,
                                '-07-31'
                            ),
                            CURDATE()
                        )
                    ) AS DATE
                )
                OR
                CAST(
                    IF(
                        posts_student.date_in_sem = 1,
                        CONCAT(
                            posts_student.date_in_y,
                            '-08-01'
                        ),
                        CONCAT(
                            posts_student.date_in_y+1,
                            '-02-01'
                        )
                    ) AS DATE
                ) BETWEEN '$from' AND '$to'
            )
            JOIN
                posts
            ON
                posts.id_post = posts_student.id_post AND posts.name IN(
                    'Руководитель сектора',
                    'Руководитель направления',
                    'Руководитель РГ'
                )
            GROUP BY
                faculty.name,
                posts.name
    ) AS  koef_fac_roli
    GROUP BY 
        koef_fac_roli.name
) AS p
ON
    p.name = faculty.name
LEFT JOIN
(
    SELECT
        faculty.name,
        COUNT(*) * event_points.past/10 AS count_responsible
    FROM
        students
    JOIN
        stud_group
    ON
        stud_group.id_student = students.id_student
    JOIN
        groups
    ON
        groups.id_group = stud_group.id_group
    JOIN
        faculty
    ON
        faculty.name = groups.faculty
    JOIN
        event_student
    ON
        event_student.id_student = students.id_student
    JOIN
        events
    ON
        events.id_event = event_student.id_event AND 
        events.date BETWEEN '$from' AND '$to'
    JOIN
        roles
    ON
        roles.id_role = event_student.id_role AND 
        roles.name = 'организатор'
    JOIN
        event_levels
    ON
        event_levels.id_level = events.level
    JOIN
        event_points
    ON
        event_points.id_role = roles.id_role AND 
        event_points.id_level = event_levels.id_level
    GROUP BY
        faculty.name
) AS resp
ON
    resp.name = faculty.name
LEFT JOIN
(
    SELECT
        faculty.name,
        COUNT(*) AS count_fac_meet
    FROM
        faculty
    JOIN
        events
    ON
        events.name LIKE CONCAT('Собрание ', faculty.name) AND 
        events.date BETWEEN '$from' AND '$to'
    GROUP BY
        faculty.name
) AS fac_meet
ON
    fac_meet.name = faculty.name
LEFT JOIN
(
    SELECT
        groups.faculty AS name,
        COUNT(*) AS count_rukOnMeet
    FROM
        students
    JOIN
        stud_group
    ON
        stud_group.id_student = students.id_student
    JOIN
        groups
    ON
        groups.id_group = stud_group.id_group
    JOIN
        posts_student
    ON
        posts_student.id_student = students.id_student  AND 
        (
            '$from' BETWEEN 
            CAST(
                IF(
                    posts_student.date_in_sem = 1,
                    CONCAT(
                        posts_student.date_in_y,
                        '-08-01'
                    ),
                    CONCAT(
                        posts_student.date_in_y+1,
                        '-02-01'
                    )
                ) AS DATE
            ) AND 
            CAST(
                IF(
                    posts_student.date_out_sem = 1,
                    CONCAT(
                        posts_student.date_out_y + 1,
                        '-01-31'
                    ),
                    IF(
                        posts_student.date_out_sem = 2,
                        CONCAT(
                            posts_student.date_out_y+1,
                            '-07-31'
                        ),
                        CURDATE()
                    )
                ) AS DATE
            )
            OR
            CAST(
                IF(
                    posts_student.date_in_sem = 1,
                    CONCAT(
                        posts_student.date_in_y,
                        '-08-01'
                    ),
                    CONCAT(
                        posts_student.date_in_y+1,
                        '-02-01'
                    )
                ) AS DATE
            ) BETWEEN '$from' AND '$to'
        )
    JOIN
        posts
    ON
        posts.id_post = posts_student.id_post AND 
        posts.name IN(
            'Председатель профбюро',
            'Заместитель председателя профбюро',
            'Руководитель сектора',
            'Руководитель направления',
            'Руководитель РГ'
        )
    JOIN
        event_student
    ON
        event_student.id_student = students.id_student
    JOIN
        events
    ON
        events.id_event = event_student.id_event AND 
        events.date BETWEEN '$from' AND '$to'
    JOIN
        event_levels
    ON
        event_levels.id_level = events.level AND 
        event_levels.name = 'Собрание ППОС'
    GROUP BY
        groups.faculty
) AS rukOnMeet
ON
    rukOnMeet.name = faculty.name
LEFT JOIN 
(
    SELECT 
        koef_spiski._from AS name,
        SUM(koef_spiski.koef)/koef_spiski.count_zad AS count_koef_spiski
    FROM
    (
        SELECT
            lists._from,
            task.name,
            task.id_task,
            CASE 
                WHEN 
                    DATEDIFF(
                        lists.load_date,
                        task.date_exp
                    ) < 1 
                THEN 1 
                WHEN 
                    DATEDIFF(
                        lists.load_date,
                        task.date_exp
                    ) = 1
                THEN 0.9 
                WHEN 
                    DATEDIFF(
                        lists.load_date,
                        task.date_exp
                    ) = 2
                THEN 0.8 
                WHEN 
                    DATEDIFF(
                        lists.load_date,
                        task.date_exp
                    ) = 3
                THEN 0.7
                ELSE 0.5
            END koef,
            lists.load_date,
            task.date_exp,
            (
                SELECT
                	COUNT(*)
                FROM
                	task
                WHERE
            		task.date_exp BETWEEN '$from' AND '$to'
            ) AS count_zad
        FROM
            task
        JOIN
            lists
        ON
            lists.id_list > 0 AND
            task.id_task = lists.task AND
            task.date_exp BETWEEN '$from' AND '$to'
        WHERE 
        	task._for IN(2, 5)
    ) AS koef_spiski
    GROUP BY
        koef_spiski._from
) AS koef_spiski
ON 
    koef_spiski.name = faculty.name
LEFT JOIN
(
    SELECT
        faculty.name,
        COUNT(*) AS count_old_act_mer
    FROM
        students
    JOIN
        stud_group
    ON
        stud_group.id_student = students.id_student
    JOIN
        groups
    ON
        groups.id_group = stud_group.id_group
    JOIN
        faculty
    ON
        faculty.name = groups.faculty
    JOIN
        event_student
    ON
        event_student.id_student = students.id_student
    JOIN
        events
    ON
    	events.id_event = event_student.id_event AND
        events.date BETWEEN '$from' AND '$to'
    WHERE NOT EXISTS
    (
        SELECT
            *
        FROM
            event_student
        JOIN
            posts_student
        JOIN
            events AS mer
        ON
            mer.id_event = event_student.id_event
        WHERE
            students.id_student IN(
                event_student.id_student,
                posts_student.id_student
            ) AND 
            DATEDIFF('$from', mer.date) BETWEEN 30 AND 180 AND
            (
                DATEDIFF(
                    '$from', 
                    CAST(
                        IF(
                            posts_student.date_out_sem = 1,
                            CONCAT(
                                posts_student.date_out_y + 1,
                                '-01-31'
                            ),
                            IF(
                                posts_student.date_out_sem = 2,
                                CONCAT(
                                    posts_student.date_out_y+1,
                                    '-07-31'
                                ),
                                CURDATE()
                            )
                        ) AS DATE
                    )
                ) < 180 OR
                posts_student.date_out_sem = 0
            )
    )
    GROUP BY 
        faculty.name
) AS old_act_mer
ON 
    old_act_mer.name = faculty.name
LEFT JOIN
(
    SELECT
        faculty.name,
        COUNT(*) AS count_old_act_dolzh
    FROM
        students
    JOIN
        stud_group
    ON
        stud_group.id_student = students.id_student
    JOIN
        groups
    ON
        groups.id_group = stud_group.id_group
    JOIN
        faculty
    ON
        faculty.name = groups.faculty
    JOIN 
        posts_student 
    ON 
        posts_student.id_student = students.id_student AND
        CAST(
            IF(
                posts_student.date_in_sem = 1,
                CONCAT(
                    posts_student.date_in_y,
                    '-08-01'
                ),
                CONCAT(
                    posts_student.date_in_y+1,
                    '-02-01'
                )
            ) AS DATE
        ) BETWEEN '$from' AND '$to'
    WHERE NOT EXISTS
    (
        SELECT
            *
        FROM
            event_student
        JOIN
            posts_student
        JOIN
            events AS mer
        ON
            mer.id_event = event_student.id_event
        WHERE
            students.id_student IN(
                event_student.id_student,
                posts_student.id_student
            ) AND 
            NOT(
                mer.date BETWEEN '$from' AND '$to'
            ) AND
            NOT (
                CAST(
                    IF(
                        posts_student.date_in_sem = 1,
                        CONCAT(
                            posts_student.date_in_y,
                            '-08-01'
                        ),
                        CONCAT(
                            posts_student.date_in_y+1,
                            '-02-01'
                        )
                    ) AS DATE
                ) BETWEEN '$from' AND '$to'
            )
    )
    GROUP BY 
        faculty.name
) AS old_act_dolzh
ON
    old_act_dolzh.name = faculty.name
")->fetchAll();

$result['roundto'] = 3;

foreach ($result['raw'] as $list) {
    $result['first'][$list['name']] = (
        $list['count_soc_pod'] + $list['count_soc_stip']) / $list['budgCount'] + 
        (
            ($list['count_ss_runs_out'] != 0)?($list['new_ss'] / $list['count_ss_runs_out']):(0)
        ) - 
        (
            ($list['count_soc_pod'] + $list['count_soc_stip']) != 0?
            (($list['count_ss_otkazniki'] + $list['count_sp_otkazniki']) / ($list['count_soc_pod'] + $list['count_soc_stip'])):
            (0)
        );
    $result['second'][$list['name']] = $list['count_event_people_fac'] / $list['studCount'];
    $result['third'][$list['name']] = $list['count_event_people_univer'] / $list['studCount'];
    $result['fourth'][$list['name']] = ($list['count_posts_kf'] + $list['count_responsible']) / $list['studCount'];
    $result['fifth'][$list['name']] = $list['count_old_act_mer'] + $list['count_old_act_dolzh'];
    $result['sixth'][$list['name']] = ($list['count_fac_meet'] + $list['count_rukOnMeet']*$list['count_PPOS_meet'] / (3+$list['count_posts']))*$list['count_koef_spiski'];
}
$result['first']['max'] = max($result['first']);
$result['first']['kf'] = 0.193 * 100;
$result['second']['max'] = max($result['second']);
$result['second']['kf'] = 0.125 * 100;
$result['third']['max'] = max($result['third']);
$result['third']['kf'] = 0.144 * 100;
$result['fourth']['max'] = max($result['fourth']);
$result['fourth']['kf'] = 0.168 * 100;
$result['fifth']['max'] = max($result['fifth']);
$result['fifth']['kf'] = 0.167 * 100;
$result['sixth']['max'] = max($result['sixth']);
$result['sixth']['kf'] = 0.203 * 100;

foreach ($result['raw'] as $list) {
    $result['first']['total'][$list['name']] = ($result['first']['max']!=0?(round($result['first'][$list['name']]/$result['first']['max'] * $result['first']['kf'], $result['roundto'])):0);
    $result['second']['total'][$list['name']] = ($result['second']['max']!=0?(round($result['second'][$list['name']]/$result['second']['max'] * $result['second']['kf'], $result['roundto'])):0);
    $result['third']['total'][$list['name']] = ($result['third']['max']!=0?(round($result['third'][$list['name']]/$result['third']['max'] * $result['third']['kf'], $result['roundto'])):0);
    $result['fourth']['total'][$list['name']] = ($result['fourth']['max']!=0?(round($result['fourth'][$list['name']]/$result['fourth']['max'] * $result['fourth']['kf'], $result['roundto'])):0);
    $result['fifth']['total'][$list['name']] = ($result['fifth']['max']!=0?(round($result['fifth'][$list['name']]/$result['fifth']['max'] * $result['fifth']['kf'], $result['roundto'])):0);
    $result['sixth']['total'][$list['name']] = ($result['sixth']['max']!=0?(round($result['sixth'][$list['name']]/$result['sixth']['max'] * $result['sixth']['kf'], $result['roundto'])):0);
    $result['sum'][$list['name']] = $result['first']['total'][$list['name']]+$result['second']['total'][$list['name']]+$result['third']['total'][$list['name']]+$result['fourth']['total'][$list['name']]+$result['fifth']['total'][$list['name']]+$result['sixth']['total'][$list['name']];
}