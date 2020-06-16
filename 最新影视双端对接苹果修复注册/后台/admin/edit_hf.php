<?php

require_once 'globals.php';
include_once 'header.php';
$uid = isset($_GET['uid']) ? intval($_GET['uid']) : '';
$sql="select * from cl_message where uid=$uid";
$query=$db->query($sql);
$row=$db->fetch_array($query);

$hftxt = isset($_POST['hftxt']) ? addslashes($_POST['hftxt']) : '';
$hftime = time();
$submit = isset($_POST['submit']) ? addslashes($_POST['submit']) : '';
if($submit){
	$sql="UPDATE `cl_message` SET `hftxt`='$hftxt', `hftime`='$hftime' WHERE uid=$uid";
	$query=$db->query($sql);
	if($query){
		echo "<script>alert('回复成功');location.href='adm_message.php';</script>";
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
                        <a href="adm_user.php" class="nav-link ">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>用户管理</span>
                            <i class="tpl-left-nav-content tpl-badge-danger">
               
             </i>
                        </a>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="adm_message.php" class="nav-link active">
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
                用户反馈
            </div>
            <ol class="am-breadcrumb">
                <li><a href="index.php" class="am-icon-home">首页</a></li>
                <li class="am-active">反馈回复</li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> 反馈回复
                    </div>
                </div>

 <div class="tpl-block">

    <div class="am-g">
        <div class="am-scrollable-horizontal" >
        <div class="am-form-group"  >
<form class="am-form"  action="" method="post" id="addimg" name="addimg">
<div id="post">

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="txt" id="txt_label"><font color=red><?php echo $row['username'];?></font>&nbsp;反馈的问题&nbsp;&nbsp;时间:<?php echo gmdate("Y-m-d H:i:s",$row['time']+8*3600);?> </label>
    <li  type="text" class="mdui-textfield-input mdui-col-md-11" style="height:100px;"  name="gonggao" id="txt"><?php echo $row['txt'];?> </li>
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="hftxt" id="hftxt_label">回复内容：</label>
    <textarea  type="text" class="mdui-textfield-input mdui-col-md-11" style="height:100px;"  name="hftxt" id="hftxt"><?php echo $row['hftxt'];?> </textarea>
</div>




<div class="am-form-group" id="post_button">
    <div class="am-u-sm-9">
    <input type="submit" name="submit" value="确认回复" class="am-btn-primary" />
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
