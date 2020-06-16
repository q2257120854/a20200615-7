<?php
namespace app\index\controller;
use think\Url;
use think\Cache;
use think\Request;
use Org\service\NoticeService as NoticeService;
use Org\service\OreService as OreService;
use Org\service\UserSetService as UserSetService;

class Index  extends Cmmcom
{
	
    /**
     * 退出登录
	 * 创建人 杨某
	 * 时间 2017-09-06 21:15:11
     */
	public function quit() 
	{
		Cache::clear();
	    \think\Session::clear();
		\think\Session::set('CmmUser_.id','');
		\think\Session::set('CmmUser_.account','');
		\think\Session::set('CmmUser_.logintime','');
		$this->redirect('/login');
	}
	
	//首页
    public function index()
    {	

		//$sum  = $this->countTrade('11', '1000.00');
		//dump($sum);die;
		$user = new \Org\service\UsersService();
		//$this->shifang_shuibi($user);
		
		$where = array();
		$where['id']  = \think\Session::get('CmmUser_.id');
		$uid  = \think\Session::get('CmmUser_.id');
		$filed = "*" ;
		$result = $user->userInfo($where,$filed);
		
		//公告
		$notice = new NoticeService();
		$where = array();
		$where['id'] = ['>',0];
		$notice_list = $notice->noticeList($where); 

		//买入订单
		$where = array();		
		$where['id'] = ['>',0];
		$where['status'] = 2;
		$buy = new \Org\service\BuyOrderService();
			
		$buylog = $buy->buyList($where, $order="rand()");
		
		$b_sum = $buy->buySum($where,'amount');
		$this->assign('b_sum',$b_sum);//求购总量
		
		$sellwhere['uid'] = $uid;
		$sell = new \Org\service\SellOrderService();
		
		
		$sellsum = $sell->getMySellcount($sellwhere,'amount');
		
		$this->assign('sellsum',$sellsum);//卖出总量
		//dump($buylog);die;
/* 		//卖出订单
		$sell = new \Org\service\SellOrderService();
		$selllog = $sell->sellList($where); */
		
		//矿机商城列表
		$ore = new OreService();
		$where = array();
		$where['id'] = ['>',0];
		$oreList = $ore->oreList($where);
		
		//开采量总数
		$log = new \Org\service\LucrelogService();
		$where = array();
		$where['id'] = ['>',0];
		$where['type'] = 2;
		$JZ = $log->lucrelogSum($where, $field="money");
		$where['type'] = 1;
		$coin = $log->lucrelogSum($where, $field="money");
		
		$release_go = \think\Session::get('CmmUser_.release_go');
		$sf_money = $release_go * $result['release_wallet'] /100 ;
		
		$this->assign('buylog',$buylog);//买入订单
		$this->assign('sf_money',$sf_money);//释放数量
		$this->assign('oreList',$oreList);//矿机商城列表
		$this->assign('notice_list',$notice_list);//公告
		$this->assign('result',$result);//会员信息	
		$this->assign('JZ',$JZ);//可售额度	
		$this->assign('coin',$coin);//购机币
		
		return $this->fetch();
		
		//dump($buylog);die;
/* 		$this->assign('selllog',$selllog);//卖出订单
		$this->assign('buylog',$buylog);//买入订单 */

        
    }
	
	//释放
	public function shouyicaiji()
	{
		$user = new \Org\service\UsersService();
		
		$where = array();
		$where['id']  = \think\Session::get('CmmUser_.id');
		$where['status'] =1;
		$filed = "*" ;
		$result = $user->userInfo($where,$filed);
		//print_r($result);die;
		$release_go = \think\Session::get('CmmUser_.release_go');
		$sf_money = $release_go * $result['release_wallet'] /100 ;
/* 		//释放
		if($result && $release_go){
			//当天凌晨
			if($result['release_day']){
				$utime = $result['release_day'];
			}else{
				$utime = 0;
			}
			$time = (time() - $utime) / (24*60*60) ;
			if($time>=1 && $result['release_wallet']>0 && \think\Session::get('CmmUser_.release_go'))
			{
				return $this->fetch('/index/shouyicaiji');
				
			}else{
				return $this->fetch();
			}
		}else{
			return $this->fetch();
		} */
		$this->assign('sf_money',$sf_money);//释放数量
		$this->assign('result',$result);//会员信息	
		return $this->fetch();
	}
	
