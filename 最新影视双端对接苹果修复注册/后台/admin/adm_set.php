<?php
require_once 'globals.php';
include_once 'header.php';
$sql="select * from eruyi_peizhi where id=1";
$query=$db->query($sql);
$row=$db->fetch_array($query);

$iptime = isset($_POST['iptime']) ? addslashes($_POST['iptime']) : '';
$codetime = isset($_POST['codetime']) ? addslashes($_POST['codetime']) : '';
$regvip = isset($_POST['regvip']) ? addslashes($_POST['regvip']) : '';
$invvip = isset($_POST['invvip']) ? addslashes($_POST['invvip']) : '';
$dqrenshu = isset($_POST['dqrenshu']) ? addslashes($_POST['dqrenshu']) : '';
$zstime = isset($_POST['zstime']) ? addslashes($_POST['zstime']) : '';
$dqrenshu2 = isset($_POST['dqrenshu2']) ? addslashes($_POST['dqrenshu2']) : '';
$zstime2 = isset($_POST['zstime2']) ? addslashes($_POST['zstime2']) : '';


$submit = isset($_POST['submit']) ? addslashes($_POST['submit']) : '';
if($submit){
	$sql="UPDATE `eruyi_peizhi` SET `iptime`='$iptime',`codetime`='$codetime',`regvip`='$regvip',`invvip`='$invvip',`dqrenshu`='$dqrenshu',`zstime`='$zstime',`dqrenshu2`='$dqrenshu2',`zstime2`='$zstime2' WHERE id=1";
	$query=$db->query($sql);
	if($query){
		echo "<script>alert('保存成功');location.href='adm_set.php';</script>";
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
                        <a href="adm_user.php" class="nav-link tpl-left-nav-link-list">
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
                        <a href="add_user.php" class="nav-link tpl-left-nav-link-list ">
                             <i class="fa fa-user-plus" aria-hidden="true"></i>
                            <span>添加用户</span>
                            <i class="tpl-left-nav-content tpl-badge-danger">
               
             </i>
                        </a>
                    </li>


                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list active">
                           <i class="fa fa-gear" aria-hidden="true"></i>
                            <span>配置中心</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu" style="display: block;">
                            <li>
                                <a href="edit_sz.php">
                                    <i class="am-icon-angle-right"></i>
                                    <span>软件配置</span>
                                    
                                </a>
                              <a href="edit_zfgl.php">
                                    <i class="am-icon-angle-right"></i>
                                    <span>支付配置</span>
                                </a>

                                <a href="adm_set.php" class="active" >
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
                    
                </ul>

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
                配置中心
            </div>
            <ol class="am-breadcrumb">
                <li><a href="index.php" class="am-icon-home">首页</a></li>
                <li class="am-active">注册管理</li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> 注册管理
                    </div>
                  


                </div>




                <div class="tpl-block">

                    <div class="am-g" >
                        <div class="am-scrollable-horizontal"  >
                            <div class="am-form-group"  >
<form class="am-form"  action="" method="post" id="addimg" name="addimg">
<div id="post">

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="iptime" id="iptime_label">限制IP注册：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="iptime" value="<?php echo $row['iptime'];?>" id="iptime"/>（单位：小时，设0关闭。如：设置8，那么同一个IP注册需要等待8小时后才能再次注册）
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="codetime" id="codetime_label">限制机器码：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="codetime" value="<?php echo $row['codetime'];?>" id="codetime"/>（单位：小时，设0关闭。如：设置8，那么同一个机器码需要等待8小时后才能再次注册）
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="regvip" id="regvip_label">赠注册VIP：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="regvip" value="<?php echo $row['regvip'];?>" id="regvip"/>（单位：小时，设0关闭，如：设置8，那么新用户注册后会获得8小时的VIP体验时间）
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="invvip" id="invvip_label">邀请奖励VIP：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="invvip" value="<?php echo $row['invvip'];?>" id="invvip"/>（单位：小时，设0关闭，如：设置8，那么用户A邀请用户B成功注册后会获得8小时的VIP时间奖励）
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="dqrenshu" id="dqrenshu_label">①当邀请人为：</label>
    <input  type="text" class="mdui-textfield-input mdui-col-md-11" name="dqrenshu" value="<?php echo $row['dqrenshu'];?>" id="dqrenshu" />
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="zstime" id="zstime_label">送体验VIP时间：</label>
    <input type="text" class="mdui-textfield-input mdui-col-md-11" name="zstime"  value="<?php echo $row['zstime'];?>"  id="zstime"/>（单位：小时，设0关闭，如：设置8，那么邀请人数达到上面的邀请人数会获得8小时的VIP时间奖励）
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="dqrenshu2" id="dqrenshu2_label">②当邀请人为：</label>
    <input  type="text" class="mdui-textfield-input mdui-col-md-11" name="dqrenshu2"  value="<?php echo $row['dqrenshu2'];?>" id="dqrenshu2"/>
</div>
<div class="am-form-group">
    <label class="mdui-textfield-label"  for="zstime2" id="zstime2_label">送体验VIP时间：</label>
    <input class="mdui-textfield-input mdui-col-md-11" type="text" name="zstime2" value="<?php echo $row['zstime2'];?>" id="zstime2"/>（单位：小时，设0关闭，如：设置8，那么邀请人数达到上面的邀请人数会获得8小时的VIP时间奖励）
</div>

<div id="post_button">
    <input  type="submit" name="submit" value="保存设置" class="am-btn-primary" />
</div>
</div>
</form>
  </div>
                        </div>
                    </div>
                </div>


            </div>
<script> 
var div = document.getElementById('add_user'); 
div.setAttribute("class", "show"); 
</script> 
   <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/amazeui.min.js"></script>
    <script src="assets/js/iscroll.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>