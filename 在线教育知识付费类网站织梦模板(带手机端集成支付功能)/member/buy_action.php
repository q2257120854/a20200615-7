<?php

/**
 * @version        $Id: buy_action.php 1 8:38 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.yunziyuan.com.cn 电脑端支付
 */

require_once(dirname(__FILE__)."/config.php");

CheckRank(0,0);

$menutype = 'buyhui';

$menutype_son = 'op';

require_once DEDEINC.'/dedetemplate.class.php';



$product = isset($product) ? trim(HtmlReplace($product,1)) : '';

$mid = $cfg_ml->M_ID;

$ptype = '';

$pname = '';

$price = '';

$mtime = time();



if($a == 'selectpay'){
$trr = $dsql->GetOne("select * from #@__arctype where id = '$tid'");
$buyid = $oid;
$pname = $trr['typename'];
$price = $trr['price'];

	//打折系统

	if($cfg_dazhe == 'Y'){
		$price = $price / 100 * $cfg_zhekou;
	}
	

    //获取支付接口列表
    $payment_list = array();
    $dsql->SetQuery("SELECT * FROM #@__payment WHERE enabled='1' ORDER BY rank ASC");
    $dsql->Execute();
    $i = 0 ;
    while($row = $dsql->GetArray())
    {
        $payment_list[] = $row;
        $i++;
    }
    unset($row);

    $pr_encode = '';
    foreach($_REQUEST as $key => $val)
    {
        if (!in_array($key, array('product','pid'))) {
            continue;
        }
        $val = preg_replace("#[^0-9a-z]#i", "", $val);
        $pr_encode .= $pr_encode ? "&$key=$val" : "$key=$val";
    }
    
    $pr_encode = str_replace('=', '', mchStrCode($pr_encode));
    
    $pr_verify = md5("payment".$pr_encode.$cfg_cookie_encode);
    
    $tpl = new DedeTemplate();
    $tpl->LoadTemplate('templets/buy_action_payment_pc.htm');
    $tpl->Display();
exit();
}


if(isset($pd_encode) && isset($pd_verify) && md5("payment".$pd_encode.$cfg_cookie_encode) == $pd_verify)

{

    
    if(substr($aid,0,3) == 'KE-'){
	//课程购买
	$sql = "select o.*,t.typename from `#@__shops_orders` o left join #@__arctype t on o.pid = t.id where o.oid = '$aid' ";
	$orr = $dsql->GetOne($sql); 

 	$buyid = $aid;
	$pid = $orr['pid'];
	$price  = $orr['price'];
 	$product = $orr['typename'];
}else{
        
        //非课程购买
      parse_str(mchStrCode($pd_encode,'DECODE'),$mch_Post);

    $product = preg_replace("#[^0-9a-z]#i", "", $mch_Post['product']);

    $pid = preg_replace("#[^0-9a-z]#i", "", $mch_Post['pid']);



    $row  = $dsql->GetOne("SELECT * FROM #@__member_operation WHERE mid='$mid' And sta=0 AND product='$product'");

    if(!isset($row['buyid']))

    {

        ShowMsg("请不要重复提交表单!", 'javascript:;');

        exit();

    }

    if(!isset($paytype))

    {

        ShowMsg("请选择支付方式!", 'javascript:;');

        exit(); 

    }

    $buyid = $row['buyid'];  
        
    }
    
 





}else{

   

    $buyid = 'M'.$mid.'T'.$mtime.'RN'.mt_rand(100,999);

    //删除用户旧的未付款的同类记录

    if(!empty($product))    

    {

        $dsql->ExecuteNoneQuery("Delete From #@__member_operation WHERE mid='$mid' And sta=0 And product='$product'");

    }

}



if(empty($product))

{

    ShowMsg("请选择一个产品!", 'javascript:;');

    exit();

}



$pid = isset($pid) && is_numeric($pid) ? $pid : 0;

if($product=='member')

{

	/*	 if($cfg_ml->M_Rank >11)

    {

        ShowMsg("您已是VIP套餐会员", 'index.php');

        exit();

    }*/

    $ptype = "VIP会员";

    $row = $dsql->GetOne("SELECT * FROM #@__member_type WHERE aid='{$pid}'");

    if(!is_array($row))

    {

        ShowMsg("无法识别你的订单！", 'javascript:;');

        exit();

    }

    $pname = $row['pname'];

    $price = $row['money'];

}

else if ($product == 'card')

{

    $ptype = "账户余额充值";

    $row = $dsql->GetOne("SELECT * From #@__moneycard_type WHERE tid='{$pid}'");

    if(!is_array($row))

    {

        ShowMsg("无法识别你的订单！", 'javascript:;');

        exit();

    }

    $pname = $row['pname'];

    $price = $row['money'];

}

else if ($product == 'payjb')

{

    $ptype = "账户余额充值";

  /*  $row = $dsql->GetOne("SELECT * From #@__moneycard_type WHERE tid='{$pid}'");

    if(!is_array($row))

    {

        ShowMsg("无法识别你的订单！", 'javascript:;');

        exit();

    }*/

    $pname = "自定义充值{$pid}元";

    $price = "{$pid}";

}



