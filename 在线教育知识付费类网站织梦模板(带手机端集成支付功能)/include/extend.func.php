<?php

//获取课程文章数

function jjKeCount($tid){

	global $dsql;

	$arr = $dsql->GetOne("select count(id) as dd  from #@__arctiny where typeid = '$tid' and arcrank > -2");

	if(empty($arr['dd'])){$arr['dd'] = "O";}

	return $arr['dd'];

}

 



//获取后台栏目的分类属性

function getTypeShuxing($v=''){

	global $dsql;

	$sql = "select typename from #@__arctype where reid = '212'";

	$dsql->Execute('me',$sql);

	$jg ='';

	while($arr = $dsql->GetArray('me'))

	{

		if($v == $arr['typename']){

			$f = ' checked="1" ';

		}else{

			$f = '';

		}

		$jg .= '<label style="margin-right:10px;"><input type="radio" name="fenlei" value="'.$arr['typename'].'" class="np"  '.$f.' />'.$arr['typename'].'</label>';

	}

	return $jg;

}





function litimgurls($imgid=0)

{	

    global $lit_imglist,$dsql;

    //获取附加表

    $row = $dsql->GetOne("SELECT c.addtable FROM #@__archives AS a LEFT JOIN #@__channeltype AS c 

                                                            ON a.channel=c.id where a.id='$imgid'");

    $addtable = trim($row['addtable']);

    

    //获取图片附加表imgurls字段内容进行处理

    $row = $dsql->GetOne("Select imgurls From `$addtable` where aid='$imgid'");

    

    //调用inc_channel_unit.php中ChannelUnit类

    $ChannelUnit = new ChannelUnit(2,$imgid);

    

    //调用ChannelUnit类中GetlitImgLinks方法处理缩略图

    $lit_imglist = $ChannelUnit->GetlitImgLinks($row['imgurls']);

    

    //返回结果

    return $lit_imglist;

}



//获取栏目信息

function jjGetTypename($tid){

	global $dsql;

	$trr = $dsql->GetOne("select typename from #@__arctype where id = '$tid'");

	if(empty($trr['typename'])){$trr['typename'] = '';}

	return $trr['typename'];



}



function GetTypeDeurl($tid){

	global $dsql;

$arr = $dsql->GetOne("select * from #@__arctype where id = '$tid'");

$jg =  GetOneTypeUrlA($arr);

return $jg;

}



function JJGetTypeList($page,$pagesize){

	global $dsql;	

	

	$s = ($page-1)*$pagesize;

	

	

	$sql = "select t.id,t.ico,t.typename,SUM(a.click) as click,t.price,count(a.id) as dd  from #@__arctype t left join #@__archives a on t.id = a.typeid 

	 where t.reid = '18' group by t.id order by t.sortrank asc limit $s,$pagesize ";

	

//var_dump($sql);	

	$dsql->Execute('me',$sql);

	$jg = '';

	while($arr = $dsql->GetArray('me'))

	{	 

	



$brr = $dsql->GetOne("select count(a.id) as num from #@__member_stow a left join #@__arctiny b on a.aid = b.id where b.typeid = '".$arr['id']."' ");

	

		if(empty($arr['ico'])){

			$ico = '/images/yxw-sc-bg.gif';

			}else{

			$ico = 'http://www.test.com'.$arr['ico'];

		}

		if(empty($arr['click'])){

			$arr['click'] = '0';

		}

		if($arr['click'] > 10000){

			$arr['click'] = number_format($arr['click']/10000,1).'万'; 

		}

		

		if(empty($arr['num'])){

			$arr['num'] = '0';

		}

		

		if($arr['num'] > 10000){

			$arr['num'] = number_format($arr['num']/10000,1).'万'; 

		}

		

		$jg .= '<li class="content_item">

<a href="'.GetTypeDeurl($arr['id']).'" class="link" title="'.$arr['typename'].'" target="_blank">

<img src="http://www.test.com/images/yxw-sc-bg.gif" data-original="'.$ico.'">

<em class="jishu">'.$arr['dd'].'集全</em>

<div class="main_title">'.$arr['typename'].'</div>

<p class="price" style="display:none">￥'.$arr['price'].'</p>

<div class="sub_title">'.$arr['click'].'次学习</div>

</a>

</li>';

}

return $jg;

}





function JJgetCliak($tid){

	global $dsql;

	$arr = $dsql->GetOne("select sum(click) as click from #@__archives where typeid = '$tid'");

	if(empty($arr['click'])){

			$arr['click'] = '0';

		}

		if($arr['click'] > 10000){

			$arr['click'] = number_format($arr['click']/10000,1).'万'; 

		}

	return $arr['click'];

}













function freemoney($money){

$key = $money;

	$jg = '';

		 if( $money == 0 )

        {$jg .='<span class="line-cell item-price free">  免费 </span>';}

else 

		{$jg .='<span class="line-cell item-price">'.$money.'金币</span>';}

  return $jg;

}

function aaarank($arcrank){

$key = $arcrank;

	$jg = '';

		 if( $arcrank == 100 )

        {$jg .='3';}

else if( $arcrank == 200 )

        {$jg .='2';}

else 

		{$jg .='1';}

  return $jg;

}



function shopgll($id){

$key = $id;

	global $dsql;

	$arr = $dsql->GetOne("SELECT shopgl from dede_addonshop where aid = '$id'");

	$aa = $arr['shopgl'];

//	echo $aa;

	$sql="SELECT arc.id,arc.shorttitle FROM `dede_archives` arc LEFT JOIN `dede_addonshop` ON arc.id = dede_addonshop.aid where dede_addonshop.shopgl = '$aa'";

$dsql->Execute('me2',$sql);

while($arr = $dsql->GetArray('me2'))

{ $aurl = GetOneArchive($arr['id']);

if ($arr['id'] == $key ){$dq =' cur';}else{$dq ='';}

 $jg .= '<li class="cate-item'.$dq.'"><a href="'.$aurl['arcurl'].'">'.$arr['shorttitle'].'</a></li>';

}/*	 if( $money == 0 )

        {$jg .='<span class="line-cell item-price free">  免费 </span>';}

else 

		{$jg .='<span class="line-cell item-price">  ￥'.$money.'.00 </span>';}*/

  return $jg;

}





function aaurl($id){

$key = $id;

 $aurl = GetOneArchive($id);

 $jg = $aurl['arcurl'];

  return $jg;

}

function Search_video($id,$result){    

global $dsql;    

$row4 = $dsql->GetOne("SELECT shrq FROM `dede_addonvideo` where aid='$id'");    

//dede_addonarticle17 请修改为您自己的表名称    

$name=$row4[$result];    

return $name;    

}  

function Search_shop($id,$result){    

global $dsql;    

$row4 = $dsql->GetOne("SELECT tdts,trueprice FROM `dede_addonshop` where aid='$id'");    

//dede_addonarticle17 请修改为您自己的表名称    

$name=$row4[$result];    

return $name;    

}   

function titleutf8($title){

$key = $title;

//return preg_replace("/\\\u([0-9a-f]{4})/ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '$1'))", json_encode($title));

//return iconv('GBK', 'UTF-8', $title);

//return json_encode(iconv('GBK', 'UTF-8', $title));

return json_encode($title);

  

 // return sprintf("%.2f", $sl);;

} 



function pinglunsu($id,$result){    

global $dsql;    

$all = $dsql->GetOne("Select count(id) as c from dede_feedback where aid='$id';");

//dede_addonarticle17 请修改为您自己的表名称    

 if($all['c'] < '1')

{

$name=" 0"; 

} else {$name=$all['c'];}return $name;    

}  

function goodsu($id,$result){    

global $dsql;    

$all = $dsql->GetOne("Select count(id) as c from dede_shopping where aid='$id';");

//dede_addonarticle17 请修改为您自己的表名称    

 if($all['c'] < '1')

{

$name="0 "; 

} else {$name=$all['c'];}

//$name=20; 

return $name;    

}  

function goodlv($id,$result){    

global $dsql;    

$all = $dsql->GetOne("Select count(id) as c from dede_shopping where aid='$id';");

$good = $dsql->GetOne("Select count(id) as c from dede_shopping where aid='$id' AND ftype='good';");

$hpl=round(($good['c']/$all['c'])*100);

   if($all['c'] < '1')

{

$name=100; 

}

else {  if($hpl < '1')

{$name=" 0"; }else{

$name=$hpl; }}

   

return $name;    

}  

/*

function hpt($id,$result){    

global $dsql;    

$row = $dsql->GetOne("SELECT imgurls FROM `dede_shopping` where id='$id'");  

  preg_match_all("/{dede:img (.*)}(.*){\/dede:img/isU", $row['imgurls'], $wordcount);

$count = count($wordcount[2]);

$num = $count;

$name .= "<div class=\"mall-item\"><ul class=\"clearfix\">";

if($num >0 )$name .= "<a href=\"http://www.duoweizi.net". trim($wordcount[2][0])."\" data-size=\"1600x1067\" data-med=\"http://www.duoweizi.net". trim($wordcount[2][0])."\" data-med-size=\"1024x683\"><img src=\"http://www.duoweizi.net". trim($wordcount[2][0])."\"/></a>";

if($num >1 )$name .= "<a href=\"http://www.duoweizi.net". trim($wordcount[2][1])."\" data-size=\"1600x1067\" data-med=\"http://www.duoweizi.net". trim($wordcount[2][1])."\" data-med-size=\"1024x683\"><img src=\"http://www.duoweizi.net". trim($wordcount[2][1])."\"/></a>";

if($num >2 )$name .= "<a href=\"http://www.duoweizi.net". trim($wordcount[2][2])."\" data-size=\"1600x1067\" data-med=\"http://www.duoweizi.net". trim($wordcount[2][2])."\" data-med-size=\"1024x683\"><img src=\"http://www.duoweizi.net". trim($wordcount[2][2])."\"/></a>";

$name .= "</ul></div>";

//dede_addonarticle17 请修改为您自己的表名称    

//$name=$all['c'];    

return $name;    

}  */



function memtu($mid){    

global $dsql;    

$memtu = $dsql->GetOne("Select face from dede_member where mid = $mid;");

if($memtu['face'] == ''){

            $face = '/uploads/dfboy.png';

        }

        else{

            $face = $memtu['face'];

        }



   

return $face;    

}  

function mstrup($now){    

$mst = str_replace("\"/uploads/","\"http://www.test.com/uploads/",$now);

return $mst;    

}  

function mstrone($noo){   

if(strstr($noo,"http"))

{

$mso =$noo;} 

else{

$mso = "http://www.test.com".$noo;}

return $mso;    

}





/*字符过滤函数*/

function wwwcms_filter($str,$stype="inject") {

	if ($stype=="inject")  {

		$str = str_replace(

		       array( "select", "insert", "update", "delete", "alter", "cas", "union", "into", "load_file", "outfile", "create", "join", "where", "like", "drop", "modify", "rename", "'", "/*", "*", "../", "./"),

			   array("","","","","","","","","","","","","","","","","","","","","",""),

			   $str);

	} else if ($stype=="xss") {

		$farr = array("/\s+/" ,

		              "/<(\/?)(script|META|STYLE|HTML|HEAD|BODY|STYLE |i?frame|b|strong|style|html|img|P|o:p|iframe|u|em|strike|BR|div|a|TABLE|TBODY|object|tr|td|st1:chsdate|FONT|span|MARQUEE|body|title|\r\n|link|meta|\?|\%)([^>]*?)>/isU", 

					  "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",

					  );

		$tarr = array(" ",

		              "",

					  "\\1\\2",

					  ); 

		$str = preg_replace($farr, $tarr, $str);

		$str = str_replace(

		       array( "<", ">", "'", "\"", ";", "/*", "*", "../", "./"),

			   array("&lt;","&gt;","","","","","","",""),

			   $str);

	}

	return $str;

}



/**

 *  载入自定义表单(用于发布)

 *

 * @access    public

 * @param     string  $fieldset  字段列表

 * @param     string  $loadtype  载入类型

 * @return    string

 */

 

function AddFilter($channelid, $type=1, $fieldsnamef, $defaulttid, $loadtype='autofield')

{

	global $tid,$dsql,$id;

	$tid = $defaulttid ? $defaulttid : $tid;

	if ($id!="")

	{

		$tidsq = $dsql->GetOne(" Select typeid From `#@__archives` where id='$id' ");

		$tid = $tidsq["typeid"];

	}

	$nofilter = (isset($_REQUEST['TotalResult']) ? "&TotalResult=".$_REQUEST['TotalResult'] : '').(isset($_REQUEST['PageNo']) ? "&PageNo=".$_REQUEST['PageNo'] : '');

	$filterarr = wwwcms_filter(stripos($_SERVER['REQUEST_URI'], "list.php?tid=") ? str_replace($nofilter, '', $_SERVER['REQUEST_URI']) : $GLOBALS['cfg_cmsurl']."/plus/list.php?tid=".$tid);

    $cInfos = $dsql->GetOne(" Select * From  `#@__channeltype` where id='$channelid' ");

	$fieldset=$cInfos['fieldset'];

	$dtp = new DedeTagParse();

    $dtp->SetNameSpace('field','<','>');

    $dtp->LoadSource($fieldset);

    $dede_addonfields = '';

    if(is_array($dtp->CTags))

    {

        foreach($dtp->CTags as $tida=>$ctag)

        {

            $fieldsname = $fieldsnamef ? explode(",", $fieldsnamef) : explode(",", $ctag->GetName());

			if(($loadtype!='autofield' || ($loadtype=='autofield' && $ctag->GetAtt('autofield')==1)) && in_array($ctag->GetName(), $fieldsname) )

            {

                $href1 = explode($ctag->GetName().'=', $filterarr);

				$href2 = explode('&', $href1[1]);

				$fields_value = $href2[0];

				$dede_addonfields .= '<div class="list-l">'.$ctag->GetAtt('itemname').'：</div>';

				switch ($type) {

					case 1:

						$dede_addonfields .= (preg_match("/&".$ctag->GetName()."=/is",$filterarr,$regm) ? '<div class="course-quanbu"><a title="全部" href="'.str_replace("&".$ctag->GetName()."=".$fields_value,"",$filterarr).'" class="link-qb">全部</a></div>' : '<li class="quanbu"><a class="link-0">全部</a></li>').'';

					

						$addonfields_items = explode(",",$ctag->GetAtt('default'));

						for ($i=0; $i<count($addonfields_items); $i++)

						{

							$href = stripos($filterarr,$ctag->GetName().'=') ? str_replace("=".$fields_value,"=".urlencode($addonfields_items[$i]),$filterarr) : $filterarr.'&'.$ctag->GetName().'='.urlencode($addonfields_items[$i]);//echo $href;

							$dede_addonfields .= ($fields_value!=urlencode($addonfields_items[$i]) ? '<li><a title="'.$addonfields_items[$i].'" href="'.$href.'" class="link">'.$addonfields_items[$i].'</a></li>' : '<li class="quanbu"><a class="link-0">'.$addonfields_items[$i].'</a></li>')."";

						}

						$dede_addonfields .= '';

					break;

					

					case 2:

						$dede_addonfields .= '<select name="filter"'.$ctag->GetName().' onchange="window.location=this.options[this.selectedIndex].value">

							'.'<option value="'.str_replace("&".$ctag->GetName()."=".$fields_value,"",$filterarr).'">全部</option>';

						$addonfields_items = explode(",",$ctag->GetAtt('default'));

						for ($i=0; $i<count($addonfields_items); $i++)

						{

							$href = stripos($filterarr,$ctag->GetName().'=') ? str_replace("=".$fields_value,"=".urlencode($addonfields_items[$i]),$filterarr) : $filterarr.'&'.$ctag->GetName().'='.urlencode($addonfields_items[$i]);

							$dede_addonfields .= '<option value="'.$href.'"'.($fields_value==urlencode($addonfields_items[$i]) ? ' selected="selected"' : '').'>'.$addonfields_items[$i].'</option>

							';

						}

						$dede_addonfields .= '</select><br/>

						';

					break;

				}

            }

        }

    }

	echo $dede_addonfields;

}













//文章点击数过万之后的显示效果

function click_round_number( $number, $min_value = 10000, $decimal = 1 ) {

    if( $number < $min_value ) {

        return $number;

    }

    $alphabets = array( 100000000 => '亿', 10000 => '万' );

    foreach( $alphabets as $key => $value )

    if( $number >= $key ) {

        return round( $number / $key, $decimal ) . '' . $value;

    }

}



function JJseoTitle($tid){

	global $dsql;

	$arr = $dsql->GetOne("select seotitle from #@__arctype where id = '$tid'");

	return $arr['seotitle'];	

}

function JJarctype($aid){

	global $dsql;

	$arr = $dsql->GetOne("select typeid from #@__archives where id = '$aid'");

	return $arr['typeid'];

}

//九戒织梦 2018年11月5日20:47:10

function JJtypeurl($tid){

	global $dsql;

$arr = $dsql->GetOne("select * from #@__arctype where id = '$tid'");

$jg =  GetOneTypeUrlA($arr);

return $jg;

}

//九戒织梦 获取文章列表

function  JJGetTYpeARcLIST($tid){

	global $dsql;

	$sql = "select a.id,a.title,b.spmm from #@__archives a left join #@__addonvideo b on a.id = b.aid where a.typeid = '$tid' order by a.pubdate desc";

	$dsql->Execute('me',$sql);

	$jg = '';

	while($arr = $dsql->GetArray('me'))

	{

		$jg .= '<li><a href="'.aaurl($arr['id']).'" class="jjdd'.$arr['id'].'">'.$arr['spmm'].'.'.$arr['title'].'</a></li>';

	}

	return $jg;

}

//九戒织梦 2019年2月24日16:20:06

function GetTypeDeurlformarr($arr){

	 

	$jg =  GetOneTypeUrlA($arr);

	return $jg;

}

function str_split_unicode($str, $l = 0) {

if ($l > 0) {

$ret = array();

$len = mb_strlen($str, "UTF-8");

for ($i = 0; $i < $len; $i += $l) {

$ret[] = mb_substr($str, $i, $l, "UTF-8");

}

return $ret;

}

return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);

}

