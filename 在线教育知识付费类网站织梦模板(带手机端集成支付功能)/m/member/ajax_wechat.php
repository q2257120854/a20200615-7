<?php

/**

 * @version        $Id: ajax_feedback.php 1 8:38 2010年7月9日Z tianya $

 * @package        DedeCMS.Member

 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.

 * @license        http://help.dedecms.com/usersguide/license.html

 * @link           http://www.yunziyuan.com.cn

 */

require_once(dirname(__FILE__).'/config.php');
AjaxHead();
$action = $_POST['action'];

switch($action) {

case 'check_openid':

    $pms = $dsql->GetOne("SELECT * FROM #@__member_login WHERE userid='{$_POST['openid']}'");
    if($pms && $pms['mid']){
	   $cfg_ml->PutLoginInfo($pms['mid']);
	   $ret = array('status'=>1,'msg'=>'登录成功','url'=>'','action'=>1);
    }else{
	   if($pms){
		   $id = $pms['id'];
	   }else{
		     $userid = $_POST['openid'];
			 $uname = $_POST['nickname'];
			 $face = $_POST['headimgurl'];
			 $regtime = time();
			 $mid = 0;
			 $login_type = 'wechat';
		     $inquery = "INSERT INTO `#@__member_login`(`userid`,`uname`,`face`,`regtime`,`mid`,`login_type`) VALUES ('$userid','$uname','$face','$regtime','$mid','$login_type'); ";
             $rs = $dsql->ExecuteNoneQuery($inquery);
             if(!$rs)
             {
                $ret = array('status'=>-1,'error'=>'保存用户信息失败！');
				die(json_encode($ret));
             }
			 $id = $dsql->GetLastID();
	   }
	   $ret = array('status'=>1,'msg'=>'用户未绑定','action'=>2,'id'=>$id);
    }
    die(json_encode($ret));
	
break;


case 'blind_user':

    if($_POST['mobilecode'] != $_COOKIE['mobile_codec'] )
    {
	    $ret = array('status'=>-1,'error'=>'手机验证码不正确');
		die(json_encode($ret));
    }   
    $pms = $dsql->GetOne("SELECT * FROM #@__member WHERE userid='{$_POST['mobile']}'");
	if(!$pms){
		$ret = array('status'=>-1,'error'=>'该用户不存在','s'=>$inquery);
		die(json_encode($ret));
	}
	$mid = $pms['mid'];
	$thirdid = $_POST['thirdid'];
	$sql = "UPDATE `#@__member_login` SET `mid`='{$mid}' WHERE `id`='{$thirdid}' ;";
    $rs = $dsql->ExecuteNoneQuery($sql);
	if(!$rs){
        $ret = array('status'=>-1,'error'=>'绑定用户失败！');
		die(json_encode($ret));
    }else{
		$cfg_ml->PutLoginInfo($pms['mid']);
		$ret = array('status'=>1,'msg'=>'绑定成功','pms'=>$pms);
		die(json_encode($ret));
	}
	

break;

case 'new_user':
    

break;

}


