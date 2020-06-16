<?php
if(!defined('DEDEINC')) exit('Request Error!');
session_start();
/**
 * 中云支付接口类
 */
class cnzyzf
{
    var $dsql;		//数据库连接
    var $mid;		//商户号
    var $gateway = "http://zf.cnzypay.com/Pay_Index.html";   //提交地址
   // var $pay_notifyurl = "/plus/carbuyaction.php?dopost=return";	//调用后台请求地址
    var $pay_notifyurl = "/carbuyaction.php?dopost=return";	//调用后台请求地址
    //var $callbackurl="/member/shops_products.php";    ////页面返回地址
    //var $callbackurl="/member/templets/shops_pay_success.htm";
  //  var $callbackurl="/plus/carbuyaction.php?dopost=return";
	    var $callbackurl="/carbuyaction.php?dopost=return";


    /**
     * 构造函数
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function cnzyzf() {
        global $dsql;
        $this->dsql = $dsql;
    }

    function __construct()
    {
        $this->cnzyzf();
    }

	/**
     *  设定接口会送地址
     *
     *  例如: $this->SetReturnUrl($mcfg_basehost."/tuangou/control/index.php?ac=pay&orderid=".$p2_Order)
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
        global $mcfg_basehost,$cfg_cmspath;
        //$charset = $cfg_soft_lang;
        //对于二级目录的处理
        if(!empty($cfg_cmspath)) $mcfg_basehost = $mcfg_basehost.'/'.$cfg_cmspath;
		
		$Md5key=trim($payment['v_key']);
		/*echo "<script>alert('".$Md5key."')</script>";*/
		$pay_memberid = trim($payment['v_mid']);    //商户ID

		//$pay_memberid = $pay_memberid;
		$pay_orderid = trim($order['out_trade_no']);    //订单号
		 if (empty($order['out_trade_no']))
        {
            $pay_orderid    .= "u".$pay_orderid; 
        }
		
		$pay_amount = $order['price'];
		$pay_applydate = date("Y-m-d H:i:s");
		$pay_bankcode = ""; 
		$pay_notifyurl = $mcfg_basehost.$this->pay_notifyurl;//."&code=".$payment['code'];
		
		$pay_callbackurl = $mcfg_basehost.$this->callbackurl;    //."?do=>ok&oid=>".$pay_orderid;
		$pay_reserved1c = "cnzyzf";
                $_SESSION['code'] = "cnzyzf";
		
