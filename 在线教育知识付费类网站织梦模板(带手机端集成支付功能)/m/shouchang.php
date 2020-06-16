<?php
 
/**
 *
 * Ajax评论
 *
 * @version        $Id: feedback_ajax.php 1 15:38 2010年7月8日Z tianya $
 * @package        DedeCMS.Site
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.yunziyuan.com.cn
 */
require_once (dirname(__FILE__) . '/../include/common.inc.php');
require_once (DEDEINC . '/channelunit.func.php');
AjaxHead();
if ($cfg_feedback_forbid == 'Y') exit('系统已经禁止评论功能！');
$aid = intval($aid);
if (empty($aid)) exit('没指定评论文档的ID，不能进行操作！');
include_once (DEDEINC . '/memberlogin.class.php');
$cfg_ml = new MemberLogin();
if ($cfg_ml->M_ID == 0) {
    echo "<a href=\"/member/\" class=\"m-yxw-sc\"></a>";
    exit();
}
$arcRow = GetOneArchive($aid);
if ($arcRow['aid'] == '') {
    ShowMsg("无法收藏未知文档!", "javascript:window.close();");
    exit();
}
extract($arcRow, EXTR_SKIP);
$title = HtmlReplace($title, 1);
$aid = intval($aid);
$mid = $cfg_ml->M_ID;
$addtime = time();
if (empty($dopost)) $dopost = '';
//$stype = empty($stype);
$row = $dsql->GetOne("Select * From `#@__member_stow` where aid='$aid' And mid='$mid'");
if (!is_array($row) and $stype == 'good') {
    $dsql->ExecuteNoneQuery("INSERT INTO `#@__member_stow`(mid,aid,title,addtime,type) VALUES ('" . $cfg_ml->M_ID . "','$aid','" . addslashes($arctitle) . "','$addtime','bad'); ");
} else {
}
//	echo $mid;	//$stype = good;
/*----------------------
获得指定页的评论内容
function getlist(){ }
----------------------*/
if ($dopost == 'getlist') {
    shuju($stype);
    anniu($stype);
    //	echo $stype;
    exit();
}
function anniu($stype) {
    global $dsql, $aid, $mid;
    $row = $dsql->GetOne("Select * From `#@__member_stow` where aid='$aid' And mid='$mid'");
    if ($row['type'] == 'good') {
        echo "<a onclick=\"Loadxihuans('bad');\" class=\"m-yxw-sc m-yxw-sc-hover\"></a>";
    } else {
        echo "<a onclick=\"Loadxihuans('good');\" class=\"m-yxw-sc\"></a>";
    }
}
function shuju($stype) {
    global $dsql, $aid, $mid;
    //echo '123456';
    if ($stype == 'all') {
    } else {
        $time = time();
        if ($stype == 'good') {
            $dsql->ExecuteNoneQuery("UPDATE #@__member_stow SET `type`='$stype',`addtime`='$time' WHERE aid='$aid' And `mid`='$mid'");
        } else {
            $dsql->ExecuteNoneQuery("delete from #@__member_stow   WHERE aid='$aid' And `mid`='$mid'");
        }
    }
}

