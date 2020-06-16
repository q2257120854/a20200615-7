<?php

/**

 *

 * 自定义表单

 *

 * @version        $Id: diy.php 1 15:38 2010年7月8日Z tianya $

 * @package        DedeCMS.Site

 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.

 * @license        http://help.dedecms.com/usersguide/license.html

 * @link           http://www.yunziyuan.com.cn

 */
session_start();
$user_agent = $_SERVER['HTTP_USER_AGENT'];
if(strpos($user_agent,'APICloud') !== false || isset($_GET['isApp'])){ 
 $_SESSION['isApp'] = 1;
}
require_once(dirname(__FILE__)."/../include/common.inc.php");



$diyid = isset($diyid) && is_numeric($diyid) ? $diyid : 0;

$action = isset($action) && in_array($action, array('post', 'list', 'view')) ? $action : 'post';

$id = isset($id) && is_numeric($id) ? $id : 0;



if(empty($diyid))

{

    showMsg('非法操作!', 'javascript:;');

    exit();

}



require_once DEDEINC.'/diyform.cls.php';

$diy = new diyform($diyid);



/*----------------------------

function Post(){ }

---------------------------*/

if($action == 'post')

{

    if(empty($do))

    {

        $postform = $diy->getForm(true);

        include DEDEROOT."/templets/plus/{$diy->postTemplate}";

        exit();

    }

    elseif($do == 2)

    {

        $dede_fields = empty($dede_fields) ? '' : trim($dede_fields);






//判断手机号码是否正确
if(!eregi("^1[0-9]{10}$",$yxwlxfs))
{
 showMsg('手机号不对，请正确填写', '-1');
 exit();
}

//增加必填字段判断
if($required!=''){
if(preg_match('/,/', $required))
{
$requireds = explode(',',$required);
foreach($requireds as $field){
if($$field==''){
showMsg('您的建议哪里去啦~', '-1');
exit();
}
}
}else{
if($required==''){
showMsg('您的建议哪里去啦~', '-1');
exit();
}
}
}
//end







        $dede_fieldshash = empty($dede_fieldshash) ? '' : trim($dede_fieldshash);

        if(!empty($dede_fields))

        {

            if($dede_fieldshash != md5($dede_fields.$cfg_cookie_encode))

            {

                showMsg('数据校验不对，程序返回', '-1');

                exit();

            }

        }

        $diyform = $dsql->getOne("select * from #@__diyforms where diyid='$diyid' ");

        if(!is_array($diyform))

        {

            showmsg('自定义表单不存在', '-1');

            exit();

        }






//检测游客是否已经提交过表单
if(isset($_COOKIE['VOTE_MEMBER_IP']))
{
if($_COOKIE['VOTE_MEMBER_IP'] == $_SERVER['REMOTE_ADDR'])
{
ShowMsg('~不要重复提交哦~','-1');
exit();
} else {
setcookie('VOTE_MEMBER_IP',$_SERVER['REMOTE_ADDR'],time()*$row['spec']*3600,'/');
}
} else {
setcookie('VOTE_MEMBER_IP',$_SERVER['REMOTE_ADDR'],time()*$row['spec']*3600,'/');
}






        $addvar = $addvalue = '';



        if(!empty($dede_fields))

        {



            $fieldarr = explode(';', $dede_fields);

            if(is_array($fieldarr))

            {

                foreach($fieldarr as $field)

                {

                    if($field == '') continue;

                    $fieldinfo = explode(',', $field);

                    if($fieldinfo[1] == 'textdata')

                    {

                        ${$fieldinfo[0]} = FilterSearch(stripslashes(${$fieldinfo[0]}));

                        ${$fieldinfo[0]} = addslashes(${$fieldinfo[0]});

                    }

                    else

                    {

                        ${$fieldinfo[0]} = GetFieldValue(${$fieldinfo[0]}, $fieldinfo[1],0,'add','','diy', $fieldinfo[0]);

                    }

                    $addvar .= ', `'.$fieldinfo[0].'`';

                    $addvalue .= ", '".${$fieldinfo[0]}."'";

                }

            }



        }



        $query = "INSERT INTO `{$diy->table}` (`id`, `ifcheck` $addvar)  VALUES (NULL, 0 $addvalue); ";



        if($dsql->ExecuteNoneQuery($query))

        {

            $id = $dsql->GetLastID();

            if($diy->public == 2)

            {

                //diy.php?action=view&diyid={$diy->diyid}&id=$id

                $goto = "diy.php?action=list&diyid={$diy->diyid}";

                $bkmsg = '发布成功，现在转向表单列表页...';

            }

            else

            {

                $goto = !empty($cfg_cmspath) ? $cfg_cmspath : '/member/';
                $goto = '/member/';
                $bkmsg = '意见反馈成功';

            }
            ShowMsg($bkmsg,$goto,0,1000);
            //showmsg($bkmsg, $goto);

        }

    }

}

/*----------------------------

function list(){ }

---------------------------*/

else if($action == 'list')

{

    if(empty($diy->public))

    {

        showMsg('后台关闭前台浏览', 'javascript:;');

        exit();

    }

    include_once DEDEINC.'/datalistcp.class.php';

    if($diy->public == 2)

        $query = "SELECT * FROM `{$diy->table}` ORDER BY id DESC";

    else

        $query = "SELECT * FROM `{$diy->table}` WHERE ifcheck=1 ORDER BY id DESC";



    $datalist = new DataListCP();

    $datalist->pageSize = 10;

    $datalist->SetParameter('action', 'list');

    $datalist->SetParameter('diyid', $diyid);

    $datalist->SetTemplate(DEDEINC."/../templets/plus/{$diy->listTemplate}");

    $datalist->SetSource($query);

    $fieldlist = $diy->getFieldList();

    $datalist->Display();

}

else if($action == 'view')

{

    if(empty($diy->public))

    {

        showMsg('后台关闭前台浏览' , 'javascript:;');

        exit();

    }



    if(empty($id))

    {

        showMsg('非法操作！未指定id', 'javascript:;');

        exit();

    }

    if($diy->public == 2)

    {

        $query = "SELECT * FROM {$diy->table} WHERE id='$id' ";

    }

    else

    {

        $query = "SELECT * FROM {$diy->table} WHERE id='$id' AND ifcheck=1";

    }

    $row = $dsql->GetOne($query);



    if(!is_array($row))

    {

        showmsg('你访问的记录不存在或未经审核', '-1');

        exit();

    }



    $fieldlist = $diy->getFieldList();

    include DEDEROOT."/templets/plus/{$diy->viewTemplate}";

}