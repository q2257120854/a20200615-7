<?php


require_once 'globals.php';
include_once 'header.php';
$uid = isset($_GET['uid']) ? intval($_GET['uid']) : '';
$sql="select * from eruyi_user where uid=$uid";
$query=$db->query($sql);
$row=$db->fetch_array($query);





$money = isset($_POST['money']) ? intval($_POST['money']) : 0;
$regip = isset($_POST['regip']) ? addslashes($_POST['regip']) : '';
$password = isset($_POST['password']) ? addslashes($_POST['password']) : '';
$icode = isset($_POST['icode']) ? addslashes($_POST['icode']) : '';
$ive = isset($_POST['ive']) ? addslashes($_POST['ive']) : '';

$regcode = isset($_POST['regcode']) ? addslashes($_POST['regcode']) : '';
$superpass = isset($_POST['superpass']) ? addslashes($_POST['superpass']) : '';
$vip = isset($_POST['vip']) ? addslashes($_POST['vip']) : '';
$lock = isset($_POST['lock']) ? 'y' : 'n';
$submit = isset($_POST['submit']) ? addslashes($_POST['submit']) : '';
$is_admin = isset($_POST['is_admin']) ? addslashes($_POST['is_admin']) : '';

if($vip == ''){
    $vip = gmdate("Y-m-d H:i:s",time()+8*3600);
}
if($vip == '999999999'){
    $vip = '999999999';
}elseif($vip == '888888888'){
    $vip = '888888888';
}else{
    $vip = strtotime($vip);
}

if(strlen($password) > 1){
   $pass = md5($password);
   if(strlen($icode) > 0 && strlen($ive) > 0){
	    $sql="UPDATE `eruyi_user` SET `money`='$money',`".$icode."`='$ive',`is_admin`='$is_admin',`regip`='$regip',`password`='$pass',`superpass`='$superpass',`regcode`='$regcode',`lock`='$lock',`vip`='$vip' WHERE uid=$uid";
   }else{
	    $sql="UPDATE `eruyi_user` SET `money`='$money',`regip`='$regip',`password`='$pass',`is_admin`='$is_admin',`superpass`='$superpass',`regcode`='$regcode',`lock`='$lock',`vip`='$vip' WHERE uid=$uid";
   }
  
}else{
	if(strlen($icode) > 0 && strlen($ive) > 0){
	    $sql="UPDATE `eruyi_user` SET `money`='$money',`".$icode."`='$ive',`is_admin`='$is_admin',`regip`='$regip',`superpass`='$superpass',`regcode`='$regcode',`lock`='$lock',`vip`='$vip' WHERE uid=$uid";
   }else{
        $sql="UPDATE `eruyi_user` SET `money`='$money',`regip`='$regip',`is_admin`='$is_admin',`superpass`='$superpass',`regcode`='$regcode',`lock`='$lock',`vip`='$vip' WHERE uid=$uid";
   }
}

if($submit){
	
	$query=$db->query($sql);
	if($query){
		echo "<script>alert('编辑成功');location.href='adm_user.php';</script>";
	}
}
?>
   <div class="tpl-page-container tpl-page-header-fixed">


        <div class="tpl-left-nav tpl-left-nav-hover">
            <div class="tpl-left-nav-title">
                管理列表
            </div>
            <div class="tpl-left-nav-list">
                <ul class="tpl-left-nav-menu">
                    <li class="tpl-left-nav-item">
                        <a href="index.php" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-home"></i>
                            <span>首页</span>
                        </a>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="adm_user.php" class="nav-link active">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>用户管理</span>
                            <i class="tpl-left-nav-content tpl-badge-danger">
               
             </i>
                        </a>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="adm_message.php" class="nav-link">
                             <i class="fa fa-pencil-square" aria-hidden="true"></i>
                            <span>用户反馈</span>
                            <i class="tpl-left-nav-content tpl-badge-danger">
               
                           </i>
                        </a>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="add_user.php" class="nav-link tpl-left-nav-link-list">
                            <i class="fa fa-user-plus" aria-hidden="true"></i>
                            <span>添加用户</span>
                            <i class="tpl-left-nav-content tpl-badge-danger">
               
             </i>
                        </a>
                    </li>

                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                            <i class="fa fa-gear" aria-hidden="true"></i>
                            <span>配置中心</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu">
                            <li>
                                <a href="edit_sz.php">
                                    <i class="am-icon-angle-right"></i>
                                    <span>软件配置</span>
                                    
                                </a>
                              <a href="edit_zfgl.php">
                                    <i class="am-icon-angle-right"></i>
                                    <span>支付配置</span>
                                </a>
                                <a href="adm_set.php">
                                    <i class="am-icon-angle-right"></i>
                                    <span>注册管理</span>
                                </a>
                                <a href="edit_gg.php">
                                    <i class="am-icon-angle-right"></i>
                                    <span>广告管理</span>
		</a>

                            </li>
                        </ul>
                    </li>

                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list ">
                            <i class="fa fa-vimeo-square" aria-hidden="true"></i>
                            <span>卡密中心</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu">
                           <li>
                                <a href="adm_kami.php">
                                    <i class="am-icon-angle-right"></i>
                                    <span>卡密管理</span>
                                    
                                </a>

                                <a href="add_kami.php">
                                    <i class="am-icon-angle-right"></i>
                                    <span>卡密生成</span>
                                </a>

                                    <a href="out_kami.php">
                                       <i class="am-icon-angle-right"></i>
                                        <span>卡密导出</span>
                                    </a>

                                        <a href="del_kami.php">
                                            <i class="am-icon-angle-right"></i>
                                            <span>卡密清理</span>

                                        </a>
                            </li>
                        </ul>
                    </li>
                  
                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                           <i class="fa fa-play-circle" aria-hidden="true"></i>
                            <span>视频管理</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu">
                           <li>
                                <a href="shipin_sc.php">
                                    <i class="am-icon-angle-right"></i>
                                    <span>上传视频</span>
                                    
                                </a>
                                
                                <a href="shipin_data.php">
                                    <i class="am-icon-angle-right "></i>
                                    <span>视频管理</span>
                                    
                                </a>

                                <a href="shipin_fl.php">
                                    <i class="am-icon-angle-right"></i>
                                    <span>视频分类</span>
                                </a>
                            </li>
                        </ul>
                    </li>
  
                </ul>
            </div>
        </div>

        <div class="tpl-content-wrapper">
            <div class="tpl-content-page-title">
                用户管理
            </div>
            <ol class="am-breadcrumb">
                <li><a href="index.php" class="am-icon-home">首页</a></li>
                <li class="am-active">用户修改</li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> 用户修改
                    </div>
                </div>

 <div class="tpl-block">

    <div class="am-g">
        <div class="am-scrollable-horizontal" >
