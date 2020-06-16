<?php
set_time_limit(0);
require_once(dirname(__FILE__)."/config.php");
require_once(DEDEINC."/oxwindow.class.php");
require_once(DEDEINC."/channelunit.class.php");
require_once(DEDEINC."/baidusitemap.func.php");
require_once(DEDEINC."/baiduxml.class.php");

if(empty($dopost)) $dopost = '';
if(empty($action)) $action = '';
if(empty($sign)) $sign = '';
if(empty($type)) $type = 1;

check_installed();

$version = baidu_get_setting('version');
if (empty($version)) $version = '0.0.2';

if (version_compare($version, PLUS_BAIDUSITEMAP_VER, '<')) {
    $mysql_version = $dsql->GetVersion(TRUE);
    
    foreach ($update_sqls as $ver => $sqls) {
        if (version_compare($ver, $version,'<')) {
            continue;
        }
        foreach ($sqls as $sql) {
            $sql = preg_replace("#ENGINE=MyISAM#i", 'TYPE=MyISAM', $sql);
            $sql41tmp = 'ENGINE=MyISAM DEFAULT CHARSET='.$cfg_db_language;
            
            if($mysql_version >= 4.1)
            {
                $sql = preg_replace("#TYPE=MyISAM#i", $sql41tmp, $sql);
            }
            $dsql->ExecuteNoneQuery($sql);
        }
        baidu_set_setting('version', $ver);
        $version=baidu_get_setting('version');
    }
}

