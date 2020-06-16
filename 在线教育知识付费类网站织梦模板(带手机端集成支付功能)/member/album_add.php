<?php

/**

 * 图集发布

 * 

 * @version        $Id: album_add.php 1 13:52 2010年7月9日Z tianya $

 * @package        DedeCMS.Member

 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.

 * @license        http://help.dedecms.com/usersguide/license.html

 * @link           http://www.yunziyuan.com.cn

 */

require_once(dirname(__FILE__)."/config.php");



//考虑安全原因不管是否开启游客投稿功能，都不允许用户对图集投稿

CheckRank(0,0);

if($cfg_mb_lit=='Y')

{

    ShowMsg("由于系统开启了精简版会员空间，你访问的功能不可用！","-1");

    exit();

}

if($cfg_mb_album=='N')

{

    ShowMsg("对不起，由于系统关闭了图集功能，你访问的功能不可用！","-1");

    exit();

}



$menutype = 'pingjia';

$pingjia = $dsql->GetOne("SELECT s.psta,p.stime FROM `#@__shops_products` as s left join `#@__shops_orders` as p on s.oid=p.oid  WHERE s.oid='".$oid."' and s.aid='".$aid."'; ");

//$rowhnbk=$dsql->GetOne("SELECT  * FROM `#@__member_person` WHERE mid='".$cfg_ml->M_ID."'");

$naid = $aid;

 $lll = $dsql->GetOne("SELECT arc.litpic,arc.title,arc.money,arc.typeid,p.trueprice FROM `#@__archives` as arc left join `#@__addonshop` as p on arc.id=p.aid  WHERE arc.id='$naid' ");

 if(is_array($pingjia))

                {

if($pingjia['psta'] ==1)

{

 //ShowMsg('已评价完!','shops_orders.php');exit;

}                 }

                else

                {

				//	    ShowMsg('无此订单!','shops_orders.php');exit;

                }

			

//会员后台

require_once(DEDEINC."/userlogin.class.php");



require_once(DEDEMEMBER."/inc/inc_archives_functions.php");





/*-------------

function _ShowForm(){  }

--------------*/

if(empty($dopost))

{

    $query = "SELECT * FROM `#@__channeltype` WHERE id='$channelid'; ";

    $cInfos = $dsql->GetOne($query);





    include(DEDEMEMBER."/templets/album_add.htm");

    exit();

}



/*------------------------------

function _SaveArticle(){  }

------------------------------*/

else if($dopost=='save')

{

    

    $cInfos = $dsql->GetOne("Select * From `#@__channeltype`  where id='$channelid'; ");

    $maxwidth = isset($maxwidth) && is_numeric($maxwidth) ? $maxwidth : 800;

    $pagepicnum = isset($pagepicnum) && is_numeric($pagepicnum) ? $pagepicnum : 12;

    $ddmaxwidth = isset($ddmaxwidth) && is_numeric($ddmaxwidth) ? $ddmaxwidth : 200;

    $prow = isset($prow) && is_numeric($prow) ? $prow : 3;

    $pcol = isset($pcol) && is_numeric($pcol) ? $pcol : 3;

    $pagestyle = in_array($pagestyle,array('1','2','3')) ? $pagestyle : 2;

    include(DEDEMEMBER.'/inc/pingjia_check.php');

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







    //保存到主表

$aid=$naid;

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

  

            $inquery = "INSERT INTO `#@__shopping`(`aid`,`typeid`,`username`,`arctitle`,`ip`,`ischeck`,`dtime`, `mid`,`bad`,`good`,`ftype`,`face`,`msg`,`imgurls`)

                   VALUES ('$aid','$typeid','$username','$arctitle','$ip','$ischeck','$dtime', '{$cfg_ml->M_ID}','0','0','$feedbacktype','$face','$msg','$imgurls'); ";

            $rs = $dsql->ExecuteNoneQuery($inquery);

            if(!$rs)

            {

                ShowMsg(' 发表评论错误! ', '-1');

                //echo $dsql->GetError();

                exit();

            }

	echo "4456";		exit;

    //增加积分

    //更新统计



    //生成HTML



    

    #api{{



}