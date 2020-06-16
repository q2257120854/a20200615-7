<?php
/** * @package Lanzou
* @author Mlooc 
* @version 1.0.0 
* @link https://www.12580sky.com */    
function MloocCurl($url,$method,$ifurl,$post_data){
	$UserAgent = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36';
	#设置ua
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	if ($method == "post") {
		curl_setopt($curl, CURLOPT_REFERER, $ifurl);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
	}
	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}
if (!empty($_GET['url'])) {
	$url = $_GET['url'];
	#第一步
	$ruleMatchDetailInList = "~ifr2\"\sname=\"[\s\S]*?\"\ssrc=\"\/(.*?)\"~";
	preg_match($ruleMatchDetailInList, MloocCurl($url,null,null,null),$link);
	$ifurl = "https://www.lanzous.com/".$link[1];
	#第二步 
	$ruleMatchDetailInList = "~=\s'(.*?)';[\S\s]*?=\s'(.*?)'[\S\s]*?=\s'(.*?)'[\S\s]*?=\s'(.*?)'~";
	preg_match($ruleMatchDetailInList, MloocCurl($ifurl,null,null,null),$segment);
	#第三步
	#post提交的数据
	$post_data = array(
	"action" => $segment[1],
	"file_id" => $segment[2],
	"t" => $segment[3],
	"k" => $segment[4]
	);
	$obj = json_decode(MloocCurl("https://www.lanzous.com/ajaxm.php","post",$ifurl,$post_data));
	#json解析
	if ($obj->dom == "") {
                               #获取失败直接跳转访问
                               header("Location: $url"); 
	}else{
		$downUrl = $obj->dom."/file/".$obj->url;
		if (!empty($_GET['type'])) {
			$type = $_GET['type'];
			if ($type == "down") {
				header('Location:'.$downUrl);
				#直接下载 
			}else{
				echo '成功|'.$obj->dom."/file/".$obj->url.'|';
				#输出直链
			}
		}else{
			echo '成功|'.$obj->dom."/file/".$obj->url.'|';#输出直链
		}
	}

}?>


