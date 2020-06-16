<?php
/**
 * @version        $Id: reg_new.php 1 8:38 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.yunziyuan.com.cn
 * @edit           互亿无线代码 www.ihuyi.com
 */
    session_start();
    require_once(dirname(__FILE__)."/config.php");
    //require_once(DEDEMEMBER."/templets/reg-new2.htm");
	require_once(DEDEMEMBER . '/lib_sms.php');
	//require_once(DEDEMEMBER . '/sms.php');
	// 短信内容
	//$verifycode = getverifycode();
	$vacode=rand('111111','999999');
//	$_POST['mobile_phone'] = 18369259596;
	PutCookie('mobile_codec', $vacode, 3600 * 24, '/');
    $message="您的验证码是：".$vacode."。请不要把验证码泄露给其他人。如非本人操作，可不用理会！";
	 $row = $dsql->GetOne("SELECT * FROM `#@__sysconfig` WHERE varname LIKE 'dxzh' ");
	 $row_pwd = $dsql->GetOne("SELECT * FROM `#@__sysconfig` WHERE varname LIKE 'dx_pwd' ");
	 $row_reg = $dsql->GetOne("SELECT * FROM `#@__sysconfig` WHERE varname LIKE 'is_reg' ");	
	$infos=$row['value'].','.$row_pwd['value'].','.$_POST['newUserName'];
	$result = sendsms($infos, $message);
	if($result){
		// echo 'ok'.$infos.$message.'nw';
		echo 'ok';	
		}else{
		echo 'nono';
	}
?>