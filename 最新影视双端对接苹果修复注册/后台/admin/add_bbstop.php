<?php
require_once 'globals.php';
include_once 'header.php';
$top = isset($_POST['top']) ? addslashes($_POST['top']) : '';
$regdate = time();

if (strlen($top) > 0){
	$sql="INSERT INTO `bbstop`(`time`, `objid`) VALUES ('$regdate','$top')";
$query=$db->query($sql);
if($query){
	echo "<script>alert('添加成功');</script>";
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
                        <a href="adm_bbstop.php" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-home"></i>
                            <span>帖子置顶</span>
                        </a>
                    </li>
				   
				   <li class="tpl-left-nav-item">
                        <a href="add_bbstop.php" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-home"></i>
                            <span>添加置顶</span>
                        </a>
                    </li>
					
					
					<li class="tpl-left-nav-item">
                        <a href="adm_userpost.php" class="nav-link tpl-left-nav-link-list">
                            <i class="am-icon-home"></i>
                            <span>用户帖子</span>
                        </a>
                    </li>
					
					
                </ul>
            </div>
        </div>

        <div class="tpl-content-wrapper">
            <div class="tpl-content-page-title">
                社区管理
            </div>
            <ol class="am-breadcrumb">
                <li><a href="index.php" class="am-icon-home">首页</a></li>
                <li class="am-active">添加置顶</li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> 添加置顶
                    </div>
                  


                </div>

                <div class="tpl-block">
                  <div class="am-g" >
                    <div class="am-scrollable-horizontal " >
                        <div class="am-form-group"  >
<form  class="am-form tpl-form-line-form"  action="" method="post" id="addimg" name="addimg">
<div id="post">

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="user-name" id="username_label">添加置顶：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="top" placeholder="帖子ID" id="top"/>
</div>

                            
<div id="post_button">
                                <input type="submit" name="submit" value="添加"  class="am-btn-primary" />
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