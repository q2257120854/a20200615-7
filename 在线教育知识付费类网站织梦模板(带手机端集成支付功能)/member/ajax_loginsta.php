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

<div id="mainmenu">

<a href="<?php echo $cfg_memberurl; ?>/" class="link"><img src="<?php echo $facepic;?>" title="<?php echo $cfg_ml->M_UserName; ?>" width="40" height="40" class="hy-tx"></a>

<!-- 我是隐藏显示 -->
<div id="mainmenu2">

<i class="arrow"></i>

<!-- 我是父 -->
<div class="nav-login-bd">

<!-- 我是子 -->
<div class="nav-login-user">



<!-- 用户头像 -->
<div class="img"><a href="<?php echo $cfg_memberurl; ?>/" class="homeLink"><img src="<?php echo $facepic;?>"></a></div>
<!-- 用户头像 End -->



<!-- 用户帐号 -->
<div class="title-accProt">

<div class="title-accProt-span"><a href="<?php echo $cfg_memberurl; ?>/" title="<?php echo $cfg_ml->M_UserName; ?>"><?php echo $cfg_ml->M_UserName; ?></a></div>

<!-- 用户权限 -->
<?php if ($cfg_ml->M_Rank > 10){echo '<div class="yxw-vip-ico-1" title="VIP会员"></div>';} else{
echo '<div class="yxw-vip-ico-0" title="您还不是会员哦~"></div>';} ?>
<!-- 用户权限 End -->

</div>
<!-- 用户帐号 End -->



</div>
<!-- 我是子 End -->


<!-- 用户权限 -->
<?php if ($cfg_ml->M_Rank > 10){echo ' ';} else{
echo '<div class="micro-card-vip" style="text-align:center;"><a href="/member/buyhui.php">开通VIP会员<span style="color:#999;padding-left:5px;">全站课程免费学习</span></a></div>';} ?>
<!-- 用户权限 End -->


<!-- 用户导航 -->
<div class="nav-login-bottom">
<ul class="userFunList">
<li><a href="<?php echo $cfg_memberurl; ?>/operation_ke.php"><i class="userFunImg img-mytw"></i><p class="userFunTxt">已购课程</p></a></li>
<li><a href="<?php echo $cfg_memberurl; ?>/buyhui.php"><i class="userFunImg img-myhy"></i><p class="userFunTxt">我的会员</p></a></li>
<li><a href="<?php echo $cfg_memberurl; ?>/"><i class="userFunImg img-grzx"></i><p class="userFunTxt">个人中心</p></a></li>
</ul>
</div>
<!-- 用户导航 End -->


<!-- 退出帐号 -->
<div class="yxw-huiyuan" style="overflow:hidden;padding:0 38px;">
<a href="<?php echo $cfg_memberurl; ?>/index_do.php?fmdo=login&dopost=exit" class="nav-login-profile-Link">退出登录</a>
</div>
<!-- 退出帐号 End -->


</div>
<!-- 我是父 End -->

</div>
<!-- 我是隐藏显示 End -->

</div>