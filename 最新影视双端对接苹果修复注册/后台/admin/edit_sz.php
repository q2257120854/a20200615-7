<?php
require_once 'globals.php';
include_once 'header.php';
$sql="select * from eruyi_peizhi where id=1";
$query=$db->query($sql);
$row=$db->fetch_array($query);

$charge = isset($_POST['charge']) ? intval($_POST['charge']) : 0;
$banben = isset($_POST['banben']) ? addslashes($_POST['banben']) : '';
$banben_code = isset($_POST['banben_code']) ? addslashes($_POST['banben_code']) : '';
$code_url = isset($_POST['code_url']) ? addslashes($_POST['code_url']) : '';
$qq = isset($_POST['qq']) ? addslashes($_POST['qq']) : '';
$dizhi = isset($_POST['dizhi']) ? addslashes($_POST['dizhi']) : '';
$qunkey = isset($_POST['qunkey']) ? addslashes($_POST['qunkey']) : '';
$gxneirong = isset($_POST['gxneirong']) ? addslashes($_POST['gxneirong']) : '';
$gonggao = isset($_POST['gonggao']) ? addslashes($_POST['gonggao']) : '';
$is_code_up=isset($_POST['is_code_up']) ? addslashes($_POST['is_code_up']) : '';
$tcgonggao = isset($_POST['tcgonggao']) ? addslashes($_POST['tcgonggao']) : '';
$tcgonggaoid = isset($_POST['tcgonggaoid']) ? addslashes($_POST['tcgonggaoid']) : '';
$tcgonggaots = isset($_POST['tcgonggaots']) ? addslashes($_POST['tcgonggaots']) : '';
$fldizhi = isset($_POST['fldizhi']) ? addslashes($_POST['fldizhi']) : '';
$mrjiekou = isset($_POST['mrjiekou']) ? addslashes($_POST['mrjiekou']) : '';
$jiekou = isset($_POST['jiekou']) ? addslashes($_POST['jiekou']) : '';
$qita = isset($_POST['qita']) ? addslashes($_POST['qita']) : '';
$zfbhb = isset($_POST['zfbhb']) ? addslashes($_POST['zfbhb']) : '';
$rjjg = isset($_POST['rjjg']) ? addslashes($_POST['rjjg']) : '';
$weixinid = isset($_POST['weixinid']) ? addslashes($_POST['weixinid']) : '';
$addyue = isset($_POST['addyue']) ? addslashes($_POST['addyue']) : '';
$apkurl = isset($_POST['apkurl']) ? addslashes($_POST['apkurl']) : '';
$updatetype = isset($_POST['updatetype']) ? addslashes($_POST['updatetype']) : '';
$updateis = isset($_POST['updateis']) ? addslashes($_POST['updateis']) : '';

