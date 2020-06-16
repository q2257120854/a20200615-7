
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title><?php echo $data['title'].'-'. $this->config['sitename']; ?></title>
    <meta name="description" content="<?php echo $data['title'].'-'. $this->config['sitename']; ?>">
    <meta name="keywords" content="<?php echo $data['title'].'-'. $this->config['sitename']; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="shortcut icon" href="/static/default/favico.ico" />
	<link rel="stylesheet" href="//cdn.amazeui.org/amazeui/2.7.2/css/amazeui.min.css">
	<link rel="stylesheet" href="//s.amazeui.org/assets/2.x/css/amaze.min.css?v=ivneousa">
	<!--[if (gte IE 9)|!(IE)]><!--><script src="//s.amazeui.org/assets/2.x/js/jquery.min.js"></script><!--<![endif]-->
	<!--[if lt IE 9]>
    <script src="http://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://cdn.amazeui.org/modernizr/2.8.3/modernizr.js"></script>
    <script src="//s.amazeui.org/assets/2.x/js/amazeui.ie8polyfill.min.js"></script>
    <![endif]-->
	<script src="//cdn.amazeui.org/amazeui/2.7.2/js/amazeui.min.js"></script>	
	<link rel="stylesheet" href="/static/default/reg/css/app.css">
    <style>
	.sy-form{
				background-color: #fff;				
		}
    </style>
</head>
<body data-type="login" class="theme-white">
 <header class="am-topbar am-topbar-inverse">
<div class="am-container">
<h1 class="am-topbar-btn am-fl am-btn am-btn-sm am-btn-success am-show-sm-only">
    <a href="/"><i class="am-header-icon am-icon-home"></i></a>
  </h1>
  <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#doc-topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>
  <div class="am-collapse am-topbar-collapse" id="doc-topbar-collapse">
    <ul class="am-nav am-nav-pills am-topbar-nav">
      <li><a href="/"><span class="am-icon-home am-icon-sm"></span>首页</a></li>
      <li><a href="http://wpa.qq.com/msgrd?v=<?php echo $this->config['qq']?>&uin=&site=qq&menu=yes" target="_blank"><i class="am-icon-qq"></i>客服</a></li>
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
<div class="am-g tpl-g">

    <div class="tpl-login">
        <div class="tpl-login-content">
                        <div class="tpl-login-title"><?php echo $this->config['sitename'].'-'.$data['title'] ; ?></div>
                        <span class="tpl-login-content-info">
                  创建一个新的用户
              </span>


            <form class="am-form tpl-form-line-form form-ajax" action="<?php echo $this->dir ?>/reg/save" method="post" >
                <div class="am-form-group">
                    <input type="email" name="email" class="tpl-form-input"  placeholder="邮箱" required>

                </div>

                <div class="am-form-group">
                    <input type="text" name="uname" class="tpl-form-input"  placeholder="用户名：请输入3个字符以上" required>
                </div>

                <div class="am-form-group">
                    <input type="password" name="upasswd" class="tpl-form-input"  placeholder="请输入密码：6位字符以上" required>
                </div>

                <div class="am-form-group">
                    <input type="password" name="rpasswd" class="tpl-form-input"  placeholder="再次输入密码" required>
                </div>

                <div class="am-form-group tpl-login-remember-me">
                    <input id="remember-me" name="ckmember" type="checkbox" checked>
                    <label for="remember-me">

                        我已阅读并同意 <a href="javascript:;" onclick="userCheck()">《用户注册协议》</a>
                    </label>

                </div>


                <div class="am-form-group">

                    <button type="submit" class="am-btn am-btn-primary  am-btn-block tpl-btn-bg-color-success tpl-login-btn">提交</button>

                </div>
            </form>
        </div>
    </div>
</div>
<div class="userCheckTxt" style="display: none">
    <?php echo $this->config['xieyi'] ; ?>
</div>

</body>

</html>
<script src="/static/common/layer/layer.js"></script>
<script src="/static/default/assets/js/app.js"></script>
<script src="/static/default/js/app.js"></script>
<script>

    function userCheck() {
        layer.open({
            title:'用户注册协议',
            type: 1,
            skin: 'layui-layer-rim', //加上边框
            area: ['700px', '500px'], //宽高
            content: $('.userCheckTxt').html()
        });
    }

</script>