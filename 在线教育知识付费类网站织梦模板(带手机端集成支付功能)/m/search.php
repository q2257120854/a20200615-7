<?php
/**
 *
 * 搜索页
 *
 * @version        $Id: search.php 1 15:38 2010年7月8日Z tianya $
 * @package        DedeCMS.Site
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.yunziyuan.com.cn
 */
 define('DEDEMOB', 'Y');
require_once(dirname(__FILE__)."/../include/common.inc.php");
require_once(DEDEINC."/arc.searchview.class.m.php");
if ( file_exists(DEDEINC."/baidusitemap.func.php") ) require_once(DEDEINC."/baidusitemap.func.php");
$pagesize = (isset($pagesize) && is_numeric($pagesize)) ? $pagesize : 8;
$typeid = (isset($typeid) && is_numeric($typeid)) ? $typeid : 0;
$channeltype = (isset($channeltype) && is_numeric($channeltype)) ? $channeltype : 0;
$kwtype = (isset($kwtype) && is_numeric($kwtype)) ? $kwtype : 0;
$mid = (isset($mid) && is_numeric($mid)) ? $mid : 0;
$mobile = (isset($mobile) && is_numeric($mobile)) ? $mobile : 0;
if ( $mobile==1 )
{
    define('DEDEMOB', 'Y');
}

if(!isset($orderby)) $orderby='';
else $orderby = preg_replace("#[^a-z]#i", '', $orderby);
if(!isset($searchtype)) $searchtype = 'titlekeyword';
else $searchtype = preg_replace("#[^a-z]#i", '', $searchtype);
if(!isset($keyword)){
    if(!isset($q)) $q = '';
    $keyword=$q;
}

$oldkeyword = $keyword = FilterSearch(stripslashes($keyword));
if ( function_exists('baidu_get_setting') )
{
    $site_id = baidu_get_setting('site_id');
    $lastuptime_all = baidu_get_setting('lastuptime_all');
    $addquery='';
    if ( $searchtype =='title' )
    {
        $addquery ='&stp=1';
    }
    // 需要提交全量索引后5个小时内才能够进行跳转
    if ( !empty($site_id) AND time()-$lastuptime_all>60*60*5)
    {
        $row = $dsql->GetOne("SELECT spwords FROM `#@__search_keywords` WHERE keyword='".addslashes($keyword)."'; ");
        if(!is_array($row))
        {
            $inquery = "INSERT INTO `#@__search_keywords`(`keyword`,`spwords`,`count`,`result`,`lasttime`)
          VALUES ('".addslashes($keyword)."', '".addslashes($keyword)."', '1', '0', '".time()."'); ";
            $dsql->ExecuteNoneQuery($inquery);
        }
        else
        {
            $dsql->ExecuteNoneQuery("UPDATE `#@__search_keywords` SET count=count+1,lasttime='".time()."' WHERE keyword='".addslashes($keyword)."'; ");
        }

        $keyword = urlencode($keyword);
        $baidu_search_url = "http://zhannei.baidu.com/cse/search?s={$site_id}&entry=1&q={$keyword}{$addquery}";
        header("Location:{$baidu_search_url}");
        exit;
    }
}

//查找栏目信息
if(empty($typeid))
{
    $typenameCacheFile = DEDEDATA.'/cache/typename.inc';
    if(!file_exists($typenameCacheFile) || filemtime($typenameCacheFile) < time()-(3600*24) )
    {
        $fp = fopen(DEDEDATA.'/cache/typename.inc', 'w');
        fwrite($fp, "<"."?php\r\n");
        $dsql->SetQuery("Select id,typename,channeltype From `#@__arctype`");
        $dsql->Execute();
        while($row = $dsql->GetArray())
        {
            $row['typename'] = HtmlReplace($row['typename']);
            fwrite($fp, "\$typeArr[{$row['id']}] = '{$row['typename']}';\r\n");
        }
        fwrite($fp, '?'.'>');
        fclose($fp);
    }
    //引入栏目缓存并看关键字是否有相关栏目内容
    require_once($typenameCacheFile);
    if(isset($typeArr) && is_array($typeArr))
    {
        foreach($typeArr as $id=>$typename)
        {
            //$keywordn = str_replace($typename, ' ', $keyword);
            $keywordn = $keyword;
            if($keyword != $keywordn)
            {
                $keyword = HtmlReplace($keywordn);
                $typeid = intval($id);
                break;
            }
        }
    }
}

$typeid = intval($typeid); $keyword = addslashes(cn_substr($keyword,30)); 

if($cfg_notallowstr !='' && preg_match("#".$cfg_notallowstr."#i", $keyword))
{
    ShowMsg("你的搜索关键字中存在非法内容，被系统禁止！","-1");
    exit();
}
if ($channeltype==1) {$typeid =6;}
if(($keyword=='' || strlen($keyword)<2) && empty($typeid))
{
    ShowMsg('关键字不能小于2个字节！','-1');
    exit();
}

//检查搜索间隔时间
$lockfile = DEDEDATA.'/time.lock.inc';
$lasttime = file_get_contents($lockfile);
/*
if(!empty($lasttime) && ($lasttime + $cfg_search_time) > time())
{
    ShowMsg('管理员设定搜索时间间隔为'.$cfg_search_time.'秒，请稍后再试！','-1');
    exit();
}
*/
//开始时间
if(empty($starttime)) $starttime = -1;
else
{
    $starttime = (is_numeric($starttime) ? $starttime : -1);
    if($starttime>0)
    {
       $dayst = GetMkTime("2008-1-2 0:0:0") - GetMkTime("2008-1-1 0:0:0");
       $starttime = time() - ($starttime * $dayst);
  }
}
$t1 = ExecTime();
$sp = new SearchView($typeid,$keyword,$orderby,$channeltype,$searchtype,$starttime,$pagesize,$kwtype,$mid);
$keyword = $oldkeyword;
$sp->Display();
PutFile($lockfile, time());
//echo ExecTime() - $t1;