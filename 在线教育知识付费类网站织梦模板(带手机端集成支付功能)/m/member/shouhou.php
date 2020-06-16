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

$menutype = 'pingjia';





#api{{

if(defined('UC_API') && @include_once DEDEROOT.'/uc_client/client.php')

{

    if($data = uc_get_user($cfg_ml->M_LoginID)) uc_pm_location($data[0]);

}

#/aip}}





//检查用户是否被禁言

CheckNotAllow();

$state=(empty($state))? "" : $state;



$menutype = 'pingjia';

$pingjia = $dsql->GetOne("SELECT s.ssta,p.stime FROM `#@__shops_products` as s left join `#@__shops_orders` as p on s.oid=p.oid  WHERE s.oid='".$oid."' and s.aid='".$aid."'; ");

//$rowhnbk=$dsql->GetOne("SELECT  * FROM `#@__member_person` WHERE mid='".$cfg_ml->M_ID."'");

$naid = $aid;



 if(is_array($pingjia))

                {

if($pingjia['ssta'] ==1)

{

ShowMsg('已经售后!','shops_orders.php');exit;

}                 }

                else

                {

   ShowMsg('无此订单!','shops_orders.php');exit;

                }

			 $lll = $dsql->GetOne("SELECT arc.litpic,arc.title,arc.money,arc.typeid,p.trueprice,s.buynum,s.price FROM `#@__archives` as arc left join `#@__addonshop` as p on arc.id=p.aid LEFT JOIN #@__shops_products AS s ON s.aid=arc.id WHERE arc.id='$naid' ");

			 // $dsql->SetQuery("SELECT s.*,arc.litpic FROM s.oid='{$oid}' ORDER BY s.aid ASC");

//会员后台

require_once(DEDEINC."/userlogin.class.php");



require_once("inc/inc_archives_functions.php");

$cfg_formmember = isset($cfg_formmember) ? true : false;

$ischeck = $cfg_feedbackcheck=='Y' ? 0 : 1;

 //保存评论内容

/*-------------

function _ShowForm(){  }

--------------*/

if(empty($dopost))

{

    $query = "SELECT * FROM `#@__channeltype` WHERE id='$channelid'; ";

    $cInfos = $dsql->GetOne($query);





    include("templets/shouhou.htm");

    exit();

}

else    if($dopost == 'save')

    { 

     $cInfos = $dsql->GetOne("Select * From `#@__channeltype`  where id='$channelid'; ");

    $maxwidth = isset($maxwidth) && is_numeric($maxwidth) ? $maxwidth : 800;

    $pagepicnum = isset($pagepicnum) && is_numeric($pagepicnum) ? $pagepicnum : 12;

    $ddmaxwidth = isset($ddmaxwidth) && is_numeric($ddmaxwidth) ? $ddmaxwidth : 200;

    $prow = isset($prow) && is_numeric($prow) ? $prow : 3;

    $pcol = isset($pcol) && is_numeric($pcol) ? $pcol : 3;

    $pagestyle = in_array($pagestyle,array('1','2','3')) ? $pagestyle : 2;

    include('inc/pingjia_check.php');

    $imgurls = "{dede:pagestyle maxwidth='$maxwidth' pagepicnum='$pagepicnum' ddmaxwidth='$ddmaxwidth' row='$prow' col='$pcol' value='$pagestyle'/}\r\n";

    $hasone = false;

    $ddisfirst=1;







    //正常上传

    for($i=1;$i<=120;$i++)

    {

        //含有图片的条件

        if(isset($_FILES['imgfile'.$i]['tmp_name']) && is_uploaded_file($_FILES['imgfile'.$i]['tmp_name']) )

        {

            $iinfo = str_replace("'","`",stripslashes(${'imgmsg'.$i}));

            if(!is_uploaded_file($_FILES['imgfile'.$i]['tmp_name']))

            {

                continue;

            }

            else

            {

                $sparr = Array("image/pjpeg","image/jpeg","image/gif","image/png","image/xpng","image/wbmp");

                if(!in_array($_FILES['imgfile'.$i]['type'],$sparr))

                {

                    continue;

                }

                $filename = MemberUploads('imgfile'.$i,'',$cfg_ml->M_ID,'image','',0,0,false);

                if($filename!='')

                {

                    SaveUploadInfo($title,$filename,1);

                }



                //缩图

                if($pagestyle > 2)

                {

                    $litpicname = GetImageMapDD($filename,$ddmaxwidth);

                    if($litpicname != '')

                    {

                        SaveUploadInfo($title.' 小图',$litpicname,1);

                    }

                }

                else

                {

                    $litpicname = $filename;

                }

                $imgfile = $cfg_basedir.$filename;

                if(is_file($imgfile))

                {

                    $iurl = $filename;

                    $info = '';

                    $imginfos = @getimagesize($imgfile,$info);

                    $imgurls .= "{dede:img ddimg='$litpicname' text='$iinfo' width='".$imginfos[0]."' height='".$imginfos[1]."'} $iurl {/dede:img}\r\n";

                }

            }

            if(!$hasone && $litpic=='' && !empty($litpicname))

            {

                $litpic = $litpicname;

                $hasone = true;

            }

        }

    }//循环结束

    $imgurls = addslashes($imgurls);



$aid=$aid;

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

$oid=$oid;



	



    $face = intval($face);

    $typeid = (isset($typeid) && is_numeric($typeid)) ? intval($typeid) : 0;

    extract($arcRow, EXTR_SKIP);

    $msg = cn_substrR(TrimMsg($msg), 1000);

    $username = cn_substrR(HtmlReplace($username, 2), 20);

        if($msg!='')

        {

            $inquery = "INSERT INTO `#@__shouhou`(`aid`,`typeid`,`username`,`arctitle`,`ip`,`ischeck`,`dtime`, `mid`,`bad`,`good`,`ftype`,`face`,`msg`,`imgurls`,`oid`)

                   VALUES ('$aid','$typeid','$username','$arctitle','$ip','$ischeck','$dtime', '{$cfg_ml->M_ID}','0','0','$feedbacktype','$face','$msg','$imgurls','$oid'); ";

            $rs = $dsql->ExecuteNoneQuery($inquery);

            if(!$rs)

            {

                ShowMsg(' 发布售后问题错误! ', '-1');

                //echo $dsql->GetError();

                exit();

            }

        }

		    if($cfg_ml->M_ID > 0)

    {

        $dsql->ExecuteNoneQuery("UPDATE `#@__member` SET scores=scores+{$cfg_sendfb_scores} WHERE mid='{$cfg_ml->M_ID}' ");

        $dsql->ExecuteNoneQuery("UPDATE `#@__shops_products` SET ssta='1'  WHERE oid='".$oid."' and aid='".$aid."'");

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

        ShowMsg('问题已提交请等待回复', $backurl);

    }

    else

    {

        ShowMsg('成功售后问题，现在转回会员中心!', $backurl);

    }

    exit();

    }