		$requestarray = array(
				"pay_memberid" => $pay_memberid,
				"pay_orderid" => $pay_orderid,
				"pay_amount" => $pay_amount,
				"pay_applydate" => $pay_applydate,
				"pay_bankcode" => $pay_bankcode,
				"pay_notifyurl" => $pay_notifyurl,
				"pay_callbackurl" => $pay_callbackurl
			);
			
			
			ksort($requestarray);
			reset($requestarray);
			$md5str = "";
			foreach ($requestarray as $key => $val) {
				$md5str = $md5str . $key . "=>" . $val . "&";
			}
			//echo($md5str . "key=" . $Md5key."<br>");
			$sign = strtoupper(md5($md5str . "key=" . $Md5key)); 
			$requestarray["pay_md5sign"] = $sign;
			
			
        $def_url  = '<form style="text-align:center;" method="post" action="'.$this->gateway.'">';  
		 foreach ($requestarray as $key => $val) {
            $def_url = $def_url . '<input type="hidden" name="' . $key . '" value="' . $val . '" />';
        }
        $def_url .= '<input type="hidden" name="pay_reserved1c" value="'.$pay_reserved1c.'" />';
        $def_url .= '<input type="submit" value="立即在线支付" class="btn_mid_grey" />';
        $def_url .= '</form>';
		

        
        /* 清空购物车 */
        require_once DEDEINC.'/shopcar.class.php';
        $cart     = new MemberShops();
        $cart->clearItem();
        $cart->MakeOrders();
        return $def_url;
    }

	    /**
    * 响应操作
    */
    function respond() {
        $ordertype=""; 
		$memberid   =trim($_REQUEST['memberid']);     // 商户编号
		$orderid    =trim($_REQUEST['orderid']);      // 商户发送的订单编号   		   
		$amount     =trim($_REQUEST['amount']);       // 支付金额
		$datetime   =trim($_REQUEST['datetime']);    // 订单提交时间
		$returncode =trim($_REQUEST['returncode']);   // 状态，"00"为成功
		$md5sign    =trim($_REQUEST['sign']);        //拼凑后的MD5校验值
		$Md5key = "Bd8CtKVzYNPVxL9uRKlpmz6JCmEZqk";
		//$pay_reserved1c  =  trim($_REQUEST['pay_reserved1c']); //备注字段1
		$_SESSION['code'] = "cnzyzf";

		/* 引入配置文件 */
		$code="cnzyzf";
		require_once DEDEDATA.'/payment/'.$code.'.php';

		/**
		 * 重新计算md5的值
		 */
		$ReturnArray = array(
				"memberid" => $memberid,
				"orderid" =>  $orderid,
				"amount" =>  $amount,
				"datetime" =>  $datetime,
				"returncode" => $returncode
		);
		ksort($ReturnArray);
        reset($ReturnArray);
        $md5str = "";
        foreach ($ReturnArray as $key => $val) {
            $md5str = $md5str . $key . "=>" . $val . "&";
        } 
        $sign = strtoupper(md5($md5str . "key=" . $Md5key));
	
        /*判断订单类型*/
		if(preg_match ("/S-P[0-9]+RN[0-9]/",$orderid)) {
			//检查支付金额是否相符
			$row = $this->dsql->GetOne("SELECT * FROM #@__shops_orders WHERE oid = '{$orderid}'");
			if ($row['priceCount'] != $amount)
			{
				return $msg = "支付失败，支付金额与商品总价不相符!";
			}
			$this->mid = $row['userid'];
			$ordertype="goods";
		}else if (preg_match ("/M[0-9]+T[0-9]+RN[0-9]/", $orderid)){
			$row = $this->dsql->GetOne("SELECT * FROM #@__member_operation WHERE buyid = '{$orderid}'");
			//获取订单信息，检查订单的有效性
			if(!is_array($row)||$row['sta']==2) return $msg = "您已购买成功!";
			else if($row['money'] != $amount) return $msg = "支付失败，支付金额与商品总价不相符!";
			$ordertype = "member";
			$product =    $row['product'];
			$pname= $row['pname'];
			$pid=$row['pid'];
			$this->mid = $row['mid'];
		} else {    
			file_put_contents ( "runinfo.txt", "支付失败，您的订单号有问题！\n", FILE_APPEND ); // 将字符串写入文件
			return $msg = "支付失败，您的订单号有问题！";
		}
		if ($md5sign != $sign){
			return $msg = "支付失败!";
		}
		if($returncode=="00"){
            if($ordertype=="goods"){ 
                if($this->success_db($orderid)){
					  return $msg = "支付成功!<br> <a href='/'>返回主页</a> <a href='/member'>会员中心</a>或去 <a href='../member/shops_products.php?oid=".$orderid."'>查看订单</a>";
				}
                else  return $msg = "支付失败！";
            } else if ( $ordertype=="member" ) {
                $oldinf = $this->success_mem($orderid,$pname,$product,$pid);
                return $msg = "<font color='red'>".$oldinf."</font>";
            }
		} else {
			file_put_contents ( "runinfo.txt", "支付失败！\n", FILE_APPEND ); // 将字符串写入文件
			         
			$this->log_result ("verify_failed");
            return $msg = "支付失败！";
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
    function success_mem($order_sn,$pname,$product,$pid) {
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
                return $oldinf;
            } else {
                $this->log_result ("verify_failed,订单号:".$order_sn);//将验证结果存入文件
                return "支付失败！";
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
                $this->log_result("verify_success,订单号:".$order_sn); //将验证结果存入文件
                return "会员升级成功！";
            } else {
                $this->log_result ("verify_failed,订单号:".$order_sn);//将验证结果存入文件
                return "会员升级失败！";
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
                return $oldinf;
            } else {
                $this->log_result ("verify_failed,订单号:".$order_sn);//将验证结果存入文件
                return "支付失败！";
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
    
}