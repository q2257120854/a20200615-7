<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"/www/wwwroot/leetao.cn/public/../application/index/view/member/order_cmm_list.html";i:1562133044;}*/ ?>
<!DOCTYPE html>

<html style="background:#fff">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <title></title>
	
    <link href="__HOME_CSS__/mui.min.css" rel="stylesheet"/>
    <link href="__HOME_CSS__/style.css" rel="stylesheet"/>
    <link rel="stylesheet" href="__INDEX_CSS__/base.css" />

    <link rel="stylesheet" href="__INDEX_CSS__/swiper.min.css">

    <link rel="stylesheet" href="__INDEX_CSS__/style.css" />

    <script type="text/javascript" src="__INDEX_JS__/jquery-1.7.js" ></script>
<style type="text/css">
			.mui-bar {background: #fff;}
			.mui-input-row label {
				font-size: .32rem;
				color: #444;
			}
			.mui-input-group .mui-input-row:after {
				left: 0;
				background-color: #E6E6E6;
			}
			.mui-bar-nav {
			    padding-top: 20px;
			    box-sizing: content-box;
			    background-color: #fff;
			    border-bottom: 1px solid #eee;
			}			
			.mui-input-group .mui-input-row,
			.mui-input-row label~input {
				height: 60px;
			}
			.mui-input-row label {
				line-height: 40px;
			}
			.app-btn {
				padding: 15px;
				background: #3C7FFF;
				border: 1px solid #3C7FFF;
			}
			.container{
			background:#ffffff;
			}
			.sjfl li.on a{
			color:#957afd;
			border-color:#957afd;
			}
		</style>

</head>

<body style="background:#fff;">


	<div class="wrap">
		<header class="mui-bar mui-bar-nav" style="background: #fff;">
			<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"style="color: #957afd;"></a>
			<h1 class="mui-title">乐豆交换</h1>
		</header>
		<br><br>
        <!--分类tab-->

	    <ul class="sjfl" style="top:65px;">

	      <li class="on" style="width:25%;"><a href="#1">乐豆需求</a></li>
	      <li style="width:25%;"><a href="#2">乐豆转让</a></li>
		  <li style="width:25%;"><a href="#3">交换中</a></li>
	      <li style="width:25%;"><a href="#4">已完成</a></li>

	    </ul>
		<br>
	    <div class="container" style="padding-top:86px">

				<ul class="dd_content">
					
					<!--买入-->
					<li style="display:block">
						<ul class="ddlist">
							<?php if(is_array($buylog) || $buylog instanceof \think\Collection || $buylog instanceof \think\Paginator): if( count($buylog)==0 ) : echo "" ;else: foreach($buylog as $key=>$vo): ?>
							<li>
								
								<div class="ddtitle">
									订单号
									<span class="grey">
										<?php echo $vo['orderid']; ?>
									</span>
									<span class="zj red">
										￥<?php echo $vo['total_money']; ?>元
									</span>
								</div>
								<ul class="last">
									<li>
										<ul class="ddtwo">
											<li>
												<label>
													产品类型：
												</label>
												<span class="red">
													购机币
												</span>
											</li>
											<li>
												<label>
													单价：
												</label>
												<span class="hs">
													<?php echo $vo['price']; ?>
												</span>
											</li>
											<li>
												<label>
													数量：
												</label>
												<span>
													<?php echo $vo['amount']; ?>
												</span>
											</li>
											<li>
												<label>
													人民币：
												</label>
												<span class="red">
													<?php echo $vo['total_money']; ?>
												</span>
											</li>
											<li>
												<label>
													买入时间：
												</label>
												<span>
													<?php echo date("Y-m-d H:i",$vo['addtime']); ?>
												</span>
											</li>
										</ul>
									</li>
								</ul>
								<div class="ddtitle">
									当前状态：
									<?php if($vo['status'] == '0'): ?>
									<span class="red">
										冻结
									</span>
									<?php endif; if($vo['status'] == '2'): ?>
									<span style="color:#0062cc;">
										等待中
									</span>
									<?php endif; ?>
									<!--0冻结交易，1成功交易（卖家确认收款），2等待买家付款，3等待卖家确认收款-->

										<?php if($vo['m_st'] == '110'): ?>
										<span style="color:#0062cc;">
											排队中
										</span>
										<?php endif; if($vo['m_st'] == '0'): ?>
										<span class="red">
											冻结交易
										</span>
										<?php endif; if($vo['m_st'] == '1'): ?>
										<span style="color:#006f19;">
											成功交易
										</span>
										<?php endif; if($vo['m_st'] == '2'): ?>
										<span class="red">
											等待买家付款
										</span>
										<?php endif; if($vo['m_st'] == '3'): ?>
										<span class="red">
											等待卖家确认收款
										</span>
										<?php endif; ?>
										
									<a href="/xiangqing.html?orderid=<?php echo $vo['orderid']; ?>" style="color: #fff; background:#3c7fff;">查看详情</a>
								</div>
							</li>
							<?php endforeach; endif; else: echo "" ;endif; ?>

						</ul>
					</li>
					
					<!--卖出-->
					<li>
						<ul class="ddlist">
							<?php if(is_array($selllog) || $selllog instanceof \think\Collection || $selllog instanceof \think\Paginator): if( count($selllog)==0 ) : echo "" ;else: foreach($selllog as $key=>$vo): ?>
							<li>
								<div class="ddtitle">
									订单号
									<span class="grey">
										<?php echo $vo['orderid']; ?>
									</span>
									<span class="zj red">
										￥<?php echo $vo['total_money']; ?>元
									</span>
								</div>
								<ul class="last">
									
									<li>
										<ul class="ddtwo">
											<li>
												<label>
													产品类型：
												</label>
												<span class="red">
													可售额度
												</span>
											</li>
											<li>
												<label>
													单价：
												</label>
												<span class="hs">
													<?php echo $vo['price']; ?>
												</span>
											</li>
											<li>
												<label>
													数量：
												</label>
												<span>
													<?php echo $vo['amount']; ?>
												</span>
											</li>
											<li>
												<label>
													人民币：
												</label>
												<span class="red">
													<?php echo $vo['total_money']; ?>
												</span>
											</li>
											<li>
												<label>
													买入时间：
												</label>
												<span>
													<?php echo date("Y-m-d H:i",$vo['addtime']); ?>
												</span>
											</li>
										</ul>
									</li>
									
								</ul>
								<div class="ddtitle">
									当前状态：
									<?php if($vo['status'] == '0'): ?>
									<span class="red">
										冻结
									</span>
									<?php endif; if($vo['status'] == '2'): ?>
									<span style="color:#0062cc;">
										等待中
									</span>
									<?php endif; ?>
									<!--0冻结交易，1成功交易（卖家确认收款），2等待买家付款，3等待卖家确认收款-->

										<?php if($vo['m_st'] == '110'): ?>
										<span style="color:#0062cc;">
											排队中
										</span>
										<?php endif; if($vo['m_st'] == '0'): ?>
										<span class="red">
											冻结交易
										</span>
										<?php endif; if($vo['m_st'] == '1'): ?>
										<span style="color:#006f19;">
											成功交易
										</span>
										<?php endif; if($vo['m_st'] == '2'): ?>
										<span class="red">
											等待买家付款
										</span>
										<?php endif; if($vo['m_st'] == '3'): ?>
										<span class="red">
											等待卖家确认收款
										</span>
										<?php endif; ?>
										<a href="/xiangqing.html?orderid=<?php echo $vo['orderid']; ?>" style="color: #fff;">查看详情</a>
								</div>
							</li>
							<?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					</li>		
					
					
				</ul>

        </div>

     </div>

</body>

<script>


		
		$(".mui-action-back").click(function(){
			self.location='/index.html'; 
		});

		$(".sjfl li").click(function(){

			var index=$(this).index();

			$(this).addClass("on").siblings().removeClass();

		    $(".dd_content>li").hide().eq(index).show()

		});
		
	var id='';
	function showBuysss(id){
		console.log(id);
		//self.location= window.location.host+'/xiangqing.html?orderid='+id; 
	}
	 id='';
	function showSellsss(id){
	console.log(id);
		//self.location= window.location.host+'/xiangqing.html?orderid='+id; 
	}		

	
	

</script>

</html>