<?php
/**
 * 我的收藏夹
 * 
 * @version        $Id: mystow.php 1 8:38 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.yunziyuan.com.cn
 */
session_start();
$user_agent = $_SERVER['HTTP_USER_AGENT'];
if(strpos($user_agent,'appClient') !== false || isset($_GET['isApp'])){ 
 $_SESSION['isApp'] = 1;
}

require_once(dirname(__FILE__)."/config.php");
require_once(DEDEINC."/datalistcp.class.php");
setcookie("ENV_GOBACK_URL",GetCurUrl(),time()+3600,"/");
$type = empty($type)? "sys" : trim($type);
$tpl = '';
$menutype = 'mystow';
$rank = empty($rank)? "" : $rank;
if($rank == 'top'){
    $sql = "SELECT s.*,COUNT(s.aid) AS num,t.*  from #@__member_stow AS s LEFT JOIN `#@__member_stowtype` AS t on t.stowname=s.type group by s.aid order by num desc";
    $tpl = 'stowtop';
}else{
    $sql = "SELECT s.*,t.*,arc.shorttitle,arc.litpic,arc.source,arc.title as title FROM `#@__member_stow` AS s left join `#@__addonvideo` AS v on v.aid=s.aid left join `#@__member_stowtype` AS t on t.stowname=s.type  left join `#@__archives` AS arc on arc.id=s.aid  where s.mid='".$cfg_ml->M_ID."'   AND s.type ='good' order by s.addtime desc";
    $tpl = 'mystow';
}

$dsql->Execute('nn','SELECT indexname,stowname FROM `#@__member_stowtype`');
while($row = $dsql->GetArray('nn'))
{
    $rows[]=$row;
}

$dlist = new DataListCP();
$dlist->pageSize = 8;
$dlist->SetTemplate("templets/$tpl.htm");
$dlist->SetSource($sql);
$dlist->Display();