<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:13:"./tixian.html";i:1558859110;}*/ ?>
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
		.mui-input-group .mui-button-row{
		height:auto;
		}
	</style>
	
	<!--引入webuploader-->
	<link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css">
	<script type="text/javascript" src="https://fex.baidu.com/webuploader/js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="/webuploader/webuploader.js"></script>

</head>
<body style="background:#fff;">
	<header class="mui-bar mui-bar-nav header">
			<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left" style="color: #fff;"></a>
			<h1 class="mui-title h1">提现</h1>
	</header>	
	<br><br><br>
			<form class="mui-input-group form">
							<div class="mui-input-row divc">
								<img src="/tmc/img/sl.png"  class="img" style="width: 25px;"/>
								<input type="hidden" id="userid" class="int" value='<?php echo $userid; ?>'>
								<input type="number" id="txsl" class="int" placeholder="USDT提现数量">
							</div>
							<div class="mui-input-row divc">
								<img src="/tmc/img/qianbao.png"  class="img" style="width: 25px;"/>
								<input type="text" id="qbdz" class="int" placeholder="提现钱包地址">
							</div>
							<div class="mui-input-row divc">
								<img src="/tmc/img/mima.png"  class="img"style="width: 30px;" />
								<input type="password" id="jymm" class="int" placeholder="交易密码">
							</div>
							<!--
							<div class="mui-button-row">
								<button type="button" class="mui-btn mui-btn-danger button" style="background: #acb9c4;">上传凭证</button>
							</div>
							-->
							<!--dom结构部分-->
							<input type="hidden" id='pz' name='pz' value=''/>
							<div id="uploader-demo" class="mui-button-row">
								<!--用来存放item-->
								<div id="fileList" class="uploader-list"></div>
								<div id="filePicker" >上传凭证</div>
							</div>
							
			
							<br>
							<div class="mui-button-row">
								<button type="button" class="mui-btn mui-btn-danger button" onclick="scpz()">提现</button>
							</div><br>
						<p style="font-size: 0.6em;font-family: '微软雅黑';">注意事项：USDT提现时请仔细核对提现钱包地址是否填写正 确，避免发生因USDT提现地址错误而发生的不必要财产损失 。</p>
						</form>
						
		
</body>

<script>

	//提现
	function scpz(){
		
		$.ajax({
			url : 'http://45.127.96.224/admincmsby/users/tixian_details.html',
			type : 'post', 
			timeout:3000,   
			data : {  
				txsl:$('#txsl').val(),
				qbdz :$('#qbdz').val(),
				jymm :$('#jymm').val(),
				pz :$('#pz').val(),
				userid :$('#userid').val(),
			}, 
			success : function(data){
				alert(data);
			   
			},
			 error : function(xhr, erroType, error, msg) {
			}
		});
				 
	}

	// 初始化Web Uploader
	var uploader = WebUploader.create({

	    // 选完文件后，是否自动上传。
	    auto: true,
		fileVal:'file',

	    // swf文件路径
	    swf: '/webuploaderjs/Uploader.swf',

	    // 文件接收服务端。
	    server: 'http://45.127.96.224/getimage.html',

	    // 选择文件的按钮。可选。
	    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
		// 指定选择文件的按钮
		pick : {
			id : '#filePicker',// 指定选择文件的按钮的ID，class等
			multiple : false,// 是否开起同时选择多个文件能力
		},
		


	    // 只允许选择图片文件。
	    accept: {
	        title: 'Images',
	        extensions: 'gif,jpg,jpeg,bmp,png',
	        mimeTypes: 'image/*'
	    }
	});
	
	// 当有文件添加进来的时候
	uploader.on( 'fileQueued', function( file ) {
		var $li = $(
				'<div id="' + file.id + '" class="file-item thumbnail">' +
					'<img>' +
				'</div>'
				),
			$img = $li.find('img');


		// $list为容器jQuery实例
		$("#fileList ").empty();
		$("#fileList ").append( $li );

		// 创建缩略图
		// 如果为非图片文件，可以不用调用此方法。
		// thumbnailWidth x thumbnailHeight 为 100 x 100
		uploader.makeThumb( file, function( error, src ) {
			if ( error ) {
				$img.replaceWith('<span>不能预览</span>');
				return;
			}

			$img.attr( 'src', src );
		}, 100, 100 );
	});
	
	// 文件上传过程中创建进度条实时显示。
	uploader.on( 'uploadProgress', function( file, percentage ) {
		var $li = $( '#'+file.id ),
			$percent = $li.find('.progress span');

		// 避免重复创建
		if ( !$percent.length ) {
			$percent = $('<p class="progress"><span></span></p>')
					.appendTo( $li )
					.find('span');
		}

		$percent.css( 'width', percentage * 100 + '%' );
	});
	
	// 文件上传成功，给item添加成功class, 用样式标记上传成功。
	uploader.on( 'uploadSuccess', function( file ,response) {
		$( '#'+file.id ).addClass('upload-state-done');
		$( '#pz').val(response._raw);
		
	});

	// 文件上传失败，显示上传出错。
	uploader.on( 'uploadError', function( file ) {
		var $li = $( '#'+file.id ),
			$error = $li.find('div.error');

		// 避免重复创建
		if ( !$error.length ) {
			$error = $('<div class="error"></div>').appendTo( $li );
		}

		$error.text('上传失败');
	});

	// 完成上传完了，成功或者失败，先删除进度条。
	uploader.on( 'uploadComplete', function( file ) {
		$( '#'+file.id ).find('.progress').remove();
	});
	
	

</script>

</html>