if($dopost=='auth'){
    if ( empty($sign) )
    {
	    $siteurl=$cfg_basehost;
        $sigurl="http://baidu.api.dedecms.com/index.php?siteurl=".urlencode($siteurl);
        $result = baidu_http_send($sigurl);
    	//var_dump($result);exit();
        $data = json_decode($result, true); 
        baidu_set_setting('siteurl', $data['siteurl']);
        baidu_set_setting('checksign', $data['checksign']);
        if($data['status']==0){
            $checkurl=$siteurl."{$cfg_plus_dir}/baidusitemap.php?dopost=checkurl&checksign=".$data['checksign'];

            $authurl="http://zz.baidu.com/api/opensitemap/auth?siteurl=".$data ['siteurl']."&checkurl=".urlencode($checkurl)."&checksign=".$data['checksign'];
            $authdata = baidu_http_send($authurl);
            $output = json_decode($authdata, true);
            if($output['status']==0){
                baidu_set_setting('pingtoken', $output['token']);
                $sign = md5($data['siteurl'].$output['token']);
                ShowMsg('成功同百度站点API完成通信，下面进行索引提交……','?dopost=auth&sign='.$sign.'&action='.$action);
            } else {
                ShowMsg("提交百度索引失败，无法校验本地密钥！远程接口服务器无法正常获取到您的站点文件！ <a href='http://www.dedecms.com/addons/baidusitemap/#help' target='_blank'>点击获取更多帮助</a>","javascript:;");
                exit();
            }
        }
    } else {
        $siteurl = baidu_get_setting('siteurl');
        $type=1;
        $old_bdpwd = baidu_get_setting('bdpwd');
        if($action=='resubmit')
        {
            baidu_delsitemap($siteurl,1,$sign);
            baidu_set_setting('setupmaxaid',0);
            baidu_set_setting('bdpwd','');
            $old_bdpwd='';
        }
        
        if(empty($old_bdpwd))
        {
            $bdpwd = baidu_gen_sitemap_passwd();
            baidu_set_setting('bdpwd', $bdpwd);
            $sign = md5($siteurl.$output['token']);
            //提交全量索引
            $type=1;
            $allreturnjson = baidu_savesitemap('save',$siteurl, 1, $bdpwd, $sign);
            $allresult = json_decode($allreturnjson['json'], true);
            baidu_set_setting('lastuptime_all', time());
        } else {
            //提交增量索引
            $type=2;
            $sign = md5($siteurl.$output['token']);
            baidu_delsitemap($siteurl,2,$sign);
            $row = $dsql->GetOne("SELECT count(*) as dd FROM `#@__plus_baidusitemap_list` where type=2");
            
            $allreturnjson = baidu_savesitemap('save',$siteurl, 2, $old_bdpwd, $sign);
            $allresult = json_decode($allreturnjson['json'], true);
            baidu_set_setting('lastuptime_inc', time());
        }
        if(0==$allresult['status'])
        {
            ShowMsg("百度站内索引分析完成，进入提交页完成索引提交……","?dopost=submit&type=".$type);
            exit();
        } else {
            ShowMsg("提交百度索引失败","?");
            exit();
        }
        
    }
} elseif ( $dopost=='submit' )
{
    $bdpwd = baidu_get_setting('bdpwd');
    if(empty($bdpwd))
    {
        $bdpwd = baidu_gen_sitemap_passwd();
        baidu_set_setting('bdpwd', $bdpwd);
    }

    $siteurl = baidu_get_setting('siteurl');
    $token = baidu_get_setting('pingtoken');
    $sign=md5($siteurl.$token);
    $bdpwd=addslashes($bdpwd);
    if (1 == $type) {
        $script = 'indexall';
        $stype = 'all';
    } else if (2 == $type) {
        $script = 'indexinc';
        $stype = 'inc';
    }
    $indexurl = $siteurl."{$cfg_plus_dir}/baidusitemap.php?dopost=sitemap_urls&pwd={$bdpwd}&type={$type}";
    $submiturl="http://zz.baidu.com/api/opensitemap/savesitemap?siteurl=".urlencode($siteurl)."&indexurl=".urlencode($indexurl)."&tokensign=".urlencode($sign)."&type={$stype}&resource_name=CustomSearch_Normal";
    $rat = baidu_http_send($submiturl);
    $query = "UPDATE `#@__plus_baidusitemap_list` SET `isok` = '1'";
    $rs = $dsql->ExecuteNoneQuery($query);
    ShowMsg("成功提交所有索引！","?");
    exit();
} elseif ( $dopost=='searchbox2' || $dopost=='searchpage2' || $dopost=='income2' || $dopost=='report2')
{
    $site_id = baidu_get_setting('site_id');
    if ( empty($site_id) )
    {
        ShowMsg("尚未绑定站点ID，请先绑定再进行操作……","?dopost=bind_site_id");
        exit();
    }
    $arr['searchbox2']['title']="搜索框管理";
    $arr['searchbox2']['url']="http://zn.baidu.com/cse/searchbox2/index?sid={$site_id}";
    $arr['searchpage2']['title']="结果页管理";
    $arr['searchpage2']['url']="http://zn.baidu.com/cse/searchpage2/index?sid={$site_id}";
    $arr['income2']['title']="获得收入";
    $arr['income2']['url']="http://zn.baidu.com/cse/income2/index?sid={$site_id}";
    $arr['report2']['title']="数据报表";
    $arr['report2']['url']="http://zn.baidu.com/cse/report2/index?sid={$site_id}";
    if ( !isset($arr[$dopost]) )
    {
        exit('error!');
    }
    $str = <<<EOT
<script type="text/javascript" src="http://baidu.api.dedecms.com/assets/js/jquery.min.js"></script>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>百度站内搜索</title>
		<link rel="stylesheet" type="text/css" href="css/base.css">
	</head>
	<body background='images/allbg.gif' leftmargin="8" topmargin='8'>
		<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#DFF9AA" height="100%">
			<tr>
				<td height="28" style="border:1px solid #DADADA" background='images/wbg.gif'>
					<div style="float:left">&nbsp;<b>◇<a href="?">◇百度站内搜索 》结构化数据提交::索引管理</b>
					</div>
					<div style="float:right;margin-right:20px;">
					</div>
				</td>
			</tr>
			<tr>
				<td width="100%" height="100%" valign="top" bgcolor='#ffffff' style="padding-top:5px">
					<table width='100%' border='0' cellpadding='3' cellspacing='1' bgcolor='#DADADA' height="100%">
						<tr bgcolor='#DADADA'>
							<td colspan='2' background='images/wbg.gif' height='26'><font color='#666600'><b>{$arr[$dopost]['title']}</b></font>
							</td>
						</tr>
						<tr bgcolor='#FFFFFF'>
							<td colspan='2' height='100%' style='padding:20px'>
								<br/>
								<iframe src="{$arr[$dopost]['url']}" scrolling="auto" width="100%" height="100%" style="border:none"></iframe>
							</td>
						</tr>
						<tr>
							<td bgcolor='#F5F5F5'>&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<p align="center">
			<br>
			<br>
		</p>
	</body>

</html>
EOT;
    echo $str;exit;
} elseif($dopost=='viewsub')
{
    $query="SELECT * FROM `#@__plus_baidusitemap_list` ORDER BY sid DESC";
    $dsql->SetQuery($query);
    $dsql->Execute('dd');
    $liststr="";
    while($arr=$dsql->GetArray('dd'))
    {
        $typestr=$arr['type']==1?'[全量]':'[增量]';
        $arr['isok'] = $arr['isok']==0? '<font color="red">未提交</font>' : '<font color="green">已提交</font>';
        $arr['create_time'] = Mydate('Y-m-d H:m:i',$arr['create_time']);
        $liststr.=<<<EOT
<tr align="center" bgcolor="#FFFFFF" height="26" onmousemove="javascript:this.bgColor='#FCFDEE';" onmouseout="javascript:this.bgColor='#FFFFFF';">
			<td>{$typestr}
			</td>
			<td><a href="{$arr['url']}" target="_blank">{$arr['url']}</a>
			</td>
			<td>{$arr['create_time']}</td>
			</td>
		</tr>
EOT;
    }
    //返回成功信息
    $msg = <<<EOT
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6">
	<tbody>
		<tr align="center" bgcolor="#FBFCE2" height="26">
			<td width="8%">类型</td>
			<td width="30%">地址</td>
			<td width="15%">提交时间</td>
		</tr>
		 {$liststr}
		
		<tr bgcolor="#ffffff" height="28">
			<td colspan="5">　 
			</td>
		</tr>

	</tbody>
</table>
   
EOT;
    $msg = "<div style=\"line-height:20px;\">    {$msg}</div><script type=\"text/javascript\">
function isGoUrl(url,msg)
{
	if(confirm(msg))
	{
		window.location.href=url;
	} else {
		return false;
	}
}
</script>";

    $wintitle = '索引列表管理';
    $wecome_info = '<a href=\'baidusitemap_main.php\'>百度站内搜索</a> 》结构化数据提交::索引管理';
    $win = new OxWindow();
    $win->AddTitle($wintitle);
    $win->AddMsgItem($msg);
    $winform = $win->GetWindow('hand', '&nbsp;', false);
    $win->Display();
} elseif ( $dopost=='bind_site_id' )
{
	$siteurl=$cfg_basehost;
    $sigurl="http://baidu.api.dedecms.com/index.php?siteurl=".urlencode($siteurl);
    $result = baidu_http_send($sigurl);
	//var_dump($result);exit();
    $data = json_decode($result, true); 
    baidu_set_setting('siteurl', $data['siteurl']);
    baidu_set_setting('checksign', $data['checksign']);
    if($data['status']==0){
        $checkurl=$siteurl."{$cfg_plus_dir}/baidusitemap.php?dopost=checkurl&checksign=".$data['checksign'];

        $authurl="http://zz.baidu.com/api/opensitemap/auth?siteurl=".$data ['siteurl']."&checkurl=".urlencode($checkurl)."&checksign=".$data['checksign'];
        $authdata = baidu_http_send($authurl);
        $output = json_decode($authdata, true);
        if($output['status']==0){
            baidu_set_setting('pingtoken', $output['token']);
            $sign = md5($data['siteurl'].$output['token']);
            //$site=$siteurl."{$cfg_plus_dir}/baidusitemap.php?dopost=site_id&checksign=".$data['checksign'];
            $u = "http://zhanzhang.baidu.com/api/cooperation/cse?tokensign={$sign}&site={$data['siteurl']}";
            $login_url='https://passport.baidu.com/v2/?login&tpl=zhanzhang&u='.urlencode($u);
            //echo $login_url;exit;
            header('Location:'.$login_url);
            exit;
        } else {
            ShowMsg("无法校验本地密钥，远程接口服务器无法正常获取到您的站点文件！ <a href='http://www.dedecms.com/addons/baidusitemap/#help' target='_blank'>点击获取更多帮助</a>","javascript:;");
            exit();
        }
    }
} elseif ( $dopost=='ping1' )
{
    $sigurl="http://baidu.api.dedecms.com/index.php";
    $authdata = baidu_http_send($sigurl);
    $output = json_decode($authdata, true);
    if ( $output['status']==1 )
    {
        ShowMsg("通信正常！",-1);
        exit();
    } else {
        ShowMsg("无法连接：您的服务器无法正常连接'http://baidu.api.dedecms.com'，请确保服务器环境支持远程获取文件。<a href='http://www.dedecms.com/addons/baidusitemap/#help' target='_blank'>点击获取更多帮助</a>",'javascript:;');
        exit();
    }
} elseif ( $dopost=='ping2' )
{
    $sigurl="http://zhanzhang.baidu.com/api/opensitemap/deletesitemap";
    $authdata = baidu_http_send($sigurl);
    //$output = json_decode($authdata, true);
    if ( $output['status']==1 )
    {
        ShowMsg("通信正常！",-1);
        exit();
    } else {
        ShowMsg("无法连接：您的服务器无法正常连接'http://zhanzhang.baidu.com/api'，请确保服务器环境支持远程获取文件。<a href='http://www.dedecms.com/addons/baidusitemap/#help' target='_blank'>点击获取更多帮助</a>",'javascript:;');
        exit();
    }
} elseif ( $dopost=='bind' )
{
    $site_id = baidu_get_setting('site_id');
    if ( !empty($site_id) )
    {
        ShowMsg("当前站点已经绑定site_id，无需重复绑定",-1);
        exit();
    }
    $site_id_msg = '<font color="red">尚未绑定站点ID，请点击</font><a href="?dopost=bind_site_id" style="color:blue">[绑定站点ID]</a><font color="red">完成绑定</font>';
    $siteurl = baidu_get_setting('siteurl');
    $ver = PLUS_BAIDUSITEMAP_VER;
    $siteurl2 = urlencode($siteurl);
    $msg = <<<EOT
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#DADADA">
	<tbody>
		<tr bgcolor="#FFFFFF">
			<td colspan="2" height="100">
				<table width="98%" border="0" cellspacing="1" cellpadding="1">
					<tbody>
						<tr>
							<td width="16%" height="30">模块版本：</td>
							<td width="84%" style="text-align:left;"><span style='color:black'><iframe name='stafrm' src='http://baidu.api.dedecms.com/index.php?c=welcome&m=new_ver&ver={$ver}&siteurl={$siteurl2}&setupmaxaid={$setupmaxaid}' frameborder='0' id='stafrm' width='98%' height='22'></iframe></span>
							</td>
						</tr>
						<tr>
							<td width="16%" height="30">站点地址：</td>
							<td width="84%" style="text-align:left;"><span style='color:black'>{$siteurl}{$site_id_msg}</span>
							</td>
						</tr>
						<tr>
							<td width="16%" height="30">织梦接口地址：</td>
							<td width="84%" style="text-align:left;"><span style='color:black'>http://baidu.api.dedecms.com</span> <a href='?dopost=ping1' style='color:blue'><u>[检查通信]</u></a>
							</td>
						</tr>
						<tr>
							<td width="16%" height="30">百度接口地址：</td>
							<td width="84%" style="text-align:left;"><span style='color:black'>http://zhanzhang.baidu.com/api/</span> <a href='?dopost=ping2' style='color:blue'><u>[检查通信]</u>
							</td>
						</tr>

		</tr>

		<tr>
			<td height="30" colspan="2" style="color:#999"><strong>百度站内搜索</strong>百度站内搜索旨在帮助站长低成本地为网站用户提供高质量的网站内搜索服务。使用百度站内搜索工具，您可以轻松打造网站专属的搜索引擎，自定义个性化的展现样式、功能模块等，并通过搜索广告获得收入。</td>
		</tr>
		</tbody>
		</table>
		</td>
		</tr>
		<tr>
			<td bgcolor="#F5F5F5">&nbsp;</td>
		</tr>
	</tbody>
</table>
EOT;
    $msg = "<div style=\"line-height:36px;\">{$msg}</div><script type=\"text/javascript\">
function isGoUrl(url,msg)
{
	if(confirm(msg))
	{
		window.location.href=url;
	} else {
		return false;
	}
}
</script>";

    $wintitle = '百度站内搜索';
    $wecome_info = '百度站内搜索 》';
    $win = new OxWindow();
    $win->AddTitle($wintitle);
    $win->AddMsgItem($msg);
    $winform = $win->GetWindow('hand', '&nbsp;', false);
    $win->Display();
}

 else {
    //返回成功信息
    $siteurl = baidu_get_setting('siteurl');
    $setupmaxaid = baidu_get_setting('setupmaxaid');
    $lastuptime_all = date('Y-m-d',baidu_get_setting('lastuptime_all'));
    $lastuptime_inc = date('Y-m-d',baidu_get_setting('lastuptime_inc'));
    $site_id = baidu_get_setting('site_id');
    if ( empty($site_id) )
    {
        header('location:?dopost=bind');
        exit;
    }
    $site_id_msg=$submitall_msg='';
    if ( empty($site_id) )
    {
        $site_id_msg = '<font color="red">尚未绑定站点ID，请点击</font><a href="?dopost=bind_site_id" style="color:blue">[绑定站点ID]</a><font color="red">完成绑定</font>';
    }
    if ( !empty($site_id) AND empty($lastuptime_all) )
    {
        //header('location:?dopost=auth&action=resubmit');
        //exit;
        $submitall_msg = '<font color="red">尚未提交全量索引，点击</font><a href="?dopost=auth&action=resubmit" style="color:blue">[提交全量索引]</a><font color="red">进行提交，提交5个小时后才有搜索结果</font>';
    }
    
    $bdarcs = new BaiduArticleXml;
    $bdarcs->setSitemapType(1);
    $maxaid = $bdarcs->getMaxAid();
    $ver = PLUS_BAIDUSITEMAP_VER;
    $siteurl2 = urlencode($siteurl);
    $msg = <<<EOT
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#DADADA">
	<tbody>
		<tr bgcolor="#FFFFFF">
			<td colspan="2" height="100">
				<table width="98%" border="0" cellspacing="1" cellpadding="1">
					<tbody>
						<tr>
							<td width="16%" height="30">模块版本：</td>
							<td width="84%" style="text-align:left;"><span style='color:black'><iframe name='stafrm' src='http://baidu.api.dedecms.com/index.php?c=welcome&m=new_ver&ver={$ver}&siteurl={$siteurl2}&setupmaxaid={$setupmaxaid}' frameborder='0' id='stafrm' width='98%' height='22'></iframe></span>
							</td>
						</tr>
						<tr>
							<td width="16%" height="30">站点地址：</td>
							<td width="84%" style="text-align:left;"><span style='color:black'>{$siteurl}</span>
							</td>
						</tr>
						<tr>
							<td width="16%" height="30">绑定站点ID：</td>
							<td width="84%" style="text-align:left;">	<span style='color:black'>{$site_id}</span>{$site_id_msg}
								<br />
							</td>
						</tr>
						<tr>
							<td width="16%" height="30">最后提交文档ID：</td>
							<td width="84%" style="text-align:left;">	<span style='color:black'>{$setupmaxaid} {$submitall_msg}</span>
							</td>
						</tr>
						<tr>
							<td width="16%" height="30">当前文档最新ID：</td>
							<td width="84%" style="text-align:left;">	<span style='color:black'>{$maxaid}</span>
							</td>
						</tr>
		</tr>
		<tr>
			<td width="16%" height="30">增量索引最后提交：</td>
			<td width="84%" style="text-align:left;">	<span style='color:black'>{$lastuptime_inc}</span>
			</td>
		</tr>
		</tr>
		<tr>
			<td width="16%" height="30">全量索引最后提交：</td>
			<td width="84%" style="text-align:left;">	<span style='color:black'>{$lastuptime_all}</span>
			</td>
		</tr>
		<tr>
			<td height="30" colspan="2"><b>您可以进行以下操作：</b></td>
		</tr>
		<tr>
			<td height="30" colspan="2"> <a href='javascript:isGoUrl("baidusitemap_main.php?dopost=auth","是否确定提交增量索引？");' style='color:blue'><u>[提交增量索引]</u></a>
 <a href='javascript:isGoUrl("baidusitemap_main.php?dopost=auth&action=resubmit","是否确定重新提交全量索引？");' style='color:blue'><u>[重新提交全量索引]</u></a>
 <a href='baidusitemap_main.php?dopost=searchbox2' style='color:blue'><u>[搜索框管理]</u></a>
 <a href='baidusitemap_main.php?dopost=searchpage2' style='color:blue'><u>[结果页管理]</u></a>
 <a href='baidusitemap_main.php?dopost=income2' style='color:blue'><u>[获得收入]</u></a>
					<a
					href='baidusitemap_main.php?dopost=report2' style='color:blue'><u>[数据报表]</u>
						</a>
			</td>
		</tr>
		<tr>
			<td height="30" colspan="2">
				<hr>功能说明：
				<br>在对应模板中使用标签：<font color="red">{dede:baidusitemap/}</font>，直接进行调用即可，样式设定可点击<a href="baidusitemap_main.php?dopost=searchbox2" style="color:blue">[搜索框管理]</a> 进行设置。
				<hr>功能说明：
				<br> <b>[提交增量索引]</b>用于提交更新频率较频繁的索引，一般是全量索引提交完成后，每次更新少量内容后进行增量索引提交；
				<br> <b>[重新提交全量索引]</b>重新对全站的百度索引进行提交；
				<br> <b>[搜索框管理]</b>管理搜索框的模板样式；
				<br> <b>[结果页管理]</b>您可以在“结果页管理”页面，对搜索结果页的顶部、频道、样式模板、筛选排序等功能进行设置；
				<br> <b>[获得收入]</b>通过将站内搜索与百度联盟账户相关联，您将有机会获得广告收入；
				<br> <b>[数据报表]</b>查看站内搜索数据统计报表；
				<br>
				<br>
				<hr>
			</td>
		</tr>
		<tr>
			<td height="30" colspan="2" style="color:#999"><strong>百度站内搜索</strong>百度站内搜索旨在帮助站长低成本地为网站用户提供高质量的网站内搜索服务。使用百度站内搜索工具，您可以轻松打造网站专属的搜索引擎，自定义个性化的展现样式、功能模块等，并通过搜索广告获得收入。</td>
		</tr>
		</tbody>
		</table>
		</td>
		</tr>
		<tr>
			<td bgcolor="#F5F5F5">&nbsp;</td>
		</tr>
	</tbody>
</table>
EOT;
    $msg = "<div style=\"line-height:36px;\">{$msg}</div><script type=\"text/javascript\">
function isGoUrl(url,msg)
{
	if(confirm(msg))
	{
		window.location.href=url;
	} else {
		return false;
	}
}
</script>";

    $wintitle = '百度站内搜索';
    $wecome_info = '百度站内搜索 》';
    $win = new OxWindow();
    $win->AddTitle($wintitle);
    $win->AddMsgItem($msg);
    $winform = $win->GetWindow('hand', '&nbsp;', false);
    $win->Display();
}

