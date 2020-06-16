<?php
namespace app\index\controller;
use think\Url;
use think\Cache;
use think\Request;
use Org\service\NoticeService as NoticeService;
use think\Db;


class Market  extends Cmmcom
{
    /**
     * 财富天下
	 * 创建人 杨某
	 * 时间 2017-09-06 21:15:11
     */
	public function cmmphp() 
	{
		return $this->fetch();
	}
	
    /**
     * 买入订单
	 * 创建人 杨某
	 * 时间 2017-09-06 21:15:11
     */
	public function buyorder() 
	{		
		return $this->fetch();
	}
	
    /**
     * 兑换购机币
	 * 创建人 杨某
	 * 时间 2017-09-06 21:15:11
     */
	public function exchange() 
	{	
		//会员设置数据
		$coin_rate = 1;//购机币兑换率

		$where = array();		
		$where['id'] = ['>',0];	
		$set = new \Org\service\UserSetService();
			
		$setInfo = $set->userSetInfo($where);
		$res = unserialize($setInfo['value']);
		foreach($res as $key=>$v){
			if($key=='SET_coin_rate'){
				$coin_rate = $v;
			}	
		}
 		$where = array();
		$where['id']  = \think\Session::get('CmmUser_.id');
		$filed = "account,myphone,money_wallet,reward_wallet,fry_data,ping_id,fullname,weixin,aiplay,eth_purse,refereeid,forepart_money,forepart_time,status,ore_wallet,release_wallet,rank" ;
		$user = new \Org\service\UsersService();
		$result = $user->userInfo($where,$filed); 
		
		$this->assign('result',$result);
		$this->assign('coin_rate',$coin_rate);
		return $this->fetch();
	}
	
    /**
     * 卖出订单
	 * 创建人 杨某
	 * 时间 2017-09-06 21:15:11
     */
	public function sellorder() 
	{
 		$where = array();
		$where['id']  = \think\Session::get('CmmUser_.id');
		$filed = "account,myphone,money_wallet,reward_wallet,fry_data,ping_id,fullname,weixin,aiplay,eth_purse,refereeid,forepart_money,forepart_time,status,ore_wallet,release_wallet,rank" ;
		$user = new \Org\service\UsersService();
		$result = $user->userInfo($where,$filed); 
		
		$UserSet = new \Org\service\UserSetService();
		$where = array();		
		$where['id'] = ['>',0];	
		$setInfo = $UserSet->userSetInfo($where);
		$webInfo = unserialize($setInfo['value']);
		
		$shouxufei = 0;
		$usable = 0;
		
		foreach($webInfo as $key=>$v){
			if($key=='SET_poundage'){
				$shouxufei = $v;
			}
			if($key=='SET_usable'){
				$usable = $v;
			}
		}		
		$shouxufei = $shouxufei /100;
		
		//dump($result);die;
		$this->assign('usable',$usable);//POW额度
		$this->assign('shouxufei',$shouxufei);//手续费
		$this->assign('result',$result);//会员信息
		return $this->fetch();
	}
	
    /**
     * 兑换购机币操作
	 * 创建人 杨某
	 * 时间 2017-09-06 21:15:11
     */
	public function exchangeDooCmm() 
	{	
		if (request()->isAjax()){
			//强制要求完善个人资料
			$perfect = parent::perfectInfo();
			if(!$perfect){
				return json(['s'=>'请先完善个人资料再操作']);	
			}
			//判断支付密码
			$user = new \Org\service\UsersService();
			//判断安全密码是否正确
			if(!input('post.pay_pw')){
				return json(['s'=>'请输入只支付密码！']);	
			}
			$old_s = input('post.pay_pw');
			
			$keys = $user->keyCheck($tyle=0, $old_s);
			if(!$keys){
				return json(['s'=>'支付密码错误！']);
			}
			if(input('post.op')!='588cmmphp'){
				return json(['s'=>'参数错误！']);
			}
						
			if(!is_numeric(input('post.number'))){
				return json(['s'=>'参数错误！']);
			}
			
			if(!preg_match("/^\d*$/",input('post.number'))){
				return json(['s'=>'参数错误！']);
			}
				
			
			if(input('post.number')<1){
				return json(['s'=>'兑换数量不能小于1']);
			}	
			//会员设置数据
			$coin_rate = 1;//购机币兑换率

			$where = array();		
			$where['id'] = ['>',0];	
			$set = new \Org\service\UserSetService();
				
			$setInfo = $set->userSetInfo($where);
			$res = unserialize($setInfo['value']);
			foreach($res as $key=>$v){
				if($key=='SET_coin_rate'){
					$coin_rate = $v;
				}	
			}
			$total = $coin_rate * intval(input('post.number'));//兑换总金额
			if($total<0){
				return json(['s'=>'非法请求']);
			}
			
			//会员信息
			$where = array();
			$where['id']  = \think\Session::get('CmmUser_.id');
			$where['status']  = 1;
			$filed = "account,myphone,money_wallet,reward_wallet,fry_data,forepart_money,forepart_time,status,ore_wallet,release_wallet,rank" ;
			
			$result = $user->userInfo($where,$filed);	
			
			if(!$result){
				return json(['s'=>'账号已冻结']);
			}
			
			if($result['money_wallet']<intval(input('post.number'))){
				return json(['s'=>'购机币余额不足']);
			}
			//购机币
			$save = $user->userSetDec($where, 'money_wallet', input('post.number'));
			//购机币
			$save = $user->userSetInc($where, $field='release_wallet', $total);
			
			if($save){
				return json(['s'=>'ok']);
			}else{
				return json(['s'=>'兑换失败']);
			}
			
		}else{
			return json(['s'=>'参数错误！']);
		}
	}	 
	
