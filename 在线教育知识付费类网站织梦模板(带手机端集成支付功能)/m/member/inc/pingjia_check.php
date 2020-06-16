<?php

/**

 * 文档验证

 * 

 * @version        $Id: archives_check.php 1 13:52 2010年7月9日Z tianya $

 * @package        DedeCMS.Member

 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.

 * @license        http://help.dedecms.com/usersguide/license.html

 * @link           http://www.yunziyuan.com.cn

 */

if(!defined('DEDEMEMBER'))    exit('dedecms');



include_once(DEDEINC.'/image.func.php');

include_once(DEDEINC.'/oxwindow.class.php');







$faqkey = isset($faqkey) && is_numeric($faqkey) ? $faqkey : 0;

$safe_faq_send = isset($safe_faq_send) && is_numeric($safe_faq_send) ? $safe_faq_send : 0;





$flag = '';

$autokey = $remote = $dellink = $autolitpic = 0;

$userip = GetIP();







$query = "Select tp.ispart,tp.channeltype,tp.issend,ch.issend as cissend,ch.sendrank,ch.arcsta,ch.addtable,ch.fieldset,ch.usertype

          From `#@__arctype` tp left join `#@__channeltype` ch on ch.id=tp.channeltype where tp.id='$typeid' ";

$cInfos = $dsql->GetOne($query);





//对保存的内容进行处理

$money = 0;

$flag = $shorttitle = $color = $source = '';

$sortrank = $senddate = $pubdate = time();

$title = cn_substrR(HtmlReplace($title,1),$cfg_title_maxlen);

$writer =  cn_substrR(HtmlReplace($writer,1),20);

if(empty($description)) $description = '';

$description = cn_substrR(HtmlReplace($description,1),250);

$keywords = cn_substrR(HtmlReplace($tags,1),30);

$mid = $cfg_ml->M_ID;



//处理上传的缩略图

$litpic = MemberUploads('litpic', '', $cfg_ml->M_ID, 'image', '', $cfg_ddimg_width, $cfg_ddimg_height, FALSE);

if($litpic!='') SaveUploadInfo($title,$litpic,1);