$submit = isset($_POST['submit']) ? addslashes($_POST['submit']) : '';
if($submit){
	$sql="UPDATE `eruyi_peizhi` SET `banben`='$banben',`apkurl`='$apkurl',`updatetype`='$updatetype',`updateis`='$updateis',`addyue`='$addyue',`tcgonggaots`='$tcgonggaots',`qq`='$qq',`dizhi`='$dizhi',`qunkey`='$qunkey',`gxneirong`='$gxneirong',`gonggao`='$gonggao',`tcgonggao`='$tcgonggao',`tcgonggaoid`='$tcgonggaoid',`fldizhi`='$fldizhi',`mrjiekou`='$mrjiekou',`jiekou`='$jiekou',`qita`='$qita',`zfbhb`='$zfbhb',`rjjg`='$rjjg',`banben_code`='$banben_code',`code_url`='$code_url',`charge`='$charge',`is_code_up`='$is_code_up',`weixinid`='$weixinid' WHERE id=1";
	$query=$db->query($sql);
	if($query){
		echo "<script>alert('保存成功');location.href='edit_sz.php';</script>";
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
                                <a href="edit_sz.php" class="active" >
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
                <li class="am-active">软件配置</li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> 软件配置
                    </div>
                  


                </div>




                <div class="tpl-block">
                    <div class="am-g" >
                        <div class="am-scrollable-horizontal"  >
                            <div class="am-form-group"  >
<form  class="am-form" action="" method="post" id="addimg" name="addimg">
<div id="post">

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="username" id="username_label">运营模式：</label>
<br>
    <input type="radio" name="charge" value="1" id="charge"<?php if($row['charge']=='1'):?> checked="checked"<?php endif; ?> />收费模式1
    <input type="radio" name="charge" value="0" id="charge"<?php if($row['charge']=='0'):?> checked="checked"<?php endif; ?> />免费模式0
    <input type="radio" name="charge" value="2" id="charge"<?php if($row['charge']=='2'):?> checked="checked"<?php endif; ?> />免登模式2
    <input type="radio" name="charge" value="3" id="charge"<?php if($row['charge']=='3'):?> checked="checked"<?php endif; ?> />限制模式3
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="username"  id="username_label">版本：</label>
    <input class="mdui-textfield-input mdui-col-md-11" type="text" name="banben" value="<?php echo $row['banben'];?>" id="banben"/>
</div>
<div class="am-form-group">
    <label class="mdui-textfield-label"  for="banben_code"  id="banben_code_label">版本号：</label>
    <input class="mdui-textfield-input mdui-col-md-11" type="text" name="banben_code" value="<?php echo $row['banben_code'];?>" id="banben_code"/>
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="username"  id="username_label">一次任务加余额：</label>
    <input class="mdui-textfield-input mdui-col-md-11" type="text" name="addyue" value="<?php echo $row['addyue'];?>" id="addyue"/>
</div>


<div class="am-form-group">
    <label class="mdui-textfield-label"  for="username" id="username_label">微信分享APP_ID：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="weixinid" value="<?php echo $row['weixinid'];?>" id="weixinid"/>
	APP_ID需要到微信官网申请https://open.weixin.qq.com/cgi-bin/frame?t=home/app_tmpl&lang=zh_CN
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="username" id="username_label">QQ：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="qq" value="<?php echo $row['qq'];?>" id="qq"/>
</div>


<div class="am-form-group">
    <label class="mdui-textfield-label"  for="money" id="money_label">QQ群号：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="qunkey" value="<?php echo $row['qunkey'];?>" id="qunkey"/>
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="regdate" id="regdate_label">更新内容：</label>
    <textarea  type="text" class="mdui-textfield-input mdui-col-md-11" style="height:100px;"   name="gxneirong" id="gxneirong" ><?php echo $row['gxneirong'];?> </textarea>
</div>
<div class="am-form-group">
    <label class="mdui-textfield-label"  for="superpass" id="superpass_label">下载地址：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="dizhi" value="<?php echo $row['dizhi'];?>" id="dizhi"/>
</div>
 <div class="am-form-group">
    <label class="mdui-textfield-label"  for="apkurl" id="apkurl_label">直连更新地址：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="apkurl" value="<?php echo $row['apkurl'];?>" id="apkurl"/>
</div>
 <div class="am-form-group">
    <label class="mdui-textfield-label"  for="code_url" id="code_url">增量更新地址：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="code_url" value="<?php echo $row['code_url'];?>" id="code_url"/>
</div>
 <div class="am-form-group">
    <label class="mdui-textfield-label"  for="is_code_up" id="is_code_up_label">是否增量更新：</label>
<br>
    <input type="radio" name="is_code_up" value="1" id="is_code_up"<?php if($row['is_code_up']=='1'):?> checked="checked"<?php endif; ?> />是
    <input type="radio" name="is_code_up" value="0" id="is_code_up"<?php if($row['is_code_up']=='0'):?> checked="checked"<?php endif; ?> />否
</div>
 <div class="am-form-group">
    <label class="mdui-textfield-label"  for="updatetype" id="updatetype_label">更新方式：</label>
<br>
    <input type="radio" name="updatetype" value="1" id="updatetype"<?php if($row['updatetype']=='1'):?> checked="checked"<?php endif; ?> />跳转更新
    <input type="radio" name="updatetype" value="0" id="updatetype"<?php if($row['updatetype']=='0'):?> checked="checked"<?php endif; ?> />直连更新
</div>
   <div class="am-form-group">
    <label class="mdui-textfield-label"  for="updateis" id="updateis_label">是否强制更新：</label>
<br>
    <input type="radio" name="updateis" value="1" id="updateis"<?php if($row['updateis']=='1'):?> checked="checked"<?php endif; ?> />是
    <input type="radio" name="updateis" value="0" id="updateis"<?php if($row['updateis']=='0'):?> checked="checked"<?php endif; ?> />否
</div>
<div class="am-form-group">
    <label class="mdui-textfield-label"  for="regip" id="regip_label">公告：</label>
    <textarea  type="text" class="mdui-textfield-input mdui-col-md-11" style="height:100px;"  name="gonggao" id="gonggao"><?php echo $row['gonggao'];?> </textarea>
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="regip" id="regip_label">弹窗公告：</label>
    <textarea  type="text" class="mdui-textfield-input mdui-col-md-11" style="height:100px;"  name="tcgonggao" id="tcgonggao"><?php echo $row['tcgonggao'];?> </textarea>
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="superpass" id="superpass_label">弹窗id：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="number" name="tcgonggaoid" value="<?php echo $row['tcgonggaoid'];?>" id="tcgonggaoid"/>
</div>
 <div class="am-form-group">
    <label class="mdui-textfield-label"  for="superpass" id="superpass_label">弹窗提示：</label>
    <input class="mdui-textfield-input mdui-col-md-11 " type="text" name="tcgonggaots" value="<?php echo $row['tcgonggaots'];?>" id="tcgonggaots"/>
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="regcode" id="regcode_label">更多配置：</label>
    <textarea  type="text" class="mdui-textfield-input mdui-col-md-11" style="height:100px;"   name="fldizhi" id="fldizhi" ><?php echo $row['fldizhi'];?> </textarea>
</div>
<div class="am-form-group">
    <label class="mdui-textfield-label"  for="regcode" id="regcode_label">默认接口：</label>
    <input class="mdui-textfield-input mdui-col-md-11" type="text" name="mrjiekou" value="<?php echo $row['mrjiekou'];?>" id="mrjiekou"/>
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="regcode" id="regcode_label">分享内容：</label>
    <textarea  type="text" class="mdui-textfield-input mdui-col-md-11" style="height:100px;"  name="jiekou" id="jiekou"><?php echo $row['jiekou'];?> </textarea>
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="regcode" id="regcode_label">分享图片：</label>
    <input class="mdui-textfield-input mdui-col-md-11" type="text" name="qita" value="<?php echo $row['qita'];?>" id="qita"/>
</div>

<div class="am-form-group">
    <label class="mdui-textfield-label"  for="regcode" id="regcode_label">支付宝红包搜索码：</label>
    <textarea  type="text" class="mdui-textfield-input mdui-col-md-11" style="height:100px;"  name="zfbhb" id="zfbhb"><?php echo $row['zfbhb'];?> </textarea>
</div>


<div class="am-form-group">
    <label class="mdui-textfield-label"  for="regcode" id="regcode_label">软件价格：</label>
    <textarea  type="text" class="mdui-textfield-input mdui-col-md-11" style="height:100px;"  name="rjjg" id="rjjg"><?php echo $row['rjjg'];?> </textarea>注:价格后面必须带.00
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