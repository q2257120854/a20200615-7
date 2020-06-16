<?php
	// {"order_amount":"0.01","out_pay_sn":"1567949256743","seller_id":"1","sub_mch_id":"1555004251","sign":"cb0eddf4f4bee1b3bd292ace46a32677"}
	$data = [];
	$data['order_amount'] = $_REQUEST['order_amount']//订单金额
	$data['out_pay_sn']   = $_REQUEST['out_pay_sn']//第三方订单号
	$data['seller_id']    = $_REQUEST['seller_id']//商户号
	$data['sub_mch_id']   = $_REQUEST['sub_mch_id']//子商户号
	$data['sign']         = $_REQUEST['sign']//加密码
	$skey = '65bac3357fd900d32de584b79410fd7d';//商户密钥 后台获取
	$keysign = $data['sign'];
	unset($data['sign']);
    ksort($data);
    $sign = '';
    foreach ($data as $key => $value) {
      $sign .= $value;
    }
    $sign = md5($sign.$skey);
	if($keysign == $sign){
		//回调成功逻辑

		//回调成功逻辑end
		echo 'OK';
		exit;
	}else{
		//失败
		echo 'fail';
		exit;
	}