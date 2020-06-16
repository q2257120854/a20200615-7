<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $data['gname'].$data['title'].$this->config['sitename']?></title>
    <meta name="description" content="<?php echo $this->config['description']?>">
    <meta name="keywords" content="<?php echo $this->config['keyword']?>">
	<link rel="stylesheet" href="https://cdn.bootcss.com/amazeui/2.7.2/css/amazeui.min.css">
	<script src="https://cdn.bootcss.com/jquery/1.7.2/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/amazeui/2.7.2/js/amazeui.min.js"></script>	
	<script src="https://cdn.bootcss.com/layer/2.3/layer.js"></script>
    <link rel="stylesheet" href="/static/default/assets/css/admin.css">
    <link rel="stylesheet" href="/static/default/assets/css/app.css">
    <style type="text/css"> 
      body{
      background: #e9ecf3 url(<?php echo $this->config['bodyimage']?>) no-repeat center center / cover;
    	background-attachment: fixed;
      }
        .am-container{
          max-width: 1200px;
        }
    
        /* 色调设置 */
       .good-trade{
             background-color: #fff;
        }
		.sy-form{
				background-color: #fff;				
		}
    </style>
</head>
<body>
  <header class="am-topbar am-topbar-inverse am-header-fixed">
<div class="am-container">
<h1 class="am-topbar-btn am-fl am-btn am-btn-sm am-btn-success am-show-sm-only">
    <a href="/"><i class="am-header-icon am-icon-home"></i></a>
  </h1>
  <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#doc-topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>
  <div class="am-collapse am-topbar-collapse" id="doc-topbar-collapse">
    <ul class="am-nav am-nav-pills am-topbar-nav ">
      <li><a href="/"><span class="am-icon-home am-icon-sm"></span>首页</a></li>
      <li><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $this->config['qq']?>&site=qq&menu=yes" target="_blank"><i class="am-icon-qq"></i>客服</a></li>
      	  <?php if($this->session->get('login_name')) { ?>		  
				  <li><a href="/user"><span class="am-icon-users"></span>会员中心</a></li>
				  <li><a href="/user/sett"><span class="am-icon-cog"></span>个人资料</a></li>	  	  
				  <li><a href="javascript:;" onclick="repwd()"><span class="am-icon-lock"></span>修改密码</a></li>
				  <li><a href="/login/logout"><span class="am-icon-sign-out"></span>退出</a></li>
           <?php }else{ ?>		   
			  <li><a href="/login"><span class="am-icon-sign-in"></span>登录</a></li>	
			  <li><a href="/reg"><span class="am-icon-sign-out"></span>注册</a></li> 
              <?php } ?> 
    </ul>	
    <form action="//<?php echo $_SERVER['SERVER_NAME'];?>" method="get" class="am-topbar-form am-topbar-left am-form-inline sy-form" role="search">
      <div class="am-form-group">
        <input type="text" name="gname" class="am-form-field am-input-sm" placeholder="搜索">
      </div>
    </form>

    <div class="am-topbar-right">
			<ul class="am-nav am-nav-pills am-topbar-nav">
            <li><a href="/chaka"><span class="am-icon-search"></span>订单查询</a></li>
            <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
          </ul>     
    </div>
  </div>
</div>
</header>
<div class="am-topbar"></div>