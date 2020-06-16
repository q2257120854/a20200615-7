<?php
/*
* File：后台登陆
* Author：易如意
* QQ：51154393
* Url：www.eruyi.cn
* 模板：BIN
* BIN博客：fooor.cn
*/
$err = isset($_GET['err']) ? intval($_GET['err']) : 0;
$errmsg = array(null,'账号密码不能为空','账号密码有误','您还没有登陆，请先登录！');
$error_msg = $errmsg[$err];
?>
<!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <title>管理登录</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="format-detection" content="telephone=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="alternate icon" type="image/png" href="assets/img/favicon.ico">
  <link rel="stylesheet" href="assets/css/amazeui.min.css"/>
  <style>
    .header {
      text-align: center;
    }
    .header h1 {
      font-size: 200%;
      color: #333;
      margin-top: 30px;
    }
    .header p {
      font-size: 14px;
    }
  </style>
</head>
<body>
<div class="header">
  <div class="am-g">
    <h1>后台管理</h1>
  </div>
  <hr />
</div>
<div class="am-g">
  <div class="am-u-lg-4 am-u-md-4 am-u-sm-centered">
    <form method="post" class="am-form"  action="./index.php?action=login">
      <label for="text">账号:</label>
      <input type="text" name="user" id="user"  value="">
      <br>
      <label for="password">密码:</label>
      <input type="password" name="pw" id="pw" value="">
      <br>
      <label for="remember-me">
        <input id="remember-me" type="checkbox">
        记住密码
      </label>
      <br />
      <div class="am-cf">
        <input type="submit" name="" value="登 录" class="am-btn am-btn-primary am-btn-sm am-fl">
        <?php if ($error_msg): ?>
        <br>
        <p><?php echo $error_msg; ?></p>   
        <?php endif;?>
      </div>
    </form>
    <hr>
    <p>© 2018 <a href="https://fooor.cn">BIN</a></p>
  </div>
</div>
</body>
</html>
