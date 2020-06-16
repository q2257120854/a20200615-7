<?php
/**
 *
 * 关于文章权限设置的说明
 * 文章权限设置限制形式如下：
 * 如果指定了会员等级，那么必须到达这个等级才能浏览
 * 如果指定了金币，浏览时会扣指点的点数，并保存记录到用户业务记录中
 * 如果两者同时指定，那么必须同时满足两个条件
 *
 * @version        $Id: view.php 1 15:38 2010年7月8日Z tianya $
 * @package        DedeCMS.Site
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.yunziyuan.com.cn
 */

 
 
require_once(dirname(__FILE__)."/../member/config.php");
require_once(DEDEINC.'/arc.archives.class.php');

$t1 = ExecTime();

if(empty($okview)) $okview = '';
if(isset($arcID)) $aid = $arcID;
if(!isset($dopost)) $dopost = '';

$arcID = $aid = (isset($aid) && is_numeric($aid)) ? $aid : 0;
if($aid==0) die(" Request Error! ");

 
if(empty($cfg_ml->M_ID)){

	ShowMsg('请先登录！', '/member/',  0, 0);
	exit;
}
 
 

$arc = new Archives($aid);
if($arc->IsError) ParamError();


//检查阅读权限
$needMoney = $arc->Fields['money'];
$needRank = $arc->Fields['arcrank'];
 
require_once(DEDEINC.'/memberlogin.class.php');
$cfg_ml = new MemberLogin();
 


//如果都买过这个课程 把 needrank 改成0
if(!empty($cfg_ml->M_ID)){
	$arr = $dsql->GetOne("select typeid from #@__archives where id = '$aid'");
	$tid = $arr['typeid'];
	$arr = $dsql->GetOne("select * from  `#@__shops_orders` where userid = '".$cfg_ml->M_ID."' and pid = '$tid' and state = '1' ");
	if(!empty($arr['oid'])){
		$needRank = 0 ;
	}
}



if($needRank < 0 && $arc->Fields['mid'] != $cfg_ml->M_ID)
{
    ShowMsg('文章尚未审核,非作者本人无权查看!', 'javascript:;');
    exit();
}

