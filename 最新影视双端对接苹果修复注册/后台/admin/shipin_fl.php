<?php
require_once 'globals.php';
include_once 'header.php';

$tjfenlei = isset($_POST['tjfenlei']) ? addslashes($_POST['tjfenlei']) : '';
$submit = isset($_POST['submit']) ? addslashes($_POST['submit']) : '';
if($submit){
	if($tjfenlei!=''){
		$sql="UPDATE `shipin_fl` SET `fenlei`='$tjfenlei' WHERE 1";
	    $sql="INSERT INTO `shipin_fl`(`fenlei`) VALUES ('$tjfenlei')";
	    $query=$db->query($sql);
	    if($query){
	    	echo "<script>alert('添加成功');location.href='shipin_fl.php';</script>";
	    }
	}
}

$ids = isset($_POST['ids']) ? $_POST['ids'] : '';
 if($ids){
	$idss = '';
	foreach ($ids as $value) {
		$idss .= $value.",";
	}
	$idss = rtrim($idss, ",");
    $sql="select * from shipin_fl where uid=$idss";
    $query=$db->query($sql);
    $row=$db->fetch_array($query);
	if($row){
			$shipfl = $row['fenlei'];
            $name = iconv('utf-8','gb2312',$shipfl);
	        $filename = '../video/'.$name.'.txt';
            unlink($filename); //删除文件 
		}

	 
	$sql="DELETE FROM `shipin_fl` WHERE `uid` in ($idss)";
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
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                           <i class="fa fa-gear" aria-hidden="true"></i>
                            <span>配置中心</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu">
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
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list active">
                           <i class="fa fa-play-circle" aria-hidden="true"></i>
                            <span>视频管理</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu" style="display: block;">
                           <li>
                                <a href="shipin_sc.php">
                                    <i class="am-icon-angle-right"></i>
                                    <span>上传视频</span>
                                    
                                </a>
                                
                                <a href="shipin_data.php">
                                    <i class="am-icon-angle-right "></i>
                                    <span>视频管理</span>
                                    
                                </a>

                                <a href="shipin_fl.php" class="active">
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
                 <div class="am-u-sm-12 am-u-md-3"> 
<form class="am-form tpl-form-line-form"  action="" method="post" id="addimg" name="addimg">
 <div class="am-form-group">
<input class="mdui-textfield-input mdui-col-md-11 " placeholder="添加分类" class="mdui-textfield-input mdui-col-md-11" type="text" name="tjfenlei" value="" id="tjfenlei"/>
<br>
<input class="am-btn  am-btn-default am-btn-success tpl-am-btn-success am-icon-search" value="添加" name="submit" type="submit"></input>
</div>
</form>
           </div>
                    <div class="am-g">
                        <div class="am-u-sm-12">  
<form action="" method="post" name="form_log" id="form_log">
    <div class="am-scrollable-horizontal">
  <table width="100%" id="adm_log_list" class="am-table am-table-striped am-table-hover table-main am-text-nowrap">
  <thead>
      <tr>
		<th><b>选择</b></th>
		<th><b>视频分类</b></th>
        <th><b>视频数量</b></th>
      </tr>
	</thead>
 	<tbody>
<?php
 $username = isset($_POST['username']) ? addslashes(trim($_POST['username'])) : '';
		
 $sql="select * from shipin_fl";
 $query=$db->query($sql);
 while($rows=$db->fetch_array($query)){
	  $fenlei = $rows['fenlei'];
	  $sql1="select * from shipin_data  where shipfl='$fenlei'";
      $query1=$db->query($sql1);
	  $data = array();
      while($rows1=$db->fetch_array($query1)){
		  $data[] = $rows1;
	  }
	  $shuliang = count($data);
?>
      <tr>
      <td><input type="checkbox" name="ids[]" value="<?php echo $rows['uid']; ?>" class="ids" /></td>
	  <td><?php echo $fenlei ?></td>
	  <td><?php echo $shuliang ?></td>
      </tr>
<?php
 }
?></div><font color=red>【推荐】 分类请勿删除 为首页推荐显示</font>
	</tbody>
	</table>
	<div class="list_footer">
	选中项：<a href="javascript:void(0);" onclick="delsubmit()" class="care">删除</a>
	</div>
</form>
            </div>
<script> 
function delsubmit(){
	var delform = document.getElementById("form_log");
	delform.submit();
}
var div = document.getElementById('add_user'); 
div.setAttribute("class", "show"); 
</script> 

   <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/amazeui.min.js"></script>
    <script src="assets/js/iscroll.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>