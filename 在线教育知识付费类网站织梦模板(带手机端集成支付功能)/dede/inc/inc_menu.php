<?php

/**

 * 后台管理菜单项

 *

 * @version        $Id: inc_menu.php 1 10:32 2010年7月21日Z tianya $

 * @package        DedeCMS.Administrator

 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.

 * @license        http://help.dedecms.com/usersguide/license.html

 * @link           http://www.yunziyuan.com.cn

 */

require_once(dirname(__FILE__)."/../config.php");



//载入可发布频道

$addset = '';



//检测可用的内容模型

if($cfg_admin_channel = 'array' && count($admin_catalogs) > 0)

{

    $admin_catalog = join(',', $admin_catalogs);

    $dsql->SetQuery(" SELECT channeltype FROM `#@__arctype` WHERE id IN({$admin_catalog}) GROUP BY channeltype ");

}

else

{

    $dsql->SetQuery(" SELECT channeltype FROM `#@__arctype` GROUP BY channeltype ");

}

$dsql->Execute();

$candoChannel = '';

while($row = $dsql->GetObject())

{

    $candoChannel .= ($candoChannel=='' ? $row->channeltype : ','.$row->channeltype);

}

if(empty($candoChannel)) $candoChannel = 1;

$dsql->SetQuery("SELECT id,typename,addcon,mancon FROM `#@__channeltype` WHERE id IN({$candoChannel}) AND id<>-1 AND isshow=1 ORDER BY id ASC");

$dsql->Execute();

while($row = $dsql->GetObject())

{

    $addset .= "  <m:item name='{$row->typename}' ischannel='1' link='{$row->mancon}?channelid={$row->id}' linkadd='{$row->addcon}?channelid={$row->id}' channelid='{$row->id}' rank='' target='main' />\r\n";

}

//////////////////////////



$adminMenu1 = $adminMenu2 = '';

if($cuserLogin->getUserType() >= 10)

{

    $adminMenu1 = "<m:top item='1_' name='频道模型' display='block' rank='t_List,t_AccList,c_List,temp_One'>

  <m:item name='内容模型管理' link='mychannel_main.php' rank='c_List' target='main' />

  <m:item name='单页文档管理' link='templets_one.php' rank='temp_One' target='main'/>

  <m:item name='自由列表管理' link='freelist_main.php' rank='c_List' target='main' />

  <m:item name='自定义表单' link='diy_main.php' rank='c_List' target='main' />

</m:top>

";

$adminMenu2 = "<m:top item='7_' name='模板管理' display='none' rank='temp_One,temp_Other,temp_MyTag,temp_test,temp_All'>

  <m:item name='默认模板管理' link='templets_main.php' rank='temp_All' target='main'/>

  <m:item name='标签源码管理' link='templets_tagsource.php' rank='temp_All' target='main'/>

  <m:item name='自定义宏标记' link='mytag_main.php' rank='temp_MyTag' target='main'/>

  <m:item name='智能标记向导' link='mytag_tag_guide.php' rank='temp_Other' target='main'/>

  <m:item name='全局标记测试' link='tag_test.php' rank='temp_Test' target='main'/>

</m:top>



<m:top item='10_' name='系统设置' display='none' rank='sys_User,sys_Group,sys_Edit,sys_Log,sys_Data'>

  <m:item name='系统基本参数' link='sys_info.php' rank='sys_Edit' target='main' />

  <m:item name='系统用户管理' link='sys_admin_user.php' rank='sys_User' target='main' />

  <m:item name='用户组设定' link='sys_group.php' rank='sys_Group' target='main' />

  <m:item name='数据库备份/还原' link='sys_data.php' rank='sys_Data' target='main' />

  <m:item name='SQL命令行工具' link='sys_sql_query.php' rank='sys_Data' target='main' />

  <m:item name='文件校验[S]' link='sys_verifies.php' rank='sys_verify' target='main' />

  <m:item name='病毒扫描[S]' link='sys_safetest.php' rank='sys_verify' target='main' />

  <m:item name='系统错误修复[S]' link='sys_repair.php' rank='sys_verify' target='main' />

</m:top>



<m:top item='10_6_' name='支付管理' display='none' rank='sys_Data'>

  <m:item name='支付接口设置' link='sys_payment.php' .php' rank='sys_Data' target='main' />

  <m:item name='会员价格设置' link='member_type.php' rank='sys_Data' target='main' />

  <m:item name='会员订单管理' link='member_operations.php' rank='sys_Data' target='main' />

  <m:item name='课程订单管理' link='shops_operations.php' rank='sys_Data' target='main' />


</m:top>

    ";

}