//设置了权限限制的文章
//arctitle msgtitle moremsg
if($needMoney>0 || $needRank>1)
{
    $arctitle =  $arc->Fields['title'];
	$typeid =   $arc->Fields['typeid'];
 
    /*
    $arclink = GetFileUrl($arc->ArcID,$arc->Fields["typeid"],$arc->Fields["senddate"],
                             $arc->Fields["title"],$arc->Fields["ismake"],$arc->Fields["arcrank"]);
    */                        
    $arclink = $cfg_phpurl.'/view.php?aid='.$arc->ArcID;                         
    $arcLinktitle = "<a href=\"{$arclink}\"><u>".$arctitle."</u></a>";
        $keywords =  $arc->Fields["keywords"];

    $description =  $arc->Fields["description"];
    $pubdate = GetDateTimeMk($arc->Fields["pubdate"]);
    
    //会员级别不足
    if(($needRank>1 /* && $cfg_ml->M_Rank != $needRank */&& $arc->Fields['mid']!=$cfg_ml->M_ID))
    {
        $dsql->Execute('me' , "SELECT * FROM `#@__arcrank` ");
        while($row = $dsql->GetObject('me'))
        {
            $memberTypes[$row->rank] = $row->membername;
        }
        $memberTypes[0] = "游客或没权限会员";
        $msgtitle = "你没有权限浏览文档：{$arctitle} ！";
        $moremsg = "这篇文档需要 <font color='red'>".$memberTypes[$needRank]."</font> 才能访问，你目前是：<font color='red'>".$memberTypes[$cfg_ml->M_Rank]."</font> ！";
      $gmurl = "/plus/list.php?tid=".$arc->Fields["typeid"];
   if ($cfg_ml->M_Rank != $needRank){ $v1 = $dsql->GetOne("SELECT * FROM `#@__addonvideo` WHERE `aid`='".$arcID."'"); include_once(DEDETEMPLATE.'/plus/view_nianfei.htm');exit;}
	   else  if($arc->Fields['typeid'] == 3 ){  include_once(DEDETEMPLATE.'/plus/view_msg3.htm');exit;}
	   /*else {  include_once(DEDETEMPLATE.'/plus/view_msg.htm');}exit();*/
        
    }

    //需要金币的情况
    if($needMoney > 0 && $arc->Fields['mid'] != $cfg_ml->M_ID)
    {
        $sql = "SELECT aid,money FROM `#@__member_operation` WHERE buyid='ARCHIVE".$aid."' AND mid='".$cfg_ml->M_ID."'";
        $row = $dsql->GetOne($sql);
        //未购买过此文章
        if(!is_array($row))
        {
            if($cfg_ml->M_Money=='' || $needMoney > $cfg_ml->M_Money)
            {
                    $msgtitle = "你没有权限浏览文档：{$arctitle} ！";
                    $moremsg = "这篇文档需要 <font color='red'>".$needMoney." 金币</font> 才能访问，你目前拥有金币：<font color='red'>".$cfg_ml->M_Money." 个</font> ！";
     $gmurl = "/member/buy.php\"  onclick=\"alert('未登陆或余额不足,请先充值');\"";
if ($arc->Fields['typeid'] == '1'){  $v1 = $dsql->GetOne("SELECT * FROM `#@__addonvideo` WHERE `aid`='".$arcID."'");include_once(DEDETEMPLATE.'/plus/view_msg1.htm');}
	   else if ( $arc->Fields['typeid'] == '3'){  $v1 = $dsql->GetOne("SELECT `body`,`size`,`tdts` FROM `#@__addondoc` WHERE `aid`='".$arcID."'");include_once(DEDETEMPLATE.'/plus/view_msg3.htm');}
	   else {  include_once(DEDETEMPLATE.'/plus/view_msg.htm');}
	   $arc->Close();
                    exit();
            }
            else
            {
                if($dopost=='buy')
                {if ($arc->Fields['typeid'] == '1'){ $product='video';}else{ $product='archive';}
                    $inquery = "INSERT INTO `#@__member_operation`(mid,oldinfo,money,mtime,buyid,product,pname)
                              VALUES ('".$cfg_ml->M_ID."','$arctitle','$needMoney','".time()."', 'ARCHIVE".$aid."', '$product',''); ";
                    if($dsql->ExecuteNoneQuery($inquery))
                    {
                        $inquery = "UPDATE `#@__member` SET money=money-$needMoney WHERE mid='".$cfg_ml->M_ID."'";
                        if(!$dsql->ExecuteNoneQuery($inquery))
                        {
                            showmsg('购买失败, 请返回', -1);
                            exit;
                        }
						
						 if($is_fan == 'Y'){
							 $fanli = $needMoney*$fanlisu/100;
						  $inquery = "UPDATE `#@__member` SET money=money+$fanli WHERE mid='".$cfg_ml->M_ID."'";
                        if(!$dsql->ExecuteNoneQuery($inquery))
                        {
                            showmsg('反利失败, 请返回', -1);
                            exit;
                        }}
                        #api{{
                        if(defined('UC_APPID'))
                        {
                            include_once DEDEROOT.'/api/uc.func.php';
                            $row = $dsql->GetOne("SELECT `scores`,`userid` FROM `#@__member` WHERE `mid`='".$cfg_ml->M_ID."'");
                            uc_credit_note($row['userid'],-$needMoney,'money');
                        }
                        #/aip}}
 echo "<script language= \"JavaScript\">\r\n";  
 echo "alert(\"感谢购买，您已可以随时学习，同时师傅向您赠送了一笔金额。\");\r\n";  
 echo " location.replace (\"/plus/view.php?aid=".$aid."\"); \r\n";   
 echo "</script>";  exit; 
                        showmsg('购买成功，购买扣点不会重扣金币，谢谢！', '/plus/view.php?aid='.$aid);
                        exit;
                    } else {
                        showmsg('购买失败, 请返回', -1);
                        exit;
                    }
                }
                
                $msgtitle = "扣金币购买阅读！";
                $moremsg = "阅读该文档内容需要付费！<br>这篇文档需要 <font color='red'>".$needMoney." 金币</font> 才能访问，你目前拥有金币 <font color='red'>".$cfg_ml->M_Money." </font>个！<br>确认阅读请点 [<a href='/plus/view.php?aid=".$aid."&dopost=buy' target='_blank'>确认付点阅读</a>]" ;
  $gmurl = "/plus/view.php?aid=".$aid."&dopost=buy\"  onclick=\"{if(confirm('您确定购买此课程吗？')){return true;}return false;}\"";
  if ($arc->Fields['typeid'] == '1'){  $v1 = $dsql->GetOne("SELECT * FROM `#@__addonvideo` WHERE `aid`='".$arcID."'");include_once(DEDETEMPLATE.'/plus/view_msg1.htm');}
	   else if ($arc->Fields['typeid'] == '3'){  $v1 = $dsql->GetOne("SELECT * FROM `#@__addondoc` WHERE `aid`='".$arcID."'"); include_once(DEDETEMPLATE.'/plus/view_msg3.htm');}
	   else {  include_once(DEDETEMPLATE.'/plus/view_msg.htm');}                $arc->Close();
                exit();
            }
        }
    }//金币处理付处理
}

$arc->Display();