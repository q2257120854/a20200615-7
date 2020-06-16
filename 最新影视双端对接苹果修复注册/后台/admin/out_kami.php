<?php
/*
* File：导出卡密
* Author：易如意
* QQ：51154393
* Url：www.eruyi.cn
* 模板作者：BIN
* 博客：fooor.cn
*/

require_once 'globals.php';
$type = isset($_POST['type']) ? addslashes($_POST['type']) : 'TK';
$new = isset($_POST['new']) ? addslashes($_POST['new']) : 'y';
$submit = isset($_POST['submit']) ? addslashes($_POST['submit']) : '';
if($submit){
	$sql="select * from eruyi_kami where `type`='$type' and `new`='$new'";
	$query=$db->query($sql);
	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename={$type}_kami.txt");
	echo "==============卡密开始================\r\n\r\n";
	while($rows=$db->fetch_array($query)){
		echo $rows['kami']."\r\n";
	}
	echo "\r\n\r\n==============卡密结束================";
	exit;
}else{
	require_once 'header.php';
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
                                <a href="adm_kami.php">
                                    <i class="am-icon-angle-right"></i>
                                    <span>卡密管理</span>
                                    
                                </a>

                                <a href="add_kami.php">
                                    <i class="am-icon-angle-right"></i>
                                    <span>卡密生成</span>
								</a>

                                    <a href="out_kami.php" class="active" >
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
                <li class="am-active">卡密导出</li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> 卡密导出
                    </div>
                </div>
<form action="" method="post" id="addimg" name="addimg">
<div id="post">
<div>
    <label for="type" id="type_label">卡密类型：</label>
    <select name="type" id="type">
	  <option value="TK">天卡</option>
	  <option value="ZK">周卡</option>
	  <option value="YK">月卡</option>
	  <option value="BNK">半年卡</option>
	  <option value="NK">年卡</option>
	  <option value="YJK">永久卡</option>
	  <option value="YJKK">VIP代理卡</option>
	</select>
	<select name="new" id="new">
	  <option value="y">可用</option>
	  <option value="n">已用</option>
	</select>
	<input type="submit" name="submit" value="导出卡密" class="am-btn-primary" />
</div>
</div>
</form>
</div></div>
<script> 
var div = document.getElementById('out_kami'); 
div.setAttribute("class", "show"); 
</script> 
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/amazeui.min.js"></script>
    <script src="assets/js/iscroll.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>