    /**
     * 买入操作
	 * 创建人 杨某
	 * 时间 2017-09-06 21:15:11
     */
	public function buyDooCmm() 
	{
		if (request()->isAjax()){
			//强制要求完善个人资料
			$perfect = parent::perfectInfo();
			if(!$perfect){
				return json(['s'=>'请先完善个人资料再操作']);	
			}
			
			//判断支付密码
			$user = new \Org\service\UsersService();
			//判断安全密码是否正确
			if(!input('post.pay_pw')){
				return json(['s'=>'请输入只支付密码！']);	
			}
			$old_s = input('post.pay_pw');
			
			$keys = $user->keyCheck($tyle=0, $old_s);
			if(!$keys){
				return json(['s'=>'支付密码错误！']);
			}			
			
			if(!input('post.type')){
				//return json(['s'=>'【官方委托购买】通道未开通，请选择其他通道']);
			}
			
			if(input('post.op')!='588cmmphp'){
				return json(['s'=>'参数错误！']);
			}
						
			if(!is_numeric(input('post.number'))){
				return json(['s'=>'参数错误！']);
			}
			
			if(!preg_match("/^\d*$/",input('post.number'))){
				return json(['s'=>'参数错误！']);
			}
				
			
			if(input('post.number')<1){
				return json(['s'=>'买入数量不能小于1']);
			}
			
			if(input('post.type')){
				if(!is_numeric(input('post.type'))){
					return json(['s'=>'参数错误！']);
				}
				
				if(!preg_match("/^\d*$/",input('post.type'))){
					return json(['s'=>'参数错误！']);
				}
				
				if(input('post.type')!='1'){
					return json(['s'=>'参数错误！']);
				}
			}
			
			//会员设置数据
			$price = 1;//鱼苗单价
			$status = 1;//判断交易市场是否开启
			$type = 1;//自助排单 1开启,0关闭
			$minbuy = 1;//最低买入数量
			$maxbuy = 1;//最高买入数量
			$b_limit = 1;//买入数量限制
			$b_num = 1;//买入数量限制
			
			$setInfo = array();
			$where = array();		
			$where['id'] = ['>',0];	
			$set = new \Org\service\UserSetService();
			
			$setInfo = $set->userSetInfo($where);
			$res = unserialize($setInfo['value']);
			foreach($res as $key=>$v){
				if($key=='SET_GOODS_PRICE'){
					$price = $v;
				}
				if($key=='SET_MARKET_CLOSE'){
					$status = $v;
				}	
				//自助排单 开启/关闭
				if($key=='SET_FREE'){
					$type = $v;
				}	
				//最低买入数量
				if($key=='SET_MIN_BUY'){
					$minbuy = $v;
				}	
				//最高买入数量
				if($key=='SET_MAX_BUY'){
					$maxbuy = $v;
				}	
				//买入数量限制
				if($key=='SET_buy_limit'){
					$b_limit = $v;
				}
				//同时买入限制
				if($key=='SET_buy_nums'){
					$b_num = $v;
				}
			}
			
			if(input('post.number')%$b_limit){
				return json(['s'=>'买入数量必须是'.$b_limit.'的倍数']);
			}			

			//判断是否未完成的订单
			$uid = \think\Session::get('CmmUser_.id') ;
			$buy = new \Org\service\BuyOrderService();
			$buycount = $buy->buyCount("(uid=".$uid." AND status<>1 AND status<>4 AND status<>0 ) ");
			if($buycount>=$b_num){
				return json(['s'=>'同时买入不得超过'.$b_num.'张订单！']);
			}
			$bnum = 0;
			$market = new \Org\service\MarketService();	
			$marketList = $market->marketList(array('status'=>array('neq',1)));
			foreach($marketList as $key => $v){
				$buyOrder = $buy->buyInfo("uid=".$uid." AND  id=".$v['buyid']."");
				if($buyOrder && $v['status']!=0){
					$bnum = $bnum + 1;
				}				
			}
			
			if($bnum>=$b_num){
				return json(['s'=>'同时买入不得超过'.$b_num.'张订单！']);
			}
			
			if(input('post.number')<$minbuy){
				return json(['s'=>'单笔最低买入不得低于'.$minbuy]);
			}
			if(input('post.number')>$maxbuy){
				return json(['s'=>'单笔最高买入不得超过'.$maxbuy]);
			}
			
			if(!$type){
				return json(['s'=>'【自助排单】暂时关闭，请留意网站公告！']);
			}
			
			if(!$status){
				return json(['s'=>'交易市场暂时关闭，请留意网站公告！']);
			}
			
			$total = $price * intval(input('post.number'));//总金额
			if($total<0){
				return json(['s'=>'非法请求']);
			}
			
			//会员信息
			$where = array();
			$where['id']  = \think\Session::get('CmmUser_.id');
			$where['status']  = 1;
			$filed = "account,myphone,money_wallet,reward_wallet,fry_data,forepart_money,forepart_time,status,ore_wallet,release_wallet,rank" ;
			
			$result = $user->userInfo($where,$filed);	
			
			if(!$result){
				return json(['s'=>'账号已冻结']);
			}		
			
			//添加订单
			$data = array();			
			//$data['orderid'] = $orderid ;//订单号
			$data['price'] = $price ;//买入单价
			$data['total_money'] = $total ;//买入总额
			$data['amount'] = input('post.number');//买入数量
			$data['style'] = input('post.type');//交易类型，购买方式，0委托官方购买，1自助排单购买
			
			$add = $buy->buyAdd($data);
			if($add){
				
				//生成订单号
				$orderid = makeOrderSn($add, $no='B');
				//更新订单编号
				$update = $buy->buyUpdate(array('id'=>$add), array('orderid'=>$orderid));
				
				if($update){
					//自动匹配订单
					//$this->orderMatching($add, $price, input('post.number'), $type='buy', $user, $market, $buy);
					
					$Trade = new \Org\service\TradeLogService();
					//买入记录
					$data = array();
					$data['explain'] = '买入购机币';//说明
					$data['type'] = 1;//分类，0转账，1买入，2卖出
					$data['num'] =  $total;//金额
					$data['buy_old'] =  $result['money_wallet'] ;//买家原金额
					$data['buy_new'] =  $result['money_wallet'];//买家现金额
					$data['buy_uid'] =  \think\Session::get('CmmUser_.id');//买方
					$data['buy_orderid'] =  $orderid;//买方订单ID
					
					$addLog = $Trade->tradelogAdd($data);
					return json(['s'=>'ok']);
				}				
			}else{
				return json(['s'=>'买入失败']);
			}
					
		}else{				
			return json(['s'=>'非法请求']);	
		}
	}
	

