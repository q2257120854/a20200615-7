<?php
require_once('../system/incs.php');

require_once("ldtimeout.php");

if (get_usershipin('price', $_REQUEST['id'])<0) {
    exit("2");
    alert_href('金额不能低于0元', '/pay.php?id='.$_REQUEST['id']);
}

  //订单记录
    $_data1['ip'] =xiaoyewl_ip();
    $_data1['vid'] = $_REQUEST['id'];
    $_data1['uid'] =get_usershipin('uid', $_REQUEST['id']);
    $_data1['dingdanhao'] = $_REQUEST['out_trade_no'].time();
    $_data1['vprice'] = get_usershipin('price', $_REQUEST['id']);
    $_data1['date'] = date('Y-m-d H:i:s');
    $_data1['zt'] = 0;
    $cost = $_GET['jiage'];
    $str1 = arrtoinsert($_data1);
    $sql1 = 'insert into '.flag.'order ('.$str1[0].') values ('.$str1[1].')';
     mysql_query($sql1);


if (!function_exists('get_openid')) {
    require $_SERVER['DOCUMENT_ROOT'].'/fastpay/Fast_Cofig.php';
}

$paydata=array();
$paydata['uid']=$_data1['ip'];//支付用户id,如果没有可以填写ip,不要填写随机数
$paydata['order_no']=$_data1['dingdanhao'];//订单号
$paydata['total_fee']=$cost;//金额
$paydata['param']=$_data1['uid']."|".$_data1['vid'];//其他参数
$paydata['me_back_url']="http://".$_SERVER['HTTP_HOST']."/shipin.php?id=".$_data1['vid'];//支付成功后跳转
$paydata['notify_url']="http://".$_SERVER['HTTP_HOST']."/fastpay/notify.php";//支付成功后异步回调

$geturl=fastpay_order($paydata, "http");//获取支付链接，可以传入https
exit("<meta http-equiv='Refresh' content='0;URL={$geturl}'>");



if ($ldpayoff==1) {
    echo "<font color='#333333' style='font-size:18px; font-weight:bold;'>网站接口维护,请稍后重试.</font>";
    exit;
}
$trade_no=trim(htmlspecialchars($_REQUEST['out_trade_no']));//接收订单号
$optEmail="在线支付";//收款人的账号 用于显示在页面上
//$cny=(float)trim(htmlspecialchars($_REQUEST['total_fee']));     //付款金额
$cny=trim(htmlspecialchars($_REQUEST['total_fee']));     //付款金额
$cny = number_format($cny, 2, '.', '');//---------20170823-------------------
$type=trim(htmlspecialchars($_REQUEST['pay']));   //支付方式

$text1=trim(htmlspecialchars($_REQUEST['text1']));   //备用字段1 无需传值 varchar(255) 20180607
$text2=trim(htmlspecialchars($_REQUEST['text2']));   //备用字段2 无需传值 varchar(255) 20180607
$text3=trim(htmlspecialchars($_REQUEST['text3']));   //备用字段3 无需传值 varchar(255 )20180607
$text4=trim(htmlspecialchars($_REQUEST['text4']));   //备用字段4 无需传值 int(8) default '0' 20180607
$text5=trim(htmlspecialchars($_REQUEST['text5']));   //备用字段5 无需传值 int(8) default '0' 20180607

$mobile="0";   //预留参数请设置传递值为
$ewmappid = $dosql->GetOne("SELECT * FROM `#@__ewmadmin` WHERE `id`=1");
$key=$ewmappid['appid'];//APPID

if ($type==1) {
    $appimagename="zfb.png";
    $typename="支付宝扫码";
    //$picurlewm= "HTTPS://QR.ALIPAY.COM/xxxxxxxxxxxxxxxxxxxx";  //通用支付宝二维码地址
    $picurlfx="tyali.jpg";
    $ewmmaxn=$cny.".09";
}
if ($type==2) {
    $appimagename="qqqianbao.jpg";
    $typename="QQ钱包扫码";
    //$picurlewm= "tyten.jpg";  //通用QQ二维码地址
    $picurlfx="tyten.jpg";
    $ewmmaxn=$cny.".09";
}
if ($type==3) {
    $appimagename="wx.png";
    $typename="微信扫码";
    //$picurlewm= "tywx.jpg";  //通用微信二维码地址
    $picurlfx="tywx.jpg";
    $ewmmaxn=$cny.".09";
}
//判断是否是手机
function is_mobile()
{
    $regex_match="/(nokia|iphone|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|";
    $regex_match.="htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|";
    $regex_match.="blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|";
    $regex_match.="symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|";
    $regex_match.="jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220";
    $regex_match.=")/i";
    return isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE']) or preg_match($regex_match, strtolower($_SERVER['HTTP_USER_AGENT']));
}
$is_mobile=is_mobile();

if ($renyitype==0) {
    if ($is_mobile) {
        $mobile=2;
        if ($type<=3) {
            require_once("appapiewm.php");
        }
    } else {
        if ($type<=3) {
            require_once("apiewm.php");
        }
    }
} else {
    if ($is_mobile) {
        $mobile=2;
        if ($type<=3) {
            require_once("appapiewmry.php");
        }
    } else {
        if ($type<=3) {
            require_once("apiewmry.php");
        }
    }
}

  if (stripos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false) {
      $isweixin=0;
  } else {
      $isweixin=1;
  }