    /**
     * 会员释放购机币 
	 * 修改人 杨某
	 * 时间 2017-09-14 21:39:01
     */		
	public function shifang_shuibi(){
		
		if (request()->isAjax())
		{
			
			$user = new \Org\service\UsersService();
			$log = new \Org\service\ReleaseLogService();
			$where = array();
			$where['id'] = \think\Session::get('CmmUser_.id');
			$where['status'] =1;
			$userInfo = $user->userInfo($where);
			//print_r($userInfo);
			$release_go = \think\Session::get('CmmUser_.release_go');
			//echo '----------------------------';
			//print_r($release_go);die;
			if($userInfo && $release_go){
					
				//当天凌晨
				if($userInfo['release_day']){
					$utime = $userInfo['release_day'];
				}else{
					$utime = 0;
				}
				$time = (time() - $utime) / (24*60*60) ;
				
				if($time>=1)
				{
					
					if($userInfo['release_wallet']>0 && \think\Session::get('CmmUser_.release_go')){
						//只释放一次
						$aatime = strtotime(date('Y-m-d',time())) ;//当天凌晨
						$where = array();
						$where['uid'] = \think\Session::get('CmmUser_.id');
						//大于等于
						$where['addtime'] = ['egt',$aatime];
						//判断今天是否释放购机币
						$info = $log->releaselogInfo($where);
						if(!$info){
							$money = $release_go * $userInfo['release_wallet'] /100 ;
							$data = array();
							$data['uid'] = \think\Session::get('CmmUser_.id');
							$data['money'] = $money ;
							$data['addtime'] = time();
							$add = $log->releaselogAdd($data);
							if($add){
								//更新会员信息
								$where = array();
								$where['id'] = \think\Session::get('CmmUser_.id');
								$user->userUpdate($where, array('release_day'=>time()));
								//新增可售额度钱包
								$uid = \think\Session::get('CmmUser_.id') ;
								$user->userSetInc(array('id'=> $uid), $field='money_wallet', $money);
								$user->userSetDec(array('id'=> $uid), $field='release_wallet', $money);
								return json(['s'=>'ok']);
							}else{
								return json(['s'=>'领取失败']);
							}						
						}else{
							return json(['s'=>'你今天已领取']);
						}	
					}else{
						return json(['s'=>'参数错误']);
					}				
				}else{
					return json(['s'=>'未到领取时间']);
				}
			}else{
				return json(['s'=>'未到领取时间']);
			}
			
		}
	}
	
    /**
     * 购买矿机操作
	 * 修改人 杨某
	 * 时间 2017-09-14 21:39:01
     */	
	
	public function sellOrderDooCmm()
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
			
			$set = new UserSetService();
			$where['id'] = ['>',0];	
			$info = $set->userSetInfo($where);
			
			$result = unserialize($info['value']);
			
			
			$today = (date('Y-m-d', time()));
			
			$mo = date('Y-m-d',strtotime("$today +1 day"));
			
			$userselllist = $sell->sellList("uid=".$uid);
			
			$sellnull = 0;
			
			foreach($userselllist as $v){
				
				$selltime = date('Y-m-d',$v['addtime']);
				
				if($today <= $selltime && $selltime < $mo){
			
					$sellnull = $sellnull+1;
				}
			}
			
			if($result['SET_USERSELL_NUM'] <= $sellnull){
				return json(['s'=>'对不起，您已经超出当日出售上限！']);
			}

			
			
			if(input('post.op')!='588cmmphp' || !input('post.gid')){
				return json(['s'=>'参数错误！']);
			}
						
			$gid = intval(input('post.gid')) ;

			if(!is_numeric($gid) && $gid<=0){
				return json(['s'=>'参数错误！']);
			}
			//'.input('post.gid').'
			$buy = new \Org\service\BuyOrderService();
			$buyInfo = $buy->buyInfo('id='.input('post.gid').' AND status=2');
			if(!$buyInfo){
				return json(['s'=>'订单不存在']);
			}
			//判断是否是自己买自己的单
			if($uid==$buyInfo['uid']){
				return json(['s'=>'自己不能卖给自己可售额度']);
			}

			if($buyInfo['amount']<=0){
				return json(['s'=>'订单参数错误']);
			}
			
