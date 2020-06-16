<?php
/**
 * @version        $Id: buy.php 1 8:38 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.yunziyuan.com.cn
 */
require_once(dirname(__FILE__).'/config.php');
CheckRank(0,0);
$menutype = 'buyhui';
$yujb = (isset($yujb) && is_numeric($yujb) ? $yujb : 100);
$menutype_son = 'op';



// 新加的VIP会员页面-会员剩余时间显示-不需要的话完全可以去掉
$uid=empty($uid)? "" : RemoveXSS($uid); 
if(empty($action)) $action = '';
if(empty($aid)) $aid = '';
$hnbkjf = $dsql->GetOne("SELECT * FROM `#@__member` WHERE mid='".$cfg_ml->M_ID."'; ");
$mhasDay = $hnbkjf['exptime'] - ceil((time() - $hnbkjf['uptime'])/3600/24)+1;
if($hnbkjf['rank'] > 10 && $mhasDay < 1)
{
$dsql->ExecuteNoneQuery("UPDATE `#@__member` SET rank='10',uptime='0',exptime='0' WHERE mid='".$cfg_ml->M_ID."'  ");
$mhasDay =0;
}    
if ($mhasDay < 1)$mhasDay =0;
$zcsj = ceil((time() - $hnbkjf['jointime'])/3600/24)+1;
$hydj = $dsql->GetOne("SELECT membername FROM `#@__arcrank` WHERE rank='".$cfg_ml->M_Rank."'; ");
// End




$myurl = $cfg_basehost.$cfg_member_dir.'/index.php?uid='.$cfg_ml->M_LoginID;
if ($cfg_ml->M_Rank >11)	{$yikai= "style='display:none;'";}else{$yikai='';}
$moneycards = '';
$membertypes = '';
$dsql->SetQuery("SELECT * FROM #@__moneycard_type ");
$dsql->Execute();
while($row = $dsql->GetObject())
{
    $row->money = sprintf( $row->money);
    $moneycards .= "<tr align='center'>
    <td><input type='radio' name='pid' value='{$row->tid}'></td>
    <td><strong>{$row->pname}</strong></td>
    <td>{$row->exptime}天</td>
    <td>{$row->money}元</td>
    </tr>
    ";
}
$dsql->SetQuery("SELECT #@__member_type.*,#@__arcrank.membername,#@__arcrank.money as cm From #@__member_type LEFT JOIN #@__arcrank on #@__arcrank.rank = #@__member_type.rank ");
$dsql->Execute();
while($row = $dsql->GetObject())
{
    $row->money = sprintf( $row->money); 
    $membertypes .= "<tr align='center'>
    <td><input type='radio' name='pid' value='{$row->aid}'></td>
    <td><strong>{$row->pname}</strong></td>
    <td>{$row->exptime}天</td>
    <td>{$row->money}元</td>
    </tr>
    ";
}
$tpl = new DedeTemplate();
$tpl->LoadTemplate(DEDEMEMBER.'/templets/buyhui.htm');
$tpl->Display();