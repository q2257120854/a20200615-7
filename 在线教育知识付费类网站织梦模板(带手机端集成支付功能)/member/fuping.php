<?php

/**

 * @version        $Id: index.php 1 8:24 2010年7月9日Z tianya $

 * @package        DedeCMS.Member

 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.

 * @license        http://help.dedecms.com/usersguide/license.html

 * @link           http://www.yunziyuan.com.cn

 */

require_once(dirname(__FILE__)."/config.php");

CheckRank(0,0);

$menutype = 'pm';

$menutype_son = 'pm';

//$buyid = isset($buyid)? intval($buyid) : 0;

if($cfg_mb_lit=='Y')

{

    ShowMsg('由于系统开启了精简版会员空间，你不能向其它会员发短信息，不过你可以向他留言！','-1');

    exit();

}



#api{{

if(defined('UC_API') && @include_once DEDEROOT.'/uc_client/client.php')

{

    if($data = uc_get_user($cfg_ml->M_LoginID)) uc_pm_location($data[0]);

}

#/aip}}



if(!isset($dopost))

{

    $dopost = '';

}

//检查用户是否被禁言

CheckNotAllow();

$state=(empty($state))? "" : $state;



$menutype = 'fuping';

$fuping = $dsql->GetOne("SELECT psta,mtime,product FROM `#@__member_operation` WHERE buyid='".$buyid."' and mid='".$cfg_ml->M_ID."'; ");

//$rowhnbk=$dsql->GetOne("SELECT  * FROM `#@__member_person` WHERE mid='".$cfg_ml->M_ID."'");

$naid = str_replace('ARCHIVE', '', $buyid);

 $lll = $dsql->GetOne("SELECT litpic,title,money,typeid FROM `#@__archives` WHERE id='$naid' ");

 if(is_array($fuping))

                {

if($fuping['psta'] ==1)

{

 ShowMsg('已评价完!','/member');exit;

}                 }

                else

                {

					    ShowMsg('无此订单!','/member');exit;

                }

			

//会员后台

$cfg_formmember = isset($cfg_formmember) ? true : false;

$ischeck = $cfg_feedbackcheck=='Y' ? 0 : 1;

 //保存评论内容

    if($comtype == 'comments')

    { $aid=$naid;

        $arctitle = $lll['title'];

		$typeid =  $lll['typeid'];

		$ischeck = intval($ischeck);

		 $ip = GetIP();

    $dtime = time();

        $username = $cfg_ml->M_UserName;

		$feedbacktype = preg_replace("#[^0-9a-z]#i", "", $feedbacktype);

		  if(empty($face))

    {

        $face = 0;

    }

    $face = intval($face);

    $typeid = (isset($typeid) && is_numeric($typeid)) ? intval($typeid) : 0;

    extract($arcRow, EXTR_SKIP);

    $msg = cn_substrR(TrimMsg($msg), 1000);

    $username = cn_substrR(HtmlReplace($username, 2), 20);

        if($msg!='')

        {

            $inquery = "INSERT INTO `#@__shopping`(`aid`,`typeid`,`username`,`arctitle`,`ip`,`ischeck`,`dtime`, `mid`,`bad`,`good`,`ftype`,`face`,`msg`)

                   VALUES ('$aid','$typeid','$username','$arctitle','$ip','$ischeck','$dtime', '{$cfg_ml->M_ID}','0','0','$feedbacktype','$face','$msg'); ";

            $rs = $dsql->ExecuteNoneQuery($inquery);

            if(!$rs)

            {

                ShowMsg(' 发表评论错误! ', '-1');

                //echo $dsql->GetError();

                exit();

            }

        }

		    if($cfg_ml->M_ID > 0)

    {

        $dsql->ExecuteNoneQuery("UPDATE `#@__member` SET scores=scores+{$cfg_sendfb_scores} WHERE mid='{$cfg_ml->M_ID}' ");

        $dsql->ExecuteNoneQuery("UPDATE `#@__member_operation` SET psta='1'  WHERE buyid='".$buyid."' and mid='".$cfg_ml->M_ID."'");

    }

    //统计用户发出的评论

    if($cfg_ml->M_ID > 0)

    {

        #api{{

        if(defined('UC_API') && @include_once DEDEROOT.'/api/uc.func.php')

        {

            //同步积分

            uc_credit_note($cfg_ml->M_LoginID, $cfg_sendfb_scores);

            

            //推送事件

            $arcRow = GetOneArchive($aid);

            $feed['icon'] = 'thread';

            $feed['title_template'] = '<b>{username} 发表了评论</b>';

            $feed['title_data'] = array('username' => $cfg_ml->M_UserName);

            $feed['body_template'] = '<b>{subject}</b><br>{message}';

            $url = !strstr($arcRow['arcurl'],'http://') ? ($cfg_basehost.$arcRow['arcurl']) : $arcRow['arcurl'];        

            $feed['body_data'] = array('subject' => "<a href=\"".$url."\">$arcRow[arctitle]</a>", 'message' => cn_substr(strip_tags(preg_replace("/\[.+?\]/is", '', $msg)), 150));

            $feed['images'][] = array('url' => $cfg_basehost.'/images/scores.gif', 'link'=> $cfg_basehost);

            uc_feed_note($cfg_ml->M_LoginID,$feed); unset($arcRow);

        }

        #/aip}}

    

        $row = $dsql->GetOne("SELECT COUNT(*) AS nums FROM `#@__feedback` WHERE `mid`='".$cfg_ml->M_ID."'");

        $dsql->ExecuteNoneQuery("UPDATE `#@__member_tj` SET `feedback`='$row[nums]' WHERE `mid`='".$cfg_ml->M_ID."'");

    }

    

    //会员动态记录

    $cfg_ml->RecordFeeds('feedback', $arctitle, $msg, $aid);

    

    $_SESSION['sedtime'] = time();

    if(empty($uid) && isset($cmtuser)) $uid = $cmtuser;

    $backurl = $cfg_formmember ? "index.php?uid={$uid}&action=viewarchives&aid={$aid}" : "index.php";

    if($ischeck==0)

    {

        ShowMsg('成功发表评论，但需审核后才会显示你的评论!', $backurl);

    }

    else

    {

        ShowMsg('成功发表评论，现在转到评论页面!', $backurl);

    }

    exit();

    }

    else

    {

     

        $dpl = new DedeTemplate();

        $tpl = dirname(__FILE__)."/templets/fuping.htm";

        $dpl->LoadTemplate($tpl);

        $dpl->display();

    }

