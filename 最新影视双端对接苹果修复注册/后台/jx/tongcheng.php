<?php
/** 
* @package ctdisk 
* @author Mlooc 
* @version 1.0.0 
* @link https://www.12580sky.com 
*/// 指定允许其他域名访问 
header('Access-Control-Allow-Origin:*');
function object_array($array) {
	if(is_object($array)) {
		$array = (array)$array;
	} if(is_array($array)) {
		foreach($array as $key=>$value) {
			$array[$key] = object_array($value);
		}          }
	return $array;
}
function MloocCurl($url){
	$UserAgent = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36';
	#设置UserAgent
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent);
	#关闭SSL
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	#返回数据不直接显示
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}
if (!empty($_GET['url'])) {
	$url = $_GET['url'];
	$urlInfo = MloocCurl($url);
	$ruleMatchDetailInList = "~var userid = '(.*?)'~";
	#正则表达式 
	preg_match($ruleMatchDetailInList,$urlInfo,$userid);
	$ruleMatchDetailInList = "~onclick=\"free_down\('(.*?)', 0, '(.*?)', 0, 0\)\" id=\"free_down_link\">~";
	#正则表达式
	preg_match($ruleMatchDetailInList,$urlInfo,$downInfo);
	$userid=$userid[1];
	$file_chk=$downInfo[2];
	$fid=$downInfo[1];
	$url="https://mlooc.ctfile.com/get_file_url.php?uid=".$userid."&fid=".$fid."&file_chk=".$file_chk;
	$downInfo=MloocCurl($url);
	// $downUrl = $result["main"]["descr_downurl"];
	$downInfo=json_decode($downInfo);
	$downInfo=object_array($downInfo);
	print_r($downInfo["downurl"]);
}else{
	$result_url = str_replace("index.php","","//".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?url=https://u17877708.ctfile.com/fs/17877708-297837876");
	echo "演示：";
	echo "<br/>";
	echo "<br/>";
	echo '<a href="'.$result_url.'" target="_blank">'.$result_url.'</a>';
}?>