    /**
     * 卖出操作
	 * 创建人 杨某
	 * 时间 2017-09-06 21:15:11
     */
	public function sellDooCmm() 
	{
		if (request()->isAjax()){
			//强制要求完善个人资料
			$perfect = parent::perfectInfo();
			if(!$perfect){
				return json(['s'=>'请先完善个人资料再操作']);	
			}
			
			//判断是否未完成的订单
			$uid =  \think\Session::get('CmmUser_.id') ;
			
			$sell = new \Org\service\SellOrderService();
			$sellOrder = $sell->sellInfo("uid=".$uid." AND status<>1 AND status<>4 AND status<>0 ");
			if($sellOrder){
				return json(['s'=>'您有一张订单未完成交易！']);
			}
			
			$market = new \Org\service\MarketService();	
			$marketList = $market->marketList(array('status'=>array('neq',1)));
			foreach($marketList as $key => $v){
				$sellOrder = $sell->sellInfo("uid=".$uid." AND id=".$v['sellid']." ");
				if($sellOrder && $v['status']!=0){
					return json(['s'=>'您有一张订单未完成交易！']);
				}				
			}
			
			if(!input('post.type')){
				return json(['s'=>'【官方委托回收】通道未开通，请选择其他通道']);
			}
			
			if(input('post.op')!='588cmmphp'){
				return json(['s'=>'参数错误！']);
			}
						
			if(!is_numeric(input('post.number'))){
				return json(['s'=>'参数错误！']);
			}
			
			if(!preg_match("/^\d*$/",input('post.number'))){
				return json(['s'=>'参数错误！']);
			}
			
			if(input('post.number')<1){
				return json(['s'=>'卖出数量不能小于1']);
			}
			
			if(input('post.type')){
				if(!is_numeric(input('post.type'))){
					return json(['s'=>'参数错误！']);
				}
				
				if(!preg_match("/^\d*$/",input('post.type'))){
					return json(['s'=>'参数错误！']);
				}
			}
			
			//会员设置数据
			$price = 1;//鱼苗单价
			$status = 1;//判断交易市场是否开启
			$type = 1;//自助排单 1开启,0关闭
			//$dayPer = 0;//日交易百分比
			$minsell = 1;//最低卖出数量
			$feiyong = 0;//手续费
			$maxsell = 1;
			
			$setInfo = array();
			$where = array();		
			$where['id'] = ['>',0];	
			$set = new \Org\service\UserSetService();
			
			$setInfo = $set->userSetInfo($where);
			$res = unserialize($setInfo['value']);
			foreach($res as $key=>$v){
				if($key=='SET_GOODS_PRICE'){
					$price = $v;
				}
				if($key=='SET_MARKET_CLOSE'){
					$status = $v;
				}
				//自助排单 开启/关闭
				if($key=='SET_FREE'){
					$type = $v;
				}
				//最低卖出数量
				if($key=='SET_MIN_SELL'){
					$minsell = $v;
				}
				//最高卖出数量
				if($key=='SET_MAX_SELL'){
					$maxsell = $v;
				}
				if($key=='SET_poundage'){
					$feiyong = $v;
				}
/* 				if($key=='SET_DAY_PER'){
					$dayPer = $v;
				} */
			}
			
			if(input('post.number')<$minsell){
				return json(['s'=>'单笔最低卖出数量不得低于'.$minsell]);
			}
			
			if(input('post.number')>$maxsell){
				return json(['s'=>'单笔最高卖出数不得超过'.$maxsell]);
			}
			
			if(!$type){
				return json(['s'=>'【自助排单】暂时关闭，请留意网站公告！']);
			}
			
			if(!$status){
				return json(['s'=>'交易市场暂时关闭，请留意网站公告！']);
			}
			
			if(!input('post.password')){
				return json(['s'=>'请输入支付密码！']);	
			}
			
			if(strlen(input('post.password'))< 6){
				return json(['s'=>'支付密码长度不能小于6位数']);
			}
			
			$total = $price * intval(input('post.number'));//总金额
			if($total<0){
				return json(['s'=>'非法请求']);
			}
			
			$user = new \Org\service\UsersService();

			//会员信息
			$where = array();
			$where['id']  = \think\Session::get('CmmUser_.id');
			$where['status']  = 1;
			$filed = "account,myphone,safe_key,money_wallet,reward_wallet,fry_data,forepart_money,forepart_time,status,ore_wallet,release_wallet,rank" ;
			
			$result = $user->userInfo($where,$filed);	
			
			if(!$result){
				return json(['s'=>'账号已冻结']);
			}

			if(!$result['safe_key']){
				return json(['s'=>'请先设置支付密码']);
			}
			
			//会员支付密码验证
			$safe = $user->keyCheck();
			if(!$safe){
				return json(['s'=>'支付密码错误！']);
			}
			
			$feiyong = input('post.number') * $feiyong /100 ;
			$totalAll = input('post.number') + $feiyong ;
			
			//会员鱼苗数量 可用鱼苗
			$umoney = $result['forepart_money'] + $result['fry_data'];
			//$useMoney = $result['fry_data'];
			if($umoney<$totalAll){
				return json(['s'=>'POW额度不足']);
			}

			if($result['ore_wallet']<$totalAll){
				return json(['s'=>'可售额度余额不足']);
			}
			
			$Trade = new \Org\service\TradeLogService();
			
			//添加订单
			$sell = new \Org\service\SellOrderService();
			$data = array();
			$data['price'] = $price ;//卖出单价
			$data['total_money'] = $total ;//卖出总额
			$data['amount'] = input('post.number') ;//卖出数量
			$data['style'] = input('post.type');//交易类型，购买方式，0委托官方购买，1自助排单购买
			$data['feiyong'] = $feiyong ;//手续费
				
			$add = $sell->sellAdd($data);
			if($add){
				
				//生成订单号
				$orderid = makeOrderSn($add, $no='S');
				//更新订单编号
				$update = $sell->sellUpdate(array('id'=>$add), array('orderid'=>$orderid));
				
				//扣除鱼苗 可用鱼苗								
				$where = array();
				$where['id']  = \think\Session::get('CmmUser_.id');	
				if($result['fry_data']<=$totalAll && $result['fry_data']>0){
					$filed = "fry_data" ;	
					$save = $user->userSetDec($where, $filed, $result['fry_data']);
					$totalAll_l = $totalAll - $result['fry_data'];
					if($totalAll_l>0){
						$filed = "forepart_money" ;
						$save = $user->userSetDec($where, $filed, $totalAll_l);		
					}

				}elseif($result['fry_data']>$totalAll && $result['fry_data']>0){
					$filed = "fry_data" ;	
					$save = $user->userSetDec($where, $filed, $totalAll);
				}else{
					$filed = "forepart_money" ;	
					$save = $user->userSetDec($where, $filed, $totalAll);
				}				
				
				$save2 = false ;
				//扣除可售额度总额  
				$filed = "ore_wallet" ;
				$save && $save2 = $user->userSetDec($where, $filed, $totalAll);
				
				//自动匹配订单
				//$this->orderMatching($add, $price, input('post.number'), $type='sell', $user, $market, $buy='', $sell);
				
				if($save2){

					//最数据 卖家
					$where = array();
					$buyNew = array();
					$where['id']  = \think\Session::get('CmmUser_.id');
					$filed = "id,account,money_wallet,fry_data,ore_wallet" ;
					$buyNew = $user->userInfo($where,$filed);
					//卖出记录
					$data = array();
					$data['explain'] = '卖出可售额度';//说明
					$data['type'] = 2;//分类，0转账，1买入，2卖出
					$data['num'] =   $total;//金额
					$data['sell_old'] =  $result['ore_wallet'] ;//卖家原鱼苗数
					$data['sell_new'] =  $buyNew['ore_wallet'];//卖家现鱼苗数
					$data['sell_uid'] =  \think\Session::get('CmmUser_.id');//卖方
					$data['sell_orderid'] =  $orderid;//卖方订单ID
					
					$addLog = $Trade->tradelogAdd($data);					
					return json(['s'=>'ok']);
				}					
			}else{
				return json(['s'=>'卖出失败']);
			}			
			
		}else{				
			return json(['s'=>'非法请求']);	
		}
	}
	
	
	
    /**
     * 订单详情
	 * 创建人 杨某
	 * 时间 2017-09-06 21:15:11
     */
	public function order_show() 
	{
		$orderid = input('get.orderid');		
		if(!$orderid){
			exit("订单不存在");die;
		}
		$pay_end = 0;//付款时限
		$yes_end = 0;//收款时限
		
		$UserSet = new \Org\service\UserSetService();
		$where = array();		
		$where['id'] = ['>',0];	
		$setInfo = $UserSet->userSetInfo($where);
		$webInfo = unserialize($setInfo['value']);
		foreach($webInfo as $key=>$v){
			if($key=='SET_paytime_end'){
				$pay_end = $v;
			}
			if($key=='SET_yestime_end'){
				$yes_end = $v;
			}
		}
		
		$user = new \Org\service\UsersService();
		$buy = new \Org\service\BuyOrderService();
		$sell = new \Org\service\SellOrderService();
		$object = $sell;
		$order = array();
		$market_list = array();
		
		$key = 'buyid';
		$utype = 'sellid';
		$title = '买入';
		//查询订单
		$str = substr($orderid,0,1);
		$where = array();		
		$where['uid'] = \think\Session::get('CmmUser_.id');
		$where['orderid'] = $orderid;
				
		if($str=="B"){
			//买入订单
			$title = '买入';
			$type = 'buy';
			$key = 'buyid';
			$utype = 'sellid';			
			$order = $buy->buyInfo($where);
			
			$object = $sell;			
		}
		
		if($str=="S"){
			//卖出订单
			$title = '卖出';
			$type = 'sell';
			$key = 'sellid';
			$utype = 'buyid';			
			$order = $sell->sellInfo($where);
			$object = $buy;
		}
		
		if(!$order){
			exit("订单不存在");die;
		}
		//dump($order );die;
		$marketList = array();
		if($order['status']=="1" || $order['status']=="3"){
			$market = new \Org\service\MarketService();
			$member = array();
			unset($where['orderid']);
			unset($where['uid']);
			$where[$key] = $order['id'];
			$marketList = $market->marketList($where);
			$file = 'account,myphone,fullname,weixin,aiplay,eth_purse,status';
			
			
			foreach($marketList as $key=>$v){
				$where = array();
				$where['id'] = $v[$utype];
				if($str=="B"){
					$ures = $sell->sellInfo($where);
				}elseif($str=="S"){
					$ures = $buy->buyInfo($where);
				}
				$where = array();
				$where['id'] = $ures['uid'];
				$member =  $user->userInfo($where, $file);
				//$marketList = $v;
				$marketList[$key]['user'] = $member;	
				$marketList[$key]['pay_end'] = 0;
				$marketList[$key]['pay_end'] = 0;
				
				if($pay_end>0 && $v['status']==2){
					$marketList[$key]['pay_end'] = $pay_end  *60 * 60 + $v['addtime'] ;
				}
				if($yes_end>0 && $v['status']==3){
					$marketList[$key]['yes_end'] = $yes_end  *60 * 60 + $v['paytime'];
				}				
			}
		}
		
		//dump($marketList);die;
		$this->assign('nowT',time());
		$this->assign('pay_end',$pay_end);
		$this->assign('yes_end',$yes_end);
		$this->assign('type',$type);
		$this->assign('title',$title);
		$this->assign('order',$order);//订单信息
		$this->assign('market_list',$marketList);//匹配订单
		return $this->fetch();
	}
	

