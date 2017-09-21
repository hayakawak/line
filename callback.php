<?php
require_once (dirname(__FILE__) . '/../../php/define.php');
require_once (dirname(__FILE__) . '/util.php');

error_log('start, callback.php');

// リクエストパラメータの取得
$obj = json_decode(file_get_contents('php://input'));

error_log(print_r($obj, true));

$event = $obj->{'events'}[0];

$type = $event->{'type'};

error_log('type:' . $type);

if ($type == 'message') {
	
	$text = $event->{'message'}->{'text'};
	$userId = $event->{'source'}->{'userId'};
	$replyToken = $event->{'replyToken'};
	
	error_log('userId:' . $userId);
	
	// レスポンス準備
	$messageData = [
		'type' => 'text',
		'text' => $text
	];
	
	$post = [
		'replyToken' => $replyToken,
		'messages' => [
			$messageData
		]
	];
	
	util::requestPost(LINE_API_REPLY_URL, $post);
	
} elseif ($type == 'follow') {
	
	$userId = $event->{'source'}->{'userId'};
	error_log('userId:' . $userId);
	
	// welcome
	$messageData = [
		'type' => 'text',
		'text' => 'welcome'
	];
	
	$post = [
		'to' => LINE_TO,
		'messages' => [
			$messageData
		]
	];
	
	util::requestPost(LINE_API_PUSH_URL, $post);
	
	// insert
	
	$db = util::dbOpen();

	$stmt = $db->prepare("INSERT INTO line_user (entryTimeStamp, user_id) VALUES (datetime('now'), ?);");
	$stmt->bindParam(1, $userId, SQLITE3_TEXT);
	
	$result = $stmt->execute();
	
	$db->close();
	
} elseif ($type == 'unfollow') {
	
	// block
	
}
?>