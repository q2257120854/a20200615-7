<?php
//禁用错误报告
//error_reporting(0);
$trade_no=trim(htmlspecialchars($_REQUEST['out_trade_no']));//接收订单号
$cny=(float)trim(htmlspecialchars($_REQUEST['total_fee']));     //付款金额
$cny = number_format($cny, 2, '.', '');
$type=trim(htmlspecialchars($_REQUEST['pay']));
$urlok=trim(htmlspecialchars($_REQUEST['url']));
$picurlewm=trim(htmlspecialchars($_REQUEST['picurlewm']));
$appid=trim(htmlspecialchars($_REQUEST['appid']));
$beizhu=trim(htmlspecialchars($_REQUEST['beizhu']));
$gdpicurlewm=trim(htmlspecialchars($_REQUEST['gdpicurlewm']));//固定金额
$zhanghao=trim(htmlspecialchars($_REQUEST['zhanghao']));//固定金额

$jines=(float)trim(htmlspecialchars($_REQUEST['jines']));     //金额
$jines = number_format($jines, 2, '.', '');

$type=1;

  if(stripos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false){
  $isweixin=0;
  }else{
  $isweixin=1;
  }
//echo $trade_no."-".$cny."-".$type."-".$urlok."-".$picurlewm."-".$appid."-".$beizhu."-".$gdpicurlewm."-".$jines."-".$zhanghao;
//exit();
?>

<?php
if ($isweixin==1 and $type==1){
?>

<html class="no-js css-menubar" lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>在线付款</title>
	<link rel="stylesheet" href="wapcss/bootstrap.css">
    <link rel="stylesheet" href="wapcss/bootstrap-extend.css">
    <link rel="stylesheet" href="wapcss/site.css">
	<script type="text/javascript" src="wapcss/jquery-2.1.1.min.js"></script>
	<script src="css/jquery.min.js"></script>
<script type="text/javascript">
var intDiff = parseInt(300);
function timer(intDiff){
    window.setInterval(function(){
    var day=0,
        hour=0,
        minute=0,
        second=0;    
    if(intDiff > 0){
        day = Math.floor(intDiff / (60 * 60 * 24));
        hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
        minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
        second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
    }
    if (minute <= 9) minute = '0' + minute;
    if (second <= 9) second = '0' + second;
    $('#day_show').html(day+"天");
    $('#hour_show').html('<s id="h"></s>'+hour+'时');
    $('#minute_show').html('<s></s>'+minute+'分');
    $('#second_show').html('<s></s>'+second+'秒');
     if(intDiff==0){
     self.location.href="<?php echo $urlok;?>";
	 //self.location.href=location.replace;
	 }
    intDiff--;
    }, 1000);
} 
$(function(){
    timer(intDiff);
});
</script>
</head>
  <body class="page-maintenance layout-full">
    <div class="page animsition text-center" style="-webkit-animation: 800ms; opacity: 1;">
      <div class="page-content vertical-align-middle">
          <!-- Qpay -->
          <div id="pjax" class="container">
            <div class="row paypage-logo">
              <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-xs-12 paypage-logorow">
                <img src="wapcss/zfb.png" alt="支付宝" width="94"></div>
            </div>
            <div class="row paypage-info">
              <div class="col-lg-6 col-lg-offset-2 col-md-7 col-md-offset-1 col-xs-10 col-xs-offset-0">
                <p class="paypage-desc">会员ID/订单号：<?php echo $trade_no;?></p>
              </div>
              <div class="col-lg-2 col-md-3 col-xs-2 clearfix">
                <p class="paypage-price">
                  <span class="paypage-price-number"><?php echo $jines;?></span>元</p>
              </div>
			  <div class="col-lg-6 col-lg-offset-2 col-md-7 col-md-offset-1 col-xs-10 col-xs-offset-0">
                <p class="paypage-desc">需要支付金额:<?php echo $beizhu;?></p>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-xs-12 paypage-qrrow">
			  
			  请点击右上角菜单，安卓选择在浏览器中打开，苹果选择在Safari中打开...请不要刷新本页面,在规定时间内支付,否则会充值失败哦!!!</br></br>
			  <div class="site-footer-right"></div>
				 <input name="payAmount" id="payAmount" value="<?php echo $jines;?>" type="hidden">
				 <input name="title" id="title" value="<?php echo $trade_no;?>" type="hidden">
				 <input name="APPID" id="APPID" value="<?php echo $appid;?>" type="hidden">
				 <input name="type" id="type" value="<?php echo $type;?>" type="hidden">
				 <input name="beizhu" id="beizhu" value="<?php echo $beizhu;?>" type="hidden">
				 <input name="zhanghao" id="zhanghao" value="<?php echo $zhanghao;?>" type="hidden">

                <p id="paypage-order" class="">
                  <span data-toggle="tooltip" data-placement="bottom" data-trigger="hover" data-title="支付后将自动发货" class="tip_show" data-original-title="" title="">订单号:<?php echo $trade_no;?></span><br><strong id="minute_show"><s></s>04分</strong>
    <strong id="second_show"><s></s>44秒</strong>过期               </p>
			 <p class="animation-slide-bottom">
            <a class="btn btn-danger" href="#">付款成功会自动跳转</a>			</p>	
				  </div>
		</div>
	  </div>
    </div>  
	
<footer class="site-footer">
<div class="site-footer-legal"></div>
<div class="site-footer-right">
  <a target="_blank">支付宝</a></div>
</footer>
</div>
</body></html>

<?php
}else{
if($gdpicurlewm==""){
echo "Error..";
exit();
}else{
	$url = $gdpicurlewm;
	header("Location:$url");
	die;
}
}
?>

<script type="text/javascript">
$(function(){
    var posTimmer;
	var $win = $(window);
	var $submit = $('#submit');
		setInterval(function(){
		  $.ajax({
			url:"zidong.php",
			type: "post",
			timeout:2000,
			data: {tradeNo:$("#title").val(),payAmount:$("#payAmount").val(),APPID:$("#APPID").val(),paytype:$("#type").val(),zhanghao:$("#zhanghao").val(),beizhu:$("#beizhu").val()},
			success: function(d){
				if(d == "success" ){
					$submit.text('付款成功');
					setTimeout(function(){
						if ( 0 ) {
							location.replace("<?php echo $urlok;?>");
						} else {
							if (window.opener) {
								location.replace("<?php echo $urlok;?>");
							} else {
								location.replace("<?php echo $urlok;?>");
							}
						}
					},500);
				}
			}
		  });
		},2000);
		$('#msgPayForm').submit();
});
</script>
<?php
if ($isweixin==1 and $type==1){//是微信是支付宝
echo "<script language='javascript' type='text/javascript'>";
echo "setTimeout(\"alert('重要提示：点右上角选在浏览器打开，付款时必须输入指定金额(".$cny."),请不要刷新本页面,在规定时间内支付,否则会充值失败哦,')\",2000);";
echo "</script>";
}
?>