$remoteMenu = ($cfg_remote_site=='Y')? "<m:item name='远程服务器同步' link='makeremote_all.php' rank='sys_ArcBatch' target='main' />" : "";

$menusMain = "

-----------------------------------------------



<m:top item='1_' name='常用操作' display='block'>

  <m:item name='网站栏目管理' link='catalog_main.php' linkadd='catalog_add.php?listtype=all' rank='t_List,t_AccList' target='main' />

  <m:item name='所有档案列表' link='content_list.php' rank='a_List,a_AccList' target='main' />

  <m:item name='等审核的档案' link='content_list.php?arcrank=-1' rank='a_Check,a_AccCheck' target='main' />

  <m:item name='我发布的文档' link='content_list.php?mid=".$cuserLogin->getUserID()."' rank='a_List,a_AccList,a_MyList' target='main' />

  <m:item name='课程讨论区' link='feedback_main.php' rank='sys_Feedback' target='main' />

  <m:item name='提现申请' link='jjtixian.php' rank='sys_Feedback' target='main' />

  <m:item name='内容回收站' link='recycling.php' linkadd='archives_do.php?dopost=clear&aid=no&recycle=1' rank='a_List,a_AccList,a_MyList' target='main' />

</m:top>



<m:top item='1_' name='附件管理' display='none' rank='sys_Upload,sys_MyUpload,plus_文件管理器'>

  <m:item name='上传新文件' link='media_add.php' rank='' target='main' />

  <m:item name='附件数据管理' link='media_main.php' rank='sys_Upload,sys_MyUpload' target='main' />

  <m:item name='文件式管理器' link='media_main.php?dopost=filemanager' rank='plus_文件管理器' target='main' />

</m:top>



$adminMenu1







<m:top item='1_3_3' name='批量维护' display='block'>

  <m:item name='更新系统缓存' link='sys_cache_up.php' rank='sys_ArcBatch' target='main' />

  <m:item name='文档批量维护' link='content_batch_up.php' rank='sys_ArcBatch' target='main' />

  <m:item name='搜索关键词维护' link='search_keywords_main.php' rank='sys_Keyword' target='main' />

  <m:item name='文档关键词维护' link='article_keywords_main.php' rank='sys_Keyword' target='main' />

  <m:item name='重复文档检测' link='article_test_same.php' rank='sys_ArcBatch' target='main' />

  <m:item name='自动摘要|分页' link='article_description_main.php' rank='sys_Keyword' target='main' />

  <m:item name='TAG标签管理' link='tags_main.php' rank='sys_Keyword' target='main' />

  <m:item name='数据库内容替换' link='sys_data_replace.php' rank='sys_ArcBatch' target='main' />

</m:top>



<m:top item='5_' name='自动任务' notshowall='1'  display='block' rank='sys_MakeHtml'>

  <m:item name='一键更新电脑端' link='makehtml_all.php' rank='sys_MakeHtml' target='main' />

  <m:item name='一键更新手机端' link='makehtml_all_m.php' rank='sys_MakeHtml_m' target='main' />

  <m:item name='更新系统缓存' link='sys_cache_up.php' rank='sys_ArcBatch' target='main' />

  {$remoteMenu}

</m:top>



<m:top item='5_' name='HTML更新' notshowall='1' display='none' rank='sys_MakeHtml'>

  <m:item name='更新主页' link='makehtml_homepage.php' rank='sys_MakeHtml' target='main' />

  <m:item name='更新栏目' link='makehtml_list.php' rank='sys_MakeHtml' target='main' />

  <m:item name='更新文档' link='makehtml_archives.php' rank='sys_MakeHtml' target='main' />
  
  
  <m:item name='更新手机主页' link='makehtml_homepage_m.php' rank='sys_MakeHtml' target='main' />

  <m:item name='更新手机栏目' link='makehtml_list_m.php' rank='sys_MakeHtml' target='main' />

  <m:item name='更新手机文档' link='makehtml_archives_m.php' rank='sys_MakeHtml' target='main' />
    

  <m:item name='更新自由列表' link='freelist_main.php' rank='sys_MakeHtml' target='main' />

  <m:item name='更新单页列表' link='templets_one.php' rank='sys_MakeHtml' target='main' />

</m:top>



<m:top item='6_' name='会员管理' display='none' rank='member_List,member_Type'>

  <m:item name='会员注册管理' link='member_main.php' rank='member_List' target='main' />
  
 <m:item name='微信授权管理' link='member_login.php' rank='member_List' target='main' />
 
  <m:item name='会员级别设置' link='member_rank.php' rank='member_Type' target='main' />

  <m:item name='会员模型管理' link='member_model_main.php' rank='member_Type' target='main' />


</m:top>



$adminMenu2






-----------------------------------------------

";