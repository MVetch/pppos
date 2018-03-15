<?
$res['doubleOrg'] = $db->query('
    SELECT
        event_student_names.*
    FROM
        event_student_names
    JOIN(
        SELECT
            COUNT(*) c,
            event_student.*
        FROM
            `event_student`
        WHERE
            `id_role` = 2
        GROUP BY
            id_event
        HAVING
            c > 1
    ) t
    ON
        t.id_event = event_student_names.id_event AND 
        event_student_names.id_role = 2
    ORDER BY event_student_names.id_event
')->fetchAll();

$event = -1;

foreach($res['doubleOrg'] as $entry) {
    if($event == $entry['id_event']){
        $result['doubleOrg'][count($result['doubleOrg']) - 1]['student'][$entry['id']] = ["name" => $entry['student_name'], "photo" => $entry['photo']];
    } else {
        $result['doubleOrg'][] = [
            'id_event'     => $entry['id_event'],
            'eventName'    => $entry['eventName'],
            'id'           => $entry['id'],
            'role'         => $entry['role'],
            'student'      => [$entry['id'] => ["name" => $entry['student_name'], "photo" => $entry['photo']]]
        ];
        $event = $entry['id_event'];
    }
}
//dump($result['doubleOrg']);


$res['doubleEntry'] = $db->query('
    SELECT
        event_student_names.*
    FROM
        event_student_names
    JOIN(
        SELECT 
            event_student.*,
            COUNT(*) c
        FROM
            event_student
        GROUP BY
            id_event,
            id_student
        HAVING
            c > 1
    ) t
    ON
    t.id_event = event_student_names.id_event and 
    t.id_student = event_student_names.id_student
    ORDER BY 
        event_student_names.id_event, 
        event_student_names.id_student
')->fetchAll();

$event = -1;
$student = -1;

foreach($res['doubleEntry'] as $entry) {
    if($event == $entry['id_event'] and $student == $entry['id_student']){
        $result['doubleEntry'][count($result['doubleEntry']) - 1]['role'][$entry['id']] = $entry['role'];
    } else {
        $result['doubleEntry'][] = [
            'id_event'     => $entry['id_event'],
            'eventName'    => $entry['eventName'],
            'id'           => $entry['id'],
            'role'         => [$entry['id'] => $entry['role']],
            'id_student'   => $entry['id_student'],
            'photo'        => $entry['photo'],
            'student_name' => $entry['student_name']
        ];
        $event = $entry['id_event'];
        $student = $entry['id_student'];
    }
}
//dump($result['doubleEntry']);