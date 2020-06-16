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
$mid  = $cfg_ml->M_ID;

if(empty($mid)){
	header("Location: /member");
	exit();

}

$sql = "select a.*,b.typename,b.ico from #@__mytypestow a left join #@__arctype b on a.tid = b.id where a.mid = '$mid' order by a.time desc";

$dlist = new DataListCP();
$dlist->SetTemplate("templets/mybodan.htm");
$dlist->SetSource($sql);
$dlist->pageSize = 6;
$dlist->Display();