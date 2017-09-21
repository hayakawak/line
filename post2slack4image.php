<?php
require_once (dirname(__FILE__) . '/util.php');

error_log('start, post2slack4image.php');

/**
 * call slack api files.upload
 */
$cmd="curl -F file=@$argv[1] -F channels=#general -F token=slacktoken https://slack.com/api/files.upload";
util::request($cmd, $output, $returnVar, $json);

/**
 * call slack api sharedPublicURL
 */
$fileId=$json->file->id;
$cmd="curl -F token=slacktoken -F file=$fileId https://slack.com/api/files.sharedPublicURL";
util::request($cmd, $output, $returnVar, $json);

/**
 * getImage
 */
$targetUrl=$json->file->permalink_public;
$file_content = file_get_contents($targetUrl);
preg_match_all('/<img.*src\s*=\s*[\"|\'](.*?)[\"|\'].*>/i', $file_content, $img_path_list);
$imgsrc=print_r($img_path_list[1][0], true);

/**
 * call line api
 */
$cmd="php /var/www/html/line/pushImage.php  $imgsrc";
util::request($cmd, $output, $returnVar, $json);

// ファイル削除
unlink($argv[1]);

error_log('end, post2slack4image.php');
?>