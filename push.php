<?php
require_once (dirname(__FILE__) . '/../../php/define.php');
require_once (dirname(__FILE__) . '/util.php');

error_log('start, push.php');

$word = util::unicode_decode($_GET['word']);

$messageData = [
	'type' => 'text',
	'text' => $word
];

/*
$post = [
	'to' => LINE_TO,
	'messages' => [
		$messageData
	]
];

util::requestPost(LINE_API_PUSH_URL, $post);
*/

$db = util::dbOpen();
$stmt = $db->prepare("SELECT * FROM line_user;");
$result = $stmt->execute();

while($res = $result->fetchArray(SQLITE3_ASSOC)){

	if(!isset($res['user_id'])) continue;

	error_log('user_id, ' . $res['user_id']);
	
	$post = [
		'to' => $res['user_id'],
		'messages' => [
			$messageData
		]
	];
	
	util::requestPost(LINE_API_PUSH_URL, $post);
}

$db->close();
?>
