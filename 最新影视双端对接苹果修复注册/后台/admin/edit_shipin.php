<?php
require_once 'globals.php';
include_once 'header.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : '';
$sql="select * from shipin_data where id=$id";
$query=$db->query($sql);
$row=$db->fetch_array($query);

$shipfl = isset($_POST['shipfl']) ? addslashes($_POST['shipfl']) : '';
$name = isset($_POST['name']) ? addslashes($_POST['name']) : '';
$time = isset($_POST['time']) ? addslashes($_POST['time']) : '';
$href = isset($_POST['href']) ? addslashes($_POST['href']) : '';
$href=str_replace("\r\n","|",$href); 

$src = isset($_POST['src']) ? addslashes($_POST['src']) : '';
$txt = isset($_POST['txt']) ? addslashes($_POST['txt']) : '';
$txt=str_replace("\r\n","",$txt);

$submit = isset($_POST['submit']) ? addslashes($_POST['submit']) : '';
if($submit){
	$sql="select * from shipin_data where name='$name'";
    $query=$db->query($sql);
    while ($have=$db->fetch_array($query)){
	    $data[] = $have;
	}
	$shuliang = count($data);
    if($shuliang > 1) exit("<script>alert('此视频已存在,请勿重复上传');location.href='';</script>");
	if($shipfl == '') exit("<script>alert('请先添加视频分类');location.href='';</script>");
	if($name == '') exit("<script>alert('视频名不能为空');location.href='';</script>");
	if($href == '') exit("<script>alert('视频播放地址不能为空');location.href='';</script>");
	if($src == '') exit("<script>alert('视频图片地址不能为空');location.href='';</script>");
	if($txt == ''){
		$txt = "作者太懒了,没有添加视频简介...";
	}
	
	
	$sql="UPDATE `shipin_data` SET `name`='$name',`src`='$src',`href`='$href',`txt`='$txt',`shipfl`='$shipfl',`time`='$time' WHERE id=$id";
	$query=$db->query($sql);
	if($query){
		echo "<script>alert('修改成功');location.href='shipin_data.php';</script>";
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
                        <ul class="tpl-left-nav-sub-menu"  style="display: block;">
                           <li>
                                <a href="shipin_sc.php">
                                    <i class="am-icon-angle-right"></i>
                                    <span>上传视频</span>
                                    
                                </a>
                                
                                <a href="shipin_data.php" class="active">
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
                视频管理
            </div>
            <ol class="am-breadcrumb">
                <li><a href="index.php" class="am-icon-home">首页</a></li>
                <li class="am-active">视频修改</li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> 视频修改
                    </div>
                </div>

 <div class="tpl-block">

    <div class="am-g">
        <div class="am-scrollable-horizontal" >
<form class="am-form"  action="" method="post" id="addimg" name="addimg">
<div class="am-form-group">
<label class="mdui-textfield-label"  for="name" id="regip_label">视频分类:</label>
<div class="am-form-group">
<select style="width:200px;" name="shipfl" id="shipfl">
<?php													   
 $sql="select * from shipin_fl";
 $query=$db->query($sql);
 while($rows=$db->fetch_array($query)){
?>
      <option><?php echo $rows['fenlei']; ?></option>
<?php
 }
?>
</select>
<a href="shipin_fl.php">
<input type="button" value="添加新分类" class="am-btn-primary" />
</a>
</div></div>
<br>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="name" id="regip_label">视频名称:</label>
 <div class="am-form-group">
    <input class="mdui-textfield-input mdui-col-md-11 " value="<?php echo $row['name'];?>" type="text" name="name" id="name"/>
</div></div>
<br>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="name" id="regip_label">视频副标:</label>
 <div class="am-form-group">
    <input class="mdui-textfield-input mdui-col-md-11 " value="<?php echo $row['time'];?>"  type="text" name="time" id="time"/>
</div></div>
<br>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="src" id="regip_label">视频图片地址:</label>
    <input class="mdui-textfield-input mdui-col-md-11 " value="<?php echo $row['src'];?>"  type="text" name="src" id="src"/>
</div>
<br>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="href" id="regip_label">视频播放地址：</label>
    <textarea  type="text" class="mdui-textfield-input mdui-col-md-11" style="height:100px;"  name="href" id="href"><?php echo str_replace("|","\r\n",$row['href']) ;?></textarea><font color=red >电影格式：：<span style="text-decoration:underline">http://www.****.mp4</span> <br>多条播放地址可用 | 或 换行符 分开, 例如：<span style="text-decoration:underline">第1集$http://www.****.mp4|第2集$http://www.****.m3u8</span>  不要有空格</font>t>
</div>
<br>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="txt" id="regip_label">视频简介：</label>
    <textarea  type="text" class="mdui-textfield-input mdui-col-md-11" style="height:100px;"  name="txt" id="txt"><?php echo $row['txt'];?></textarea>
</div>
<br>

<br>
<div id="post_button">
    <input  type="submit" name="submit" value="确定修改" class="am-btn-primary" />
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