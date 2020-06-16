<?php
require_once(dirname(__FILE__)."/config.php");
require_once(DEDEINC."/request.class.php");
$dopost = !isset($dopost) ? "" : $dopost;
if($dopost == "bindset")
{
	$dpl = new DedeTemplate();
	$tpl = dirname(__FILE__)."/templets/bindset_weixin.htm";
	$dpl->LoadTemplate($tpl);
	$dpl->display();
	exit;
}else if($dopost == 'bind'){
	$oldUserName = request('oldUserName','');
	$oldUserPwd = request('oldUserPwd','');
	  	//互亿无线代码 www.ihuyi.com start
         if(strlen($mobilecode) < 1 && $is_reg == "Y")
        {
            ShowMsg('手机验证码不能为空', '-1');
            exit();
        } 
		
         if($mobilecode != $_COOKIE['mobile_codec']  && $is_reg == "Y")
        {
            ShowMsg('手机验证码不正确', '-1');
            exit();
        }   
        // ShowMsg($mobilecode.'手机验证码OK'.$_COOKIE['mobile_codec'] , '-1');
        //    exit();		
	    //互亿无线代码 www.ihuyi.com end

	if(empty($oldUserName))
	{
		ShowMsg("您的用户名不能为空",-1);
		exit;
	}
	
	if(empty($oldUserPwd))
	{
		ShowMsg("您的密码不能为空",-1);
		exit;
	}
	
	$oldUserPwd = md5($oldUserPwd);
	$row = $dsql->GetOne("SELECT * FROM #@__member WHERE `userid` = '{$oldUserName}' AND `pwd` = '{$oldUserPwd}'");
	
	if(empty($row))
	{
		ShowMsg("您的用户名或者密码错误",-1);
		exit;
	}
	$gRow = $dsql->GetOne("SELECT * FROM #@__member_login where mid = {$row['mid']} AND login_type ='weixin'");
	if(!empty($gRow))
	{
		ShowMsg("已经有人绑定！请勿盗号！！！",-1);
		exit;
	}
	
	$weixin_mid = GetCookie("WEIXIN_MID");
	$query = "UPDATE #@__member_login SET `mid` = '{$row['mid']}' WHERE id='{$weixin_mid}'";
	$dsql->ExecuteNoneQuery($query);
	$logintime = time();
	$dsql->ExecuteNoneQuery("UPDATE #@__member set logintime='$logintime' where mid = '{$row['mid']}'");
	$cfg_ml->PutLoginInfo($row['mid']);
	//$cfg_ml->DelCache($row['mid']);
	DropCookie("WEIXIN_MID");
	ShowMsg("绑定成功...","index.php",0,2000);
    exit;
}else if($dopost == 'reg'){
     	//互亿无线代码 www.ihuyi.com start
         if(strlen($mobilecode) < 1 && $is_reg == "Y")
        {
            ShowMsg('手机验证码不能为空', '-1');
            exit();
        } 
		
         if($mobilecode != $_COOKIE['mobile_codec']  && $is_reg == "Y")
        {
            ShowMsg('手机验证码不正确', '-1');
            exit();
        }   
        // ShowMsg($mobilecode.'手机验证码OK'.$_COOKIE['mobile_codec'] , '-1');
        //    exit();		
	    //互亿无线代码 www.ihuyi.com end
		$newUserName = request('newUserName','');
		if(preg_match("/1[34578]{1}\d{9}$/",$newUserName)){}else{  ShowMsg('手机号不正确', '-1');exit;}
$newUserPwd = request('newUserPwd','');
	
	$newUserPwd = md5($newUserPwd);
  $uname = substr_replace($newUserName,'****',3,4);
	$qq = request('qq','');
	$newUserEmail = $qq."";
	$jointime = time();
	$logintime = time();
	$joinip = GetIP();
	$loginip = GetIP();
	$weixin_mid = GetCookie("WEIXIN_MID");
	if(empty($newUserName))
	{
		ShowMsg('登录帐号不能为空',-1);
		exit;
	}
	if(empty($uname))
	{
		ShowMsg('姓名不能为空',-1);
		exit;
	}
	if(empty($newUserPwd))
	{
		ShowMsg('密码不能为空',-1);
		exit;
	}
	if(empty($qq))
	{
		ShowMsg('qq号不能为空',-1);
		exit;
	}
	$row = $dsql->GetOne("SELECT * FROM #@__member WHERE `userid`='{$newUserName}'");
	$qqRow = $dsql->GetOne("SELECT * FROM #@__member_login WHERE id = '{$weixin_mid}'");
	if(!empty($row))
	{
		ShowMsg("此用户名已经存在，请重新注册",-1);
		exit;
	}
	if(!empty($qqRow['mid']))
	{
		ShowMsg("你已经绑定会员无需重新绑定",-1);
		exit;
	}
		        //会员的默认金币
        $dfscores = 0;
        $dfmoney = 0;
        $dfrank = $dsql->GetOne("SELECT money,scores FROM `#@__arcrank` WHERE rank='10' ");
        if(is_array($dfrank))
        {
            $dfmoney = $dfrank['money'];
            $dfscores = $dfrank['scores'];
        }
	$inQuery = "INSERT INTO `#@__member` (`mtype` ,`userid` ,`pwd` ,`uname`,`money` ,`spacesta` ,`rank` ,
        `matt` ,`face`,`email`,`jointime` ,`joinip` ,`logintime` ,`loginip`,`qq` )
       VALUES ('个人','$newUserName','$newUserPwd' ,'$uname','$dfmoney','2','10','0','$qqRow[face]','$newUserEmail','$jointime','$joinip','$logintime','$loginip','$qq'); "; 
	if($dsql->ExecuteNoneQuery($inQuery))
	{
		$mid = $dsql->GetLastID();
		$query = "UPDATE #@__member_login SET `mid` = '{$mid}' WHERE id='{$weixin_mid}'";
		$cfg_ml->PutLoginInfo($mid);
		$dsql->ExecuteNoneQuery($query);
		
		$membertjquery = "INSERT INTO `#@__member_tj` (`mid`,`article`,`album`,`archives`,`homecount`,`pagecount`,`feedback`,`friend`,`stow`)
			   VALUES ('$mid','0','0','0','0','0','0','0','0'); ";
		$dsql->ExecuteNoneQuery($membertjquery);
		$space='person';
		//写入默认空间配置数据
		$spacequery = "INSERT INTO `#@__member_space`(`mid` ,`pagesize` ,`matt` ,`spacename` ,`spacelogo` ,`spacestyle`, `sign` ,`spacenews`)
				VALUES('{$mid}','10','0','{$uname}的空间','','$space','',''); ";
		$dsql->ExecuteNoneQuery($spacequery);
		//$dsql->ExecuteNoneQuery("UPDATE #@__member set email='$newUserEmail' where mid = '{$WEIXIN_MID}'");
		DropCookie("WEIXIN_MID");
		ShowMsg("新用户注册成功，并绑定成功","/member",0,2000);
		exit;
	}else{
		ShowMsg("新用户注册失败",-1);
		exit;
	}
}else if($dopost =='user_ajx'){
	$username = request('username','');
	$row = $dsql->GetOne("SELECT * FROM #@__member WHERE `userid`='{$username}'");
	if(!empty($row))
	{
		echo -1;
		exit;
	}else{
		echo 0;
		exit;
	}
}else if($dopost == 'loginout'){
	DropCookie("WEIXIN_MID");
	ShowMsg("退出成功","/",0,2000);
	exit;
}else if($dopost == 'release'){
	$memberRow = $dsql->GetOne("SELECT * FROM #@__member_login where mid=".$cfg_ml->M_ID);
	if(empty($memberRow['mid']))
	{
		ShowMsg("操作有误",-1);
		exit;
	}else{
		$sql = "UPDATE #@__member_login SET mid=0 where mid=".$cfg_ml->M_ID;
		if($dsql->ExecuteNoneQuery($sql))
		{
			$cfg_ml->ExitCookie();
			ShowMsg("解除绑定成功","/member");
		}
	}
}