    /**
     * 取消订单
	 * 创建人 杨某
	 * 时间 2017-09-06 21:15:11
     */
	public function abolishOrderDoo(){
		if (request()->isAjax()){
			//强制要求完善个人资料
			$perfect = parent::perfectInfo();
			if(!$perfect){
				return json(['s'=>'请先完善个人资料再操作']);	
			}
			
			if(input('post.op')!='588cmmphp' || !input('post.orderid') || !input('post.type')){
				return json(['s'=>'参数错误']);	
			}
			
			$where = array();
			$where['orderid'] = input('post.orderid');
			$where['uid'] = \think\Session::get('CmmUser_.id');
			//查询订单
			if(input('post.type')=="buy"){
				//买家订单
				$object = new \Org\service\BuyOrderService();
				$order = $object->buyInfo($where);
			}elseif(input('post.type')=="sell"){
				//卖家订单
				$object = new \Org\service\SellOrderService();
				$order = $object->sellInfo($where);
			}
			if(!$order){
				return json(['s'=>'该订单不存在']);
			}
			if($order['status']!="2"){
				return json(['s'=>'该订单不能取消']);	
			}
			
			$times = 30*60 + $order['addtime'];
			if($times>time()){
				return json(['s'=>'该订单不到30分钟不能取消']);
			}
			
			//取消订单
			$data = array();
			$data['status'] = 4;
			$save = false;
			if(input('post.type')=="buy"){
				//买家取消订单
				$save = $object->buyUpdate($where, $data);
			}elseif(input('post.type')=="sell")
			{
				//卖家取消订单
				$save = $object->sellUpdate($where, $data);
				//返回可售额度给卖家
				$where = array();
				$where['id'] = \think\Session::get('CmmUser_.id');
				$num = $order['amount'] + $order['feiyong']; 
				$user = new \Org\service\UsersService();
				$user->userSetInc($where, $field='ore_wallet', $num);
				//POW额度
				$user->userSetInc($where, $field='forepart_money', $num);
				
			}		
			if($save){
				return json(['s'=>'ok']);
			}else{
				return json(['s'=>'取消失败']);	
			}
		}else{
			return json(['s'=>'非法请求']);	
		}
	}
	
	
    /**
     * 确认【付款】操作
	 * 创建人 杨某
	 * 时间 2017-09-06 21:15:11
     */
	public function paymentOrderDoo(){
		if (request()->isAjax()){
			//强制要求完善个人资料
			$perfect = parent::perfectInfo();
			if(!$perfect){
				return json(['s'=>'请先完善个人资料再操作']);	
			}
			
			if(input('post.op')!='588cmmphp' || !input('post.orderid') || !input('post.type')){
				return json(['s'=>'参数错误']);	
			}
			
			if(input('post.type')!="buy"){
				return json(['s'=>'参数错误']);	
			}
			
			$pay_end = 0;//付款时限
			
			$UserSet = new \Org\service\UserSetService();
			$where = array();		
			$where['id'] = ['>',0];	
			$setInfo = $UserSet->userSetInfo($where);
			$webInfo = unserialize($setInfo['value']);
			foreach($webInfo as $key=>$v){
				if($key=='SET_paytime_end'){
					$pay_end = $v;
				}
			}
			
			$market = new \Org\service\MarketService();
			
			$order = array();
			$where = array();
			$where['orderid'] = input('post.orderid');//input('post.orderid');
			$where['status'] = 2;
			$order = $market->marketInfo($where);
			if(!$order){
				return json(['s'=>'订单不存在']);
			}
			if($order['status']=="0"){
				return json(['s'=>'该订单已被冻结']);
			}
			
			if($pay_end>0){
				$pay_end = $pay_end  *60 * 60 + $order['addtime'] ;
			}
			if($pay_end<time() && $pay_end>100000){
				return json(['s'=>'该订单超时未支付已被冻结']);
			}
			
			//自己是买家
			if($order['status']!="2"){
				return json(['s'=>'该订单状态不能操作']);
			}
			
			$sell = new \Org\service\SellOrderService();
			$buy = new \Org\service\BuyOrderService();
			$user = new \Org\service\UsersService();			
			$userOne = array();
			$where = array();

			//确认付款，卖家信息（对方）
			$where['id'] = $order['sellid'];
			$userOne = $sell->sellInfo($where);
			if(!$userOne){
				return json(['s'=>'卖家订单不存在']);
			}
			
			$b_table = '';
			$join = '';					
			$b_table = $buy->buyDb().' b';
			$join = "a.buyid = b.id";
				
			//判断对方账号
			$where['id'] = $userOne['uid'];
			$member = $user->userInfo($where);
			if(!$member){
				return json(['s'=>'对方账号不存在']);
			}
					
			//判断是否是本人操作
			$where = '';
			$where = 'a.id='.$order['id'].' and b.uid='.\think\Session::get('CmmUser_.id') .' and b.id='.$order['buyid'];
			$field = "*";
		
			$userOrder = $market->marketOneJoin($where, $field, $b_table, $join);
			if(!$userOrder){
				return json(['s'=>'你无权操作']);
			}
			
			$data = array();
			$data['status'] = 3;//确认付款 下一步等待卖家确认收款
			$data['paytime'] = time();//付款时间			
			//修改订单状态
			$save = false;
			$save = $market->marketUpdate(array('id'=>$order['id']), $data);	
			
			if($save){
				//向卖家发送短信通知
				$this->buyMsm($member['myphone'], $userOne['orderid'], $type=2);	
				
				return json(['s'=>'ok']);
			}else{
				return json(['s'=>'操作失败']);
			}
			
		}else{
			return json(['s'=>'非法请求']);	
		}		
	}

