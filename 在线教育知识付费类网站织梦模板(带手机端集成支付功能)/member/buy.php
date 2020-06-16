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
$menutype = 'jinbi';
$yujb = (isset($yujb) && is_numeric($yujb) ? $yujb : 100);

$menutype_son = 'op';
$myurl = $cfg_basehost.$cfg_member_dir.'/index.php?uid='.$cfg_ml->M_LoginID;
if ($cfg_ml->M_Rank >11)	{$yikai= "style='display:none;'";}else{$yikai='';}
$moneycards = '';
$membertypes = '';
$dsql->SetQuery("SELECT * FROM #@__moneycard_type ");
$dsql->Execute();
while($row = $dsql->GetObject())
{
    $row->money = sprintf("%01.2f", $row->money);
    $moneycards .= "<tr align='center'>
    <td><input type='radio' name='pid' value='{$row->tid}'></td>
    <td><strong>{$row->pname}</strong></td>
    <td>{$row->money}元</td>
    </tr>
    ";
}
$dsql->SetQuery("SELECT #@__member_type.*,#@__arcrank.membername,#@__arcrank.money as cm From #@__member_type LEFT JOIN #@__arcrank on #@__arcrank.rank = #@__member_type.rank ");
$dsql->Execute();
while($row = $dsql->GetObject())
{
    $row->money = sprintf("%01.2f", $row->money); 
    $membertypes .= "<tr align='center'>
    <td><input type='radio' name='pid' value='{$row->aid}'></td>
    <td><strong>{$row->pname}</strong></td>
    <td>{$row->money}元</td>
    </tr>
    ";
}
$tpl = new DedeTemplate();
$tpl->LoadTemplate(DEDEMEMBER.'/templets/buy.htm');
$tpl->Display();