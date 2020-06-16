<?php
/*
* File：编辑用户
* Author：易如意
* QQ：51154393
* Url：www.eruyi.cn
*/

require_once 'globals.php';
include_once 'header.php';
$id = isset($_GET['uid']) ? intval($_GET['uid']) : '';
$sql="select * from bbspost where id='$id'";
$query=$db->query($sql);
$row=$db->fetch_array($query);
$title = isset($_POST['title']) ? addslashes($_POST['title']) : '';
$content = isset($_POST['content']) ? addslashes($_POST['content']) : '';
$img = isset($_POST['img']) ? addslashes($_POST['img']) : '';
$submit = isset($_POST['submit']) ? addslashes($_POST['submit']) : '';
$sql="UPDATE `bbspost` SET `title`='$title',`content`='$content',`img`='$img' WHERE id= '$id'";
if($submit){
	$query=$db->query($sql);
	if($query){
		echo "<script>alert('编辑成功');location.href='adm_bbs.php';</script>";
	}else{
		
		
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
                    
                </ul>
            </div>
        </div>

        <div class="tpl-content-wrapper">
            <div class="tpl-content-page-title">
                社区管理
            </div>
            <ol class="am-breadcrumb">
                <li><a href="index.php" class="am-icon-home">首页</a></li>
                <li class="am-active">帖子修改</li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> 帖子修改
                    </div>
                </div>

 <div class="tpl-block">

    <div class="am-g">
        <div class="am-scrollable-horizontal" >
<form class="am-form"  action="" method="post" id="addimg" name="addimg">
<div id="post">



<div class="am-form-group">
    <label class="mdui-textfield-label"  for="user-name" id="username_label">标题：</label>
 <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="title" placeholder="标题" value="<?php echo $row['title'];?>" id="title" />
</div>
<div class="am-form-group">
    <label class="mdui-textfield-label"  for="user-name" id="username_label">内容：</label>
 <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="content" placeholder="内容" value="<?php echo $row['content'];?>" id="content"/>
</div>
<div class="am-form-group">
    <label class="mdui-textfield-label"  for="user-name" id="username_label">图片：</label>
 <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="img" placeholder="图片" value="<?php echo $row['img'];?>" id="img"/>
</div>

<div class="am-form-group" id="post_button">
    <div class="am-u-sm-9">
    <input type="submit" name="submit" value="编辑保存" class="am-btn-primary" />
</div>
</div>
</div>
</form>
</div></div></div>
<script> 
var div = document.getElementById('adm_bbs'); 
div.setAttribute("class", "show"); 
</script> 
 <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/amazeui.min.js"></script>
    <script src="assets/js/iscroll.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>