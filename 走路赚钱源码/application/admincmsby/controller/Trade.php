<?php
// +----------------------------------------------------------------------
// | CmmPHP [ 5G云资源网以Thinkphp框架进行独立开发 ]
// +----------------------------------------------------------------------
// | 5G云源码分享网 http://www.yunziyuan.com.cn// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 5G云源码分享网
// +----------------------------------------------------------------------
namespace app\admincmsby\controller;
use think\Url;
use think\Cache;
use think\Db;
use think\Request;
use Org\service\UsersService as UsersService;
use Org\service\OperatelogService as OperateService;
use Org\service\TradeLogService as TradeLogService;
use Org\service\BuyOrderService as BuyOrderService;
use Org\service\SellOrderService as SellOrderService;
use Org\service\MarketService as MarketService;

class Trade extends Cmmcom
{	
	
	//交易记录
    public function tradelog(){
		
		//$name = $this->msmSend("15918525806", "B10001801");
		//权限验证
		parent::adminPower(64);
		$trade_l = "active";
		$trade = new TradeLogService();
		$user = new UsersService();		
		
		$keyword = input('get.keyword');
		$orderid =  input('get.orderid');
		$pidStr = array();
		
		if($keyword){
			$member = $user->userInfo(array('account'=>$keyword));
			if($member){
				$pidStr['sell_uid|buy_uid'] = $member['id'];
			}else{
				$pidStr['sell_uid'] = $keyword;
			}
		}
		
		if($orderid){
			$pidStr['buy_orderid|sell_orderid'] = $orderid;
		}
				
		if(!$pidStr){
			$where['id'] = ['>',0];
		}else{
			$where = $pidStr;
		}
		
		$list = $trade->tradelogPageList($where, $field='*');
		$volist = $list->toArray();
		foreach($volist['data'] as $key=>$v){
			$volist['data'][$key]['sell_user'] = '--';
			$volist['data'][$key]['buy_user'] = '--';
			
			$info = $user->userInfo(array('id'=>$v['sell_uid']));
			$info2 = $user->userInfo(array('id'=>$v['buy_uid']));
			if($info || $info2){
				$info && $volist['data'][$key]['sell_user'] = $info['account'];
				$info2 && $volist['data'][$key]['buy_user'] = $info2['account'];
			}
		}
		
		$this->assign('list',$list);//分页
		$this->assign('volist',$volist);		
		$this->assign('keyword',$keyword);
		$this->assign('orderid',$orderid);
		$this->assign('trade_l',$trade_l);//导航高亮
        return $this->fetch();
    }
	
