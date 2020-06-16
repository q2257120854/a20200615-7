<?php
function getIP(){
    // if (isset($_SERVER)) {
    //     if (isset($_SERVER[HTTP_X_FORWARDED_FOR])) {
    //         $realip = $_SERVER[HTTP_X_FORWARDED_FOR];
    //     } elseif (isset($_SERVER[HTTP_CLIENT_IP])) {
    //         $realip = $_SERVER[HTTP_CLIENT_IP];
    //     } else {
    //         $realip = $_SERVER[REMOTE_ADDR];
    //     }
    // } else {
    //     if (getenv("HTTP_X_FORWARDED_FOR")) {
    //         $realip = getenv( "HTTP_X_FORWARDED_FOR");
    //     } elseif (getenv("HTTP_CLIENT_IP")) {
    //         $realip = getenv("HTTP_CLIENT_IP");
    //     } else {
    //         $realip = getenv("REMOTE_ADDR");
    //     }
    // }
    // return $realip;


    if (isset($_SERVER)) { 
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']); 
            /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */ 
            foreach ($arr AS $ip) { 
            $ip = trim($ip); 
            if ($ip != 'unknown') { 
            $realip = $ip; 
            break; 
            } 
            } 
            if(!isset($realip)){ 
            $realip = "0.0.0.0"; 
            } 
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) { 
            $realip = $_SERVER['HTTP_CLIENT_IP']; 
            } else { 
            if (isset($_SERVER['REMOTE_ADDR'])) { 
            $realip = $_SERVER['REMOTE_ADDR']; 
            } else { 
            $realip = '0.0.0.0'; 
            } 
            } 
            } else { 
            if (getenv('HTTP_X_FORWARDED_FOR')) { 
            $realip = getenv('HTTP_X_FORWARDED_FOR'); 
            } elseif (getenv('HTTP_CLIENT_IP')) { 
            $realip = getenv('HTTP_CLIENT_IP'); 
            } else { 
            $realip = getenv('REMOTE_ADDR'); 
            } 
        } 
    preg_match("/[\d\.]{7,15}/", $realip, $onlineip); 
    $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0'; 
    return $realip; 
}

function getCity($ip){  //获取城市

    // 获取当前位置所在城市 
    $content = file_get_contents("http://api.map.baidu.com/location/ip?ak=2TGbi6zzFm5rjYKqPPomh9GBwcgLW5sS&ip=$ip");

    $json = json_decode($content);
    $data['address'] = $json->{'content'}->{'address'};//按层级关系提取address数据 
    $data['status']  = $json->{'status'};//判断是否获取到数据
    $data['province'] = mb_substr($data['address'],0,3,'utf-8'); 
    $data['city'] = mb_substr($data['address'],3,3,'utf-8');


    if($data['status']==0){
        return $data['city'];
    }else{
        return '未知';
    }
 
    // $res1 = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=$ip");
    // $res1 = json_decode($res1,true);
 

    // if ($res1[ "code"]==0){
    //     return $res1['data']["city"];
    // }else{
    //     return "未知";
    // }
}

function getCountry($ip){  //获取国家


    // 获取当前位置所在城市 
    $content = file_get_contents("http://api.map.baidu.com/location/ip?ak=2TGbi6zzFm5rjYKqPPomh9GBwcgLW5sS&ip=58.63.66.15");

    $json = json_decode($content);
    $data['gCountry']  = $json->{'address'};//获取国家

    $data['gCountry'] = explode('|',$data['gCountry']); 

 
    // $res1 = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=$ip");
    // $res1 = json_decode($res1,true);
 

    if ($data['gCountry'][0]=='CN'){
        return '中国';
    }else{
        return "未知";
    }
}
?>