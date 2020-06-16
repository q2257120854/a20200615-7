<?php

if(!defined('DEDEINC')) exit('Request Error!');

/**

 * 支付宝接口类

 */

class Alipaym

{

    var $dsql;

    var $mid;

    var $return_url = "/plus/carbuyaction.php?dopost=return";

    /**

     * 构造函数

     *

     * @access  public

     * @param

     *

     * @return void

     */

    function Alipaym()

    {

        global $dsql;

        $this->dsql = $dsql;

    }



    function __construct()

    {

        $this->Alipaym();

    }

    

    /**

     *  设定接口会送地址

     *

     *  例如: $this->SetReturnUrl($cfg_basehost."/tuangou/control/index.php?ac=pay&orderid=".$p2_Order)

     *

     * @param     string  $returnurl  会送地址

     * @return    void

     */

    function SetReturnUrl($returnurl='')

    {

        if (!empty($returnurl))

        {

            $this->return_url = $returnurl;

        }

    }



    /**

    * 生成支付代码

    * @param   array   $order      订单信息

    * @param   array   $payment    支付方式信息

    */

    function GetCode($order, $payment)

    {

        global $cfg_basehost,$cfg_cmspath,$cfg_soft_lang;

        $charset = $cfg_soft_lang;

        //对于二级目录的处理

        if(!empty($cfg_cmspath)) $cfg_basehost = $cfg_basehost.'/'.$cfg_cmspath;



        $real_method = $payment['alipay_pay_method'];



        switch ($real_method){

            case '0':

                $service = 'alipay.wap.create.direct.pay.by.user';

                break;

            case '1':

                $service = 'create_partner_trade_by_buyer';

                break;

            case '2':

                $service = 'create_direct_pay_by_user';

                break;

        }

        $agent = 'C4335994340215837114';

		$parameter = array(

		"service"       => $service,

          'partner'           => $payment['alipay_partner'],

		"seller_id"  => $payment['alipay_account'],

		"payment_type"	=> 1,

		'notify_url'        => $cfg_basehost.$this->return_url."&code=".$payment['code'],

          'return_url'        => $cfg_basehost.$this->return_url."&code=".$payment['code'],

		"_input_charset"	=> $charset,

		"out_trade_no"	=> $order['out_trade_no'],

		"subject"	=> "支付订单号:".$order['out_trade_no'],

		"total_fee"	=> $order['price'],

		//"total_fee"	=> 0.01,

		//"show_url"	=> $show_url,

		"app_pay"	=> "Y",//启用此参数能唤起钱包APP支付宝

		//"body"	=> $body,

		//其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.2Z6TSk&treeId=60&articleId=103693&docType=1

        //如"参数名"	=> "参数值"   注：上一个参数末尾需要“,”逗号。

		

);





        ksort($parameter);

        reset($parameter);



        $param = '';

        $sign  = '';



        foreach ($parameter AS $key => $val)

        {

            $param .= "$key=" .urlencode($val). "&";

            $sign  .= "$key=$val&";

        }



        $param = substr($param, 0, -1);

        $sign  = substr($sign, 0, -1). $payment['alipay_key'];



        $button = 'https://mapi.alipay.com/gateway.do?'.$param. '&sign='.md5($sign).'&sign_type=MD5';



        /* 清空购物车 */

        require_once DEDEINC.'/shopcar.class.php';

        $cart     = new MemberShops();

        $cart->clearItem();

        $cart->MakeOrders();

        return $button;

    }



    

    /**

    * 响应操作

    */

    function respond()