			//会员设置数据
			$price = 1;//鱼苗单价
			$status = 1;//判断交易市场是否开启
			$feiyong = 0;//手续费
			
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
				if($key=='SET_poundage'){
					$feiyong = $v;
				}
			}
			if(!$status){
				return json(['s'=>'交易市场暂时关闭，请留意网站公告！']);
			}

			$total = $price * intval($buyInfo['amount']);//总金额
			if($total<=0){
				return json(['s'=>'非法请求']);
			}
			
			$feiyong = $buyInfo['amount'] * $feiyong /100 ;
			$totalAll = $buyInfo['amount'] + $feiyong ;	
			//$totalAll = $buyInfo['amount'];
			$forepartmoney = $buyInfo['amount'];
			//判断会员账号余额是否足够
			$where = array();
			$where['id']  = $uid;
			$filed = "*" ;
			$user = new \Org\service\UsersService();
			$result = $user->userInfo($where,$filed);	
			if($result['ore_wallet']<$totalAll){
				return json(['s'=>'账号可售额度余额不足']);
			}
			if($result['status']!=1){
				return json(['s'=>'账号已冻结']);
			}
			//会员POW额度
			$umoney = $result['forepart_money'] + $result['fry_data'];
			if($umoney<$totalAll){
				return json(['s'=>'POW额度不足']);
			}	
			$Trade = new \Org\service\TradeLogService();
			
			//添加订单
			$data = array();
			$data['price'] = $price ;//卖出单价
			$data['total_money'] = $total ;//卖出总额
			$data['amount'] = $buyInfo['amount'] ;//卖出数量
			$data['style'] = 1;//交易类型，购买方式，0委托官方购买，1自助排单购买
			$data['feiyong'] = $feiyong ;//手续费
				
			$add = $sell->sellAdd($data);
			if($add){
				
				//生成订单号
				$orderid = makeOrderSn($add, $no='S');
				//更新订单编号
				$update = $sell->sellUpdate(array('id'=>$add), array('orderid'=>$orderid));
				
				//扣除POW额度							
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
					$save = $user->userSetDec($where, $filed, $forepartmoney);
				}else{
					$filed = "forepart_money" ;	
					$save = $user->userSetDec($where, $filed, $forepartmoney);
				}				
				
				$save2 = false ;
				//扣除可售额度总额  
				$filed = "ore_wallet" ;
				$save && $save2 = $user->userSetDec($where, $filed, $totalAll);
				
				//自动匹配订单
				$this->orderMatching($add, $buyInfo['id'], $price, $buyInfo['amount'], $type='sell', $user, $market, $buy, $sell);
				
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
			return json(['s'=>'非法操作！']);
		}
	}
	
    /**
     *  自动匹配订单
	 *  修改人 杨某
	 * 	$number 买入/卖出数量 $type配比的类型【买入或者卖出】 $price单价 $Aid甲方ID
	 * 时间 2017-09-14 21:39:01
     */		
	public function orderMatching($sellid=0,$buyid=0, $price=1, $number=0, $type='sell', $user='', $market='', $buy='', $sell=''){
		
		if(!$sellid || !$buyid){
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
		
		//卖出订单信息 甲方
		$sellInfo = $sell->sellInfo(array('id'=>$sellid));
		//买入订单信息 乙方
		$buyInfo = $buy->buyInfo(array('id'=>$buyid));	
		
		//判断是否已匹配
		$Bminfo = $market->marketInfo(array('buyid'=>$buyid));
		if($Bminfo){
			return false;
		}
			
		//进行匹配
		$data = array();
		//甲方
		$data['buyid'] = $buyid ;
		//乙方		
		$data['sellid'] = $sellid ;
		//数量
		$data['amount'] = $number ;
		//价格
		$data['price'] =  $price ;
		$data['status'] =  2 ;
				
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
     * 购买矿机操作
	 * 修改人 杨某
	 * 时间 2017-09-14 21:39:01
     */	
	public function buyShopOre() 
	{
		if (request()->isAjax()){
			//强制要求完善个人资料
			$perfect = parent::perfectInfo();
			if(!$perfect){
				return json(['s'=>'请先完善个人资料再操作']);	
			}
			if(input('post.op')!='588cmmphp' || !input('post.gid')){
				return json(['s'=>'参数错误！']);
			}
						
			$gid = intval(input('post.gid')) ;

			if(!is_numeric($gid) && $gid<=0){
				return json(['s'=>'参数错误！']);
			}

			if(!input('post.wallet')){
				return json(['s'=>'请选择支付钱包!']);
			}
			
			//查询商品信息
			$ore = new OreService();
			$where = array();
			$where['id'] = $gid;
			$oreInfo = $ore->oreInfo($where);
			
			$price = $oreInfo['price'];
				
			if(!$oreInfo){
				return json(['s'=>'矿机不存在']);
			}
			$orderM = new \Org\service\KorderService();
			//判断会员有多少该类矿机
			$where = array();
			$where['uid'] = \think\Session::get('CmmUser_.id');
			$where['kid'] = $gid;
			$where['endtime'] = ['>=',time()];
			$korderNum = $orderM->korderCount($where);
			
			//会员设置数据
			$kjMax = 1;//矿机台数
			$str = 'SET_kjnum_'.$oreInfo['grade'];
/* 			$buys_1 = 0;
			$buys_2 = 0;
			$buys_3 = 0;
			$coin_1 = 0;
			$coin_2 = 0;
			$parents_1 = 0;
			$parents_2 = 0; */
			
			$setInfo = array();
			$where = array();		
			$where['id'] = ['>',0];	
			$set = new \Org\service\UserSetService();
			
			$setInfo = $set->userSetInfo($where);
			$res = unserialize($setInfo['value']);
			foreach($res as $key=>$v){
				if($key==$str){
					$kjMax = $v;
				}
/* 				if($key=='SET_buys_1'){
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
				if($key=='SET_parents_1'){
					$parents_1 = $v;
				}
				if($key=='SET_parents_2'){
					$parents_2 = $v;
				} */				
			}
			
			if($korderNum>$kjMax){
				return json(['s'=>'该类型矿机每人购买不得超过'.$kjMax.'台']);
			}
			
			
			//判断会员账户余额
			$where = array();
			$where['id']  = \think\Session::get('CmmUser_.id');
			$filed = "id,account,myphone,money_wallet,reward_wallet,fry_data,ping_id,fullname,weixin,aiplay,eth_purse,refereeid,forepart_money,forepart_time,status,ore_wallet,rank" ;
			$user = new \Org\service\UsersService();
			$result = $user->userInfo($where,$filed);	
			//钱包余额
			if(input('post.wallet')==1){
				$wallet = $result['ore_wallet'];
				$wName = 'ore_wallet';//钱包类型
			}
			if(input('post.wallet')==2){
				$wallet = $result['money_wallet'];
				$wName = 'money_wallet';//钱包类型
			}
			
			if($wallet<$price){				
				return json(['s'=>'钱包余额不足']);
			}
			
			//扣除金额
			$save = $user->userSetDec($where, $wName, $price);	
			if($save){
				//生产订单
				
				$data=array();
				
				$data['uid'] = $result['id'];
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
					/*
					//判断会员等级
					if(!$result['rank']){
						//查找购买矿机的数量
						$where = array();
						$where['grade'] = 1;
						$oreInfo = $ore->oreInfo($where);
						$count = $orderM->korderCount(array('kid'=>$oreInfo['id'],'uid'=>$result['id']));
						if($count>$buys_1){
							$user->userUpdate(array('id'=>$result['id']), array('rank'=>1));
						}
					}elseif($result['rank']=='1'){
						//查找购买矿机的数量
						$where = array();
						$where['grade'] = 2;
						$oreInfo = $ore->oreInfo($where);
						$count = $orderM->korderCount(array('kid'=>$oreInfo['id'],'uid'=>$result['id']));
						if($count>$buys_2){
							$user->userUpdate(array('id'=>$result['id']), array('rank'=>2,'money_wallet'=>$coin_1));
						}
						
					}elseif($result['rank']=='2'){
						$where = array();
						$where['grade'] = 3;
						$oreInfo = $ore->oreInfo($where);
						$count = $orderM->korderCount(array('kid'=>$oreInfo['id'],'uid'=>$result['id']));
						if($count>$buys_3){
							$user->userUpdate(array('id'=>$result['id']), array('rank'=>3,'money_wallet'=>$coin_2));
							//直推人奖励
							if($result['refereeid']){
								$user->userUpdate(array('id'=>$result['refereeid']), array('rank'=>3,'money_wallet'=>$coin_2));
								if($parents_1){
									//赠送N台小型矿机
									$where = array();
									$where['grade'] = 2;
									$oreInfo = $ore->oreInfo($where);
									$parents_1 = $parents_1;
									while($parents_1>0){
										//生产订单									
										$data=array();
										
										$data['uid'] = $result['refereeid'];
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
								
								if($parents_2){
									//赠送N台中型矿机
									$where = array();
									$where['grade'] = 3;
									$oreInfo = $ore->oreInfo($where);
									$parents_2 = $parents_2;
									while($parents_2>0){
										//生产订单									
										$data=array();
										
										$data['uid'] = $result['refereeid'];
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
						}
					}*/
					if($update){
						return json(['s'=>'ok']);
					}else{
						return json(['s'=>'订单编号更新失败']);
					}
				}else{
					return json(['s'=>'购买失败']);
				}
			}
		
			
		}else{
			return json(['s'=>'参数错误']);
		}
		
	}
	
	//签到操作
	public function signInDoCmm() 
	{
		if (request()->isAjax()){
			
			//强制要求完善个人资料
			$perfect = parent::perfectInfo();
			if(!$perfect){
				return json(['s'=>'请先完善个人资料再操作']);	
			}
			
			if(input('post.op')!='588qiandao'){
				return json(['s'=>'参数错误']);	
			}
			
			$time = strtotime(date('Y-m-d',time()));
			$bonus = new \Org\service\BonusLogService();
			$where = array();
			$where['uid']  = \think\Session::get('CmmUser_.id');
			$where['addtime']  = ['>=',$time];
			$where['tyle']  = 0;
			
			$qiandao = $bonus->bonuslogInfo($where);

			if($qiandao){
				return json(['s'=>'你今天已经签到！']);
			}
			//会员设置数据
			$min_money = 0;//签到最低收益总金额
			$min_profit = 0;//签到最低收益 元
			$min_per = 0;//签到收益百分比
			$card_per = 0;//【收益加速卡+】 百分比
			
			$setInfo = array();
			$where = array();		
			$where['id'] = ['>',0];	
			$set = new \Org\service\UserSetService();
			
			$setInfo = $set->userSetInfo($where);
			$result = unserialize($setInfo['value']);
			foreach($result as $key=>$v){
				if($key=='SET_SING_AMOUNT'){
					$min_money = $v;
				}
				if($key=='SET_SING_PROFIT'){
					$min_profit = $v;
				}
				if($key=='SET_SING_PER'){
					$min_per = intval($v);
				}
				if($key=='SET_SING_CARD'){
					$card_per = intval($v);
				}
				
			}
						
			//判断是否有【收益加速卡+】						
			$redeem = new \Org\service\RedeemService();
			$time = time();
			$where2 = array();
			$where2['uid']  = \think\Session::get('CmmUser_.id');
			$where2['endtime']  = ['>',$time];
			$where2['status']  = 2;
			
			$code = $redeem->redeemInfo($where2);
			if($code){
				$min_per = $min_per + $card_per;
			}			
			
			$save = false;
			$addBonus = false;			
			$money = $min_money;
			$max_money = $min_profit;
			
			//会员信息		
			$where = array();
			$where['id']  = \think\Session::get('CmmUser_.id');
			$filed = "money_wallet" ;
			$user = new \Org\service\UsersService();
			$uInfo = $user->userInfo($where,$filed);
						
			if($uInfo['money_wallet']>=$min_money){
				$money = $uInfo['money_wallet'];
				$max_money = ($money * $min_per)/100 ;
			}
			//生成一个随机字符串
			$code = \think\Session::get('CmmRand_code');
			if(!$code){
				$rand = rand(10000,99999);
				$rand = md5(time().$rand);
				$code = $rand;
				\think\Session::set('CmmRand_code',$rand);			
			}		
			//奖励到 鱼苗总额钱包
			$filed = "money_wallet" ;
			$data = $max_money;
			//自增
			$save = $user->userSetInc($where, $filed, $data, $code);			
			if($save){
				//奖励记录
				$data = array();
				$data['explain'] = '签到奖励';//说明
				$data['num'] =  $max_money;//金额
				$bonus = new \Org\service\BonusLogService();
				$addBonus = $bonus->bonuslogAdd($data);
			}else{
				return json(['s'=>'签到失败！']);
			}
			
			if($addBonus){
				//销毁数据
				\think\Session::set('CmmRand_code','');
				return json(['s'=>'ok']);
			}else{
				return json(['s'=>'签到失败！']);	
			}
			 
		}else{
			return json(['s'=>'非法请求']);	
		}
	}
	
    /**
     *  打捞鱼苗
	 * 修改人 杨某
	 * 时间 2017-09-14 21:39:01
     */	
	public function FryDoCmm() 
	{
		if (request()->isAjax()){
			
/* 			//强制要求完善个人资料
			$perfect = parent::perfectInfo();
			if(!$perfect){
				return json(['s'=>'请先完善个人资料再操作']);	
			}
			
			if(input('post.op')!='588cmmphp'){
				return json(['s'=>'参数错误']);	
			}
			
			$time = strtotime(date('Y-m-d',time()));
			$bonus = new \Org\service\BonusLogService();
			$where = array();
			$where['uid']  = \think\Session::get('CmmUser_.id');
			$where['addtime']  = ['>=',$time];
			$where['tyle']  =1;
			
			$fish = $bonus->bonuslogInfo($where);

			if($fish){
				return json(['s'=>'你今天已打捞！']);
			}
			//会员设置数据
			$min_money = 0;//打捞鱼苗 最低收益总金额
			$min_profit = 0;//打捞鱼苗 最低收益 元
			$min_per = 0;//打捞鱼苗 收益百分比
			$card_per = 0;//【收益加速卡+】 百分比
			
			$setInfo = array();
			$where = array();		
			$where['id'] = ['>',0];	
			$set = new \Org\service\UserSetService();
			
			$setInfo = $set->userSetInfo($where);
			$result = unserialize($setInfo['value']);
			foreach($result as $key=>$v){
				if($key=='SET_FRY_AMOUNT'){
					$min_money = $v;
				}
				if($key=='SET_FRY_PROFIT'){
					$min_profit = $v;
				}
				if($key=='SET_FRY_PER'){
					$min_per = intval($v);
				}
				if($key=='SET_SING_CARD'){
					$card_per = intval($v);
				}
				
			}
						
			//判断是否有【收益加速卡+】						
			$redeem = new \Org\service\RedeemService();
			$time = time();
			$where2 = array();
			$where2['uid']  = \think\Session::get('CmmUser_.id');
			$where2['endtime']  = ['>',$time];
			$where2['status']  = 2;
			
			$code = $redeem->redeemInfo($where2);
			if($code){
				$min_per = $min_per + $card_per;
			}			
			
			$save = false;
			$addBonus = false;			
			$money = $min_money;
			$max_money = $min_profit;
			
			//会员信息		
			$where = array();
			$where['id']  = \think\Session::get('CmmUser_.id');
			$filed = "money_wallet" ;
			$user = new \Org\service\UsersService();
			$uInfo = $user->userInfo($where,$filed);
						
			if($uInfo['money_wallet']>=$min_money && $min_money>0){
				$money = $uInfo['money_wallet'];
				$max_money = ($money * $min_per)/100 ;
			}
			//生成一个随机字符串
			$code = \think\Session::get('CmmRand_code');
			if(!$code){
				$rand = rand(10000,99999);
				$rand = md5(time().$rand);
				$code = $rand;
				\think\Session::set('CmmRand_code',$rand);			
			}		
			//奖励到 鱼苗总额钱包
			$filed = "money_wallet" ;
			$data = $max_money;
			//自增
			$save = $user->userSetInc($where, $filed, $data, $code);			
			if($save){
				//奖励记录
				$data = array();
				$data['explain'] = '打捞购机币收益';//说明
				$data['num'] =  $max_money;//金额
				$data['tyle'] = 1;//1代表打捞鱼苗
				$bonus = new \Org\service\BonusLogService();
				$addBonus = $bonus->bonuslogAdd($data);
			}else{
				return json(['s'=>'打捞购机币失败！']);
			}
			
			if($addBonus){
				//销毁数据
				\think\Session::set('CmmRand_code','');
				return json(['s'=>'ok']);
			}else{
				return json(['s'=>'打捞购机币失败！']);	
			} */
			
		}else{
			return json(['s'=>'非法请求']);	
		}
	}
	
    /**
     *  删除所有cache缓存文件
	 * 修改人 杨某
	 * 时间 2017-09-14 21:39:01
     */	
	public function delAllCache() 
	{
		parent::delAllDir();
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
