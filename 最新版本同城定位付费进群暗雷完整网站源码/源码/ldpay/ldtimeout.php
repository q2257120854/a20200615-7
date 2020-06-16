<?php
error_reporting(0);
@session_start();
define('TIME_OUT', $cfg_ldtimeout); //定义重复操作最短的允许时间，单位秒
$ldtime = time();
if( isset($_SESSION['ldtimeout']) )
{
 if( $ldtime - $_SESSION['ldtimeout'] <= TIME_OUT ) //判断超时
 {
  //echo $_SESSION['ldtimeout'];
  $ldurlout = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
  echo '<script type=text/javascript>alert("在'.TIME_OUT.'秒内只能访问一次！");</script>';
  echo '<script type=text/javascript>window.location.href="/user.php?uid='.get_usershipin('uid',$_REQUEST['id']).'";</script>';
  exit();
 }
}
$_SESSION['ldtimeout'] = $ldtime;
?>
