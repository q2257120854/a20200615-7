<?php


require_once 'globals.php';
include_once 'header.php';

 $sql="select * from eruyi_user where 1";
 $queryc=$db->query($sql);
 $nums=$db->num_rows($queryc);
 $enums=30;  //每页显示的条目数 
 $page=isset($_GET['page']) ? intval($_GET['page']) : 1;
 $av_url = $_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"]);
 $url="adm_userpost.php?page=";
 $bnums=($page-1)*$enums;
 
 $ids = isset($_POST['ids']) ? $_POST['ids'] : '';
 if($ids){
	$idss = '';
	foreach ($ids as $value) {
		$idss .= $value.",";
	}
	$idss = rtrim($idss, ",");
	$sql="DELETE FROM `bbspost` WHERE `id` in ($idss)";
	$query=$db->query($sql);
	if($query){
		echo "<script>alert('删除成功');</script>";
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
           
            <ol class="am-breadcrumb">
                <li><a href="index.php" class="am-icon-home">首页</a></li>
                <li class="am-active">社区管理</li>
            </ol>
            <div class="tpl-portlet-components">
                
                <div class="tpl-block">
                 <div class="am-u-sm-12 am-u-md-3">  
<form action="adm_userpost.php" method="post" name="suer" id="suer">
<input type="text" name="id" class="am-form-field" placeholder="搜索用户ID"/><br><input class="am-btn  am-btn-default am-btn-success tpl-am-btn-success am-icon-search" value="搜索" type="submit"></input>
</form>
                 </div>
                    <div class="am-g">
                        <div class="am-u-sm-12">
                          
<form action="" method="post" name="form_log" id="form_log">
    <div class="am-scrollable-horizontal">
  <table width="100%" id="adm_log_list" class="am-table am-table-striped am-table-hover table-main am-text-nowrap">
  <thead>
      <tr>
		<th><input type="checkbox" onclick="checkAll();" class="ids" id="all"/></th>
        <th><b>帖子ID</b></th>
		<th><b>账号</b></th>
		<th><b>发布时间</b></th>
		<th><b>标题</b></th>
        <th><b>内容</b></th>
		<th><b>图片</b></th>
        <th class="table-set"><b>管理</b></th>
      </tr>
	</thead>
 	<tbody>
<?php
 $id = isset($_POST['id']) ? addslashes(trim($_POST['id'])) : '';
 if($id != ''){

 $sql="select * from bbspost where userid = '$id' order by time desc limit $bnums,$enums";
 }else{
 $sql="select * from bbspost where 1 order by time desc limit $bnums,$enums";
 }
 $query=$db->query($sql);
 while($rows=$db->fetch_array($query)){
?>
      <tr>
      <td><input type="checkbox" name="ids[]" value="<?php echo $rows['id']; ?>" class="ids" /></td>
	  
	  <td><?php echo $rows['id']; ?></td>
	  <td><?php echo $rows['userid']; ?></td>
      <td><?php echo gmdate("Y-m-d H:i:s",$rows['time']) ?></td>
      <td><?php echo mb_substr($rows['title'],0,20,"UTF-8"); ?></td>
	  <td><?php echo mb_substr($rows['content'],0,20,"UTF-8"); ?></td>
	  <td><?php echo mb_substr($rows['img'],0,20,"UTF-8"); ?></td>
	  <td>
	  	<div class="am-btn-toolbar">
                                                    <div class="am-btn-group am-btn-group-xs">
                                                        <a href="edit_bbs.php?uid=<?php echo $rows['id']; ?>" target="_self" class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> 编辑</a>
        
                                                    </div>
                                                </div>
	  </td>
      </tr>
<?php
 }
?>
	</tbody>
	</table>
</div>
	<div class="list_footer">
	选中项：<a href="javascript:void(0);" onclick="delsubmit()" class="care">删除</a>
	</div>
</form>
<?php if($id == ''): ?>
<div class="page"><?php echo pagination($nums,$enums,$page,$url); ?></div>
<?php endif; ?>
<script>
function checkAll() {
    var code_Values = document.getElementsByTagName("input");
	var all = document.getElementById("all");
    if (code_Values.length) {
        for (i = 0; i < code_Values.length; i++) {
            if (code_Values[i].type == "checkbox") {
                code_Values[i].checked = all.checked;
            }
        }
    } else {
        if (code_Values.type == "checkbox") {
            code_Values.checked = all.checked;
        }
    }
}
function delsubmit(){
	var delform = document.getElementById("form_log");
	delform.submit();
}
var div = document.getElementById('adm_user'); 
div.setAttribute("class", "show"); 
</script>
</div>	</div>
   <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/amazeui.min.js"></script>
    <script src="assets/js/iscroll.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>