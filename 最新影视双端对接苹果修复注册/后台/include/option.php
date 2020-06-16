<?php


$sql="select * from eruyi_peizhi where id=1";
$query=$db->query($sql);
$have=$db->fetch_array($query);
if($have){
$iptime = $have['iptime']*3600;  //同IP注册间隔（单位：小时，设0关闭）
$codetime = $have['codetime']*3600; //同注册码注册间隔168（单位：小时，设0关闭）
$regvip = $have['regvip']*3600; //注册送体验VIP时间3600/86400（单位：小时，设0关闭）
$invvip = $have['invvip']*3600; //邀请成功赠送体验VIP时间（单位：小时，设0关闭）

$yzfid=$have['yzfid'];//商户ID
$yzfkey=$have['yzfkey'];//商户KEY
$yzfurl=$have['yzfurl'];//查单地址

$dqrenshu = $have['dqrenshu']; //当邀请人为3 送7天时间
$zstime = $have['zstime']*3600; //送体验VIP时间（单位：小时，设0不送）

$dqrenshu2 = $have['dqrenshu2']; //当邀请人为12 送1年时间
$zstime2 = $have['zstime2']*3600; //送体验VIP时间（单位：小时，设0不送）
}else{
    exit("系统设置加载失败");
}
?>