if(!isset($paytype))

{    

    $inquery = "INSERT INTO #@__member_operation(`buyid` , `pname` , `product` , `money` , `mtime` , `pid` , `mid` , `sta` ,`oldinfo`)

   VALUES ('$buyid', '$pname', '$product' , '$price' , '$mtime' , '$pid' , '$mid' , '0' , '$ptype');

    ";

    $isok = $dsql->ExecuteNoneQuery($inquery);

    if(!$isok)

    {

        echo "数据库出错，请重新尝试！".$dsql->GetError();

        exit();

    }

    

    if($price=='')

    {

        echo "无法识别你的订单！";

        exit();

    }

    

    //获取支付接口列表

    $payment_list = array();

    $dsql->SetQuery("SELECT * FROM #@__payment WHERE enabled='1' ORDER BY rank ASC");

    $dsql->Execute();

    $i = 0 ;

    while($row = $dsql->GetArray())

    {

        $payment_list[] = $row;

        $i++;

    }

    unset($row);



    $pr_encode = '';

    foreach($_REQUEST as $key => $val)

    {

        if (!in_array($key, array('product','pid'))) {

            continue;

        }

        $val = preg_replace("#[^0-9a-z]#i", "", $val);

        $pr_encode .= $pr_encode ? "&$key=$val" : "$key=$val";

    }

    

    $pr_encode = str_replace('=', '', mchStrCode($pr_encode));

    

    $pr_verify = md5("payment".$pr_encode.$cfg_cookie_encode);

    

    $tpl = new DedeTemplate();

    $tpl->LoadTemplate(DEDEMEMBER.'/templets/buy_action_payment.htm');

    $tpl->Display();

    

}else{

if($paytype == '10'){
 
	$url = '/member/weixinpay/example/native.php?oid='.$aid;
	header("Location: $url"); 
	exit();

}
    

    $rs = $dsql->GetOne("SELECT * FROM `#@__payment` WHERE id='$paytype' ");
 
    $rs['code'] = preg_replace("#[^0-9a-z]#i", "", $rs['code']);

    if (!file_exists(DEDEINC.'/payment/'.$rs['code'].'.php')) {

        ShowMsg("未发现支付接口文件，请到后台配置！",'javascript:;');

        exit();

    }



    require_once DEDEINC.'/payment/'.$rs['code'].'.php';

    $pay = new $rs['code'];

    $payment="";

    if($rs['code']=="cod" || $rs['code']=="bank") {

        $order=$buyid;

        $payment="member";

    }

    else{

        $order=array( 'out_trade_no' => $buyid,

                      'price' => sprintf("%01.2f", $price)

        );

        require_once DEDEDATA.'/payment/'.$rs['code'].'.php';

    }

    $button=$pay->GetCode($order,$payment);
	


header("Location: $button");


 
exit();

    $dtp = new DedeTemplate();

    $carts = array( 'orders_id' => $buyid,

                    'cart_count' => '1',

                    'price_count' => sprintf("%01.2f", $price)

                     );

    $row = $dsql->GetOne("SELECT pname,money FROM #@__member_operation WHERE buyid='{$buyid}'");

    $dtp->SetVar('pay_name',$row['pname']);

    $dtp->SetVar('price',$row['money']);

    $dtp->SetVar('pay_way',$rs['name']);

    $dtp->SetVar('description',$rs['description']);

    $dtp->SetVar('button',$button);

    $dtp->Assign('carts',$carts);

    $dtp->LoadTemplate(DEDEMEMBER.'/templets/shops_action_payment.htm');

    $dtp->Display();

    exit();

}



/**

 *  加密函数

 *

 * @access    public

 * @param     string  $string  字符串

 * @param     string  $operation  操作

 * @return    string

 */

function mchStrCode($string, $operation = 'ENCODE') 

{

    $key_length = 4;

    $expiry = 0;

    $key = md5($GLOBALS['cfg_cookie_encode']);

    $fixedkey = md5($key);

    $egiskeys = md5(substr($fixedkey, 16, 16));

    $runtokey = $key_length ? ($operation == 'ENCODE' ? substr(md5(microtime(true)), -$key_length) : substr($string, 0, $key_length)) : '';

    $keys = md5(substr($runtokey, 0, 16) . substr($fixedkey, 0, 16) . substr($runtokey, 16) . substr($fixedkey, 16));

    $string = $operation == 'ENCODE' ? sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$egiskeys), 0, 16) . $string : base64_decode(substr($string, $key_length));



    $i = 0; $result = '';

    $string_length = strlen($string);

    for ($i = 0; $i < $string_length; $i++){

        $result .= chr(ord($string{$i}) ^ ord($keys{$i % 32}));

    }

    if($operation == 'ENCODE') {

        return $runtokey . str_replace('=', '', base64_encode($result));

    } else {

        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$egiskeys), 0, 16)) {

            return substr($result, 26);

        } else {

            return '';

        }

    }

}