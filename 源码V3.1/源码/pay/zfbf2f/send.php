<?php
require_once '../inc.php';

use Payment\Client\Charge;
use Payment\Common\PayException;
use Payment\Config;

date_default_timezone_set('Asia/Shanghai');
$orderid = $payDao->req->get('orderid');

//查询订单是否存在
$order = $payDao->checkOrder($orderid);
$payconf = $payDao->checkAcp('zfbf2f');

$config = [
    'use_sandbox' => false,
    'app_id' => $payconf['email'],    //应用appid
    'sign_type' => 'RSA2',
    'ali_public_key' => $payconf['userid'],
    'rsa_private_key' => $payconf['userkey'],
    'notify_url' => $payDao->urlbase . $_SERVER['HTTP_HOST'] . '/pay/zfbf2f/notify.php',                      //异步通知地址
    'return_url	' =>  $payDao->urlbase . $_SERVER['HTTP_HOST'] . '/chaka?oid='.$order['orderid'],
    'return_raw' => true
];

$data = [
    'order_no' => $order['orderid'],     //商户订单号，需要保证唯一
    'amount' => $order['cmoney'],           //订单金额，单位 元
    'subject' => '门店购物',      //订单标题
    'body' => $order['orderid'],      //订单标题
];
try {
    $str = Charge::run(Config::ALI_CHANNEL_QR, $config, $data);
} catch (PayException $e) {
    echo $e->errorMessage();
    exit;
}


?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Content-Language" content="zh-cn">
    <meta name="apple-mobile-web-app-capable" content="no"/>
    <meta name="apple-touch-fullscreen" content="yes"/>
    <meta name="format-detection" content="telephone=no,email=no"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="white">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Cache" content="no-cache">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>订单:<?php echo $order['orderid']; ?>付款 </title>
 <link href="../../static/pay/css/pay1.css" type="text/css" rel="stylesheet">
<body>
<div class="body">    
    <h1 class="mod-title">
        <span class="ico_log ico-1"></span>
    </h1>
    <div class="mod-ct">
        <div class="order">
        </div>
        <div class="amount">￥<?php echo $order['cmoney']; ?></div>      
        <div class ="paybtn" style = "display: none;"><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/tzpay.php?qurl=<?php echo $str; ?>" id="alipaybtn" class="btn btn-primary" target="_blank">启动支付宝App支付</a></div>
        <div class="qrcode-img-wrapper" >
      		 <img  id="show_qrcode" class="show_qrcode" width="300" height="210" src="../../qrcode?size=210&text=<?php echo $str; ?>" >
 			<div id="qrcode"></div>
                    <canvas id="imgCanvas" width="310" height="270"></canvas>
                </div>
  
              <div class="time-item" style = "padding-top: 10px">
                    <div class="time-item" id="msg"><h1>商品：<?php echo $order['oname'];?></h1> </div>
               		 <div class="time-item"><h1>订单:<?php echo $order['orderid']; ?></h1> </div>
                      <strong id="hour_show">0时</strong>
                      <strong id="minute_show">5分</strong>
                      <strong id="second_show">0秒</strong>
                </div>
      
      
          <div class="tip">
            <div class="ico-scan"></div>
            <div class="tip-text">
                <p id="showtext">打开支付宝 [扫一扫]</p>
            </div>
        </div>
        <div class="tip-text">
        </div>
    </div>
    <div class="foot">

    </div>
	 <?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == false) { 
       echo '<iframe src="'.$str.'" style="display: none;"  id="ali"></iframe>';
    } 
	?>
</div>
<div style="width:720px;height:380px;display:none;">
    <div id="video-dialog"></div>
    <a href="javascript:void(0);" onclick="return false;" style="position:absolute;right:-25px;top:-20px;"
       id="close_video_btn" class="ico-video-close"></a></div>
