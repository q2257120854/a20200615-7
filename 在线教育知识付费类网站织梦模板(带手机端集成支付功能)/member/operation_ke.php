<?php 
/**
 * 操作
 * 
 * @version        $Id: search.php 1 8:38 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.yunziyuan.com.cn
 */
require_once(dirname(__FILE__)."/config.php");
require_once(DEDEINC."/datalistcp.class.php");
CheckRank(0,0);
$menutype = 'mydede_ke';
$menutype_son = 'op';
setcookie("ENV_GOBACK_URL",GetCurUrl(),time()+3600,"/");
if(!isset($dopost)) $dopost = '';

/**
 *  获取状态
 *
 * @param     string  $sta  状态ID
 * @return    string
 */
function GetSta($sta){
    if($sta==0) return '未付款';
    else if($sta==1) return '已付款';
    else return '已完成';
}

if($dopost=='')
{
    $sql = "SELECT o.*,t.typename as pname,t.ico,t.id as tid FROM `#@__shops_orders` o left join #@__arctype t on o.pid = t.id  WHERE o.userid='".$cfg_ml->M_ID."' and o.state > 0 ORDER BY o.stime DESC";
    $dlist = new DataListCP();
    $dlist->pageSize = 10;
    $dlist->SetTemplate(DEDEMEMBER."/templets/operation_ke.htm");    
    $dlist->SetSource($sql);
    $dlist->Display(); 
}
else if($dopost=='del')
{
    $ids = preg_replace("#[^0-9,]#", "", $ids);
    $query = "DELETE FROM `#@__member_operation` WHERE aid IN($ids) AND mid='{$cfg_ml->M_ID}'";
    $dsql->ExecuteNoneQuery($query);
    ShowMsg("成功删除指定的交易记录!","operation.php");
    exit();
}