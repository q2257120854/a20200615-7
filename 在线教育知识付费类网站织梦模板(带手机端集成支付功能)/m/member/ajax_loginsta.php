<?php
/**
 * @version        $Id: ajax_loginsta.php 1 8:38 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.yunziyuan.com.cn
 */
require_once(dirname(__FILE__)."/config.php");
require_once DEDEINC.'/shopcar.class.php';
AjaxHead();
if($myurl == '') exit('');
$uid  = $cfg_ml->M_LoginID;
!$cfg_ml->fields['face'] && $face = ($cfg_ml->fields['sex'] == '女')? 'dfgirl' : 'dfboy';
$facepic = empty($face)? $cfg_ml->fields['face'] : $GLOBALS['cfg_memberurl'].'/templets/images/'.$face.'.png';
       $pms = $dsql->GetOne("SELECT COUNT(*) AS nums FROM #@__member_pms WHERE toid='{$cfg_ml->M_ID}' AND `hasview`=0 AND folder = 'inbox'");
$cart = new MemberShops();
?>

<a href="<?php echo $cfg_memberurl; ?>/index.php" class="m-link"><img src="<?php echo $cfg_ml->fields['face']=mstrone($cfg_ml->fields['face']); ?>" title="<?php echo $cfg_ml->M_UserName; ?>"></a>