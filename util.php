<?php

class util
{

	/**
	 * unicode_decode
	 *
	 * @param unknown $str
	 * @return mixed
	 */
	public function unicode_decode($str)
	{
		return preg_replace_callback('/((?:[^\x09\x0A\x0D\x20-\x7E]{3})+)/', 'decode_callback', $str);
	}
	
	/**
	 * request
	 * 
	 * @param unknown $cmd
	 * @param unknown $output
	 * @param unknown $returnVar
	 * @param unknown $json
	 */
	public function request($cmd, &$output, &$returnVar, &$json)
	{
		exec($cmd, $output, $returnVar);
		
		error_log("output:"  . print_r($output, true));
		error_log("returnVar:"  . print_r($returnVar, true));
		
		$json=json_decode($output[0]);
		error_log("dump:"  . print_r($json, true));
		
	}

	/**
	 * requestPost
	 *
	 * @param unknown $url
	 * @param unknown $post
	 */
	public static function requestPost($url, $post)
	{
		
		$header = array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . LINE_CHANNEL_ACCESS_TOKEN
		);
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		
		$result = curl_exec($ch);
		
		error_log('result:' . $result);
		
		curl_close($ch);
	}
	
	/**
	 * dbOpen
	 * @return SQLite3
	 */
	public static function dbOpen()
	{
		return new SQLite3(DATABASE);
	}
}
?>
