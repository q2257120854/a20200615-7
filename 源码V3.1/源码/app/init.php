<?php
error_reporting(0);//error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors','off');//ini_set('display_errors','on');

define('BL_ROOT',dirname(__FILE__));
ob_start();header('Content-Type:text/html;charset=utf8');
date_default_timezone_set('Asia/Shanghai');
//自动加载
require BL_ROOT.'/../vendor/autoload.php';
require_once BL_ROOT.'/common.php';
require_once BL_ROOT.'/Config.php';
require_once BL_ROOT.'/blapp.php';

session_start();
?>