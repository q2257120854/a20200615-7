<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="keywords" content="">
<meta name="description" content="">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>扫码支付 安全快速！</title>
<link rel="stylesheet" href="css/buttons.css">
<link rel="stylesheet" type="text/css" href="css/pay.css">
<link rel="stylesheet" type="text/css" href="css/newpay.css">
<link rel="stylesheet" type="text/css" href="css/buttons.css">
<link charset="utf-8" rel="stylesheet" href="css/api.css" media="all">
<script type="text/javascript" src="css/jquery-1.8.0.min.js"></script>
<style type="text/css">
<!--
body,td,th {
	font-size: 12px;
}
-->
</style></head>
<body>
<?php 
$trade_no="uoceshi".time();//生成10位随机数的订单号
?>
<div class="topbar">
      <div class="topbar-wrap fn-clear">
        <a href="https://help.alipay.com/lab/help_detail.htm?help_id=258086" class="topbar-link-last" target="_blank" seed="goToHelp">常见问题</a>
        		<span class="topbar-link-first">你好，欢迎使用扫码付款！</span>

      </div>
    </div>
    <div id="header">
      <div class="header-container fn-clear">
        <div class="header-title">
          <span class="logo-title-news">
            我的收银台
          </span>
        </div>
      </div>
    </div>
     
<div id="container">
      <div id="content" class="fn-clear">
        <div id="J_order" class="order-area">
          <div id="order" class="order order-bow">
            <div class="orderDetail-base">
              <div class="commodity-message-row">
                <span class="first long-content">
                 请选择充值金额
                <span class="second short-content">
                
                </span>
              </div>
			   <span class="payAmount-area" id="J_basePriceArea">
            <strong class=" amount-font-22 "></strong>
        </span>

            </div>
          </div>
        </div>
        <!-- 操作区 -->
        <div class="cashier-center-container">
          <div>
            <!-- 扫码支付页面 -->
            <div>
      
              <!-- 扫码区域 -->
<form name="form1" id="form1" method="post" target="_blank" action="alipay.php">
<div 1="">
 <table width="800" border="0" align="center" cellpadding="8" cellspacing="1" bgcolor="#ffffff">
              <tbody><tr>
                <td height="60" colspan="2"><div align="center"><strong>请选择充值金额</strong></div></td>
              </tr>
              <tr>
                <td height="60"><div align="right">充值额度：
                  </div>
                  <div class="pay-dwb" id="bank_ICBCDiv">
                      <label></label>
                </div></td>
                <td>
				<div class="skl_moneyBox">
          <a money-type="0" data-value="1" class=""><font face="微软雅黑">￥1元</font></a>
          <a money-type="0" data-value="10" class=""><font face="微软雅黑">￥10元</font></a>
          <a money-type="0" data-value="50" class=""><font face="微软雅黑">￥50元</font></a>
          <a money-type="0" data-value="100" class="skl_selectli"><font face="微软雅黑">￥100元</font></a>
          <a money-type="0" data-value="200" class=""><font face="微软雅黑">￥200元</font></a>
          <a money-type="0" data-value="500" class=""><font face="微软雅黑">￥500元</font></a>
          <a money-type="1" class="">
            <input style="width:65px;color: #666;" name="skl_custom_money" type="text" value="其他金额"></a>
            <input type="hidden" id="skl_money" name="total_fee" value="100">
			<!--input type="hidden" id="text1" name="text1" value="1">
			<input type="hidden" id="text2" name="text2" value="2">
			<input type="hidden" id="text3" name="text3" value="3">
			<input type="hidden" id="text4" name="text4" value="4">
			<input type="hidden" id="text5" name="text5" value="5"-->
            <input type="hidden" name="skl_money_type" value="0"></div>
				</td>
              </tr>
              
              <tr>
                <td height="60"><div align="right">充值方式：</div></td>
                <td><label><div class="fenlei"><input name="pay" type="radio" value="1" checked="checked">支付宝扫码</div></label>
				    <label><div class="fenleiwx"><input type="radio" name="pay" value="3">微信支付</div></label>
                    <label><div class="fenleicf"><input type="radio" name="pay" value="2">QQ钱包支付</div></label>
					
					<input name="out_trade_no" type="hidden" id="out_trade_no" value="<?php echo $trade_no;?>">
					<input name="mobile" type="hidden" id="mobile" value="0">
				</td>
              </tr><tr>
                <td height="60"></td>
                <td><label> <input type="submit" name="Submit" id="Submit" class="button button-pill button-primary" value="二维码充值"></label></td>
              </tr>
            </tbody></table>
</form>
              </div>
            </div>
       
          </div>
        </div>
      </div>
	  </div>
<div id="partner"><br><p>本站为第三方辅助软件服务商，与支付宝官方和淘宝网无任何关系，本支付系统拒绝违法网站使用 <br>支付后将立即到达指定的账户。</p>
<br><img alt="合作机构" src="css/2R3cKfrKqS.png"></div>
<script>	
$(".payment-list ul li").click(function(){ $(this).parent().find('li').removeClass('curr');$(this).addClass('curr');
var n = $(this).index();
$("#payid").find("option").eq(n).attr("selected", true)
})
	
</script>
<script type="text/javascript">
$(function($) {

 //选择金额
 skl_moneyBoxLi=$(".skl_moneyBox a");
 skl_money=$("input[id='skl_money']");
 skl_custom_money=$("input[name='skl_custom_money']");
 skl_otherMoney="其他金额";
 
 skl_moneyBoxLi.click(function(){	 
	  
	//先移除样式
	skl_moneyBoxLi.removeClass("skl_selectli");
	
	thisLi=$(this);
	thisLi.addClass("skl_selectli");
	
	skl_money.val(thisLi.attr("data-value"));
	$("input[name='skl_money_type']").val(thisLi.attr("money-type"));
		 
});

	
	//获得焦点
	skl_custom_money.focus(function(){
    if(skl_custom_money.val() == skl_otherMoney){
		  skl_money.val(skl_custom_money.val(""));
		}
		
	});

	//焦点离开
	skl_custom_money.focusout(function(){
		skl_money.val(skl_custom_money.val());
	});		

  //显示默认金额
  skl_moneyBoxLi.first().click();
   
//alert(addds);
 });
</script>
</body></html>