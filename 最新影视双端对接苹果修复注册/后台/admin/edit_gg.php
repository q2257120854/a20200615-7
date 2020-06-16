<?php
require_once 'globals.php';
include_once 'header.php';
$sql="select * from eruyi_peizhi where id=1";
$query=$db->query($sql);
$row=$db->fetch_array($query);

$ggms = isset($_POST['ggms']) ? intval($_POST['ggms']) : 0;
$guanggao = isset($_POST['guanggao']) ? addslashes($_POST['guanggao']) : '';
$guanggao2 = isset($_POST['guanggao2']) ? addslashes($_POST['guanggao2']) : '';
$guanggao3 = isset($_POST['guanggao3']) ? addslashes($_POST['guanggao3']) : '';
$guanggao4 = isset($_POST['guanggao4']) ? addslashes($_POST['guanggao4']) : '';
$guanggao5 = isset($_POST['guanggao5']) ? addslashes($_POST['guanggao5']) : '';
$guanggao6 = isset($_POST['guanggao6']) ? addslashes($_POST['guanggao6']) : '';
$submit = isset($_POST['submit']) ? addslashes($_POST['submit']) : '';
if($submit){
	$sql="UPDATE `eruyi_peizhi` SET `guanggao`='$guanggao',`guanggao2`='$guanggao2',`guanggao3`='$guanggao3',`guanggao4`='$guanggao4',`guanggao5`='$guanggao5',`guanggao6`='$guanggao6',`ggms`='$ggms' WHERE id=1";
	$query=$db->query($sql);
	if($query){
		echo "<script>alert('保存成功');location.href='edit_gg.php';</script>";
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
                                <a href="edit_sz.php" >
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

                                <a href="edit_gg.php" class="active">
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
                <li class="am-active">广告管理</li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> 广告管理
                    </div>
                </div>


                <div class="tpl-block">
                    <div class="am-g" >
                        <div class="am-scrollable-horizontal"  >
                            <div class="am-form-group"  >
<form class="am-form"  action="" method="post" id="addimg" name="addimg">
<div id="post">

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="username" id="username_label">广告模式：</label>
<br>
    <input type="radio" name="ggms" value="1" id="ggms"<?php if($row['ggms']=='1'):?> checked="checked"<?php endif; ?> />影视模式
    <input type="radio" name="ggms" value="0" id="ggms"<?php if($row['ggms']=='0'):?> checked="checked"<?php endif; ?>/>自定义模式
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="regcode" id="regcode_label">首页轮播广告：</label>
    <textarea  type="text" class="mdui-textfield-input mdui-col-md-11" style="height:100px;"  name="guanggao" id="guanggao"><?php echo $row['guanggao'];?> </textarea>广告图片大小：1280×424
</div>


<div class="am-form-group">
    <label class="mdui-textfield-label"  for="regcode" id="regcode_label">搜索轮播广告：</label>
    <textarea  type="text" class="mdui-textfield-input mdui-col-md-11" style="height:100px;"  name="guanggao2" id="guanggao2"><?php echo $row['guanggao2'];?> </textarea>广告图片大小：1280×424
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="regcode" id="regcode_label">代理轮播广告：</label>
    <textarea  type="text" class="mdui-textfield-input mdui-col-md-11" style="height:100px;"  name="guanggao3" id="guanggao3"><?php echo $row['guanggao3'];?> </textarea>广告图片大小：1280×424
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="regcode" id="regcode_label">播放页广告：</label>
    <textarea  type="text" class="mdui-textfield-input mdui-col-md-11" style="height:100px;"  name="guanggao4" id="guanggao4"><?php echo $row['guanggao4'];?> </textarea>广告图片大小：1280×424
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="regcode" id="regcode_label">广告5：</label>
    <textarea  type="text" class="mdui-textfield-input mdui-col-md-11" style="height:100px;"  name="guanggao5" id="guanggao5"><?php echo $row['guanggao5'];?> </textarea>广告图片大小：1280×424
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="regcode" id="regcode_label">启动页广告：</label>
    <textarea  type="text" class="mdui-textfield-input mdui-col-md-11" style="height:100px;"  name="guanggao6" id="guanggao6"><?php echo $row['guanggao6'];?> </textarea>广告图片大小：1280×424
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