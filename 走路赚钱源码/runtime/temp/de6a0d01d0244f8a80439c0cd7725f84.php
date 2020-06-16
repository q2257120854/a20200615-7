<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:15:"./chongzhi.html";i:1558626092;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title></title>
    <script src="/tmc/js/mui.min.js"></script>
    <link href="/tmc/css/mui.min.css" rel="stylesheet"/>
    <script type="text/javascript" charset="utf-8">
      	mui.init();
    </script>
	<style>
		.body{
			line-height: px;
		}
		.mui-table-view-cell:after{
			left: 0px;
			background-color:#efeff4;
		}
		.mui-table-view:before{ 
			background-color:#efeff4;
		}
		.mui-table-view:after{
			background-color:#efeff4;
		}
		.mui-input-group:before{
			height:0px
		}
		.mui-input-group:after{
			height:0px;
		}
		.header{
			background:blue;
			top:0;
			box-shadow:0 0px 0px #ccc;
			-webkit-box-shadow:0 0px 0px #ccc;
		}
		.h1{
			font-family:'微软雅黑';
			color:#fff;
		}
		.ul{
			margin-top:40px;
			background:blue;
			line-height:2em;
		}
		.p{
			margin-left:10%;
			font-family:'微软雅黑';
			color:aquamarine;
		}
		.p1{
			position:absolute;
			left:35%;
			bottom:12px;
			font-family:'微软雅黑';
			font-size:1em;
			color:#fff;
		}
		.form{
			top:20px;
			height:0px;
			width:80%;
			left:0px;
			right:0px;
			margin:auto;
		}
		.divc{
			border-radius:30px;
			background-color:#fff;
			margin-bottom:30px;
		}
		.img{
			position:absolute;
			width:30px;
			margin-left:15px;
			margin-top:4px;
		}
		.int{
			color:#0062CC;
			margin-left:22%;
			font-size:0.9em;
			font-family:'微软雅黑';
		}
		.button{
			line-height:2em;
			font-size:0.9em;
			width:80%;
			font-family:'微软雅黑';
			border-radius:10px;
			border:0px solid;
			background:blue;
		}
	</style>
</head>
<body style="background:#fff;">
	<header class="mui-bar mui-bar-nav header">
			<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left" style="color: #fff;"></a>
			<h1 class="mui-title h1">充值</h1>
	</header>	
		<ul class="mui-table-view ul">
			<li class="mui-table-view-cell mui-collapse-content"><p class="p">钱包地址</p><p class="p1">das45d6asd456</p> </li>
		</ul>
			<form class="mui-input-group form">
							<img src="/tmc/img/qrcode.png" style="width: 120px; margin-left: 100px;" />
							<br><br>
							<div class="mui-input-row divc">
								<img src="/tmc/img/sl.png"  class="img" style="width: 25px;"/>
								<input type="hidden" id="userid" class="int" value='<?php echo $userid; ?>'>
								<input type="number" id="czsl" class="int" placeholder="充值数量">
							</div>
							<div class="mui-input-row divc">
								<img src="/tmc/img/mima.png"  class="img"style="width: 30px;" />
								<input type="password" id="jymm" class="int" placeholder="交易密码">
							</div>
							<div class="mui-button-row">
								<button type="button" class="mui-btn mui-btn-danger button"  onclick="scpz()">上传凭证</button>
							</div> 
							<br>
							<!--div class="mui-button-row">
								<button type="button" class="mui-btn mui-btn-danger button">转让</button>
							</div--><br>
						<p style="font-size: 0.6em;font-family: '微软雅黑';">注意事项：USDT充值时请先复制充值地址至交易所或者第三 方钱包发币地址，发币成功后请截图并且在充值审核时上传发 币成功截图。</p>
						</form>
						<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script>
			function scpz(){
				var czsl=$('#czsl').val();
				var jymm=$('#jymm').val();
				
				$.ajax({
    url : 'http://45.127.96.224/admincmsby/users/recharge_details.html',
    type : 'post', 
    timeout:3000,   
    data : {  
        czsl:$('#czsl').val(),
        jymm :$('#jymm').val(),
        userid :$('#userid').val(),
    }, 
    success : function(data){
        alert(data);
       
    },
     error : function(xhr, erroType, error, msg) {
    }
});
				 
				
				
				
				
				
			}
		</script>
</body>
</html>