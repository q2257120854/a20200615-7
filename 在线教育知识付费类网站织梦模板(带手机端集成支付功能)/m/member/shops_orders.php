<?php 
/**
 * 商品订单
 * 
 * @version        $Id: shops_orders.php 1 8:38 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.yunziyuan.com.cn
 */
require_once(dirname(__FILE__)."/config.php");
include_once DEDEINC.'/datalistcp.class.php';
$menutype = 'dingdan';
$menutype_son = 'op';
if(!isset($dopost)) $dopost = '';

/**
 *  获取状态
 *
 * @access    public
 * @param     string  $sta  状态ID
 * @param     string  $oid  订单ID
 * @return    string
 */
function GetSta($sta,$oid)
{
    global $dsql;
    $row = $dsql->GetOne("SELECT p.name,s.kuaidi,s.kuaididan FROM #@__shops_orders AS s LEFT JOIN #@__payment AS p ON s.paytype=p.id WHERE s.oid='$oid'");
    if($sta==0)
    {
        return  $row['name'].'<span class="m-user-sep">|</span><a href="../plus/carbuyaction.php?dopost=memclickout&oid='.$oid.'" ><span style="color:#ff0000;">去付款</span></a>';
    } else if ($sta==1){
        return '等发货';
    } else if ($sta==2){
        return $row['kuaidi'].':'.$row['kuaididan'].'<a href="shops_products.php?do=ok&oid='.$oid.'">确认</a>';
    } else {
        return $row['kuaidi'].':'.$row['kuaididan'].'已完成';
    }
}
function ddcp($sta,$oid)
{
    global $dsql;
    $dsql->SetQuery("SELECT s.*,arc.litpic FROM #@__shops_products AS s LEFT JOIN #@__archives AS arc ON s.aid=arc.id WHERE s.oid='{$oid}' ORDER BY s.aid ASC");
 	$dsql->Execute();
//	$jg ='';
	while($row=$dsql->GetObject()){
//if($row->psta !=1){ $psta="<a class='btn-small btn-line-gray' href='pingjia.php?aid=".$row->aid."&oid".$row->oid."'>评价晒图".$row->psta."</a>";}
//if($row->ssta !=1){ $ssta="<a class='btn-small btn-line-gray' href='shouhou.php?aid=".$row->aid."&oid".$row->oid."' target='_blank'>申请退换货".$row->ssta."</a>";}

echo "
<div class=\"m-mall-mall\">
<a href=\"/plus/view.php?aid=".$row->aid."\">
<img src=\"".mstrone($row->litpic)."\">
<div class=\"m-mall-ming\">
<p class=\"m-mall-m-title\">".$row->title."</p>
</div>
</a>
</div>
<div class=\"m-user-dingdan-pl\" style=\"min-height:26px\">
<p class=\"price\" style=\"float:left;padding-left:10px;\">".$row->price."元 × ".$row->buynum."</p>";
if($row->psta!=1 and $sta > 1){echo "<a class='m-btn-small' href='pingjia.php?aid=".$row->aid."&oid=".$row->oid."'>评价晒图</a>";}else{/*echo "<a class='m-btn-small2'>已评价</a>";*/}
if($row->ssta!=1 and $sta > 1){echo "<a class='m-btn-small' href='shouhou.php?aid=".$row->aid."&oid=".$row->oid."'>申请退换货</a>";}else{/*echo "<a class='m-btn-small2'>已售后</a>";*/}

echo "</div>";
}
 // return $jg;

}
/*";
if($psta!=1){$jp .="<a class='btn-small btn-line-gray' href='pingjia.php?aid=".$row->aid."&oid".$row->oid."'>评价晒图</a>";}
if($ssta!=1){$jp .="<a class='btn-small btn-line-gray' href='shouhou.php?aid=".$row->aid."&oid".$row->oid."' target='_blank'>申请退换货</a>";}
$jp .="海纳百客 获取商品
function ddsp($key){
global $dsql,$cfg_puccache_time;	
$cachezihuiyuan = GetCache('ddsp', $key);
if($cachezihuiyuan== false  ){
 	//执行代码开始
	
	$dsql->SetQuery("SELECT mid,pubdate,count(*) FROM `#@__archives` where typeid='27' group by mid ORDER BY pubdate DESC limit 0,120");
	$dsql->Execute();
$i = 1;
$jg = '<li>';
	while($row=$dsql->GetObject()){
		$iiii++;
	$ac=$dsql->GetOne("select count(1) as num from dede_archives where mid='".$row->mid."'");
$fbs=$ac['num'] ;
	$pro=$dsql->GetOne("SELECT * FROM `#@__member` mem LEFT JOIN `#@__member_company` com ON mem.mid=com.mid where mem.mid='".$row->mid."'");
$product=$pro['product'] ;
$jg .= "<a href='/member/shopsInfo.php?mid=".$row->mid."' title='".$pro['company']."'>".$product."</a> ";
if($iiii%3==0){
$jg .= '</li><li>';
}
}
	SetCache('huoyuebang', $key, $jg, $cfg_datacachejj);
}else{
	$jg =  $cachezihuiyuan ;
}
$jg .= '</li>';
return $jg;
}*/
if($dopost=='')
{
  $sql = "SELECT s.*,t.consignee FROM #@__shops_orders  AS s left join `#@__shops_userinfo` AS t on t.oid=s.oid  WHERE s.userid='".$cfg_ml->M_ID."' ORDER BY s.stime DESC";
  $dl = new DataListCP();
  $dl->pageSize = 20;
  //这两句的顺序不能更换
  $dl->SetTemplate(dirname(__FILE__)."/templets/shops_orders.htm");      //载入模板
  $dl->SetSource($sql);            //设定查询SQL
  $dl->Display();                  //显示
} else if ($dopost=='del')
{
    $ids = explode(',',$ids);
    if(isset($ids) && is_array($ids))
    {
        foreach($ids as $id)
        {
            $id = preg_replace("/^[a-z][0-9]$/","",$id);
            $query = "DELETE FROM `#@__shops_products` WHERE oid='$id' AND userid='{$cfg_ml->M_ID}'";
            $query2 = "DELETE FROM `#@__shops_orders` WHERE oid='$id' AND userid='{$cfg_ml->M_ID}'";
            $query3 = "DELETE FROM `#@__shops_userinfo` WHERE oid='$id' AND userid='{$cfg_ml->M_ID}'";
            $dsql->ExecuteNoneQuery($query);
            $dsql->ExecuteNoneQuery($query2);
            $dsql->ExecuteNoneQuery($query3);
        }
        ShowMsg("成功删除指定的交易记录!","shops_orders.php");
        exit();
    }
}