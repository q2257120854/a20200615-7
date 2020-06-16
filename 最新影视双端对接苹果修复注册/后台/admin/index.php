<?php

require_once 'globals.php';
include_once 'header.php';
$sql1 = "select count(*) from eruyi_user ";
$data1 = mysql_query($sql1);
$rows1=mysql_fetch_array($data1);
$rowCount1 = $rows1[0];

$sql2 = "select count(*) from eruyi_kami ";
$data2 = mysql_query($sql2);
$rows2=mysql_fetch_array($data2);
$rowCount2 = $rows2[0];

$sql3 = "select count(*) from eruyi_kami where new='n '";
$data3 = mysql_query($sql3);
$rows3=mysql_fetch_array($data3);
$rowCount3 = $rows3[0];

$sql4 = "select count(*) from eruyi_kami where new='y '";
$data4 = mysql_query($sql4);
$rows4=mysql_fetch_array($data4);
$rowCount4 = $rows4[0];

$domain = $_SERVER['SERVER_NAME'];
$serverapp = $_SERVER['SERVER_SOFTWARE'];
$mysql_ver = $db->getMysqlVersion();
$php_ver = PHP_VERSION;
$uploadfile_maxsize = ini_get('upload_max_filesize');
if (function_exists("imagecreate")) {
	if (function_exists('gd_info')) {
		$ver_info = gd_info();
		$gd_ver = $ver_info['GD Version'];
	} else{
		$gd_ver = '支持';
	}
} else{
	$gd_ver = '不支持';
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
                        <a href="" class="nav-link active">
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
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
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

					
					<li class="tpl-left-nav-item">
                        <a href="adm_bbs.php" class="nav-link tpl-left-nav-link-list">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>社区管理</span>
                            <i class="tpl-left-nav-content tpl-badge-danger">
               
             </i>
                        </a>
                    </li>
					
					
                </ul>
            </div>
        </div>


<div class="tpl-content-wrapper">
            <div class="tpl-content-page-title">
                用户中心
            </div>
            <ol class="am-breadcrumb">
                <li><a href="#" class="am-icon-home">首页</a></li>
            </ol>
            <div class="tpl-content-scope">
                <div class="note note-info">
                    <h3>站点信息</h3>
                   <h4><li>当前域名：<?php echo $domain; ?></li>
<li>PHP版本：<?php echo $php_ver; ?></li>
<li>MySQL版本：<?php echo $mysql_ver; ?></li>
<li>服务器环境：<?php echo $serverapp; ?></li>
<li>GD图形处理库：<?php echo $gd_ver; ?></li>
<li>服务器空间允许上传最大文件：<?php echo $uploadfile_maxsize; ?></li></h4>
                </div>
            </div>

            <div class="row">
                <div class="am-u-lg-3 am-u-md-6 am-u-sm-12">
                    <div class="dashboard-stat blue">
                        <div class="visual">
                            <i class="am-icon-comments-o"></i>
                        </div>
                        <div class="details">
                            <div class="number"> <?php echo $rows1[0] ;?> </div>
                            <div class="desc"> 用户 </div>
                        </div>
                        <a class="more" href="adm_user.php"> 查看更多
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
                    </div>
                </div>
                <div class="am-u-lg-3 am-u-md-6 am-u-sm-12">
                    <div class="dashboard-stat red">
                        <div class="visual">
                            <i class="am-icon-bar-chart-o"></i>
                        </div>
                        <div class="details">
                            <div class="number"><?php echo $rows2[0] ;?></div>
                            <div class="desc"> 卡密总数</div>
                        </div>
                        <a class="more" href="adm_kami.php"> 查看更多
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
                    </div>
                </div>
                <div class="am-u-lg-3 am-u-md-6 am-u-sm-12">
                    <div class="dashboard-stat green">
                        <div class="visual">
                            
                        </div>
                        <div class="details">
                            <div class="number"> <?php echo $rows3[0] ;?> </div>
                            <div class="desc"> 卡密已使用 </div>
                        </div>
                        <a class="more" href="adm_kami.php"> 查看更多
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
                    </div>
                </div>
                <div class="am-u-lg-3 am-u-md-6 am-u-sm-12">
                    <div class="dashboard-stat purple">
                        <div class="visual">
                            
                        </div>
                        <div class="details">
                            <div class="number"> <?php echo $rows4[0] ;?> </div>
                            <div class="desc"> 卡密未使用 </div>
                        </div>
                        <a class="more" href="adm_kami.php"> 查看更多
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
                    </div>
                </div>
        
                </div>
                </div>  

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/amazeui.min.js"></script>
    <script src="assets/js/iscroll.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>