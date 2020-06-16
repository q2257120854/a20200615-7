<?php
require_once 'globals.php';
include_once 'header.php';
$sql="select * from eruyi_peizhi where id=1";
$query=$db->query($sql);
$row=$db->fetch_array($query);

$yzfid = isset($_POST['yzfid']) ? addslashes($_POST['yzfid']) : '';
$yzfkey = isset($_POST['yzfkey']) ? addslashes($_POST['yzfkey']) : '';
$yzfurl = isset($_POST['yzfurl']) ? addslashes($_POST['yzfurl']) : '';

$pay_type = isset($_POST['pay_type']) ? addslashes($_POST['pay_type']) : '';
$mzfid = isset($_POST['mzfid']) ? addslashes($_POST['mzfid']) : '';
$mzfkey = isset($_POST['mzfkey']) ? addslashes($_POST['mzfkey']) : '';
$mzftoken = isset($_POST['mzftoken']) ? addslashes($_POST['mzftoken']) : '';
$kmgmdz = isset($_POST['kmgmdz']) ? addslashes($_POST['kmgmdz']) : '';


$submit = isset($_POST['submit']) ? addslashes($_POST['submit']) : '';
if($submit){
	$sql="UPDATE `eruyi_peizhi` SET `yzfid`='$yzfid',`yzfkey`='$yzfkey',`yzfurl`='$yzfurl',`pay_type`='$pay_type',`mzfid`='$mzfid',`mzfkey`='$mzfkey',`mzftoken`='$mzftoken',`kmgmdz`='$kmgmdz' WHERE id=1";
	$query=$db->query($sql);
	if($query){
		echo "<script>alert('保存成功');location.href='edit_zfgl.php';</script>";
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
                              <a href="edit_zfgl.php" class="active" >
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
                <li class="am-active">支付配置</li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> 支付配置
                    </div>
                  


                </div>




                <div class="tpl-block">

                    <div class="am-g" >
                        <div class="am-scrollable-horizontal"  >
                            <div  class="am-form-group"  >
<form class="am-form" action="" method="post" name="form_log" id="form_log">

<div id="post">
<div class="am-form-group">
    <label class="mdui-textfield-label"  for="pay_type" id="pay_type_label">充值方式：</label>
<br>
    <input type="radio" name="pay_type" value="0" id="pay_type"<?php if($row['pay_type']=='0'):?> checked="checked"<?php endif; ?> />码支付
    <input type="radio" name="pay_type" value="1" id="pay_type"<?php if($row['pay_type']=='1'):?> checked="checked"<?php endif; ?> />易支付
    <input type="radio" name="pay_type" value="2" id="pay_type"<?php if($row['pay_type']=='2'):?> checked="checked"<?php endif; ?> />购买卡密
</div>
<div class="am-form-group">
    <label class="mdui-textfield-label"  for="yzfid" id="yzfid_label">易支付商户ID：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="yzfid" value="<?php echo $row['yzfid'];?>" id="yzfid"/>
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="yzfkey" id="yzfkey_label">易支付商户token：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="yzfkey" value="<?php echo $row['yzfkey'];?>" id="yzfkey"/>
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="yzfurl" id="yzfurl_label">易支付url：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="yzfurl" value="<?php echo $row['yzfurl'];?>" id="yzfurl"/>
</div>

  <div class="am-form-group">
    <label class="mdui-textfield-label"  for="mzfid" id="mzfid_label">码支付商户ID：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="mzfid" value="<?php echo $row['mzfid'];?>" id="mzfid"/>
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="mzfkey" id="mzfkey_label">码支付商户key：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="mzfkey" value="<?php echo $row['mzfkey'];?>" id="mzfkey"/>
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="mzftoken" id="mzftoken_label">码支付商户token：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="mzftoken" value="<?php echo $row['mzftoken'];?>" id="mzftoken"/>
</div>
  
 <div class="am-form-group">
    <label class="mdui-textfield-label"  for="kmgmdz" id="kmgmdz_label">卡密购买地址：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="kmgmdz" value="<?php echo $row['kmgmdz'];?>" id="kmgmdz"/>
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