<?php

require_once 'globals.php';
$sql="select * from admin where id=1";
$query=$db->query($sql);
$row=$db->fetch_array($query);
if($row){
	$user = $row['username'];//后台账号
    $pass = $row['password'];//后台密码
	$cookie = '8f14e45fceea167a5a36dedd4bea2543';
}



/* 请手动修改以上账号密码信息 */
?>