    /**
     *  确认【收款】操作
	 * 修改人 杨某
	 * 时间 2017-09-14 21:39:01
     */		
	public function makeMoneyDoo(){
		if (request()->isAjax()){
			//强制要求完善个人资料
			$perfect = parent::perfectInfo();
			if(!$perfect){
				return json(['s'=>'请先完善个人资料再操作']);	
			}
			
			if(input('post.op')!='588cmmphp' || !input('post.orderid') || !input('post.type')){
				return json(['s'=>'参数错误']);	
			}
			
			if(input('post.type')!="sell"){
				return json(['s'=>'参数错误']);	
			}
			
			$yes_end = 0;//收款时限
			
			$UserSet = new \Org\service\UserSetService();
			$where = array();		
			$where['id'] = ['>',0];	
			$setInfo = $UserSet->userSetInfo($where);
			$webInfo = unserialize($setInfo['value']);
			foreach($webInfo as $key=>$v){
				if($key=='SET_yestime_end'){
					$yes_end = $v;
				}
			}
			
			$market = new \Org\service\MarketService();
			$sell = new \Org\service\SellOrderService();
			$buy = new \Org\service\BuyOrderService();
			$user = new \Org\service\UsersService();
			
			$order = array();
			$where = array();
			$where['orderid'] = input('post.orderid');
			$where['status'] = 3;
			$order = $market->marketInfo($where);
			
			//print_r($order);die;
			
			if(!$order){				
				return json(['s'=>'订单不存在']);
			}
			
			$buywhere['id'] = $order['buyid'];
			
			$buylist = $buy->buyInfo($buywhere);
			$sumwhere['uid'] = $buylist['uid'];
			$sumwhere['status'] = array('neq',2);
			$mfileds = 'amount';
			$userbuysummoney = $buy->buySum($sumwhere,$mfileds);
			
			
			
			//print_r($buylist);die;
			
			if($yes_end>0){
				$yes_end = $yes_end  *60 * 60 + $order['paytime'];
			}

			if($yes_end<time() && $yes_end>100000){
				return json(['s'=>'该订单超时未支付已被冻结']);
			}				
		
			if($order['status']=="0"){
				return json(['s'=>'该订单已被冻结']);
			}
			
			$userOne = array();
			$where = array();
			$data = array();
			$b_table = '';
			$join = '';
			
			//自己是卖家
			if($order['status']!="3"){
				return json(['s'=>'该订单状态不能操作']);
			}
			//确认收款，买家信息（对方）
			$where['id'] = $order['buyid'];
			$userOne = $buy->buyInfo($where);
			if(!$userOne){
				return json(['s'=>'买家订单不存在']);
			}
			$data['status'] = 1;//确认收款		
			$data['endtime'] = time();//完成交易时间
			$b_table = $sell->sellDb().' b';
			$join = "a.sellid = b.id";

			//判断对方账号
			$where['id'] = $userOne['uid'];
			$member = $user->userInfo($where);
			if(!$member){
				return json(['s'=>'对方账号不存在']);
			}
					
			//判断是否是本人操作
			$where = '';
			$where = 'a.id='.$order['id'].' and b.uid='.\think\Session::get('CmmUser_.id') .' and b.id='.$order['sellid'];
			$field = "*";
		
			$userOrder = $market->marketOneJoin($where, $field, $b_table, $join);
			if(!$userOrder){
				return json(['s'=>'你无权操作']);
			}
			
			/*---------------------------买家、卖家个人信息------------------------*/
			$buy_info  = '';//买家
			$sell_info  = '';//卖家
			$uid = \think\Session::get('CmmUser_.id');//会员为卖家
			
			$where = array();	
			
			//买家信息
			$buy_info = $member;
				
			//卖家（自己）
			$where['id'] = $uid;
			$sell_info = $user->userInfo($where);
				
			//ID
			$sell_id = $uid;
			$buy_id = $userOne['uid'];
			
			//订单ID
			$bid = $userOne['uid'];
			$sid = $userOne['uid'];
			
			////------------结束
			
			//修改订单状态
			$save = false;
			$save = $market->marketUpdate(array('id'=>$order['id']), $data);	
			//$save = 1;
			if($save){				
				
				/*---------------------------买家会员更新------------------------*/
				//购机币
				$data2 = $order['amount'];
				
				//买家 总金额增加
				$user->userSetInc(array('id'=>$buy_id), $field='money_wallet', $data2);
				$usable = \think\Session::get('CmmUser_.usable') * $data2 /100 ;
				//POW额度增加
				$user->userSetInc(array('id'=>$buy_id), $field='forepart_money', $usable);	
				
				////------------结束
				
				/*---------------------------更新订单状态------------------------*/
				$data = array();
				$data['status'] = 1;
				$data['endtime'] = time();					
				//更新 买入/卖出 订单状态
				$buy->buyUpdate(array('id'=>$order['buyid']), $data);
				$sell->sellUpdate(array('id'=>$order['sellid']), $data);
				
				////------------结束
				
				$minfo_ = false;
				$where = array();
				$where['id'] = $order['id'];
				$where['status'] = 1;
				
				$minfo_ = $market->marketInfo($where);
				//$minfo_ = 1;
				/*---------------------------会员奖励------------------------*/
				if($minfo_){
					
					//更新会员活跃状态
					//!$member['team_sign'] && $user->userUpdate('id="'.$member['id'].'"', $field='team_sign', 1);
					/*---------------------------充值奖励------------------------*/
					//会员设置数据
					$reward = 0;//团队奖 领导奖励百分百
					$groom_1 = 0;
					$groom_2 = 0;
					$groom_3 = 0;
					$groom_4 = 0;
					$groom_4 = 0;

					$uGrade_1 = 0;
					$uGrade_2 = 0;
					$uGrade_3 = 0;
					$uReward_1 = 0;
					$uReward_2 = 0;
					$uReward_3 = 0;
					
					$parents_1 = 0;
					$parents_2 = 0;
					
					//会员买币奖励
					$buys_1 = 0;
					$buys_2 = 0;
					$buys_3 = 0;
					$coin_1 = 0;
					$coin_2 = 0;
					$coin_3 = 0;	
					$goods_1 = 0;
					$goods_2 = 0;
					$goods_3 = 0;						
					
					$setInfo = array();
					$result = array();
					$where = array();										
					$where['id'] = ['>',0];	
					$set = new \Org\service\UserSetService();
					$orderM = new \Org\service\KorderService();
					$ore = new \Org\service\OreService();
					$log = new \Org\service\LucrelogService();
						
					$setInfo = $set->userSetInfo($where);
					$result = unserialize($setInfo['value']);
					
					foreach($result as $key=>$v){

						if($key=='SET_buys_1'){
							$buys_1 = $v;
						}
						if($key=='SET_buys_2'){
							$buys_2 = $v;
						}
						if($key=='SET_buys_3'){
							$buys_3 = $v;
						}
						if($key=='SET_give_coin_1'){
							$coin_1 = $v;
						}
						if($key=='SET_give_coin_2'){
							$coin_2 = $v;
						}
						if($key=='SET_give_coin_3'){
							$coin_3 = $v;
						}
						if($key=='SET_give_goods_1'){
							$goods_1 = $v;
						}
						if($key=='SET_give_goods_2'){
							$goods_2 = $v;
						}
						if($key=='SET_give_goods_3'){
							$goods_3 = $v;
						}
						//团队奖
						if($key=='SET_REWARD_PER'){
							$reward = $v;
						}
						if($key=='SET_groom_1'){
							$groom_1 = $v;
						}
						if($key=='SET_groom_2'){
							$groom_2 = $v;
						}
						if($key=='SET_groom_3'){
							$groom_3 = $v;
						}
						if($key=='SET_groom_4'){
							$groom_4 = $v;
						}
						if($key=='SET_user_Grade_1'){
							$uGrade_1 = $v;
						}
						if($key=='SET_user_Grade_2'){
							$uGrade_2 = $v;
						}
						if($key=='SET_user_Grade_3'){
							$uGrade_3 = $v;
						}
						if($key=='SET_user_reward_1'){
							$uReward_1 = $v;
						}
						if($key=='SET_user_reward_2'){
							$uReward_2 = $v;
						}
						if($key=='SET_user_reward_3'){
							$uReward_3 = $v;
						}
						if($key=='SET_parents_1'){
							$parents_1 = $v;
						}
						if($key=='SET_parents_2'){
							$parents_2 = $v;
						}
						if($key=='SET_kjnum_2'){
							$kjnum_2 = $v;
						}
						if($key=='SET_kjnum_3'){
							$kjnum_3 = $v;
						}
						
					}
					
					$g_coin = 0;
					$grade = 0 ;
					$g_goods = 0 ;			
					
					$jlsta = 0 ;
					
					if($userbuysummoney>=$buys_1 && $userbuysummoney < $buys_2 && $member['rank']==1){
						//赠送矿机等级
						$grade = 2 ;
						$g_goods = $goods_1 ;
						//赠送购机币数量
						$g_coin = intval($coin_1);
						$user->userSetInc(array('id'=>$buy_id), $field='rank', 1);//会员升级
						
					}elseif($userbuysummoney>=$buys_2 && $buys_2>0 && $member['rank']==1){
						//赠送矿机等级
						$grade = 2 ;	
						$g_goods = $goods_2 ;
						//赠送购机币数量
						$g_coin = 0;	
						$user->userSetInc(array('id'=>$buy_id), $field='rank', 1);//会员升级												
					}elseif($userbuysummoney>=$buys_2 && $userbuysummoney < $buys_3 && $buys_3>0 && $member['rank']==2){
						
						//赠送矿机等级
						$grade = 2 ;	
						$g_goods = $goods_2 ;
						//赠送购机币数量
						$g_coin = 0;
						
					}elseif($userbuysummoney>=$buys_3 && $buys_3>0 && $member['rank']==2){
						
						$user->userSetInc(array('id'=>$buy_id), $field='rank', 1);//会员升级
						
						//赠送矿机等级
						$grade = 3 ;	
						$g_goods = $goods_3 ;
						//赠送购机币数量
						$g_coin = intval($coin_3);	
						$jlsta = 1;
					}
					
					
					
					if($grade && $g_goods>=1){
						
						
						//赠送矿机
						//送矿机
								
						$where = array();
						$where['grade'] = $grade;
						$oreInfo = $ore->oreInfo($where);
						
						if($oreInfo){
							$num = $g_goods;
							while($num>0){
								
								$data=array();										
								$data['uid'] = $buy_id;
								$data['price'] = $oreInfo['price'];
								$data['kid'] = $oreInfo['id'];
								$data['output'] = $oreInfo['output'];
								$data['profit'] = $oreInfo['profit'];
								$data['day_gain'] = $oreInfo['day_gain'];
								$data['ore_coin'] = $oreInfo['ore_coin'];
								$data['cyc'] = $oreInfo['cyc'];
								$data['addtime'] = time();
								//结束时间
								$endtime = time() + $oreInfo['cyc'] * 24 *60 * 60 ;
								$data['endtime'] = $endtime;
								$data['status'] = 1;
										
								$add = $orderM->korderAdd($data);
								//$add = 1;
								if($add){
									//生成订单号
									$orderid = makeOrderSn($add, $no='MD');
									$update = $orderM->korderUpdate(array('id'=>$add), array('orderid'=>$orderid));
											
								}
								$num = $num -1 ;
							}
							
							
						}
					
					}
						//return json(['s'=>$g_coin]);
					if($g_coin>0){
						//送购机币
						
						//赠送购机币 直接放入乐豆种子release_wallet
						$save = $user->userSetInc(array('id'=>$buy_id), 'release_wallet', $g_coin);
						//3赠送
						$data = array();
						$data['uid'] = $buy_id;
						$data['explain'] = '购买'.$order['amount'].'购机币赠送购机币';
						$data['money'] = $g_coin;
						$data['type'] = 3;
						$data['days'] = 0;
						$data['addtime'] = time();
						
						$log->lucrelogAdd($data);						
					}					
					
					//-------------------直推奖----------------------
					
					//买家 直推奖 //$member['uid']
					$zj_parent = $user->userInfo(array('id'=>$member['refereeid']));
					//print_r($zj_parent);die;
					
					if($zj_parent){
						
						$open = 0 ;
						
						if($open){
							//echo 22222222222;
							$zj_son = $user->userList(array('refereeid'=>$member['refereeid']));
							$zj_count = 0;
							foreach($zj_son as $key=>$v){
								//判断是否是活跃用户
								$buyIbfo = $buy->buyInfo(array('uid'=>$v['id'], 'status'=>1));
								if($buyIbfo){
									$zj_count = $zj_count+1;
								}							
							}
						
							if($zj_parent['jiangli']=='0' && $zj_count>=$groom_1){
								$grade = 1;
							}
							if($zj_parent['jiangli']=='1' && $zj_count>=$groom_2){
								$grade = 2;
							}
							if($zj_parent['jiangli']=='2' && $zj_count>=$groom_3){
								$grade = 3;
							}
							if($zj_parent['jiangli']=='3' && $zj_count>=$groom_4){
								$grade = 4;
							}
							if($grade){
								//送矿机							
								//echo 11111111111;
								$where = array();
								$where['grade'] = $grade;
								$oreInfo = $ore->oreInfo($where);
								$data=array();
								
								$data['uid'] = $zj_parent['id'];
								$data['price'] = $oreInfo['price'];
								$data['kid'] = $oreInfo['id'];
								$data['output'] = $oreInfo['output'];
								$data['profit'] = $oreInfo['profit'];
								$data['day_gain'] = $oreInfo['day_gain'];
								$data['ore_coin'] = $oreInfo['ore_coin'];
								$data['cyc'] = $oreInfo['cyc'];
								$data['addtime'] = time();
								//结束时间
								$endtime = time() + $oreInfo['cyc'] * 24 *60 * 60 ;
								$data['endtime'] = $endtime;
								$data['status'] = 1;
								
								$add = $orderM->korderAdd($data);
								if($add){
									//生成订单号
									$orderid = makeOrderSn($add, $no='MD');
									$update = $orderM->korderUpdate(array('id'=>$add), array('orderid'=>$orderid));
									
								}
								//更新上级数据
								$user->userSetField(array('id'=>$zj_parent['id']) , $field='jiangli', $grade);
							}							
						}
	
						
											
						$team_num = array();
						if($reward){
							$team_num = explode(',',$reward);
						}
						$open = 1 ;
						if($team_num && $open){
							//购机币 $order['amount']
							$parentid = $member['refereeid'];
							$keyC = 0;						
							
							while($parentid>0){

								$parents = $user->userInfo(array('id'=>$parentid));
								if(!$parents){
									$parentid = 0;
									//dump($parentid);die;
									break;
									
								}
								if(isset($team_num[$keyC])){
									
									$amounts = $order['amount'] * $team_num[$keyC] / 100;
									if($amounts){
										$save = $user-> userSetInc(array('id'=>$parentid), $field='money_wallet', $amounts);
										//更新POW额度
										$usable = \think\Session::get('CmmUser_.usable') * $amounts / 100 ;
										$save2 = $user-> userSetInc(array('id'=>$parentid), $field='forepart_money', $usable);
										//添加收益
										//3购机币 领导奖
										$data = array();
										$data['uid'] = $parentid;
										$data['money'] = $amounts;
										$data['type'] = 3;
										$data['days'] = 0;
										$data['addtime'] = time();
										
										$log->lucrelogAdd($data);									
									}
								}							
								if($parents['refereeid']){
									
									$parentid = $parents['refereeid'];
									
								}else{
									$parentid = 0;
									break;
								}
								$keyC = $keyC+1;	
							}							
						}
							//echo $jlsta."<BR/>";
							//echo $member['refereeid'].'----'.$member['rank'].'----'.$parents_1.'----'.$parents_2;die;
						//直推奖
					
						if($member['refereeid'] && $jlsta == 1){

								if($parents_1>0){
									//赠送N台小型矿机
									$where = array();
									$where['grade'] = 3;
									$oreInfo = $ore->oreInfo($where);
									$parents_1 = $parents_1;
									while($parents_1>0){
										//生产订单									
										$data=array();
										
										$data['uid'] = $member['refereeid'];
										$data['price'] = $oreInfo['price'];
										$data['kid'] = $oreInfo['id'];
										$data['output'] = $oreInfo['output'];
										$data['profit'] = $oreInfo['profit'];
										$data['day_gain'] = $oreInfo['day_gain'];
										$data['ore_coin'] = $oreInfo['ore_coin'];
										$data['cyc'] = $oreInfo['cyc'];
										$data['addtime'] = time();
										//结束时间
										$endtime = time() + $oreInfo['cyc'] * 24 *60 * 60 ;
										$data['endtime'] = $endtime;
										$data['status'] = 1;
										$add = 0;
										$add = $orderM->korderAdd($data);
										if($add){
											//生成订单号
											$orderid = makeOrderSn($add, $no='MD');
											$update = $orderM->korderUpdate(array('id'=>$add), array('orderid'=>$orderid));
											$parents_1 = $parents_1-1;											
										}

									}
								
								}
								
								if($parents_2>0){
									//赠送N台中型矿机
									$where = array();
									$where['grade'] = 2;
									$oreInfo = $ore->oreInfo($where);
									$parents_2 = $parents_2;
									while($parents_2>0){
										//生产订单									
										$data=array();
										
										$data['uid'] = $member['refereeid'];
										$data['price'] = $oreInfo['price'];
										$data['kid'] = $oreInfo['id'];
										$data['output'] = $oreInfo['output'];
										$data['profit'] = $oreInfo['profit'];
										$data['day_gain'] = $oreInfo['day_gain'];
										$data['ore_coin'] = $oreInfo['ore_coin'];
										$data['cyc'] = $oreInfo['cyc'];
										$data['addtime'] = time();
										//结束时间
										$endtime = time() + $oreInfo['cyc'] * 24 *60 * 60 ;
										$data['endtime'] = $endtime;
										$data['status'] = 1;
										$add = 0;
										$add = $orderM->korderAdd($data);
										if($add){
											//生成订单号
											$orderid = makeOrderSn($add, $no='MD');
											$update = $orderM->korderUpdate(array('id'=>$add), array('orderid'=>$orderid));
											$parents_2 = $parents_2-1;											
										}

									}
								
								}	

									$jlsta = 0;
						}						
						
						//团队奖2
						/*$reward_s = 0;
						if($zj_parent['rank']==$uGrade_1){
							$reward_s = $uReward_1;
						}elseif($zj_parent['rank']==$uGrade_2){
							$reward_s = $uReward_2;
						}elseif($zj_parent['rank']==$uGrade_3){
							$reward_s = $uReward_3;
						}

						$reward_s = $reward_s;							
						$uids = $zj_parent['id'];
						$parentid = $zj_parent['refereeid'];
						$num = 3;//关闭时为0
						$i = 0;
						
						while($num>0){
							//给上级团队奖
							$reward_s = explode("," , $reward_s);
								
							if(isset($reward_s[$i]) && $reward_s){
								$money = $reward_s[$i] * 100 / 100;
								//奖励记录
								$data = array();
								$data['explain'] = '团队奖'.$reward_s[$i].'%';//说明
								$data['num'] =  $money;//金额
								$data['tyle'] = 2;//1代表打捞鱼苗
								$data['uid'] =  $uids;
								$bonus = new \Org\service\BonusLogService();
								$addBonus = $bonus->bonuslogAdd($data);
								//更新购机币
								$save = $user-> userSetInc(array('id'=>$uids), $field='money_wallet', $money);
								//更新POW额度
								$save = $user-> userSetInc(array('id'=>$uids), $field='forepart_money', $money);
							}
								
							$parent = $user->userInfo(array('id'=>$parentid));

							if($parent){
								$reward_s = 0;
									
								if($parent['rank']==$uGrade_1){
									$reward_s = $uReward_1;
								}elseif($parent['rank']==$uGrade_2){
									$reward_s = $uReward_2;
								}elseif($parent['rank']==$uGrade_3){
									$reward_s = $uReward_3;
								}
									
								$parentid = $parent['refereeid'];
								$uids = $parent['id'];
							}else{
								$parentid = 0;
							}
							$i = $i+1;
							$num = $num - 1;
						}*/
							

						
					}
					/*if($zj_parent){
						
						//直推奖
						if($member['refereeid'] && $member['rank']==2){
								
								if($parents_1>0){
									//赠送N台小型矿机
									$where = array();
									$where['grade'] = 3;
									$oreInfo = $ore->oreInfo($where);
									$parents_1 = $parents_1;
									while($parents_1>0){
										//生产订单									
										$data=array();
										
										$data['uid'] = $member['refereeid'];
										$data['price'] = $oreInfo['price'];
										$data['kid'] = $oreInfo['id'];
										$data['output'] = $oreInfo['output'];
										$data['profit'] = $oreInfo['profit'];
										$data['day_gain'] = $oreInfo['day_gain'];
										$data['ore_coin'] = $oreInfo['ore_coin'];
										$data['cyc'] = $oreInfo['cyc'];
										$data['addtime'] = time();
										//结束时间
										$endtime = time() + $oreInfo['cyc'] * 24 *60 * 60 ;
										$data['endtime'] = $endtime;
										$data['status'] = 1;
										$add = 0;
										$add = $orderM->korderAdd($data);
										if($add){
											//生成订单号
											$orderid = makeOrderSn($add, $no='MD');
											$update = $orderM->korderUpdate(array('id'=>$add), array('orderid'=>$orderid));
											$parents_1 = $parents_1-1;											
										}

									}
								
								}
								
								if($parents_2>0){
									//赠送N台中型矿机
									$where = array();
									$where['grade'] = 2;
									$oreInfo = $ore->oreInfo($where);
									$parents_2 = $parents_2;
									while($parents_2>0){
										//生产订单									
										$data=array();
										
										$data['uid'] = $member['refereeid'];
										$data['price'] = $oreInfo['price'];
										$data['kid'] = $oreInfo['id'];
										$data['output'] = $oreInfo['output'];
										$data['profit'] = $oreInfo['profit'];
										$data['day_gain'] = $oreInfo['day_gain'];
										$data['ore_coin'] = $oreInfo['ore_coin'];
										$data['cyc'] = $oreInfo['cyc'];
										$data['addtime'] = time();
										//结束时间
										$endtime = time() + $oreInfo['cyc'] * 24 *60 * 60 ;
										$data['endtime'] = $endtime;
										$data['status'] = 1;
										$add = 0;
										$add = $orderM->korderAdd($data);
										if($add){
											//生成订单号
											$orderid = makeOrderSn($add, $no='MD');
											$update = $orderM->korderUpdate(array('id'=>$add), array('orderid'=>$orderid));
											$parents_2 = $parents_2-1;											
										}

									}
								
								}							
						}						
					}*/
					
				}
			
				return json(['s'=>'ok']);
			}else{
				return json(['s'=>'操作失败']);
			}
			
		}else{
			return json(['s'=>'非法请求']);	
		}		
	}	
	
