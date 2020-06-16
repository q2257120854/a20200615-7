<?php


require_once '../include/global.php';
require_once 'userdata.php';

$action = isset($_GET['action']) ? addslashes($_GET['action']) : '';

//登录验证
if ($action == 'login') {
	$username = isset($_POST['user']) ? addslashes(trim($_POST['user'])) : '';
	$password = isset($_POST['pw']) ? addslashes(trim($_POST['pw'])) : '';
	
    if($username == '' || $password == ''){
		header('Location:./login.php?err=1');
		exit;
	}
	if($username == $user && $password == $pass){
		setcookie('SEVEN_AUTH', $cookie, time() + 36000, '/');
		header('Location:./');
		exit;
	}else{
		header('Location:./login.php?err=2');
		exit;
	}
}
//退出
if ($action == 'logout') {
	setcookie('SEVEN_AUTH', ' ', time() - 36000, '/');
	header('Location:./login.php');
	exit;
}

$SEVEN_AUTH = isset($_COOKIE['SEVEN_AUTH']) ? addslashes(trim($_COOKIE['SEVEN_AUTH'])) : '';
if($SEVEN_AUTH == $cookie){
	$islogin = true;
}else{
	$islogin = false;
}

if (!$islogin) {
	header('Location:./login.php?err=3');
	exit;
}
