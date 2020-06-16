<?php
// <?php
//     $url = 'http://pay.toubaba.me/api/uni/pay';

//     $totalMoney = 5;
//     $ubodingdannew  = time().rand(100,999);
//     // $xieyi=is_HTTPS()?"https://":"http://";
//     $notify_url=$xieyi.$_SERVER['HTTP_HOST']."/index.php/index/pay/yinshengzhifu.html";
//     $redirect_url=$xieyi.$_SERVER['HTTP_HOST']."/index.php/index/pay/notifyyunzhifu/orderId/".$ubodingdannew;
//     $skey = 'e1b08f6723cb4be4934677d23857f4e3';//支付密钥后台获取
//     $data = [];
//     $data['merchant_no']    = '2019091116353833822027';
//     $data['version']        = '1.0'; //以分为单位
//     $data['payment_type']   = 'WxPay-JSPay';//商户ID 后台可获取
//     $data['notify_url']     = $notify_url;//异步回调地址
//     $data['return_url']     = $redirect_url;//同步回调地址
//     $data['merchant_order_num'] =  $ubodingdannew;
//     $data['amount']         = $totalMoney;//公众号支付:Wxgzh 

//     ksort($data);
//     $sign = '';
//     foreach ($data as $key => $value) {
//       $sign .= '&'.$key.'='.$value;
//     }
//     rtrim($sign,'&');
//     $sign = md5($sign.$skey);
//     $data['sign'] = $sign;
//     $ch = curl_init();
//       //设置选项，包括URL
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//     curl_setopt($ch, CURLOPT_HEADER, 0);
//     curl_setopt($ch,CURLOPT_TIMEOUT,180); //定义超时3秒钟 
//     // POST数据
//     curl_setopt($ch, CURLOPT_POST, 1);
//     // 把post的变量加上
//     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));  //所需传的数组用http_bulid_query()函数处理一下，就ok了
//     //执行并获取url地址的内容
//     $output = curl_exec($ch);
//     $data = json_decode($output,true);

//     $errorCode = curl_errno($ch);
//     //释放curl句柄
//     curl_close($ch);
//     var_dump($data);
//     exit;
//     $url = $url."?".http_build_query($data);
//     header("Location:".$url);
	$url = 'http://www.hychsc.com/api/pay/pay';

    $skey = 'nr9B1nFubgUeo1CqQSPUe92vVcBe9Zb9';//支付密钥后台获取
	$data = [];
	$data['pay_sn'] 		= time().rand(100,999);
	$data['order_amount'] 	= 600; //以分为单位
	$data['seller_id'] 		= 80;//商户ID 后台可获取
	// $data['sub_mch_id'] 	= xxxxx;//子商户ID 后台申请可获取不填 可自动轮训商户 收满额度自动关闭
	$data['notify_url'] 	= 'http://'.$_SERVER['HTTP_HOST'].'/notify.php';//异步回调地址
    $data['return_url']     = 'http://'.$_SERVER['HTTP_HOST'].'/';//同步回调地址
	$data['pay_type'] 	    = 'Wxgzh';//公众号支付:Wxgzh 扫码支付:wxsm
    ksort($data);
    $sign = '';
    foreach ($data as $key => $value) {
      $sign .= $value;
    }
    $sign = md5($sign.$skey);
	$data['sign'] = $sign;
    $url = $url."?".http_build_query($data);
    header("Location:".$url);//个别防封系统请使用这个跳转 这个删除
    // echo ' <script type="text/javascript">location.href = "'.urldecode($url).'";</script>'; 
    exit;