<form class="am-form"  action="" method="post" id="addimg" name="addimg">
<div id="post">
<div class="am-form-group">
    <label class="mdui-textfield-label"  for="user-name" id="username_label">用户账号：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="username" value="<?php echo $row['username'];?>" disabled id="username"/>
<?php if($row['vip']>time() || $row['vip']=='999999999'|| $row['vip']=='888888888'): ?> <font color=red>VIP</font><?php endif; ?>
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="user-name" id="username_label">修改密码：</label>
 <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="password" placeholder="密码" id="password"/>
</div>


<div class="am-form-group">
    <label class="mdui-textfield-label"  for="user-name" id="username_label">自定义修改变量：</label>
 <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="icode" placeholder="参数名" id="icode"/>
 <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="ive" placeholder="参数值" id="ive"/>
 
</div>





<div class="am-form-group">
    <label class="mdui-textfield-label"  for="user-name" id="username_label">会员时间：</label>
    <?php $vip = $row['vip']=='999999999' ? $row['vip']: gmdate("Y-m-d H:i:s",$row['vip']+8*3600); ?>
    <?php $vip = $row['vip']=='888888888' ? $row['vip']: gmdate("Y-m-d H:i:s",$row['vip']+8*3600); ?>
    <!--input type="text" class="input w50" name="vip" value="<?php echo $vip; ?>" id="vip" placeholder="请输入到期时间" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"/-->
    <input type="text" class="input w50" name="vip" value="<?php echo $vip; ?>" id="vip" placeholder="请输入到期时间"/>
<div class="tipss"> 现在时间：<?php echo gmdate("Y-m-d H:i:s",time()+8*3600)?> --- (或者填写999999999为永久会员，888888888为VIP代理)</div>
</div></div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="user-name" id="username_label">手机号码：</label>
 <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="superpass" value="<?php echo $row['superpass'];?>" id="superpass"/>
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="user-name" id="username_label">账户余额：</label>
 <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="money" value="<?php echo $row['money'];?>" id="money"/>
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="user-name" id="username_label">注册时间：</label>
 <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="regdate" value="<?php echo gmdate("Y-m-d H:i:s",$row['regdate']+8*3600); ?>" disabled id="regdate"/>
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="user-name" id="username_label">注册 I P：</label>
 <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="regip" value="<?php echo $row['regip'];?>" id="regip"/>
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="user-name" id="username_label">注册机器：</label>
 <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="regcode" value="<?php echo $row['regcode'];?>" id="regcode"/>
</div>
 <div class="am-form-group">
    <label class="mdui-textfield-label"  for="is_admin" id="is_admin_label">手机端管理员：</label>
<br>
    <input type="radio" name="is_admin" value="1" id="is_admin"<?php if($row['is_admin']=='1'):?> checked="checked"<?php endif; ?> />是
    <input type="radio" name="is_admin" value="0" id="is_admin"<?php if($row['is_admin']=='0'):?> checked="checked"<?php endif; ?> />否
</div>
<div class="am-form-group">
    <label class="mdui-textfield-label"  for="user-name" id="username_label">禁用账户：</label>
<div class="am-form-group">
 <input type="checkbox" name="lock" value="lock" id="lock"<?php if($row['lock']=='y'):?> checked="checked"<?php endif; ?> /> 勾选禁用该账户
</div></div>


<div class="am-form-group" id="post_button">
    <div class="am-u-sm-9">
    <input type="submit" name="submit" value="编辑保存" class="am-btn-primary" />
</div>
</div>
</div>
</form>
</div></div></div>
<script> 
var div = document.getElementById('adm_user'); 
div.setAttribute("class", "show"); 
</script> 
 <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/amazeui.min.js"></script>
    <script src="assets/js/iscroll.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>