    {

        if (!empty($_POST))

        {

            foreach($_POST as $key => $data)

            {

                $_GET[$key] = $data;

            }

        }

        /* 引入配置文件 */

		$code = preg_replace( "#[^0-9a-z-]#i", "", $_GET['code'] );

		require_once DEDEDATA.'/payment/'.$code.'.php';

		

        /* 取得订单号 */

        $order_sn = trim($_GET['out_trade_no']);

        /*判断订单类型*/



if(substr($order_sn,0,3) == 'KE-'){

	$ddh = $order_sn;

	$arr = $this->dsql->GetOne("select * from #@__shops_orders where `oid` = '".$ddh."'");

	if($arr['state'] == 0){//未付款状态

		$sql = "UPDATE `#@__shops_orders` SET `state`='1',paytype='8'  where `oid` = '".$ddh."'";//改为已付款

		$this->dsql->ExecuteNoneQuery($sql);

		







//九戒织梦 2019年10月18日14:08:11 推广购课部分

 	 



//1、推荐人加佣金 2、付款人改成已购买用户  3、写收益记录

 

$typearr = $this->dsql->GetOne("SELECT typename FROM  #@__arctype where id = '".$arr['pid']."' ");



$arr['mid'] = $arr['userid'];

$arr['money'] = $arr['priceCount'];



$tjrarr = $this->dsql->GetOne("select tjrmid from #@__member where mid = '".$arr['mid']."'");

if(!empty($tjrarr['tjrmid'])){

	

	global $cfg_keyjbl;

	$time = time();

	$yongjin = $arr['money'] * $cfg_keyjbl / 100;

	$yongjin = number_format($yongjin,2);

	$tjrmid = $tjrarr['tjrmid'];

	

	//1

	$sql = "update #@__member set shouyi = (shouyi + $yongjin) where mid = '$tjrmid'";

 

	$this->dsql->ExecuteNoneQuery($sql);

	

	//2

	$sql = "update #@__member set yigoumai = '1' where mid = '".$arr['mid']."'";

 

	$this->dsql->ExecuteNoneQuery($sql);

	

	//3

	$sql = "insert into #@__jj_shouyi (`tjrmid`,`mid`,`jine`,`chanpin`,`yongjin`,`time`,`tid` ) values ('$tjrmid','".$arr['mid']."','".$arr['money']."','".$typearr['typename']."','$yongjin','$time','".$arr['pid']."')";

 

	$this->dsql->ExecuteNoneQuery($sql);		

	

}

 

//推荐end



		

	}





return $msg = "

<!-- 订单支付信息 -->

<div class='container'>

<div class='ep-wp-hd'><i class='ep-icon'></i><h2 class='ep-status'>支付成功</h2></div>

<div class='text-center'>

<p>订单号：".$order_sn."</p>

<p><em>￥</em><span>".$arr['price']."</span></p>

<a href='http://m.test.com/' class='text-link'>完成</a>

</div>

</div>

<!-- 订单支付信息 End -->



<script type='text/javascript' src='http://m.test.com/m-js/jquery.js'></script>

<script type='text/javascript' src='http://m.test.com/m-css/app.css.php?format=js&v=1.01'></script>



<style type='text/css'>

body{background:#fff;font-size:14px;color:#333;font-family:-apple-system,BlinkMacSystemFont,Helvetica Neue,PingFang SC,Microsoft YaHei,Source Han Sans SC,Noto Sans CJK SC,WenQuanYi Micro Hei,sans-serif;}

*{margin:0;padding:0;}

ul,li{list-style:none;}

h1,h2,h3,h4,h5,h6{font-size:100%;font-weight:normal;}

i,em{font-style:normal;}

a{text-decoration:none;color:#333;}

a:hover{text-decoration:none;color:#23b8ff;}

#preloader{margin:0 !important;padding:0 !important;}

#status{max-width:800px !important;}

#preloader .center-yxw-img{display:none !important;}

.center-text{display:none;}

.container{max-width:800px;min-width:320px;margin:0 auto;}



/*支付成功反馈信息*/

.ep-wp-hd{padding-top:50px;}

.ep-wp-hd .ep-status{font-size:20px;color:#ff700a;padding:10px 0;text-align:center;}

.ep-wp-hd .ep-icon{width:45px;height:45px;margin:0 auto;background:url(http://m.test.com/m-images/pay-wanchen.png) no-repeat;background-size:45px 45px;display:block;}



.text-center{padding:20px 0;text-align:center;}

.text-center h2{line-height:26px;color:#23b8ff;font-size:18px;}

.text-center p{color:#333;font-size:16px;padding-bottom:20px;}

.text-center p em{font-size:12px;padding-right:2px;}

.text-center p span{font-size:28px;}

.text-center a{line-height:38px;border:1px solid #ff700a;color:#ff700a;font-size:16px;display:inline-block;border-radius:5px;padding:0 40px;}

</style>

";

	

	

}else if(preg_match ("/S-P[0-9]+RN[0-9]/",$order_sn)) {

            //检查支付金额是否相符

            $row = $this->dsql->GetOne("SELECT * FROM #@__shops_orders WHERE oid = '{$order_sn}'");

            if ($row['priceCount'] != $_GET['total_fee'] )

            {

                return $msg = "支付失败，支付金额与商品总价不相符!";

            }

            $this->mid = $row['userid'];

            $ordertype="goods";

        }else if (preg_match ("/M[0-9]+T[0-9]+RN[0-9]/", $order_sn)){

            $row = $this->dsql->GetOne("SELECT * FROM #@__member_operation WHERE buyid = '{$order_sn}'");

            //获取订单信息，检查订单的有效性

            if(!is_array($row)||$row['sta']==2) return $msg = "

<!-- 订单支付信息 -->

<div class='container'>

<div class='ep-wp-hd'><i class='ep-icon'></i><h2 class='ep-status'>支付成功</h2></div>

<div class='text-center'>

<p>订单号：".$order_sn."</p>

<p><em>￥</em><span>".$row['money']."</span></p>

<a href='http://m.test.com/' class='text-link'>完成</a>

</div>

</div>

<!-- 订单支付信息 End -->



<script type='text/javascript' src='http://m.test.com/m-js/jquery.js'></script>

<script type='text/javascript' src='http://m.test.com/m-css/app.css.php?format=js&v=1.01'></script>



<style type='text/css'>

body{background:#fff;font-size:14px;color:#333;font-family:-apple-system,BlinkMacSystemFont,Helvetica Neue,PingFang SC,Microsoft YaHei,Source Han Sans SC,Noto Sans CJK SC,WenQuanYi Micro Hei,sans-serif;}

*{margin:0;padding:0;}

ul,li{list-style:none;}

h1,h2,h3,h4,h5,h6{font-size:100%;font-weight:normal;}

i,em{font-style:normal;}

a{text-decoration:none;color:#333;}

a:hover{text-decoration:none;color:#23b8ff;}

#preloader{margin:0 !important;padding:0 !important;}

#status{max-width:800px !important;}

#preloader .center-yxw-img{display:none !important;}

.center-text{display:none;}

.container{max-width:800px;min-width:320px;margin:0 auto;}



/*支付成功反馈信息*/

.ep-wp-hd{padding-top:50px;}

.ep-wp-hd .ep-status{font-size:20px;color:#ff700a;padding:10px 0;text-align:center;}

.ep-wp-hd .ep-icon{width:45px;height:45px;margin:0 auto;background:url(http://m.test.com/m-images/pay-wanchen.png) no-repeat;background-size:45px 45px;display:block;}



.text-center{padding:20px 0;text-align:center;}

.text-center h2{line-height:26px;color:#23b8ff;font-size:18px;}

.text-center p{color:#333;font-size:16px;padding-bottom:20px;}

.text-center p em{font-size:12px;padding-right:2px;}

.text-center p span{font-size:28px;}

.text-center a{line-height:38px;border:1px solid #ff700a;color:#ff700a;font-size:16px;display:inline-block;border-radius:5px;padding:0 40px;}

</style>

";

            elseif($row['money'] != $_GET['total_fee'] ) return $msg = "支付失败，支付金额与商品总价不相符!";

            $ordertype = "member";

            $product =    $row['product'];

            $pname= $row['pname'];

            $pid=$row['pid'];

            $this->mid = $row['mid'];

        } else {    

            return $msg = "支付失败，您的订单号有问题！";

        }



        /* 检查数字签名是否正确 */

        ksort($_GET);

        reset($_GET);



        $sign = '';

        foreach ($_GET AS $key=>$val)

        {

            if ($key != 'sign' && $key != 'sign_type' && $key != 'code' && $key != 'dopost')

            {

                $sign .= "$key=$val&";

            }

        }



        $sign = substr($sign, 0, -1).$payment['alipay_key'];



        if (md5($sign) != $_GET['sign'])

        {

            return $msg = "支付失败!";

        }



        if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS' || $_GET['trade_status'] == 'TRADE_SUCCESS')

        {

            if($ordertype=="goods"){ 

                if($this->success_db($order_sn))  return $msg = "您的商品已付款成功，我们即刻安排发货，请等候发货哦！<br> <a class='likx' href='/'>返回首页</a> <a class='likx2' href='/member/'>会员中心</a>";

                else  return $msg = "支付失败！<br> <a class='likx' href='/'>返回首页</a> <a class='likx2' href='/member/'>会员中心</a>";

            } else if ( $ordertype=="member" ) {

                $oldinf = $this->success_mem($order_sn,$pname,$product,$pid);

                return $msg = "<font color='red'>".$oldinf."</font><br> <a class='likx' href='/'>返回首页</a> <a class='likx2' href='/member/'>会员中心</a>";

            }

        } else {

            $this->log_result ("verify_failed");

            return $msg = "支付失败！<br> <a class='likx' href='/'>返回首页</a> <a class='likx2' href='/member/'>会员中心</a>";

        }

    }



    /*处理物品交易*/

    function success_db($order_sn)

    {

        //获取订单信息，检查订单的有效性

        $row = $this->dsql->GetOne("SELECT state FROM #@__shops_orders WHERE oid='$order_sn' ");

        if($row['state'] > 0)

        {

            return TRUE;

        }    

        /* 改变订单状态_支付成功 */

        $sql = "UPDATE `#@__shops_orders` SET `state`='1' WHERE `oid`='$order_sn' AND `userid`='".$this->mid."'";

        if($this->dsql->ExecuteNoneQuery($sql))

        {

            $this->log_result("verify_success,订单号:".$order_sn); //将验证结果存入文件

            return TRUE;

        } else {

            $this->log_result ("verify_failed,订单号:".$order_sn);//将验证结果存入文件

            return FALSE;

        }

    }



    /*处理点卡，会员升级*/

    function success_mem($order_sn,$pname,$product,$pid){

				$row = $this->dsql->GetOne("SELECT * FROM #@__member_operation WHERE buyid = '$order_sn'");

				$arr = $row;

			//获取订单信息，检查订单的有效性

			if(!is_array($row)||$row['sta']==2) /*return $msg = "您的订单已经处理，请不要重复提交!";*/header('Location: /member/');

        //更新交易状态为已付款

        $sql = "UPDATE `#@__member_operation` SET `sta`='1' WHERE `buyid`='$order_sn' AND `mid`='".$this->mid."'";

        $this->dsql->ExecuteNoneQuery($sql);



        /* 改变点卡订单状态_支付成功 */

        if($product=="card")

        {

            $row = $this->dsql->GetOne("SELECT cardid FROM #@__moneycard_record WHERE ctid='$pid' AND isexp='0' ");;

            //如果找不到某种类型的卡，直接为用户增加金币

            if(!is_array($row))

            {

                $nrow = $this->dsql->GetOne("SELECT num FROM #@__moneycard_type WHERE pname = '{$pname}'");

                $dnum = $nrow['num'];

                $sql1 = "UPDATE `#@__member` SET `money`=money+'{$nrow['num']}' WHERE `mid`='".$this->mid."'";

                $oldinf ="已经充值了".$nrow['num']."金币到您的帐号！";

            } else {

                $cardid = $row['cardid'];

                $sql1=" UPDATE #@__moneycard_record SET uid='".$this->mid."',isexp='1',utime='".time()."' WHERE cardid='$cardid' ";

                $oldinf='您的充值密码是：<font color="green">'.$cardid.'</font>';

            }

            //更新交易状态为已关闭

            $sql2=" UPDATE #@__member_operation SET sta=2,oldinfo='$oldinf' WHERE buyid='$order_sn'";

            if($this->dsql->ExecuteNoneQuery($sql1) && $this->dsql->ExecuteNoneQuery($sql2))

            {

                $this->log_result("verify_success,订单号:".$order_sn); //将验证结果存入文件

 return $msg = "<font color='red'>".$oldinf."</font><br> <a class='likx' href='/'>返回首页</a> <a class='likx2' href='/member/'>会员中心</a>";				//20170115    return $oldinf;

            } else {

                $this->log_result ("verify_failed,订单号:".$order_sn);//将验证结果存入文件

                return $msg = "支付失败！<br> <a class='likx' href='/'>返回首页</a> <a class='likx2' href='/member/'>会员中心</a>";

            }

        /* 改变会员订单状态_支付成功 */

        } else if ( $product=="member" ){

			

            $row = $this->dsql->GetOne("SELECT rank,exptime FROM #@__member_type WHERE aid='$pid' ");

            $rank = $row['rank'];

            $exptime = $row['exptime'];

            /*计算原来升级剩余的天数*/

            $rs = $this->dsql->GetOne("SELECT uptime,exptime FROM #@__member WHERE mid='".$this->mid."'");

            if($rs['uptime']!=0 && $rs['exptime']!=0 ) 

            {

                $nowtime = time();

                $mhasDay = $rs['exptime'] - ceil(($nowtime - $rs['uptime'])/3600/24) + 1;

                $mhasDay=($mhasDay>0)? $mhasDay : 0;

            }

			

			//$mhasDay=0;//说改变级别不增加时间 20170120

            //获取会员默认级别的金币和积分数

            $memrank = $this->dsql->GetOne("SELECT money,scores FROM #@__arcrank WHERE rank='$rank'");

            //更新会员信息

            $sql1 =  " UPDATE #@__member SET rank='$rank',money=money+'{$memrank['money']}',

                       scores=scores+'{$memrank['scores']}',exptime='$exptime'+'$mhasDay',uptime='".time()."' 

                       WHERE mid='".$this->mid."'";

            //更新交易状态为已关闭

            $sql2=" UPDATE #@__member_operation SET sta='2',oldinfo='会员升级成功!' WHERE buyid='$order_sn' ";

            if($this->dsql->ExecuteNoneQuery($sql1) && $this->dsql->ExecuteNoneQuery($sql2))

            {

//九戒织梦 2019年1月22日09:30:45 推广注册部分

 	 



//1、推荐人加佣金 2、付款人改成已购买用户  3、写收益记录

$tjrarr = $this->dsql->GetOne("select tjrmid from #@__member where mid = '".$arr['mid']."'");

if(!empty($tjrarr['tjrmid'])){

	

	global $cfg_tgyjbl;

	$time = time();

	$yongjin = $arr['money'] * $cfg_tgyjbl / 100;

	$yongjin = number_format($yongjin,2);

	$tjrmid = $tjrarr['tjrmid'];

	

	//1

	$sql = "update #@__member set shouyi = (shouyi + $yongjin) where mid = '$tjrmid'";

 

	$this->dsql->ExecuteNoneQuery($sql);

	

	//2

	$sql = "update #@__member set yigoumai = '1' where mid = '".$arr['mid']."'";

 

	$this->dsql->ExecuteNoneQuery($sql);

	

	//3

	$sql = "insert into #@__jj_shouyi (`tjrmid`,`mid`,`jine`,`chanpin`,`yongjin`,`time` ) values ('$tjrmid','".$arr['mid']."','".$arr['money']."','".$arr['pname']."','$yongjin','$time')";

 

	$this->dsql->ExecuteNoneQuery($sql);		

	

}

 

//推荐end



				

                $this->log_result("verify_success,订单号:".$order_sn); //将验证结果存入文件

return $msg = "会员升级成功！<br> <a class='likx' href='/'>返回首页</a> <a class='likx2' href='/member/'>会员中心</a>";

					 //20170115    return "会员升级成功！";

            } else {

                $this->log_result ("verify_failed,订单号:".$order_sn);//将验证结果存入文件

return $msg = "会员升级失败！<br> <a class='likx' href='/'>返回首页</a> <a class='likx2' href='/member/'>会员中心</a>";

					 //20170115     return "会员升级失败！";

            }











			

        }    else if($product=="payjb")

        {

            $row = $this->dsql->GetOne("SELECT cardid FROM #@__moneycard_record WHERE ctid='$pid' AND isexp='0' ");;

            //如果找不到某种类型的卡，直接为用户增加金币

            if(!is_array($row))

            {

                $nrow = $this->dsql->GetOne("SELECT num FROM #@__moneycard_type WHERE pname = '{$pname}'");

                $dnum = $pid;

                $sql1 = "UPDATE `#@__member` SET `money`=money+'{$dnum}' WHERE `mid`='".$this->mid."'";

                $oldinf ="已经充值了".$dnum."金币到您的帐号！";

            } else {

                $cardid = $row['cardid'];

                $sql1=" UPDATE #@__moneycard_record SET uid='".$this->mid."',isexp='1',utime='".time()."' WHERE cardid='$cardid' ";

                $oldinf='您的充值密码是：<font color="green">'.$cardid.'</font>';

            }

            //更新交易状态为已关闭

            $sql2=" UPDATE #@__member_operation SET sta=2,oldinfo='$oldinf' WHERE buyid='$order_sn'";

            if($this->dsql->ExecuteNoneQuery($sql1) && $this->dsql->ExecuteNoneQuery($sql2))

            {

                $this->log_result("verify_success,订单号:".$order_sn); //将验证结果存入文件

 return $msg = "<font color='red'>".$oldinf."</font><br> <a class='likx' href='/'>返回首页</a> <a class='likx2' href='/member/'>会员中心</a>";					 //20170115   return $oldinf;



            } else {

                $this->log_result ("verify_failed,订单号:".$order_sn);//将验证结果存入文件

				return $msg = "支付失败！<br> <a class='likx' href='/'>返回首页</a> <a class='likx2' href='/member/'>会员中心</a>";



            }

        /* 改变会员订单状态_支付成功 */

        }    

    }



  

  function  log_result($word) 

    {

        global $cfg_cmspath;

        $fp = fopen(dirname(__FILE__)."/../../data/payment/log.txt","a");

        flock($fp, LOCK_EX) ;

        fwrite($fp,$word.",执行日期:".strftime("%Y-%m-%d %H:%I:%S",time())."\r\n");

        flock($fp, LOCK_UN);

        fclose($fp);

    }

}//End API