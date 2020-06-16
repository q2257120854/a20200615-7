<?php
require_once 'globals.php';
include_once 'header.php';
$username = isset($_POST['username']) ? addslashes($_POST['username']) : '';
$password = isset($_POST['password']) ? addslashes($_POST['password']) : '';
$superpass = isset($_POST['superpass']) ? addslashes($_POST['superpass']) : '';
$money = isset($_POST['money']) ? intval($_POST['money']) : 0;
$regdate = time();
$regip = isset($_POST['regip']) ? addslashes($_POST['regip']) : '';
$regcode = isset($_POST['regcode']) ? addslashes($_POST['regcode']) : '';
if($username != '' && $password != '' && $superpass != ''){
	$sql="select * from eruyi_user where username='$username'";
	$query=$db->query($sql);
	$have=$db->fetch_array($query);
	if($have){
		echo "<script>alert('失败：用户名已存在');</script>";
	}else{
		$pass = md5($password);
		$sql="INSERT INTO `eruyi_user`(`username`, `password`, `superpass`, `money`, `regdate`, `regip`, `regcode`,`lock`) VALUES ('$username','$pass','$superpass','$money','$regdate','$regip','$regcode','n')";
		$query=$db->query($sql);
		if($query){
			echo "<script>alert('添加成功');</script>";
		}
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
                        <a href="" class="nav-link active">
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
                用户中心
            </div>
            <ol class="am-breadcrumb">
                <li><a href="index.php" class="am-icon-home">首页</a></li>
                <li class="am-active">添加用户</li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> 添加用户
                    </div>
                  


                </div>

                <div class="tpl-block">
                  <div class="am-g" >
                    <div class="am-scrollable-horizontal " >
                        <div class="am-form-group"  >
<form  class="am-form tpl-form-line-form"  action="" method="post" id="addimg" name="addimg">
<div id="post">

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="user-name" id="username_label">用户名：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="username" placeholder="请输入用户名(必填)" id="username"/>
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="user-name" id="username_label">用户密码：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="password" placeholder="请输入用户密码(必填)" id="password"/>
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="user-name" id="username_label">超级密码：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="superpass" placeholder="请输入超级密码(必填)" id="superpass"/>
</div>
<div class="am-form-group">
    <label class="mdui-textfield-label"  for="user-name" id="username_label">账户余额：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="money" value="0" id="money"/>
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="user-name" id="username_label">注册IP：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="regip" placeholder="" id="regip"/>
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="user-name" id="username_label">注册机器：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="regcode" placeholder="" id="regcode"/>
</div>

                            
<div id="post_button">
                                <input type="submit" name="submit" value="添加用户"  class="am-btn-primary" />
                            </div >
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