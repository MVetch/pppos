<?
global $vote;
$result['vote_given'] = $db->Select(
	[],
	"vote_given_names",
	[
		"id_from" => $user->getId()
	]
)->fetchAll();

$result['faculties'] = $db->Select(
	[],
	"faculty"
)->fetchAll();


$res = $db->query('
SELECT 
	vote_participants_names.*,
    COALESCE(rate.votes / votes.amount * 100, 0) as percentage,
    COALESCE(rate.votes, 0) as votes
FROM
	vote_participants_names
LEFT JOIN (
	SELECT
        COUNT(*) as amount,
        id_vote
    FROM
        vote_given_names
    GROUP BY
    	id_vote
	) votes
ON
	votes.id_vote = vote_participants_names.id
LEFT JOIN (
    SELECT
		COUNT(*) as votes,
        id_vote,
        vote_given_names.id as id_participant
	FROM
	    vote_given_names
	GROUP BY
	    id_vote,
	    id
	) rate
ON 
	rate.id_vote = vote_participants_names.id AND 
	rate.id_participant = vote_participants_names.id_participant
');
//dump($res);

while ($list = $res->fetch()) {
	if($list['for_faculty'] == 0){
		$result['votes'][$list['id']]['parts'][] = array(
			'id_participant' => $list['id_participant'],
			'name'        => $list['fio'],
			'group'      => $list['group'],
			'id'         => $list['id_student'],
			'photo'      => $list['photo'],
			'faculty'    => $list['faculty'],
			'percentage' => $list['percentage'],
			'votes'      => $list['votes']
		);
	} else {
		$result['votes'][$list['id']]['parts'][] = array(
			'id_participant' => $list['id_participant'],
			'name'       => $list['faculty_to_vote'],
			'percentage' => $list['percentage'],
			'votes'      => $list['votes']
		);
	}
	$result['votes'][$list['id']]['vote_name'] = $list['vote_name'];
	$result['votes'][$list['id']]['for_faculty'] = ($list['for_faculty'] == 1);
	$result['votes'][$list['id']]['given_to'] = 0;
	foreach ($result['vote_given'] as $key => $vote) {
		if($list['id'] == $vote['id_vote']){
			$result['votes'][$list['id']]['given_to'] = $vote['id'];
			break;
		}
	}
}

uasort($result['votes'], function($v1, $v2){
	return $v1['given_to'] == 0 ? -1 : 1;
});
//dump($result['votes']);