<?php
/**
 * @version        $Id: edit_baseinfo.php 1 8:38 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.yunziyuan.com.cn
 */
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);


if($a == 'checkuname'){
	if(empty($uname)){
		echo '<font color="red">昵称不能为空！</font>';
	}else if(mb_strlen($uname) > 10){
		echo '<font color="red">昵称长度不能超过10个字符</font>';
	}else{
		$arr = $dsql->GetOne("select mid from #@__member where uname = '$uname' and mid <> '".$cfg_ml->M_ID."'");
		if(!empty($arr['mid'])){
			echo '<font color="red">昵称已存在</font>';		
		}else{
			echo 'ok';
		}
	}

	exit();	
}


$menutype = 'mydwz';
if(!isset($dopost)) $dopost = '';
$pwd2=(empty($pwd2))? "" : $pwd2;
$row=$dsql->GetOne("SELECT  * FROM `#@__member` WHERE mid='".$cfg_ml->M_ID."'");
$face = $row['face'];


if($dopost=='save')
{ 

//九戒织梦 查看是否已存在的昵称
if(empty($uname)){
	ShowMsg('昵称不能为空！','-1',0,1000);
		 exit();	
	}else if(mb_strlen($uname) > 10){
	ShowMsg('昵称长度不能超过10个字符！','-1',0,1000);
    exit();	
}
	
$arr = $dsql->GetOne("select mid from #@__member where uname = '$uname' and mid <> '".$cfg_ml->M_ID."'");
if(!empty($arr['mid'])){
    ShowMsg('昵称已存在！','-1',0,1000);
    exit();	
}





    $query1 = "UPDATE `#@__member` SET uname='$uname' where mid='".$cfg_ml->M_ID."' ";
    $dsql->ExecuteNoneQuery($query1); 
    // 清除会员缓存
    $cfg_ml->DelCache($cfg_ml->M_ID);
    ShowMsg('修改成功！','/member/',0,1000);
    exit();
}
include(DEDEMEMBER."/templets/edit_user.htm");