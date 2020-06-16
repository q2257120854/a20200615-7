<?php
require_once 'globals.php';
include_once 'header.php';
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Test Page</title>
<style>
.wrap{margin:10px;border:1px solid #ccc;padding:10px;width:280px;float:left;height:160px;}
hr{border:none;border-top:1px solid #ccc;}
input{margin-top:2px;}
.button{margin-left:90px;}
</style>
</head>
<body>
<div style="margin-left:10px;">
	<b>接口调试页面</b>
	<p>接口调试完毕可删除此页面</p>
</div>
<div class="wrap">
	<b>用户注册</b><hr>
	<form action="api.php?action=register" method="post" id="register" name="register">
	<div id="post">
	<div>
		<label for="username" id="username_label">用户账号：</label>
		<input type="text" maxlength="200" name="username" value="" id="username"/> *
	</div>
	<div>
		<label for="password" id="password_label">用户密码：</label>
		<input type="text" maxlength="200" name="password" value="" id="password"/> *
	</div>
	<div>
		<label for="superpass" id="superpass_label">超级密码：</label>
		<input type="text" maxlength="200" name="superpass" value="" id="superpass"/> *
	</div>
	<div>
		<label for="regcode" id="regcode_label">注册机器：</label>
		<input type="text" maxlength="200" name="regcode" value="" id="regcode"/> *
	</div>
         <div>
		<label for="regcode" id="regcode_label">邀请码：</label>
		<input type="text" maxlength="200" name="inv" value="" id="inv"/> *
	</div>
	<div id="post_button">
		<input type="submit" name="submit" value="注册" class="button" />
	</div>
	</div>
	</form>
</div>
<div class="wrap">
	<b>用户登陆</b><hr>
	<form action="api.php?action=login" method="post" id="login" name="login">
	<div id="post">
	<div>
		<label for="username" id="username_label">用户账号：</label>
		<input type="text" maxlength="200" name="username" value="" id="username"/> *
	</div>
	<div>
		<label for="password" id="password_label">用户密码：</label>
		<input type="password" maxlength="200" name="password" value="" id="password"/> *
	</div>
	<div>
		<label for="logcode" id="logcode_label">登陆机器：</label>
		<input type="text" maxlength="200" name="logcode" value="" id="logcode"/> *
	</div>
	<div id="post_button">
		<input type="submit" name="submit" value="登陆" class="button" />
	</div>
	</div>
	</form>
</div>
<div class="wrap">
	<b>修改机器码</b><hr>
	<form action="api.php?action=editcode" method="post" id="editcode" name="editcode">
	<div id="post">
	<div>
		<label for="username" id="username_label">用户账号：</label>
		<input type="text" maxlength="200" name="username" value="" id="username"/> *
	</div>
	<div>
		<label for="superpass" id="superpass_label">超级密码：</label>
		<input type="text" maxlength="200" name="superpass" value="" id="superpass"/> *
	</div>
	<div>
		<label for="newcode" id="newcode_label">新机器码：</label>
		<input type="text" maxlength="200" name="newcode" value="" id="newcode"/> *
	</div>
	<div id="post_button">
		<input type="submit" name="submit" value="修改" class="button" /> 
	</div>24小时仅可修改一次
	</div>
	</form>
</div>
<div class="wrap">
	<b>找回密码</b><hr>
	<form action="api.php?action=findpass" method="post" id="findpass" name="findpass">
	<div id="post">
	<div>
		<label for="username" id="username_label">用户账号：</label>
		<input type="text" maxlength="200" name="username" value="" id="username"/> *
	</div>
	<div>
		<label for="superpass" id="superpass_label">超级密码：</label>
		<input type="text" maxlength="200" name="superpass" value="" id="superpass"/> *
	</div>
	<div>
		<label for="password" id="password_label">重设密码：</label>
		<input type="text" maxlength="200" name="password" value="" id="password"/> *
	</div>
	<div id="post_button">
		<input type="submit" name="submit" value="找回" class="button" />
	</div>
	</div>
	</form>
</div>
<div class="wrap">
	<b>卡密升级</b><hr>
	<form action="api.php?action=checkkami" method="post" id="checkkami" name="checkkami">
	<div id="post">
	<div>
		<label for="username" id="username_label">用户账号：</label>
		<input type="text" maxlength="200" name="username" value="" id="username"/> *
	</div>
	<div>
		<label for="kami" id="kami_label">使用卡密：</label>
		<input type="text" maxlength="200" name="kami" value="" id="kami"/> *
	</div>
	<div id="post_button">
		<input type="submit" name="submit" value="升级" class="button" />
	</div>
	</div>
	</form>
</div>
<div class="wrap">
	<b>获取信息</b><hr>
	<form action="api.php?action=getinfo" method="post" id="getinfo" name="getinfo">
	<div id="post">
	<div>
		<label for="username" id="username_label">用户账号：</label>
		<input type="text" maxlength="200" name="username" value="" id="username"/> *
	</div>
	<div>
		<label for="token" id="token_label">Usertoken:</label>
		<input type="text" maxlength="200" name="token" value="" id="token"/> *
	</div>
	<div id="post_button">
		<input type="submit" name="submit" value="获取" class="button" />
	</div>
	</div>
	</form>
</div>
<div class="wrap">
	<b>修改密码</b><hr>
	<form action="api.php?action=modify" method="post" id="modify" name="modify">
	<div id="post">
	<div>
		<label for="username" id="username_label">用户账号：</label>
		<input type="text" maxlength="200" name="username" value="" id="username"/> *
	</div>
	<div>
		<label for="password" id="password_label">用户密码：</label>
		<input type="password" maxlength="200" name="password" value="" id="password"/> *
	</div>
	<div>
		<label for="newpass" id="newpass_label">修改密码：</label>
		<input type="password" maxlength="200" name="newpass" value="" id="newpass"/> *
	</div>
	<div id="post_button">
		<input type="submit" name="submit" value="修改" class="button" />
	</div>
	</div>
	</form>
</div>

<div class="wrap">
	<b>提交邀请码</b><hr>
	<form action="api.php?action=invitecode" method="post" id="modify" name="modify">
	<div id="post">
	<div>
		<label for="username" id="username_label">用户账号：</label>
		<input type="text" maxlength="200" name="username" value="" id="username"/> *
	</div>
	<div>
		<label for="password" id="password_label">邀请码：</label>
		<input type="password" maxlength="200" name="inv" value="" id="inv"/> *
	</div>
	<div id="post_button">
		<input type="submit" name="submit" value="提交" class="button" />
	</div>
	</div>
	</form>
</div>

<div class="wrap">
	<b>其他功能</b><hr>
	<p>暂无</p>
</div>
</body>
</html>



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
var div = document.getElementById('del_houtai'); 
div.setAttribute("class", "show"); 
</script>