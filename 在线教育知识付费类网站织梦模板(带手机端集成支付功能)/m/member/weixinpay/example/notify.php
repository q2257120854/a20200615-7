<?php
require_once(dirname(__FILE__)."/../../../../include/common.inc.php");

//post HE get 都是空的

$fp = fopen("post.txt", "a+"); 
	fwrite($fp,date('Y-m-d H:i:s')."发来通知\r\n"); 
fclose($fp);

ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

 
require_once "../lib/WxPay.Api.php";
require_once '../lib/WxPay.Notify.php';
require_once 'log.php';

//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
	/*	
$fp = fopen("zhao.txt", "w+"); 
fwrite($fp,date('Y-m-d H:i:s',time())." - data:\r\n");
foreach($data as $k=>$v){	fwrite($fp,$k."=>".$v."\r\n"); }
fclose($fp);
*/

//订单状态付款成功
					if($data['result_code'] =='SUCCESS' && $data['return_code'] =='SUCCESS'){
					global $dsql;


//购买课程

$ddh = $data['attach'];
if(substr($ddh,0,3) == 'KE-'){
	$arr = $dsql->GetOne("select * from #@__shops_orders where `oid` = '".$ddh."'");
	if($arr['state'] == 0){//未付款状态
		$sql = "UPDATE `#@__shops_orders` SET `state`='1',paytype='10'  where `oid` = '".$ddh."'";//改为已付款
		$dsql->ExecuteNoneQuery($sql);




//九戒织梦 2019年10月18日14:08:11 推广购课部分
 	 

//1、推荐人加佣金 2、付款人改成已购买用户  3、写收益记录
 
$typearr = $dsql->GetOne("SELECT typename FROM  #@__arctype where id = '".$arr['pid']."' ");

$arr['mid'] = $arr['userid'];
$arr['money'] = $arr['priceCount'];

$tjrarr = $dsql->GetOne("select tjrmid from #@__member where mid = '".$arr['mid']."'");
if(!empty($tjrarr['tjrmid'])){
	
	global $cfg_keyjbl;
	$time = time();
	$yongjin = $arr['money'] * $cfg_keyjbl / 100;
	$yongjin = number_format($yongjin,2);
	$tjrmid = $tjrarr['tjrmid'];
	
	//1
	$sql = "update #@__member set shouyi = (shouyi + $yongjin) where mid = '$tjrmid'";
 
	$dsql->ExecuteNoneQuery($sql);
	
	//2
	$sql = "update #@__member set yigoumai = '1' where mid = '".$arr['mid']."'";
 
	$dsql->ExecuteNoneQuery($sql);
	
	//3
	$sql = "insert into #@__jj_shouyi (`tjrmid`,`mid`,`jine`,`chanpin`,`yongjin`,`time`,`tid`  ) values ('$tjrmid','".$arr['mid']."','".$arr['money']."','".$typearr['typename']."','$yongjin','$time','".$arr['pid']."')";
 
	$dsql->ExecuteNoneQuery($sql);		
	
}
 
//推荐end

		
	}
	
}else{
				//验证价格是否正确
					
					
					//九戒织梦 2016年2月14日11:53:33  处理订单开始
					//验证成功  开始写数据库 改变会员状态了
						/*处理点卡，会员升级*/
					
					
					$order_sn = $data['attach'];
					
					if(empty($order_sn)){
						$fp = fopen("zhao.txt", "a+"); 
						fwrite($fp,date('Y-m-d H:i:s',time())." --订单号不存在呢？？"); 
						fclose($fp);						
			$out_trade_no = $data['out_trade_no'];
$arr = $dsql->GetOne("select * from #@__member_operation where `out_trade_no` = '".$out_trade_no."'");	
					}else{					
					$arr = $dsql->GetOne("select * from #@__member_operation where `buyid` = '".$order_sn."'");	
					} 
					 
					 
					
					
					
						if($arr['sta'] == 0){ //未付款状态
$mid = $arr['mid'];
$pid = $arr['pid']; 
														
					//检查这个订单是否已经更新过了
if($arr['product'] == 'card'){//充值金币
/*
	$fp = fopen("zhao.txt", "a+"); 
		fwrite($fp, "进入金币充值环节\r\n");			
		fclose($fp);
	*/	
		
	//查询对应的金币数
	$pid = $arr['pid']; //对应点卡的ID号
	$brr = $dsql->GetOne("Select num From #@__moneycard_type where tid = '$pid'"); //查询对应的价格
	/*
	$fp = fopen("zhao.txt", "a+"); 
		fwrite($fp, "应该加金币".$brr['num']."\r\n");			
		fclose($fp);
	*/	
if(empty($brr['num'])){//自定义金币充值
	$brr['num'] = intval($data['total_fee'] / 100);
}
	if(empty($brr['num'])){
		$fp = fopen("zhao.txt", "a+"); 
		fwrite($fp, "没找到对应的点卡产品\r\n");			
		fclose($fp);
	}else{
		
		
		
		//更新交易状态为已付款
		$sql = "UPDATE `#@__member_operation` SET `sta`='1' WHERE `buyid`='$order_sn' AND `mid`='".$mid."'";//改为已付款
		$dsql->ExecuteNoneQuery($sql);
		//给会员加金币
		$dsql->ExecuteNoneQuery("UPDATE `#@__member` SET money =( money + ".$brr['num'].") WHERE `mid`='$mid'");
		//修改订单状态为已充值，记录充值金币数
		$sql2=" UPDATE #@__member_operation SET sta='2',oldinfo='已充值".$brr['num']."金币' WHERE buyid='$order_sn' ";									
		$dsql->ExecuteNoneQuery($sql2);
	}	
	return ;

}else if($arr['product'] == 'member'){ //会员升级
							
					
								//更新交易状态为已付款
								$sql = "UPDATE `#@__member_operation` SET `sta`='1' WHERE `buyid`='$order_sn' AND `mid`='".$mid."'";//改为已付款
						 
								$dsql->ExecuteNoneQuery($sql);
						 
									$row = $dsql->GetOne("SELECT rank,exptime FROM #@__member_type WHERE aid='$pid' ");
									$rank = $row['rank'];
									$exptime = $row['exptime'];
									/*计算原来升级剩余的天数*/
									$rs = $dsql->GetOne("SELECT uptime,exptime FROM #@__member WHERE mid='".$mid."'");
									if($rs['uptime']!=0 && $rs['exptime']!=0 ) 
									{
										$nowtime = time();
										$mhasDay = $rs['exptime'] - ceil(($nowtime - $rs['uptime'])/3600/24) + 1;
										$mhasDay=($mhasDay>0)? $mhasDay : 0;
									}
									//获取会员默认级别的金币和积分数
									$memrank = $dsql->GetOne("SELECT money,scores FROM #@__arcrank WHERE rank='$rank'");
									//更新会员信息
									$sql1 =  " UPDATE #@__member SET rank='$rank',money=money+'{$memrank['money']}',
											   scores=scores+'{$memrank['scores']}',exptime='$exptime'+'$mhasDay',uptime='".time()."' 
											   WHERE mid='".$mid."'";
									
									//更新交易状态为已关闭
									$sql2=" UPDATE #@__member_operation SET sta='2',oldinfo='会员升级成功!' WHERE buyid='$order_sn' ";
									
									$dsql->ExecuteNoneQuery($sql1);
									$dsql->ExecuteNoneQuery($sql2);
					 				$msg = "付款成功，已经为您升级会员";

//九戒织梦 2019年1月22日09:30:45 推广注册部分
  	 

//1、推荐人加佣金 2、付款人改成已购买用户  3、写收益记录
$tjrarr = $dsql->GetOne("select tjrmid from #@__member where mid = '".$arr['mid']."'");
if(!empty($tjrarr['tjrmid'])){
	
	global $cfg_tgyjbl;
	$time = time();
	$yongjin = $arr['money'] * $cfg_tgyjbl / 100;
	$yongjin = number_format($yongjin,2);
	$tjrmid = $tjrarr['tjrmid'];
	
	//1
	$sql = "update #@__member set shouyi = (shouyi + $yongjin) where mid = '$tjrmid'";
 
	$dsql->ExecuteNoneQuery($sql);
	
	//2
	$sql = "update #@__member set yigoumai = '1' where mid = '".$arr['mid']."'";
 
	$dsql->ExecuteNoneQuery($sql);
	
	//3
	$sql = "insert into #@__jj_shouyi (`tjrmid`,`mid`,`jine`,`chanpin`,`yongjin`,`time` ) values ('$tjrmid','".$arr['mid']."','".$arr['money']."','".$arr['pname']."','$yongjin','$time')";
 
	$dsql->ExecuteNoneQuery($sql);		
	
}
 
//推荐end

									
									return true;
}					
					

						
			}//九戒织梦 2016年2月14日11:53:33  处理订单结束 
					
			
}

																										
			
					
}
		
		Log::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}


	
			

		
		return true;
	}
}



Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);