	//删除交易日志
	public function tradelog_del(){
		//权限验证
		parent::adminPower(64);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='trade/del_nucm'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$trade = new TradeLogService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $trade->tradelogInfo($where);
			if(!$info){
				$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $trade->tradelogDel($where);
			if($del){
				
				$operat->operatelogAdd(request()->path(), 1, '删除成功');
				return json(['s'=>'ok']);					
			}else{
				$operat->operatelogAdd(request()->path(), 0, '删除失败');
				return json(['s'=>'删除失败']);	
			}		
		}else{
			$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}	
	}
	//批量删除交易日志
	public function tradelog_delmost(){
		//权限验证
		parent::adminPower(64);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='trade/DelAll_nucm'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.delid');
			if(!$id){
				return json(['s'=>'请选择删除的数据']);
			}
			$trade = new TradeLogService();
			//删除数据
			$del = $trade->tradelogDelMost($id);
			if($del){			
				$operat->operatelogAdd(request()->path(), 1, '批量删除成功');
				return json(['s'=>'ok']);					
			}else{
				$operat->operatelogAdd(request()->path(), 0, '批量删除失败');
				return json(['s'=>'删除失败']);	
			}		
		}else{
			$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}		
	}
	

	//买入订单
    public function buyorder(){
		//权限验证
		parent::adminPower(67);
		$buyo_l = "active";
		$buy = new BuyOrderService();
		$user = new UsersService();	
		
		$keyword = input('get.keyword');
		$orderid = input('get.orderid');
		$status = input('get.status');
		$number = input('get.number');
		$style = input('get.style');
		$market_sellid = input('get.market_sellid');//匹配订单ID
		$pidStr = array();

		if($market_sellid){
			$pidStr['status'] = 2;
		}
		
		if($keyword){
			$member = $user->userInfo(array('account'=>$keyword));
			if($member){
				$pidStr['uid'] = $member['id'];
			}else{
				$pidStr['uid'] = $keyword;
			}
		}
		
		if($orderid){
			$pidStr['orderid'] = $orderid;
		}
		
		if($status){
			$pidStr['status'] = $status-1;
		}
		
		if($style){
			$pidStr['style'] = $style-1;
		}
				
		if(!$pidStr){
			$where['id'] = ['>',0];
		}else{
			$where = $pidStr;
		}
		
		//单数
		$orlistlist = $sum = Db::table("cmm_buyorder")->field('uid,COUNT(*) as num')->group('uid')->select();
		
		if($number){
			
			foreach($orlistlist as $key=>$v){
				$uidArray=array();
				if($number==1){
					if($v['num']==1){
						array_push($uidArray,$v['uid']);
					}
					
				}else if($number==2){
					if($v['num']==2){
						array_push($uidArray,$v['uid']);
					}
					
				}else if($number==3){
					if($v['num']==3){
						array_push($uidArray,$v['uid']);
					}
				}else if($number==4){
					if($v['num']>3){
						array_push($uidArray,$v['uid']);
					}
				}
				
			}
			
			$where['uid']=array('in',implode(",", $uidArray));
			
		}
		
		$list = $buy->buyPageList($where, $field='*');
		$volist = $list->toArray();
		foreach($volist['data'] as $key=>$v){
			$volist['data'][$key]['username'] = '';
			
			$info = $user->userInfo(array('id'=>$v['uid']));
			if($info){
				$st = '';
				if(!$info['status']){
					$st = '&nbsp;(<font style="color:red;">账号冻结</font>)';
				}
				$volist['data'][$key]['username'] = $info['account'].$st;
			}
		}
		
		
		$this->assign('list',$list);//分页
		$this->assign('volist',$volist);
		$this->assign('orderid',$orderid);
		$this->assign('status',$status);
		$this->assign('keyword',$keyword);
		$this->assign('sellid',$market_sellid);//匹配订单ID
		
		$this->assign('buyo_l',$buyo_l);//导航高亮
        return $this->fetch();
    }
	
	//删除买入订单
	public function buyorder_del(){
		//权限验证
		parent::adminPower(67);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='buyorder/del_nucm'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$buy = new BuyOrderService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $buy->buyInfo($where);
			if(!$info){
				$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $buy->buyDel($where);
			if($del){
				
				$operat->operatelogAdd(request()->path(), 1, '删除成功');
				return json(['s'=>'ok']);					
			}else{
				$operat->operatelogAdd(request()->path(), 0, '删除失败');
				return json(['s'=>'删除失败']);	
			}		
		}else{
			$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}	
	}
	//批量删除买入订单
	public function buyorder_delmost(){
		//权限验证
		parent::adminPower(67);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='buyorder/DelAll_nucm'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.delid');
			if(!$id){
				return json(['s'=>'请选择删除的数据']);
			}
			$buy = new BuyOrderService();
			//删除数据
			$del = $buy->buyDelMost($id);
			if($del){			
				$operat->operatelogAdd(request()->path(), 1, '批量删除成功');
				return json(['s'=>'ok']);					
			}else{
				$operat->operatelogAdd(request()->path(), 0, '批量删除失败');
				return json(['s'=>'删除失败']);	
			}		
		}else{
			$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}		
	}

	//卖出订单
    public function sellorder(){
		//权限验证
		parent::adminPower(68);
		$sello_l = "active";
		$sell = new SellOrderService();
		$user = new UsersService();	

		$keyword = input('get.keyword');
		$orderid = input('get.orderid');
		$status = input('get.status');
		$style = input('get.style');
		$market_buyid = input('get.market_buyid');//匹配订单ID
		$pidStr = array();

		if($market_buyid){
			$pidStr['status'] = 2;
		}
				
		if($keyword){
			$member = $user->userInfo(array('account'=>$keyword));
			if($member){
				$pidStr['uid'] = $member['id'];
			}else{
				$pidStr['uid'] = $keyword;
			}
		}
		
		if($orderid){
			$pidStr['orderid'] = $orderid;
		}
		
		if($status){
			$pidStr['status'] = $status-1;
		}
		
		if($style){
			$pidStr['style'] = $style-1;
		}
				
		if(!$pidStr){
			$where['id'] = ['>',0];
		}else{
			$where = $pidStr;
		}
		
		$list = $sell->sellPageList($where, $field='*');
		$volist = $list->toArray();
		foreach($volist['data'] as $key=>$v){
			$volist['data'][$key]['username'] = '';
			
			$info = $user->userInfo(array('id'=>$v['uid']));
			if($info){
				$st = '';
				if(!$info['status']){
					$st = '&nbsp;(<font style="color:red;">账号冻结</font>)';
				}
				$volist['data'][$key]['username'] = $info['account'];
			}
		}
		
		$this->assign('list',$list);//分页
		$this->assign('volist',$volist);		
		$this->assign('orderid',$orderid);
		$this->assign('status',$status);
		$this->assign('keyword',$keyword);
		$this->assign('buyid',$market_buyid);//匹配订单ID
		
		$this->assign('sello_l',$sello_l);//导航高亮
        return $this->fetch();
    }

	//删除卖出订单
	public function sellorder_del(){
		//权限验证
		parent::adminPower(68);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='sellorder/del_nucm'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$sell = new SellOrderService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $sell->sellInfo($where);
			if(!$info){
				$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $sell->sellDel($where);
			if($del){
				
				$operat->operatelogAdd(request()->path(), 1, '删除成功');
				return json(['s'=>'ok']);					
			}else{
				$operat->operatelogAdd(request()->path(), 0, '删除失败');
				return json(['s'=>'删除失败']);	
			}		
		}else{
			$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}	
	}
	//批量删除卖出订单
	public function sellorder_delmost(){
		//权限验证
		parent::adminPower(68);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='sellorder/DelAll_nucm'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.delid');
			if(!$id){
				return json(['s'=>'请选择删除的数据']);
			}
			$sell = new SellOrderService();
			//删除数据
			$del = $sell->sellDelMost($id);
			if($del){			
				$operat->operatelogAdd(request()->path(), 1, '批量删除成功');
				return json(['s'=>'ok']);					
			}else{
				$operat->operatelogAdd(request()->path(), 0, '批量删除失败');
				return json(['s'=>'删除失败']);	
			}		
		}else{
			$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}		
	}	

	//交易市场
    public function market(){
		//权限验证
		parent::adminPower(69);
		$market_l = "active";
		$market = new MarketService();
		$user = new UsersService();	
		$sell = new SellOrderService();
		$buy = new BuyOrderService();
		
		$keyword = input('get.keyword');
		$orderid = input('get.orderid');
		$status = input('get.status');
		$type = input('get.type');
		
		$key='buyid';
		$pidStr = array();
		
		
		if($keyword){
			$member = $user->userInfo(array('account'=>$keyword));
			$res = array();
			if($type=='2'){
				//卖家
				$res = $sell->sellList(array('uid'=>$member['id']));			
				$key='sellid';
			}else{
				//买家
				$res = $buy->buyList(array('uid'=>$member['id']));
				$key='buyid';
			}
						
			if($res){
				$value = '';
				foreach($res as $k=>$v){
					$value?$value .= ','.$v['id']:$value .= $v['id'];
				}
				$pidStr[$key] = ['in',$value];
				//dump($pidStr);die;
			}else{
				$pidStr[$key] = $keyword;
			}
		}
		
		if($orderid){
			$pidStr['orderid'] = $orderid;
		}
		
		if($status){
			$pidStr['status'] = $status-1;
		}
				
		if(!$pidStr){
			$where['id'] = ['>',0];
		}else{
			$where = $pidStr;
		}
		
		
		$list = $market->marketPageList($where, $field='*');
		$volist = $list->toArray();
		foreach($volist['data'] as $key=>$v){
			$volist['data'][$key]['buy_user'] = '';
			$volist['data'][$key]['sell_user'] = '';
			//买家信息
			$buy_info = $buy->buyInfo(array('id'=>$v['buyid']));
			if($buy_info){
				$u_buy = $user->userInfo(array('id'=>$buy_info['uid']));
				if($u_buy){
					$volist['data'][$key]['buy_user'] = $u_buy['account'];
				}				
			}
			//卖家信息
			$sell_info = $sell->sellInfo(array('id'=>$v['sellid']));
			if($sell_info){
				$u_sell = $user->userInfo(array('id'=>$sell_info['uid']));
				if($u_sell){
					$volist['data'][$key]['sell_user'] = $u_sell['account'];
				}				
			}
		}
		
		$this->assign('list',$list);//分页
		$this->assign('volist',$volist);		
		$this->assign('orderid',$orderid);
		$this->assign('status',$status);
		$this->assign('keyword',$keyword);
		$this->assign('type',$type);
	
		$this->assign('market_l',$market_l);//导航高亮
        return $this->fetch();
    }
	
	//删除匹配订单
	public function market_del(){
		//权限验证
		parent::adminPower(69);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='market/del_nucm'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$market = new MarketService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $market->marketInfo($where);
			if(!$info){
				$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $market->marketDel($where);
			if($del){
				
				$operat->operatelogAdd(request()->path(), 1, '删除成功');
				return json(['s'=>'ok']);					
			}else{
				$operat->operatelogAdd(request()->path(), 0, '删除失败');
				return json(['s'=>'删除失败']);	
			}		
		}else{
			$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}	
	}
	//批量删除匹配订单
	public function market_delmost(){
		//权限验证
		parent::adminPower(69);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='market/DelAll_nucm'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.delid');
			if(!$id){
				return json(['s'=>'请选择删除的数据']);
			}
			$market = new MarketService();
			//删除数据
			$del = $market->marketDelMost($id);
			if($del){			
				$operat->operatelogAdd(request()->path(), 1, '批量删除成功');
				return json(['s'=>'ok']);					
			}else{
				$operat->operatelogAdd(request()->path(), 0, '批量删除失败');
				return json(['s'=>'删除失败']);	
			}		
		}else{
			$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}		
	}
	
	
	//判断订单
	public function checked_order(){
		//权限验证
		parent::adminPower(69);
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='checked/order'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.id');

			if(!$id){
				return json(['s'=>'请选择要匹配的订单']);
			}
			
			if(input('post.type')=='sell'){
				$sell = new SellOrderService();
				$info = $sell->sellInfo(array('id'=>$id));
			}else{
				$buy = new BuyOrderService();
				$info = $buy->buyInfo(array('id'=>$id));
			}
			if(!$info){
				return json(['s'=>'订单不存在']);
			}
			
			if($info['status']!='2'){
				return json(['s'=>'订单状态非【等待中】，不能进行匹配']);
			}
			//判断会员状态
			$user = new UsersService();
			$member = $user->userInfo(array('id'=>$info['uid']));
			if(!$member){
				return json(['s'=>'该订单会员不存在']);
			}
			
			if($member['status']!='1'){
				return json(['s'=>'该订单会员账号已被冻结']);
			}
			
			return json(['s'=>'ok']);
			
		}else{
			return json(['s'=>'非法请求']);			
		}
	}

    /**
     * 订单匹配
	 * 创建人 杨某
	 * 时间 2017-09-06 21:15:1110
     */
	public function market_matching(){
		//权限验证
		parent::adminPower(69);
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='checked/order'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			if (!$arrid=explode(',',input('post.arrid',''))) {
				return json(['s'=>'请选中后再匹配']);
			}
			
			$user = new UsersService();
			$sell = new SellOrderService();
			$buy = new BuyOrderService();
			//乙方匹配总金额
			$Aamount = 0;
			$Anum = 0;//乙方下单数量
			//甲方匹配总金额
			$Bamount = 0;
			$Bnum = 0;//甲方下单数量
			//数量数组
			$arrNum = array();
			//总价数组
			$arrPrice = array();
			//甲乙属性
			//乙方
			$Atype = '';
			//甲方
			$Btype = '';
			
			foreach($arrid as $key=>$v){
				
				//判断会员状态
				if(input('post.type')=='sell'){
					$order = $buy->buyInfo(array('id'=>$v));
					//乙方
					$Atype = 'buyid';
					//甲方
					$Btype = 'sellid';
				}else{
					$order = $sell->sellInfo(array('id'=>$v));
					//乙方
					$Atype = 'sellid';
					//甲方
					$Btype = 'buyid';
				}
				//乙方匹配总金额
				$Aamount = $Aamount+$order['total_money'];
				//下单数量
				$Anum = $Anum+$order['amount'];
				
				if(!$order){
					return json(['s'=>'订单不存在']);
				}
				
				if($order['status']!='2'){
					return json(['s'=>$order['orderid'].'订单状态非【等待中】，不能进行匹配']);
				}
				$member = $user->userInfo(array('id'=>$order['uid']));	
				if(!$member){
					return json(['s'=>$order['orderid'].'订单会员不存在']);
				}
				
				if($member['status']!='1'){
					return json(['s'=>$order['orderid'].'订单会员账号已被冻结']);
				}
				//数量数组
				$arrNum[$key] = $order['amount'];
				//总价数组
				$arrPrice[$key] = $order['total_money'];
			}
			
			//甲方ID
			$id = input('post.id');			
			if(input('post.type')=='sell'){
				$info = $sell->sellInfo(array('id'=>$id));
			}else{				
				$info = $buy->buyInfo(array('id'=>$id));
			}
			if(!$info){
				return json(['s'=>'订单不存在']);
			}
			
			if($info['status']!='2'){
				return json(['s'=>$info['orderid'].'订单状态非【等待中】，不能进行匹配']);
			}
			//判断会员状态
			$member_2 = $user->userInfo(array('id'=>$info['uid']));
			if(!$member_2){
				return json(['s'=>'该订单会员不存在']);
			}
			
			if($member_2['status']!='1'){
				return json(['s'=>'该订单会员账号已被冻结']);
			}
			
			//验证匹配金额
			$Bamount = $info['total_money'];
			$Bnum = $info['amount'];//数量
			//变成两位数小数点数字
			$Aamount =  number_format($Aamount,2);
			$Bamount =  number_format($Bamount,2);
			
			if($Anum!=$Bnum){
				return json(['s'=>'匹配数量不对等']);
			}	
			
			if($Aamount!=$Bamount){
				return json(['s'=>'匹配金额不对等']);
			}
			
			//添加匹配数据
			$market = new MarketService();
			$k = 0;
			
			//判断是否已匹配
			$Bminfo = $market->marketInfo(array(''.$Btype.''=>input('post.id')));
			if($Bminfo){
				return json(['s'=>'订单ID【'.input('post.id').'】已匹配']);
			}		
			//甲方ID input('post.id')	
			foreach($arrid as $key=>$v){
				//判断是否已匹配
				$minfo = $market->marketInfo(array(''.$Atype.''=>$v));
				if($minfo){
					return json(['s'=>'订单ID【'.$v.'】已匹配']);
				}
				//甲方
				$data[$Btype] = input('post.id') ;
				//乙方
				$data[$Atype] = $v ;
				//数量
				$data['amount'] = $arrNum[$key] ;
				//价格
				$data['price'] =  $arrPrice[$key] ;
				
				$add = $market->marketAdd($data);
				if(!$add){
					return json(['s'=>'匹配失败']);
				}
				$orderid = '';
				$orderid = makeOrderSn($add, $no='M');
				//更新订单号
				$save = $market->marketUpdate(array('id'=>$add), array('orderid'=>$orderid));
				if(!$save){
					return json(['s'=>'匹配失败']);
				}
				
				//更新买卖双方订单状态
				$data2 = array();
				$data2['status'] = 3;
				$data2['matetime'] = time();
				if(input('post.type')=='buy'){
					$sell->sellUpdate(array('id'=>$v), $data2);	
				}else{
					$buy->buyUpdate(array('id'=>$v), $data2);
					//发送短信通知
					$this->buyMsm($v, $buy);					
				}	
				$k++;
			}
			
			//更新买卖双方订单状态
			$data3 = array();
			$data3['status'] = 3;
			$data3['matetime'] = time();
			
			if(input('post.type')=='buy'){
				$buy->buyUpdate(array('id'=>input('post.id')), $data3);
				//发送短信通知
				$this->buyMsm(input('post.id'), $buy);					
			}else{
				$sell->sellUpdate(array('id'=>input('post.id')), $data3);
			}
			
			if($k>0){
				return json(['s'=>'ok']);
			}else{
				return json(['s'=>'匹配失败']);
			}			
						
		}else{
			return json(['s'=>'非法请求']);			
		}
	}
	
    /**
     * 匹配成功，向买家发送短信
	 * 创建人 杨某
	 * 时间 2017-09-06 21:15:1110
     */
	  public function buyMsm($buyid, $object, $user=false, $type=1){
		  $orderid = 0 ;
		  $mobile = 0;
		  if($buyid){
			  $where = array();
			  $where['id'] = $buyid;
			  $buy = $object->buyInfo($where);
			  
			  if($buy){
				  $orderid = $buy['orderid'];
				  if(!$user){
					  $user = new UsersService();	
				  }
				  $where = array();
				  $where['id'] = $buy['uid'];
				  $member = $user->userInfo($where);
				  if($member){
					  $mobile = $member['myphone'] ;
				  }
				  msmSend($mobile, $orderid, $type);
			  }  
		  }		  
	  }
	  
    /**
     * 拆分订单
	 * 创建人 杨某
	 * 时间 2017-09-06 21:15:1110
     */
	public function splitOrder(){
		
		$order = array();
		$str = '{"0":"1","1":"2"}';
		$order = json_decode($str,true);
		//dump($order);die;
		
		if(input('get.type')){
			
			$user = new UsersService();
			$info = array();
			$where = array();
			$title = "";
			$usertitle = "";
			
			if(input('get.type')=="buy"){
				//权限验证
				parent::adminPower(67);	
				$buyo_l = "active";
				$title = "买入拆单";
				$usertitle = "买家账号";
				$buy = new BuyOrderService();
				$where['id'] = input('get.id');
				//数据是否存在
				$info = $buy->buyInfo($where);							
				if(!$info){
					exit("订单不存在");die;
				}
				
				if($info['status']!="2"){
					exit("该订单状态不能进行拆分操作");die;
				}
				$where = array();
				$where['id'] = $info['uid'];
				$member = $user->userInfo($where);
				$info['username'] = $member['account'] ;
				
					
				$this->assign('buyo_l',$buyo_l);//导航高亮			
			}
			
			if(input('get.type')=="sell"){
				//权限验证
				parent::adminPower(68);	
				$sello_l = "active";
				$title = "卖出拆单";
				$usertitle = "卖家账号";
				$sell = new SellOrderService();
				$where['id'] = input('get.id');
				//数据是否存在
				$info = $sell->sellInfo($where);	
				if(!$info){
					exit("订单不存在");die;
				}
				
				if($info['status']!="2"){
					exit("该订单状态不能进行拆分操作");die;
				}
				$where = array();
				$where['id'] = $info['uid'];
				$member = $user->userInfo($where);
				$info['username'] = $member['account'] ;
				
				
				$this->assign('sello_l',$sello_l);//导航高亮
			}
			
			
			$this->assign('type',input('get.type'));
			
			$this->assign('usertitle',$usertitle);
			$this->assign('title',$title);
			$this->assign('info',$info);
			return $this->fetch();			
		}else{
			exit("非法操作");die;
		}  
		  
	}

	/**
     * 拆分买入订单操作
	 * 创建人 杨某
	 * 时间 2017-09-06 21:15:1110
     */
	public function split_buy(){
		
		$operat = new OperateService();
		if (request()->isAjax()){
			if(input('post.op')!='split/buy_order'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}

			if(!input('post.id') || !input('post.split')){
				return json(['s'=>'必填项不能为空']);	
			}
			
			//订单信息
			$where = array();
			$buy = new BuyOrderService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $buy->buyInfo($where);			
			if(!$info){
				return json(['s'=>'订单不存在']);
			}
				
			if($info['status']!="2"){
				return json(['s'=>'该订单状态不能进行拆分操作']);
			}
			
			$amount = $info['amount'];//鱼苗数量
			$total = $info['total_money'];//总金额
			$price = $info['total_money']/$info['amount'] ;//单价
			//$orderid = $info['orderid'];//订单编号
			
			$num = 0;//拆分数量
			$order_str = array();
			$k = 0;
			//拆分方式
			if(input('post.split')=='1'){
				//等份拆分
				if(!is_numeric(input('post.order_num')) || !input('post.order_num')){
					return json(['s'=>'数量必须是数字且不能为空']);	
				}				
				if(input('post.order_num')<2){					
					return json(['s'=>'拆分的订单数量不能少于2']);	
				}			
				$num = input('post.order_num');
				if($amount%$num!=0){
					return json(['s'=>'订单无法平均拆分']);	
				}
				$amount = ceil($amount/$num);//平均数量
				$total_money = $amount * $price;//单笔订单价格
				
				if(($total_money*$num)!=$total){
					return json(['s'=>'金额错误']);
				}
				
				$count = $num - 1 ;
				
				for($i=0;$i<$count;$i++){
					
					$data = array();
					$data['amount'] = $amount;
					$data['total_money'] = $total_money;
					$data['price'] = $price;
					$data['style'] = $info['style'];
					$data['type'] = 1;//摘单，0不摘单，1摘单
					$data['uid'] = $info['uid'];
					
					$add = $buy->buyAdd($data);	
					
					$orderid = '';
					$orderid = makeOrderSn($add, $no='B');
						
					$buy->buyUpdate(array('id'=>$add), array('orderid'=>$orderid));
					$k++;
					
				}
				
				if($k){	
					//更新订单
					$data = array();
					$data['amount'] = $amount;
					$data['total_money'] = $total_money;
					$data['type'] = 1;//摘单，0不摘单，1摘单
					$buy->buyUpdate(array('id'=>$info['id']), $data);
				}	
				
			}	

			if(input('post.split')=='2'){
				//手动拆分
				$order_str = explode(',',input('post.order_str'));
				if(!$order_str){
					return json(['s'=>'必填项不能为空']);
				}				
				$num = count($order_str) ;				
				if($num<2){					
					return json(['s'=>'拆分的订单数量不能少于2']);	
				}	
				$count = $num - 1 ;
				$total_money = 0;//单笔订单价格
				$amount = 0;//总数量
				
				for($i=0;$i<$num;$i++){
					$total_money += $order_str[$i]* $price;
					$amount += $order_str[$i];
				}				
				
				if($amount!=$info['amount']){
					return json(['s'=>'拆分数量和原订单不相等']);
				}
				
				$total_num = 0;//要拆分的数量
				$total_money = 0;//金额
				$k = 0;
				
				for($i=0;$i<$count;$i++){
					
					$total_num += $order_str[$i];
					
					$total_money = $order_str[$i]* $price;
					
					$data = array();
					$data['amount'] = $order_str[$i];
					$data['total_money'] = $total_money;
					$data['price'] = $price;
					$data['style'] = $info['style'];
					$data['type'] = 1;//摘单，0不摘单，1摘单
					$data['uid'] = $info['uid'];
					
					$add = $buy->buyAdd($data);	
					
					$orderid = '';
					$orderid = makeOrderSn($add, $no='B');
						
					$buy->buyUpdate(array('id'=>$add), array('orderid'=>$orderid));
					$k++;
					
				}
				
				if($k){	
					
					$total_money = $order_str[$i]* $price;
					$amount = $info['amount'] - $total_num ;
					//更新订单
					$data = array();
					$data['amount'] = $amount;
					$data['total_money'] = $total_money;
					$data['type'] = 1;//摘单，0不摘单，1摘单
					$buy->buyUpdate(array('id'=>$info['id']), $data);
				}
			}
			
			if($k){			
				return json(['s'=>'ok']);
			}else{
				return json(['s'=>'拆分失败']);
			}	
			
		}else{	
			return json(['s'=>'非法请求']);			
		}
	}

	/**
     * 拆分卖出订单操作
	 * 创建人 杨某
	 * 时间 2017-09-06 21:15:1110
     */
	public function split_sell(){
		
		$operat = new OperateService();
		if (request()->isAjax()){
			if(input('post.op')!='split/sell_order'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}

			if(!input('post.id') || !input('post.split')){
				return json(['s'=>'必填项不能为空']);	
			}
			
			//订单信息
			$where = array();
			$sell = new SellOrderService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $sell->sellInfo($where);			
			if(!$info){
				return json(['s'=>'订单不存在']);
			}
				
			if($info['status']!="2"){
				return json(['s'=>'该订单状态不能进行拆分操作']);
			}
			
			$amount = $info['amount'];//鱼苗数量
			$total = $info['total_money'];//总金额
			$price = $info['total_money']/$info['amount'] ;//单价
			//$orderid = $info['orderid'];//订单编号
			
			$num = 0;//拆分数量
			$order_str = array();
			$k = 0;
			//拆分方式
			if(input('post.split')=='1'){
				//等份拆分
				if(!is_numeric(input('post.order_num')) || !input('post.order_num')){
					return json(['s'=>'数量必须是数字且不能为空']);	
				}				
				if(input('post.order_num')<2){					
					return json(['s'=>'拆分的订单数量不能少于2']);	
				}			
				$num = input('post.order_num');
				if($amount%$num!=0){
					return json(['s'=>'订单无法平均拆分']);	
				}
				$amount = ceil($amount/$num);//平均数量
				$total_money = $amount * $price;//单笔订单价格
				
				if(($total_money*$num)!=$total){
					return json(['s'=>'金额错误']);
				}
				
				$count = $num - 1 ;
				
				for($i=0;$i<$count;$i++){
					
					$data = array();
					$data['amount'] = $amount;
					$data['total_money'] = $total_money;
					$data['price'] = $price;
					$data['style'] = $info['style'];
					$data['type'] = 1;//摘单，0不摘单，1摘单
					$data['uid'] = $info['uid'];
					
					$add = $sell->sellAdd($data);	
					
					$orderid = '';
					$orderid = makeOrderSn($add, $no='S');
						
					$sell->sellUpdate(array('id'=>$add), array('orderid'=>$orderid));
					$k++;
					
				}
				
				if($k){	
					//更新订单
					$data = array();
					$data['amount'] = $amount;
					$data['total_money'] = $total_money;
					$data['type'] = 1;//摘单，0不摘单，1摘单
					$sell->sellUpdate(array('id'=>$info['id']), $data);
				}	
				
			}	

			if(input('post.split')=='2'){
				//手动拆分
				$order_str = explode(',',input('post.order_str'));
				if(!$order_str){
					return json(['s'=>'必填项不能为空']);
				}				
				$num = count($order_str) ;				
				if($num<2){					
					return json(['s'=>'拆分的订单数量不能少于2']);	
				}	
				$count = $num - 1 ;
				$total_money = 0;//单笔订单价格
				$amount = 0;//总数量
				
				for($i=0;$i<$num;$i++){
					$total_money += $order_str[$i]* $price;
					$amount += $order_str[$i];
				}				
				
				if($amount!=$info['amount']){
					return json(['s'=>'拆分数量和原订单不相等']);
				}
				
				$total_num = 0;//要拆分的数量
				$total_money = 0;//金额
				$k = 0;
				
				for($i=0;$i<$count;$i++){
					
					$total_num += $order_str[$i];
					
					$total_money = $order_str[$i]* $price;
					
					$data = array();
					$data['amount'] = $order_str[$i];
					$data['total_money'] = $total_money;
					$data['price'] = $price;
					$data['style'] = $info['style'];
					$data['type'] = 1;//摘单，0不摘单，1摘单
					$data['uid'] = $info['uid'];
					
					$add = $sell->sellAdd($data);	
					
					$orderid = '';
					$orderid = makeOrderSn($add, $no='S');
						
					$sell->sellUpdate(array('id'=>$add), array('orderid'=>$orderid));
					$k++;
					
				}
				
				if($k){	
					
					$total_money = $order_str[$i]* $price;
					$amount = $info['amount'] - $total_num ;
					//更新订单
					$data = array();
					$data['amount'] = $amount;
					$data['total_money'] = $total_money;
					$data['type'] = 1;//摘单，0不摘单，1摘单
					$sell->sellUpdate(array('id'=>$info['id']), $data);
				}
			}
			
			if($k){			
				return json(['s'=>'ok']);
			}else{
				return json(['s'=>'拆分失败']);
			}	
			
		}else{	
			return json(['s'=>'非法请求']);			
		}
	}
	
	
}
