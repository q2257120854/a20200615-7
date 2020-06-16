<?php
/**
 *
 * 文档统计
 *
 * 如果想显示点击次数,请增加view参数,即把下面ＪＳ调用放到文档模板适当位置
 * <script src="{dede:field name='phpurl'/}/count.php?view=yes&aid={dede:field name='id'/}&mid={dede:field name='mid'/}" language="javascript"></script>
 * 普通计数器为
 * <script src="{dede:field name='phpurl'/}/count.php?aid={dede:field name='id'/}&mid={dede:field name='mid'/}" language="javascript"></script>
 *
 * @version        $Id: count.php 1 20:43 2010年7月8日Z tianya $
 * @package        DedeCMS.Site
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.yunziyuan.com.cn
 */
require_once(dirname(__FILE__)."/../../include/common.inc.php");
if(isset($aid)) $arcID = $aid;

//$type = empty($type)? 1 : intval(preg_replace("/[^-\d]+[^\d]/",'', $type));
$arcID = $aid = empty($arcID)? 0 : intval(preg_replace("/[^\d]/",'', $arcID));
$maintable = '#@__archives';$idtype='id';
if($aid==0) exit();

//获得频道模型ID
if($cid < 0)
{
    $row = $dsql->GetOne("SELECT addtable FROM `#@__channeltype` WHERE id='$cid' AND issystem='-1';");
    $maintable = empty($row['addtable'])? '' : $row['addtable'];
    $idtype='aid';
}
$mid = (isset($mid) && is_numeric($mid)) ? $mid : 0;
$all = $dsql->GetOne("Select count(id) as c from dede_feedback where aid='$aid';");
$good = $dsql->GetOne("Select count(id) as c from dede_feedback where aid='$aid' AND ftype='good';");
//UpdateStat();
 if ($type == 'nokuo'){   echo $all['c']; exit();}
else if ($type == 'all'){   echo $all['c']; exit();}
else{
$hpl=round(($good['c']/$all['c'])*100);
    if($all['c'] < '1')
    {
        echo 100;
    }
	else {        echo $hpl;
}}
exit();