<?php
//九戒织梦 2019年5月19日11:46:52 电脑端
require_once(dirname(__FILE__)."/config.php");
$mid  = $cfg_ml->M_ID;
if(empty($mid)){
	header("Location: /member");
	exit();
}

if(!empty($tid)){	
	$trr = $dsql->GetOne("select * from #@__arctype where id = '$tid'");
	$stime = time();
	$OrdersId = 'KE-'.$mid.'-'.$stime;	
	$CartCount = 1;
	$price = $trr['price']; 		
	if(empty($price)){ShowMsg('该课程无法单独购买，请开通VIP查看！', '-1',  0, 0);exit();}
	//打折系统
	if($cfg_dazhe == 'Y'){
		$price = $price / 100 * $cfg_zhekou;
	}
	
	 
	
	$ip = GetIP();
	$pid = $tid; //配送方式 改为 
	$paytype = 0;
	$dprice = 0; //配送费用
		//是否购买过这个
	$arr = $dsql->GetOne("select oid,state  from `#@__shops_orders`  where pid = '$tid' and  userid = '$mid' ");
 	
	$url = '/member/buy_action.php?a=selectpay&oid='.$OrdersId."&tid=".$tid;


	if(empty($arr['oid'])){ //没购买过这个
		$sql = "INSERT INTO `#@__shops_orders` (`oid`,`userid`,`cartcount`,`price`,`state`,`ip`,`stime`,`pid`,`paytype`,`dprice`,`priceCount`)
			VALUES ('$OrdersId','$mid','$CartCount','$price','0','$ip','$stime','$pid','$paytype','$dprice','$price');";
			
			//更新订单
			if($dsql->ExecuteNoneQuery($sql))
			{
				//到支付页面
				header("Location: ".$url);
				exit();
			} 
	}else{ //已经购买过了	
		if($arr['state'] == '0'){ //未付款
		$sql = "update   `#@__shops_orders`  set `oid`= '$OrdersId' , `price` = '$price', `ip` = '$ip' ,`stime` = '$stime' ,`pid` = '$pid' ,`paytype` = '$paytype' , `priceCount` = '$price'
		where oid = '".$arr['oid']."'";
		$dsql->ExecuteNoneQuery($sql);	
			
			//到支付页面 
			header("Location: ".$url);
			exit();
		}else{
			ShowMsg('您已购买该课程，无需重复购买！', '-1',  0, 0);exit();
		}
	
	}

}



?>