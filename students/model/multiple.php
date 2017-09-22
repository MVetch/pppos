<?
$multiple=$db->query('
    SELECT
        surname,
        name,
        COUNT(*) AS "colvo"
    FROM
        students
    WHERE
        id_student NOT IN(
            SELECT studentsT.id_student FROM (
                SELECT 
                    id_student,
                    COUNT(*) AS "colvo"
                FROM
                    stud_group
                GROUP BY 
                    id_student
                HAVING 
                    colvo > 1
            ) studentsT
        )
    GROUP BY 
        surname, 
        name
    HAVING colvo > 1
')->fetchAll();

foreach ($multiple as $k => $student) {
    $result['multiple'][]=$db->Select(
        array(
            "id_student AS id",
            "surname",
            "name",
            "thirdName",
            "groups"
        ),
        "full_info",
        array(
            "surname" => $student['surname'],
            "name" => $student['name']
        )
    )->fetchAll();
    if(count($result['multiple'][$k]) > 0){
        Main::IncludeAddWindow(
            "multStudents", 
            array(
                "students" => $result['multiple'][$k], 
                "id" => $k
            )
        );
    } else {
        unset($result['multiple'][$k]);
    }
}
?>
<script>
    function checkPerson(tag){
        <?foreach ($result['multiple'] as $k => $stud):
            $student = new AUser($stud[0]);?>
            if(tag.value=="<?=$student->getSurnameName()?>")
                document.getElementById("multStudents<?=$k?>").style.display="block";
        <?endforeach?>
    }
</script>