    /**
     *  自动匹配订单
	 *  修改人 杨某
	 * 	$number 买入/卖出数量 $type配比的类型【买入或者卖出】 $price单价 $Aid甲方ID
	 * 时间 2017-09-14 21:39:01
     */		
	public function orderMatching($Aid=0, $price=1, $number=0, $type='buy', $user='', $market='', $buy='', $sell=''){
		
		if(!$Aid){
			return false;
		}

		if(!$buy){
			$buy = new \Org\service\BuyOrderService();
		}
		if(!$sell){
			$sell = new \Org\service\SellOrderService();
		}
		
		if(!$market){
			$market = new \Org\service\MarketService();
		}		
		if(!$user){
			$user = new \Org\service\UsersService();
		}
	
		//甲方
		$Atype = '';
		//乙方
		$Btype = '';
			
		
		if($type=='buy'){
			//买入订单和卖出订单进行匹配
			
			//查询最晚的订单
			$Bid = Db::table('cmm_sellorder')->where('status=2 AND amount='.$number)->min('id');
			if(!$Bid){
				return false;
			}			
			//买入订单信息 甲方
			$buyInfo = $buy->buyInfo(array('id'=>$Aid));			
			//卖出订单信息 乙方
			$sellInfo = $sell->sellInfo(array('id'=>$Bid));
			
			//甲方
			$Atype = 'buyid';
			//乙方
			$Btype = 'sellid';
			
			$buyid = $Aid;
			$sellid = $Bid;
			
		}else{
			//乙方
			$Bid = Db::table('cmm_buyorder')->where('status=2 AND amount='.$number)->min('id');
			if(!$Bid){
				return false;
			}
			//卖出订单信息 甲方
			$sellInfo = $sell->sellInfo(array('id'=>$Aid));
			//买入订单信息 乙方
			$buyInfo = $buy->buyInfo(array('id'=>$Bid));		

			//甲方
			$Atype = 'sellid';
			//乙方
			$Btype = 'buyid';
			
			$buyid = $Bid;
			$sellid = $Aid;
		}
		
		//判断是否已匹配
		$Bminfo = $market->marketInfo(array(''.$Btype.''=>$Bid));
		if($Bminfo){
			return false;
		}
			
		//进行匹配
		$data = array();
		//甲方
		$data[$Atype] = $Aid ;
		//乙方		
		$data[$Btype] = $Bid ;
		//数量
		$data['amount'] = $number ;
		//价格
		$data['price'] =  $price ;
				
		$add = $market->marketAdd($data);
		if(!$add){
			return false;
		}else{			
			$orderid = '';
			$orderid = makeOrderSn($add, $no='M');
			//更新订单号
			$save = $market->marketUpdate(array('id'=>$add), array('orderid'=>$orderid));
			if(!$save){
				return false;;
			}
				
			//更新买卖双方订单状态
			$data2 = array();
			$data2['status'] = 3;
			$data2['matetime'] = time();
			
			$sell->sellUpdate(array('id'=>$sellid), $data2);	
			$buy->buyUpdate(array('id'=>$buyid), $data2);
			
			//发送短信通知
			$sellUser = $user->userInfo(array('id'=>$sellInfo['uid']));
			$buyUser = $user->userInfo(array('id'=>$buyInfo['uid']));
			if($sellUser['myphone']){
				$this->buyMsm($sellUser, $sellInfo['orderid']);
			}
			if($buyUser['myphone']){
				$this->buyMsm($buyUser, $buyInfo['orderid']);
			}		
		}		
		
	}
	
	
    /**
     *  团队奖励
	 * 修改人 杨某
	 * 时间 2017-09-14 21:39:01
     */	
	public function parentTeam($uid=0, $money=0, $reward=array(), $user='') 
	{
		if($uid && $money){
			
			if(!$user){
				$user = new \Org\service\UsersService();
			}

			$count = count($reward);
			$uid = $uid ;
			$i = 0;
			
			while($count>0){
				if($uid){
					$where = array();
					$where['id'] = $uid;
					$where['status'] = 1;
					$info = $user->userInfo($where);
					//上级ID
					$uid = $info['refereeid'];
					if($reward && $info){
						$amount = $money * $reward[$i] /100 ;
						$save = $user->userSetInc(array('id'=>$info['id']),  $field='reward_wallet', $amount);
						
						//奖励记录
						$data = array();
						$data['explain'] = '团队奖'.$reward[$i].'%';//说明
						$data['num'] =  $amount;//金额
						$data['tyle'] = 2;//1代表打捞鱼苗
						$data['uid'] =  $info['id'];
						$bonus = new \Org\service\BonusLogService();
						$addBonus = $bonus->bonuslogAdd($data);		
					}
					$count = $count-1;
					$i = $i+1;
				}else{
					$count = 0;
					$uid = 0;
				}	
			}
			
			return true;
			
		}else{
			return false;
		}
	}
	
