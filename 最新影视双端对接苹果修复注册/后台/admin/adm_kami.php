<?php
/*
* File：管理卡密
* Author：易如意
* QQ：51154393
* Url：www.eruyi.cn
* 模板作者：BIN
* 博客：fooor.cn
*/

require_once 'globals.php';
include_once 'header.php';

 $sql="select * from eruyi_kami where 1";
 $queryc=$db->query($sql);
 $nums=$db->num_rows($queryc);
 $enums=30;  //每页显示的条目数 
 $page=isset($_GET['page']) ? intval($_GET['page']) : 1;
 $url="adm_kami.php?page=";
 $bnums=($page-1)*$enums;
 
 $id = isset($_POST['id']) ? $_POST['id'] : '';
 if($id){
	$ids = '';
	foreach ($id as $value) {
		$ids .= $value.",";
	}
	$ids = rtrim($ids, ",");
	$sql="DELETE FROM `eruyi_kami` WHERE `id` in ($ids)";
	$query=$db->query($sql);
	if($query){
		echo "<script>alert('删除成功');</script>";
	}
 }
 
 $KMtype = array(
	'TK'=>"天卡",
	'ZK'=>"周卡",
	'YK'=>"月卡",
	'BNK'=>"半年卡",
	'NK'=>"年卡",
	'YJK'=>"永久卡",
                'YJKK'=>"VIP代理卡",
 );
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
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list active">
                           <i class="fa fa-vimeo-square" aria-hidden="true"></i>
                            <span>卡密中心</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu" style="display: block;">
                           <li>
                                <a href="adm_kami.php"class="active" >
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
                卡密中心
            </div>
            <ol class="am-breadcrumb">
                <li><a href="index.php" class="am-icon-home">首页</a></li>
                <li class="am-active">卡密管理</li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> 卡密管理
                    </div>
                </div>
                
              <div class="am-u-sm-12 am-u-md-3">      	
<form action="adm_kami.php" method="post" name="skami" id="skami">
<input type="text" class="am-form-field" name="kami" placeholder="搜索卡密" /><BR><input class="am-btn  am-btn-default am-btn-success tpl-am-btn-success am-icon-search" value="搜索" type="submit"></input>
</form>
</div>

<form action="" method="post" name="form_log" id="form_log">
 <div class="am-scrollable-horizontal">
  <table width="100%" id="adm_log_list" class="am-table am-table-striped am-table-hover table-main  am-text-nowrap">
  <thead>
      <tr>
		<th class="table-check"><input type="checkbox" onclick="checkAll();" class="ids" id="all"/></th>
                                <th>ID</th>
                                <th>生成账号</th>
		<th>卡密</th>
		<th>类型</th>
		<th>状态</th>
		<th>使用者</th>
		<th>使用时间</th>
      </tr>
	</thead>
 	<tbody>
<?php
 $kami = isset($_POST['kami']) ? addslashes(trim($_POST['kami'])) : '';
 if($kami != ''){
 $sql="select * from eruyi_kami where kami='$kami' order by id desc limit $bnums,$enums";
 }else{
 $sql="select * from eruyi_kami where 1 order by id desc limit $bnums,$enums";
 }
 $query=$db->query($sql);
 while($rows=$db->fetch_array($query)){
?>
      <tr>
      <td><input type="checkbox" name="id[]" value="<?php echo $rows['id']; ?>" class="ids" /></td>
	  <td><?php echo $rows['id']; ?></td>
      <td><?php echo $rows['generate']; ?></td>
      <td><?php echo $rows['kami']; ?></td>
      <td><?php echo $KMtype[$rows['type']]; ?></td>
	  <td><?php if($rows['new']=='n'):?><font color=red>已用<?php else: ?><font color=green>可用<?php endif; ?></font></td>
	  <td><?php if($rows['new']=='n'): echo $rows['username']; endif; ?></td>
	  <td><?php if($rows['new']=='n'): echo gmdate("Y-m-d H:i:s",$rows['date']+8*3600); endif; ?></td>
      </tr>
<?php
 }
?>
	</tbody>
	</table>
	<div class="list_footer">
	选中项：<a href="javascript:void(0);" onclick="delsubmit()" class="care">删除</a>
	</div>
    </div>
</form>

<?php if($kami == ''): ?>
<div class="page" style="text-align:center;"><?php echo pagination($nums,$enums,$page,$url); ?></div>
<?php endif; ?>
<div style="height:60px;"></div>

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
var div = document.getElementById('adm_kami'); 
div.setAttribute("class", "show"); 
</script>
   <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/amazeui.min.js"></script>
    <script src="assets/js/iscroll.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>