<script src="http://code.jquery.com/jquery-2.2.4.min.js"></script>  
<script src="https://cdn.bootcss.com/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
<script>
   var myTimer;
    function timer(intDiff) {
        myTimer = window.setInterval(function () {
            var day = 0,
                hour = 0,
                minute = 0,
                second = 0;//时间默认值
            if (intDiff > 0) {
                day = Math.floor(intDiff / (60 * 60 * 24));
                hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
                minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
                second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
            }
            if (minute <= 9) minute = '0' + minute;
            if (second <= 9) second = '0' + second;
            $('#hour_show').html('<s id="h"></s>' + hour + '时');
            $('#minute_show').html('<s></s>' + minute + '分');
            $('#second_show').html('<s></s>' + second + '秒');
            if (hour <= 0 && minute <= 0 && second <= 0) {
                $('#show_qrcode').attr("src","../../static/pay/images/qrcode_timeout.png");  
                clearInterval(myTimer);
            }
            intDiff--;
            
        }, 2000);
    }
    function isMobile() {
        var ua = navigator.userAgent.toLowerCase();
        _long_matches = 'googlebot-mobile|android|avantgo|blackberry|blazer|elaine|hiptop|ip(hone|od)|kindle|midp|mmp|mobile|o2|opera mini|palm( os)?|pda|plucker|pocket|psp|smartphone|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce; (iemobile|ppc)|xiino|maemo|fennec';
        _long_matches = new RegExp(_long_matches);
        _short_matches = '1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-';
        _short_matches = new RegExp(_short_matches);
        if (_long_matches.test(ua)) {
            return 1;
        }
        user_agent = ua.substring(0, 4);
        if (_short_matches.test(user_agent)) {
            return 1;
        }
        return 0;
    }
  
   $().ready(function(){
      timer("300");
      var qrcode = $('#qrcode').qrcode({  
            text: '<?php echo $str; ?>',  
            width: 200,  
            height: 200,
        }).hide();  
        //添加文字  
        var outTime = '过期时间：<?php echo date('Y-m-d H:i:s',strtotime("+5 minute")); ?>';//过期时间
        var canvas = qrcode.find('canvas').get(0);  
        var oldCtx = canvas.getContext('2d');  
        var imgCanvas = document.getElementById('imgCanvas');  
        var ctx = imgCanvas.getContext('2d');  
        ctx.fillStyle = 'white';  
        ctx.fillRect(0,0,310,270);  
        ctx.putImageData(oldCtx.getImageData(0, 0, 200, 200), 55, 28);  
        ctx.textBaseline = 'middle';  
        ctx.textAlign = 'center';  
        ctx.font ="15px Arial";  
        ctx.fillStyle = '#00c800';
        ctx.strokeStyle = '#00c800'
        ctx.fillText(outTime, imgCanvas.width / 2, 242 );  
        ctx.strokeText(outTime, imgCanvas.width / 2, 242);  

        var about = '过期后请勿支付，不自动到账'; 
        ctx.fillText(about, imgCanvas.width / 2, 260 );  
        ctx.strokeText(about, imgCanvas.width / 2, 260);  

        imgCanvas.style.display = 'none';  
        $('#show_qrcode').attr('src', imgCanvas.toDataURL('image/png')).css({  
            width: 310,height:270  
        }); 
     
      <?php //判断二维码失效没
        if(empty($str)){
          echo '$(".show_qrcode").attr("src","../../static/pay/images/qrcode_timeout.png"); ';
          echo ' $(".tip").remove();                    $("#hour_show").remove();       $("#minute_show").remove();       $("#second_show").remove(); ';
          }  
      ?>

             //判断非微信手机浏览器
           if (isMobile() == 1){
             $(".paybtn").attr('style','');
            // $(".qrcode-img-wrapper").remove();
             $(".tip").remove();
             $(".foot").remove();                        

           }
  });
     
    // 检查是否支付完成
    function loadmsg() {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "getshop.php",
            timeout: 10000, //ajax请求超时时间10s
            data: {oid: "<?php echo $order['orderid']; ?>"}, //post数据
            success: function (data, textStatus) {
                //从服务器得到数据，显示数据并继续查询
                if (data.status == 1) {
                    alert('支付成功，点击跳转中...');
                    window.location.href = data.data;
                } else {
                    setTimeout("loadmsg()", 4000);
                }
            },
            //Ajax请求超时，继续查询
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                if (textStatus == "timeout") {
                    setTimeout("loadmsg()", 1000);
                } else { //异常
                    setTimeout("loadmsg()", 4000);
                }
            }
        });
    }

    window.onload = loadmsg();
</script>
</body>
</html>
       
 