$types = "add_balance";
$custom2= "approved";
$custom6=1;
$urlhistory = $dosql->GetOne("SELECT * FROM `#@__ewmadmin` WHERE `appid`='{$key}' and `type`='{$types}' and fkok=1 and `custom2`='{$custom2}' and `custom6`='{$custom6}' order by id asc");
$httpurls = $urlhistory['urls'];
$urlbak = $urlhistory['jiekou'];
$urlok = "http://".$urlbak;
//var_dump($ewm);die;

 ?>




<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no" />
<title></title>
<link href="video/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="video/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="video/js/lyz.delayLoading.min.js?rndjs=1392"></script>
<script type="text/javascript" src="video/js/lyz_load.js?rndjs=1392"></script>
<script type="text/javascript" src="video/js/public.js?rndjs=1392"></script>
<script type="text/javascript" src="video/js/winset.js?rndjs=1392"></script>
<script type="text/javascript">
document.title = unescape('%u5FAE%u4FE1%u652F%u4ED8');

$(function(){
check_win_common();
});

$(window).resize(function(){
check_win_common();
});
</script>
</head>
<body>
<section id="container">
<!--<textarea id="copyhidtext"></textarea>
<div id="win_con_box1">
<div class="h_close"><i onclick="javascript:Close_win_con1();">关闭</i></div>
<div class="h_con1"><p id="actext"></p>请复制以上金额以便下一步粘贴！</div>
<div class="h_con2">支付金额完全一致才可观看</div>
<div class="h_con3"><input type="button" class="c_btn" value="复制" onclick="copyText1('actext','copyhidtext');"></div>
</div>-->
<!-------------------------------->
<div class="h_payqr_box">

<div class="vcon"><span>您正要购买的是：《<?=get_usershipin('name', $_REQUEST['id'])?>》</span></div>

 <?php
$t = explode('/', $ewm);
  $m = end($t);
  $m = str_replace('.jpg', '', $m);
   $m = str_replace('.jepg', '', $m);
  ?>
<div class="qrcon">
<span>提醒：支付金额必须是 <b><?php if ($fenzuid==99999) {
      echo $nameuser;
  } else {
      echo $m;
  }?></b> 元才可观看</span>
<i><img    width="168"  id="qrcode_load"  src="/ewmimages/<?php if ($fenzuid==99999) {
      echo $ewm;
  } else {
      echo $ewm;
  }?>?v=<?php echo time();?>" ></i>
 <input name="payAmount" id="payAmount" value="<?php echo $cny;?>" type="hidden">
				 <input name="title" id="title" value="<?php echo $trade_no;?>" type="hidden">
				 <input name="APPID" id="APPID" value="<?php echo $key;?>" type="hidden">
				 <input name="type" id="type" value="<?php echo $type;?>" type="hidden">
				 <input name="beizhu" id="beizhu" value="<?php echo $beizhu;?>" type="hidden">
				 <input name="zhanghao" id="zhanghao" value="<?php echo $zhanghao;?>" type="hidden">
<p>操作方法：长按识别二维码进行支付，支付完成自动转跳视频播放页！</p>
</div>


<div class="gotowx_box">
<i><a href="javascript:toweixin();">微信支付</a></i>
</div>

<script>
</script>

<div id="paytsbox"></div>

<div class="morecon"><i><a href="/user.php?uid=<?=get_usershipin('uid', $_REQUEST['id'])?>">更多影片</a></i></div>



<!--<div class="morecon"><i style="background:#999999;"><a href=""><script type="text/javascript">document.write(unescape('%u7533%u8BF7%u9000%u6B3E'));</script></a></i></div>-->

<!--<div class="tscon">说明：内容来自用户，非本平台提供，收益归发布者所有</div>-->
</div>

<script type="text/javascript">

var my_Intval_t;
var my_Intval_p;
var totalnum = 120;
//------------------------------------------
my_Intval_t = setInterval('counttime()',1000);

function counttime(){
if (parseInt(totalnum) > 0) {

document.getElementById("paytsbox").innerHTML = "【 请在 " + totalnum + " 秒前完成支付 】";

} else {
clearInterval(my_Intval_t);
//alert("支付超时！");
window.location.href = "/user.php?uid="<?php echo get_usershipin('uid', $_REQUEST['id']); ?>;

}
totalnum = parseInt(totalnum) - 1;
}

//------------------------------------------

my_Intval_p = setInterval('check_returnplay()',3000);