    /**
     *  统计充值金额（完成交易总金额）
	 * 修改人 杨某
	 * 时间 2017-09-14 21:39:01
     */	
	public function countTrade($uid=0, $money=0, $name='', $market='', $buy='') 
	{
		if($uid && $money){
			
			if(!$market){
				$market = new \Org\service\MarketService();
			}
			
			if(!$buy){
				$buy = new \Org\service\BuyOrderService();
			}
			
			$rech = new \Org\service\RechargeLogService();
			$where['users_id'] = $uid;
			$field = "num";
			
			$sum = $rech->RechLogSum($where, $field);
			if(!$sum){
				$sum = 0;
			}
			
			if(!$name){
				$name = "a.price";//交易金额
			}
			
			$where = '';
			$where = 'a.status=1 and b.uid='.$uid;
			$field = "*";
			$b_table = $buy->buyDb().' b';
			$join = "a.buyid = b.id";	
			
			$msum = $market->marketJoinSum($where, $field, $b_table, $join, $name);
			
			if(!$msum){
				$msum = 0;
			}
			
			$sum = $sum + $msum;
			
			return $sum;
			
		}else{
			return false;
		}
	}

    /**
     *  生成（赠送）兑换码
	 * 修改人 杨某
	 * 时间 2017-09-14 21:39:01
     */	
	public function giveCode($uid=0, $num=0, $card_num=1) 
	{
		if($uid && $num){
			
			$redeem = new \Org\service\RedeemService();
					
			$k = 0;
			$rand = rand(100,999);
			if($card_num>1){
				$num = $card_num*$num;
			}
					
			for($i=0;$i<$num;$i++){
				//随机字符串
				$str = '';				
				$code = $rand;
				if($code==$rand){
					$rand = rand(100,999);
				}else{
					$code = rand(100,999);
				}
				$str = time().$code;
				unset($code);					
				if($str){
					$data = array();
					$data['uid'] = $uid;//会员ID
					$data['code'] = number_encode($str, 16);//兑换码
					$add = $redeem->redeemAdd($data);
					unset($str);
					if($add){
						$k++;
					}					
				}						
			}
			if($k){
				return true;
			}
			
		}else{
			return false;
		}
	}
	
	
    /**
     * 匹配成功，向卖家发送短信
	 * 创建人 杨某
	 * 时间 2017-09-06 21:15:1110
     */
	  public function buyMsm($mobile, $orderid, $type=1){
		  msmSend($mobile, $orderid, $type);		  
	  }
	

}
