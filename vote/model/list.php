<?
// $res = $db->Select(
// 	[],
// 	"vote_participants_names"
// );

$result['vote_given'] = $db->Select(
	[],
	"vote_given",
	["id_student" => $user->getId()]
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
            vote_given
        GROUP BY
        	id_vote
		) votes
	ON
		votes.id_vote = vote_participants_names.id
	LEFT JOIN (
	    SELECT
			COUNT(*) as votes,
	        id_vote,
	        id_participant
		FROM
		    vote_given
		GROUP BY
		    vote_given.`id_vote`,
		    vote_given.`id_participant`
		) rate
	ON 
		rate.id_vote = vote_participants_names.id AND 
		rate.id_participant = vote_participants_names.id_student
');//->fetchAll();
//dump($res);

while ($list = $res->fetch()) {
	$result['votes'][$list['id']]['parts'][] = array(
		'fio' => $list['fio'], 
		'group' => $list['group'], 
		'id' => $list['id_student'], 
		'photo' => $list['photo'], 
		'faculty' => $list['faculty'],
		'percentage' => $list['percentage'],
		'votes' => $list['votes']
	);
	$result['votes'][$list['id']]['vote_name'] = $list['vote_name'];
	$result['votes'][$list['id']]['given_to'] = 0;
	foreach ($result['vote_given'] as $key => $vote) {
		if($list['id'] == $vote['id_vote']){
			$result['votes'][$list['id']]['given_to'] = $vote['id_participant'];
			break;
		}
	}
}

uasort($result['votes'], function($v1, $v2){
	return $v1['given_to'] < $v2['given_to'] ? -1 : 1;
});