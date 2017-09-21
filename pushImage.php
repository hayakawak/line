<?php
require_once (dirname(__FILE__) . '/../../php/define.php');
require_once (dirname(__FILE__) . '/util.php');

error_log('start, pushImage.php');

$url='';

if ($argc == 2) {
	$url=$argv[1];
} else {
	error_log('nothing argv, exit');
	exit;
}

$messageData = [
	'type' => 'image',
	'originalContentUrl' => $url,
	'previewImageUrl' => $url
];

$post = [
	'to' => LINE_TO,
	'messages' => [
		$messageData
	]
];

util::requestPost(LINE_API_PUSH_URL, $post);
?>