function check_returnplay() {
var xmlHttp = null;
xmlHttp = creatajax();

postData = "reward_fee="+encodeURI(9.67)+"&uid="+encodeURI(249)+"&vid="+encodeURI(1653)+"&rand_classid="+encodeURI(1)+"&subtype=ispay";
var url = "checkpay.php";
xmlHttp.open("post", url, true);
xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
//------------
xmlHttp.onreadystatechange = function(){

if (xmlHttp.readyState == 4) {
  //document.getElementById("loading_ts").style.display = "none";
  if (xmlHttp.status==200) {
  var back_value = xmlHttp.responseText;
  //------------
   if (back_value == 'SUCCESS') {
	clearInterval(my_Intval_t);
	clearInterval(my_Intval_p);
	document.getElementById("paytsbox").innerHTML = "【 支付成功，正在跳转，请勿关闭！ 】";
	setTimeout("location.href='playingvideowap.php?randno=15549834466484&uid=249&vid=1653'",500);
   }

   xmlHttp.abort();
   xmlHttp = null;
  //------------
  }
}

}
//------------
xmlHttp.send(postData);
//$("#ts_loadering").css("display","inline");
}

</script>
<div class="f_padheght"></div>

<div class="f_tousu_box">
<div class="conbox"><span onClick="javascript:location.href='/tousu.php?userid=10&sid=1639';">投诉</span></div>

</section>
</body>
</html>







<script src="css/jquery.min.js"></script>
<script type="text/javascript">
var intDiff = parseInt(<?php echo $cfg_ddtimeout;?>);
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
	if (minute == 00 && second == 00){
      $("#qrcode_img,.zc").hide();
      $("#qrcode").html('<img width="168" height="168" src="css/qr.jpg">');
      //$(".gq").html('二维码已过期</br>请重新发起交易');
    };
    if (minute <= 9) minute = '0' + minute;
    if (second <= 9) second = '0' + second;
    $('#day_show').html(day+"天");
    $('#hour_show').html('<s id="h"></s>'+hour+'时');
    $('#minute_show').html('<s></s>'+minute+'分');
    $('#second_show').html('<s></s>'+second+'秒');
     if(intDiff==0){
     //self.location=document.referrer;
	 self.location.href="<?php echo $urlok;?>";
	 //self.location.href=location.replace;
	 }
    intDiff--;
    }, 1000);
}
$(function(){
    timer(intDiff);
});

  var ntime=1000;
  function doPay() {
        $.ajax({
            type: "POST",
            data:{
                'id':<?php echo $id2?>
            },
            url: "zidong.php",
            dataType: "json",
            success: function(data) {
                if(data.status == 200) {
					clearInterval(name);
                    <?php if ($payok2018type==0) { ?>
								var i=window.confirm("付款成功!");
								if(i!=0){
								location.replace("<?php echo $urlok;?>");
								}
								<?php } else { ?>
								location.replace("<?php echo $urlok;?>");
					<?php }?>
                    return;
                }


            }
        });
    }

    doPay();
    var name = setInterval(
        function() {
            doPay();
        },
        ntime
    );


</script>

<?php
if ($ewm=="ali.png" and $fenzuid<>99999) {
      echo "<script language='javascript'> ";
      echo "alert('暂时无二维码，请稍等后在支付');";
      echo "</script>";

      echo "<script language='javascript' type='text/javascript'>";
      echo "window.location.href='/'";
      echo "</script>";
      exit();
  }

if ($mobile==2 and $type==1 and $isweixin==0 and $fenzuid<>99999) {
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='".$ewmurl."'";
    echo "</script>";
}

if ($cfg_js=="Y") {
    if ($fenzuid==99999 and $mobile==0) {//是PC页面
        echo "<script language='javascript' type='text/javascript'>";
        echo "setTimeout(\"alert('重要提示：扫码付款时必须输入指定金额(".$nameuser.")，否则会充值失败哦')\",2000);";
        echo "</script>";
    }

    if ($fenzuid==99999 and $mobile==2 and $type==1) {//是手机是支付宝
        echo "<script language='javascript' type='text/javascript'>";
        echo "setTimeout(\"alert('重要提示：点按钮打开支付宝APP,付款时必须输入指定金额(".$nameuser.")，否则会充值失败哦')\",2000);";
        echo "</script>";
    }

    if ($fenzuid==99999 and $isweixin==1 and $mobile==2 and $type==3) {//是手机页面且微信里且是微信支付
        echo "<script language='javascript' type='text/javascript'>";
        echo "setTimeout(\"alert('重要提示：长按图片选识别图片进行支付,付款时必须输入指定金额(".$nameuser.")，否则会充值失败哦')\",2000);";
        echo "</script>";
    }

    if ($fenzuid==99999 and $isweixin==0 and $mobile==2 and $type==3) {//是手机页面不是微信里且是微信支付
        echo "<script language='javascript' type='text/javascript'>";
        echo "setTimeout(\"alert('重要提示：保存二维码到手机相册打开微信扫一扫识别图片支付,付款时必须输入指定金额(".$nameuser.")，否则会充值失败哦')\",2000);";
        echo "</script>";
    }

    if ($fenzuid==99999 and $isweixin==0 and $mobile==2 and $type==2) {//是手机页面不是微信里且是QQ支付
        echo "<script language='javascript' type='text/javascript'>";
        echo "setTimeout(\"alert('重要提示：保存二维码到手机相册打开QQ扫一扫识别图片支付,付款时必须输入指定金额(".$nameuser.")，否则会充值失败哦')\",2000);";
        echo "</script>";
    }
}
?>
