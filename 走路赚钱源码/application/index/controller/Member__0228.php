<?php
namespace app\index\controller;
use think\Url;
use think\Cache;
use think\Request;
use Endroid\QrCode\QrCode as EndroidQrCode;

class Member  extends Cmmcom
{
	//兑换码
	public function mycode(){
		
		$redeem = new \Org\service\RedeemService();
		//兑换码列表
		$where = array();
		$where['uid'] = \think\Session::get('CmmUser_.id');
		
		$list = $redeem->redeemList($where);
		
		//兑换记录
		$where['status'] = 2;
		$listlog = $redeem->redeemList($where, $order="endtime asc");
		
		$endtime = time() + (3*24*60*60);//3天
		$time = 0;
		
		foreach($listlog as $key=>$v){
			//最晚的结束时间
			if($v['status']=='2'){
				$endtime = min($endtime,$v['endtime']);
			}	
			//判断兑换码是否到期
			if($v['endtime']<time() && $v['status']=='2'){
				$data=array();
				$data['status'] = 0;//已到期
				$redeem->redeemUpdate(array('id'=>$v['id'], 'uid'=>$v['uid']), $data);
			}
			
		}
		if($endtime>time()){
			$time = $endtime - time();
		}
		
		//已完成兑换记录 已到期结束
		$where['status'] = 0;
		$endlog = $redeem->redeemList($where, $order="endtime asc");
		
		//dump($endtime);die;
		
		$this->assign('list',$list);//兑换码列表
		$this->assign('listlog',$listlog);//兑换记录
		$this->assign('endlog',$endlog);//已完成兑换记录
		$this->assign('endtime',$endtime);//最早时间
		$this->assign('time',$time);//时间
		return $this->fetch();
	}
	
	//兑换码兑换操作
	public function redeemCodeDooCmm(){
		
		if (request()->isAjax()){
			//强制要求完善个人资料
			$perfect = parent::perfectInfo();
			if(!$perfect){
				return json(['s'=>'请先完善个人资料再操作']);	
			}
			
			if(!is_numeric(input('post.cid'))){
				return json(['s'=>'参数错误！']);
			}
			
			if(!preg_match("/^\d*$/",input('post.cid'))){
				return json(['s'=>'参数错误！']);
			}
			
			if(input('post.op')!='588cmmphp'){
				return json(['s'=>'参数错误！']);
			}
			
			//查询			
			$redeem = new \Org\service\RedeemService();
			$where = array();
			
			$where['id'] = input('post.cid');
			$where['uid'] = \think\Session::get('CmmUser_.id');		
			$where['status'] = 1;
			
			$info = $redeem->redeemInfo($where, $field='id,term');
			if(!$info){
				return json(['s'=>'数据不存在！']);
			}
			
			$term = $info['term'];//期限
			
			$where2 = array();
			$where2['uid'] = \think\Session::get('CmmUser_.id');
			$where2['status'] = 2;//使用中
			
			$list = $redeem->redeemList($where2);
			$endtime = 0;
			foreach($list as $key=>$v){
				//最晚的结束时间
				$endtime = max($endtime,$v['endtime']);
			}

			//更新使用状态和使用日期
			$data = array();
			
			if($endtime>0){
				$day = $term*24*60*60;//天数
				
				$starttime = $endtime;
				$data['starttime'] = $starttime;//开始使用时间
				
				$endtime = $starttime+$day;
				$data['endtime'] = $endtime;//结束时间				
			}else{
				$data['starttime'] = time();//开始使用时间
				$endtime = 	strtotime("+".$term." days");
				$data['endtime'] = $endtime;//结束时间
			}
			
			$data['status'] = 2;//使用中
			
			$save = $redeem->redeemUpdate($where, $data);
			if(!$save){
				return json(['s'=>'兑换失败']);
			}
			
			return json(['s'=>'ok']);	
			
		}else{
			return json(['s'=>'非法请求']);	
		}
	}
	
	//团队
	public function myteam(){		
		$user = new \Org\service\UsersService();
		//团队人数
		$where = array();
		$where['refereeid'] = \think\Session::get('CmmUser_.id');
				
		//$teamCount = $user->userCount($where);
		
		//推荐人
		$where = array();
		$parent = \think\Session::get('CmmUser_.refereeid');
		if($parent){
			$where['id'] = $parent;
		}else{
			$where['id'] = 0;
		}
		
		$referee = '';
		$field = 'id,account,myphone,weixin,aiplay';	
		$referee = $user->userInfo($where, $field);
		if($referee){
			if(!$referee['account']){
				$referee['account'] = $referee['myphone'].'(该会员未完善资料)';
			}
		}
		
		//我的团队
		$where = array();
		$where['id'] = \think\Session::get('CmmUser_.id');
		$userInfo = $user->userInfo($where);
		$teamList = array();
		if($userInfo['team_str']){
			$team_str = explode('|',$userInfo['team_str']);
			for($i=0;$i<count($team_str);$i++){
				$teams = $user->userInfo('id="'.$team_str[$i].'"');
				if($teams){
					$teamList[] = $teams;
				}
			}
		}
		$teamCount = $userInfo['team_num'];
		
		
		$this->assign('teamCount',$teamCount);//团队人数
		$this->assign('referee',$referee);//推荐人
		$this->assign('teamList',$teamList);//我的团队
		return $this->fetch();
	}
	
	//会员转账
    public function mygiro()
    {	
        return $this->fetch();
    }
	
	//设置
    public function my_uset()
    {	
		$where = array();
		$where['id']  = \think\Session::get('CmmUser_.id');
		$filed = "account,myphone,money_wallet,reward_wallet,fry_data,ping_id,fullname,weixin,aiplay,eth_purse,refereeid,status,ore_wallet,release_wallet,rank" ;
		$user = new \Org\service\UsersService();
		$result = $user->userInfo($where,$filed);
		
		$this->assign('result',$result);//会员信息
        return $this->fetch();
    }
	
	//会员转账操作
	public function transfer_money_cmm(){
		if (request()->isAjax()){
			
			//强制要求完善个人资料
			$perfect = parent::perfectInfo();
			if(!$perfect){
				return json(['s'=>'请先完善个人资料再操作']);	
			}
			
			//判断会员是否设置安全密码		
			if(!input('post.username')){
				return json(['s'=>'请输入对方用户名！']);	
			}
			
			if(!input('post.number')){
				return json(['s'=>'请输入转账金额！']);	
			}
			
			if(!is_numeric(input('post.number'))){
				return json(['s'=>'转账金额必须是数字！']);
			}
			
			if(!preg_match("/^\d*$/",input('post.number'))){
				return json(['s'=>'转账金额必须是数字！']);
			}
			
			if(!input('post.password')){
				return json(['s'=>'请输入支付密码！']);	
			}
			
			if(strlen(input('post.password'))< 6){
				return json(['s'=>'支付密码长度不能小于6位数']);
			}
			
			$name = \think\Session::get('CmmUser_.account');
			if($name==input('post.username')){
				return json(['s'=>'不能自己给自己转账']);
			}

			//判断是否设置安全密码
			$where = array();
			$result = array();
			$where['id']  = \think\Session::get('CmmUser_.id');
			$where['safe_key']  = ['<>',0];
			$filed = "id,account,money_wallet,forepart_money" ;
			$user = new \Org\service\UsersService();
			$result = $user->userInfo($where,$filed);
			if(!$result){
				return json(['s'=>'请先设置支付密码！']);	
			}else{
				$u_money = 0;
				$forepart = 0;
				//判断安全密码是否正确
				$keys = $user->keyCheck();
				if(!$keys){
					return json(['s'=>'支付密码错误！']);
				}
				//判断会员是否存在
				unset($where);
				$where['id']  = ['>',0];
				$where['account']  = input('post.username');
				$sellUser = $user->userInfo($where,$filed);
				if(!$sellUser){
					return json(['s'=>'对方用户不存在！']);
				}
				
				//会员总金额 买家
				$u_money = $result['money_wallet'];
				$forepart = $result['forepart_money'];//开盘金额
				if($u_money<input('post.number') || !$u_money){
					return json(['s'=>'余额不足']);
				}				
				
				//会员设置数据
				$dayPer = 0;//日转账百分比
				
				$setInfo = array();
				$where = array();		
				$where['id'] = ['>',0];	
				$set = new \Org\service\UserSetService();
				
				$setInfo = $set->userSetInfo($where);
				$result = unserialize($setInfo['value']);
				foreach($result as $key=>$v){
					if($key=='SET_DAY_PER'){
						$dayPer = $v;
					}
				}
				
				//日最多交易金额 日转账百分比
				$money = input('post.number');
				//今日最早的交易金额【开盘金额】（在会员登陆时进行更新）
				$total = ($dayPer * $forepart)/100 ;//日可以交易的总金额
				$dayTatal = 0 ;//当前日交易总金额
				
				//查询会员交易日志记录 $dayTatal算的是自己只能买入总金额的10%
				$time = strtotime(date('Y-m-d',time()));
				$Trade = new \Org\service\TradeLogService();
				$where = array();
				$where['buy_uid'] = \think\Session::get('CmmUser_.id');//买方ID
				$where['addtime']  = ['>=',$time];
				$where['type']  = 0 ;
				
				$history = $Trade->tradelogList($where);
				foreach($history as $key=>$v){
					$dayTatal = $dayTatal+$v['num'];
				}
				
				$dayTatal = $dayTatal+$money ;			
						
				if($dayTatal>$total){
					//return json(['s'=>'日转账金额不得高于总金额的'.$dayPer.'%']);
					return json(['s'=>'您当天交易金额不得高于'.$total.'']);
				}
				
				$save = false;
				$addLog = false;
				
				//生成一个随机字符串
				$code = \think\Session::get('CmmRand_code');
				if(!$code){
					$rand = rand(100,999);
					$rand = md5(time().$rand);
					$code = $rand;
					\think\Session::set('CmmRand_code',$rand);			
				}

				//转账 鱼苗总额钱包			
				$filed = "money_wallet" ;				
				$where = array();
				$where['account']  = input('post.username');
				//自增 $type默认0,1表示自增+自减
				$save = $user->userSetInc($where, $filed, $money, $code, $type=1);			
				if($save){
					//最数据 买家
					$where = array();
					$buyNew = array();
					$where['id']  = \think\Session::get('CmmUser_.id');
					$filed = "id,account,money_wallet" ;
					$buyNew = $user->userInfo($where,$filed);
					//卖家
					$where['id']  = $sellUser['id'];
					$sellNew = $user->userInfo($where,$filed);
			
					//转账记录 交易记录 转账为买方，收款为卖方
					$data = array();
					$data['explain'] = '会员转账';//说明
					$data['type'] = 0;//分类，0转账，1买入，2卖出
					$data['num'] =  $money;//金额
					$data['sell_old'] =  $sellUser['money_wallet'] ;//卖家原金额
					$data['sell_new'] =  $sellNew['money_wallet'];//卖家现金额
					$data['buy_old'] =  $u_money ;//买家原金额
					$data['buy_new'] =  $buyNew['money_wallet'];//买家现金额
					$data['buy_uid'] =  \think\Session::get('CmmUser_.id');//买方
					$data['sell_uid'] =  $sellUser['id'];//卖方
					
					$addLog = $Trade->tradelogAdd($data);
				}else{
					return json(['s'=>'转账失败！']);
				}
				
				if($addLog){
					//销毁数据
					\think\Session::set('CmmRand_code','');
					return json(['s'=>'ok']);
				}else{
					return json(['s'=>'转账失败！']);	
				}
			}
		
		}else{
			return json(['s'=>'非法请求']);	
		}
	}
	
	//修改密码
    public function edit_mypaws()
    {	
		$style_op = 0;//已设置
		
		//判断是否设置安全密码
		$where = array();
		$result = array();
		$where['id']  = \think\Session::get('CmmUser_.id');
		$filed = "myphone,safe_key" ;
		$user = new \Org\service\UsersService();
		$result = $user->userInfo($where,$filed);
		if(!$result['safe_key']){
			$style_op = 1;//未设置
		}
		
		$this->assign('style_op',$style_op);//是否已设置安全密码
		return $this->fetch();
    }	
	
	//修改密码操作
    public function editPawsDoCmm()
    {	
		if (request()->isAjax()){
			
			if(!input('post.sms_code')){
				return json(['s'=>'请输入短信验证码！']);	
			}
			
			$reg_code = \think\Session::get('reg_code');
			
			if(!input('post.sms_code')){
				return json(['s'=>'请输入验证码！']);
			}
			
			if(!$reg_code || $reg_code!=intval(input('post.sms_code'))){
				return json(['s'=>'短信验证码错误']);
			}
			
			//判断手机号码
			$reg_mobile = \think\Session::get('reg_mobile');
			if(!$reg_mobile || $reg_mobile!=input('post.mobile')){
				return json(['s'=>'手机号码错误']);
			}
			
			$u_mobile = \think\Session::get('CmmUser_.myphone');	
			if($u_mobile!=$reg_mobile){
				return json(['s'=>'手机号码错误']);
			}
			
			if(input('post.old_password') && !input('post.new_password')){
				
				return json(['s'=>'请输入新登陆密码！']);	
			}
			
			if(input('post.old_password')){
				if(strlen(input('post.old_password'))< 6 || strlen(input('post.new_password')) < 6){
					return json(['s'=>'密码长度不能小于6位数']);
				}				
			}
			
			if(input('post.old_safepaws') && !input('post.yes_safepaws')){
				return json(['s'=>'请输入新支付密码！']);				
			}

			if(input('post.old_safepaws')){
				if(strlen(input('post.old_safepaws'))< 6 || strlen(input('post.yes_safepaws')) < 6){
					return json(['s'=>'支付密码长度不能小于6位数']);
				}				
			}
			
			$old_p = input('post.old_password');
			$old_s = input('post.old_safepaws');
			$user = new \Org\service\UsersService();
			
			//登陆密码
			if($old_p){
				if($old_p==input('post.new_password')){
					return json(['s'=>'登陆密码不能和原密码一致！']);	
				}
				//判断登陆密码是否正确				
				$keys = $user->keyCheck($tyle=1, $old_p);
				if(!$keys){
					return json(['s'=>'原登陆密码错误！']);
				}	
			}
			
			//安全密码
			if($old_s){
				$style_op = 0;//已设置
				//判断是否设置安全密码
				$where = array();
				$result = array();
				$where['id']  = \think\Session::get('CmmUser_.id');
				$filed = "myphone,safe_key" ;
				$result = $user->userInfo($where,$filed);
				if(!$result['safe_key']){
					$style_op = 1;//未设置
				}
		
				if($old_s==input('post.yes_safepaws') && !$style_op){
					return json(['s'=>'支付密码不能和原支付密码一致！']);	
				}
				
				if($style_op && $old_s!=input('post.yes_safepaws')){
					return json(['s'=>'两次输入支付密码不一致！']);
				}
				
				if(!$style_op){
					//判断安全密码是否正确
					$keys = $user->keyCheck($tyle=0, $old_s);
					if(!$keys){
						return json(['s'=>'原支付密码错误！']);
					}			
				}
			
			}
			
			if(!$old_p && !$old_s){
				return json(['s'=>'请输入需要设置的密码！']);
			}
			
			//修改密码			
			$data = array();
			$old_p && $data['paws']  = input('post.new_password');
			$old_s && $data['safe_p']  = input('post.yes_safepaws');
			
			$save = false;
			$save = $user->userPawsSave($data);
			if($save){
				return json(['s'=>'ok']);
			}else{
				return json(['s'=>'修改失败！']);
			}	
			
		}else{
			return json(['s'=>'非法请求']);	
		}
    }
	
	//编辑资料
    public function my_information()
    {	
		$where = array();
		$where['id']  = \think\Session::get('CmmUser_.id');
		$filed = "account,safe_key,myphone,money_wallet,reward_wallet,fry_data,ping_id,fullname,weixin,aiplay,eth_purse,refereeid,status,ore_wallet,release_wallet,rank" ;
		$user = new \Org\service\UsersService();
		$result = $user->userInfo($where,$filed);
		
		$pid = 0;
		if($result['refereeid']){
			$pid = number_encode($result['refereeid']);
		}	
		
		$this->assign('pid',$pid);
		$this->assign('result',$result);//会员信息
        return $this->fetch();
    }
	
	//编辑资料操作
    public function editInfoDoCmm()
    {	
		if (request()->isAjax()){
			
			$user = new \Org\service\UsersService();			
			$where = array();
			$id = \think\Session::get('CmmUser_.id');
			$where['id'] = $id;
			
			$info = $user->userInfo($where);

			if($info['weixin'] && input('post.weixin')!=$info['weixin']){
				return json(['s'=>'微信账号不能二次修改']);
			}
			if($info['aiplay'] && input('post.zhifubao')!=$info['aiplay']){
				return json(['s'=>'支付宝账号不能二次修改']);
			}
			
			if(!input('post.sms_code')){
				return json(['s'=>'请输入短信验证码！']);	
			}
			
			$reg_code = \think\Session::get('reg_code');
			
 			if(!input('post.sms_code')){
			return json(['s'=>'请输入验证码！']);
			}
			
			if(!$reg_code || $reg_code!=intval(input('post.sms_code'))){
				return json(['s'=>'短信验证码错误']);
			}
			
			//判断手机号码
			$reg_mobile = \think\Session::get('reg_mobile');
			if(!$reg_mobile || $reg_mobile!=input('post.mobile')){
				return json(['s'=>'手机号码错误']);
			}
			
			$u_mobile = \think\Session::get('CmmUser_.myphone');	
			if($u_mobile!=$reg_mobile){
				return json(['s'=>'手机号码错误']);
			} 
			
			if(!input('post.username')){
				return json(['s'=>'请输入用户名！']);	
			}
			
			$where = array();
			$id = \think\Session::get('CmmUser_.id');
			$where['id'] = ['<>',$id];
			$where['account'] = input('post.username');
			
			$info = $user->userInfo($where);
			if($info){
				return json(['s'=>'该用户名已存在']);
			}
			//判断支付宝是否重复
			$where = array();
			$id = \think\Session::get('CmmUser_.id');
			$where['id'] = ['<>',$id];
			$where['aiplay'] = input('post.zhifubao');
			
			$info = $user->userInfo($where);

			if($info){
				return json(['s'=>'支付宝已被其他账号绑定']);
			}	
			//判断微信是否重复
			$where = array();
			$id = \think\Session::get('CmmUser_.id');
			$where['id'] = ['<>',$id];
			$where['weixin'] = input('post.weixin');
			
			$info = $user->userInfo($where);

			if($info){
				return json(['s'=>'微信已被其他账号绑定']);
			}			
			
			$style_op = 0;//已设置
			//判断是否设置安全密码
			$where = array();
			$result = array();
			$where['id']  = \think\Session::get('CmmUser_.id');
			$filed = "myphone,safe_key" ;
			$result = $user->userInfo($where,$filed);
			if(!$result['safe_key']){
				$style_op = 1;//未设置
			}
				
			$data=array();
			
			if($style_op && !input('post.password')){
				return json(['s'=>'请设置支付密码！']);
			}
			
			if($style_op){
				
				if(strlen(input('post.password'))< 6 ){
					return json(['s'=>'支付密码长度不能小于6位数']);
				}
				$data['safe_key'] = input('post.password');//支付密码
			}
			
			
			$data['account'] = input('post.username');//账号
			$data['fullname'] = input('post.truename');//姓名
			$data['aiplay'] = input('post.zhifubao');//支付宝
			//$data['eth_purse'] = input('post.eth_url');//ETH钱包
			
			
			$save = false;
			$save = $user->homeUserUpdate($data, $op=1);
			
			if($save){
				return json(['s'=>'ok']);
			}else{
				return json(['s'=>'修改失败！']);
			}	
			
		}else{
			return json(['s'=>'非法请求']);	
		}
    }
	
	//我的矿机订单
	public function orelog(){
		
		//我的矿机订单
		$Korder = new \Org\service\KorderService();
		
		$where = 'a.uid='. \think\Session::get('CmmUser_.id');
		$field = 'a.*,b.name';
		$b_table = "kuang_shop b";
		$join = "a.kid = b.id";
		$orderList = $Korder->korderListJoin($where, $field, $b_table, $join);	
		//dump($orderList);die;
		
		$this->assign('orderList',$orderList);//订单列表
        return $this->fetch();		
	}

	//我的收益
	public function lucrelog(){
		
		$this->lucre_update();
		
		$log = new \Org\service\LucrelogService();
		
		$where = array();
		$where['uid'] =  \think\Session::get('CmmUser_.id');
		
		$profitList = $log->lucrelogList($where);	
		//dump($profitList);die;
		//print_r($profitList);die;
		$this->assign('profitList',$profitList);
        return $this->fetch();		
	}
	
	//每日释放记录
	public function releaselog(){
		
		//$this->lucre_update();
		
		$log = new \Org\service\ReleaseLogService();
		
		$where = array();
		$where['uid'] =  \think\Session::get('CmmUser_.id');
		$relList = $log->releaselogList($where);	
		//dump($relList);die;
		
		$this->assign('relList',$relList);
        return $this->fetch();		
	}
	
	//团队奖记录
	public function team_rreward_log(){
		
		//$this->lucre_update();
		
		$bonus = new \Org\service\BonusLogService();
		
		$where = array();
		$where['uid'] =  \think\Session::get('CmmUser_.id');
		$teamlog = $bonus->bonuslogList($where);	
		//dump($where['uid']);die;
		
		$this->assign('teamlog',$teamlog);
        return $this->fetch();		
	}
	
	//更新收益
	public function lucre_update(){
		//当天凌晨
		$time = strtotime(date('Y-m-d',time()));
		$user = new \Org\service\UsersService();
		$log = new \Org\service\LucrelogService();		
		$Korder = new \Org\service\KorderService();
		$where = array();
		$where['uid'] =  \think\Session::get('CmmUser_.id');
		$orderList = $Korder->korderList($where);	
		foreach($orderList as $key => $v){
			$otime = $time - strtotime(date('Y-m-d',$v['addtime'])) ;
			$days  = $otime / (24*60*60) ;
			
			$count = 0 ;
			$count = $log->lucrelogCount(array('orderid'=>$v['orderid']));
			
			if($count<$days){
				$money_coin = 0 ;
				$money_jz = 0 ;
				
				$money_coin = $v['day_gain'] ;
				$money_jz = $v['ore_coin'] ;
				
				$day_nume = $days;
				while($day_nume>0){
					
					//$result = $user->userInfo(array('id'=> \think\Session::get('CmmUser_.id')),$filed);
					
					$num = $day_nume - $count;
					$times = $num * 24 * 60 * 60;
					$ontime = $time - $times;
					if($num>=0){
						//添加收益
						//1购机币
						$data = array();
						$data['uid'] = \think\Session::get('CmmUser_.id');
						$data['orderid'] = $v['orderid'];
						$data['money'] = $money_coin;
						$data['type'] = 1;
						$data['days'] = $num;
						$data['addtime'] = $ontime;
						
						$log->lucrelogAdd($data);
						//2可售额度
						$data = array();
						$data['uid'] = \think\Session::get('CmmUser_.id');
						$data['orderid'] = $v['orderid'];
						$data['money'] = $money_jz;
						$data['type'] = 2;
						$data['days'] = $num;
						$data['addtime'] = $ontime;
						
						$log->lucrelogAdd($data);
						//加到钱包
						//$user->userSetInc(array('id'=>\think\Session::get('CmmUser_.id')), $field='ore_wallet', $money_jz);
						//加到钱包
						$user->userSetInc(array('id'=>\think\Session::get('CmmUser_.id')), $field='money_wallet', $money_coin);
						//$usable = $money_coin * \think\Session::get('CmmUser_.usable') /100;
						$usable = 0;
						//点击POW额度
						$save = $user->userSetInc(array('id'=>\think\Session::get('CmmUser_.id')), 'forepart_money', $usable);						
					}

					$day_nume = $day_nume-1;
				}

			}
			//dump(111);die;	
		}
	}
	
	
	//订单列表
    public function order_cmm_list()
    {	
		//买入订单
		$where = array();		
		$where['uid'] = \think\Session::get('CmmUser_.id');
		$where['status'] = ['<',4];
		$buy = new \Org\service\BuyOrderService();
		$market = new \Org\service\MarketService();	
			
		$buylog = $buy->buyList($where);
		foreach($buylog as $key=>$v){
			$buylog[$key]['m_st'] = '';
			if($v['status']==3 || $v['status']==1){
				//查询匹配状态
				$marketInfo = $market->marketInfo(array('buyid'=>$v['id']));
				if($marketInfo){
					$buylog[$key]['m_st'] = $marketInfo['status'];
				}else{
					$buylog[$key]['m_st'] = '110';
				}			
			}
			//dump($buylog[$key]['m_st']);
		}
		
		//卖出订单
		$sell = new \Org\service\SellOrderService();
		$selllog = $sell->sellList($where);
		foreach($selllog as $key=>$v){
			$selllog[$key]['m_st'] = '';
			if($v['status']==3|| $v['status']==1){
				//查询匹配状态
				$marketInfo = $market->marketInfo(array('sellid'=>$v['id']));
				if($marketInfo){
					$selllog[$key]['m_st'] = $marketInfo['status'];
				}else{
					$selllog[$key]['m_st'] = '110';
				}			
			}
		}
		$this->assign('selllog',$selllog);//卖出订单
		$this->assign('buylog',$buylog);//买入订单		
        return $this->fetch();
    }
	
	//推广
    public function propagating()
    {	
		Cache::clear();
		$path_pic = $this->ShareQrCode();
		//dump($path_pic);die;	
		
		$this->assign('path_pic',$path_pic);
        return $this->fetch();
    }
	
	// 分享图片[正经二维码]
    public function ShareQrCode(){
		
		// present=lU6UCC
		// game1.top/reg.html?present=lU6UCC
		$id = \think\Session::get('CmmUser_.id');
		$code = number_encode($id);//加密
		//二维码图片位置
		$dir = ROOT_PATH .'public/static/home/qrcode';
		$pic = strtolower($code);
		$file = '';
		$file = $dir.'/'.$pic.'.png';
		//最终图片地址
		$path_pic = '/static/home/qrcode/'.$pic.'_hb.png';	
		//dump($code);die;
		
		//判断图片是否存在
		//if(!file_exists($file)){
			$end_pic = $dir.'/'.$pic.'_hb.png';
			//注册地址URL present推荐人ID
			$url = 'http://'.$_SERVER['HTTP_HOST'].'/reg.html?present='.$code;	
			//处理需生成二维码的内容、参数和文字
			$size  = 200;//大小
			$qrCode = new EndroidQrCode();
			$qrCode->setText($url)
				->setSize($size)
				->setLabelFontPath(VENDOR_PATH.'endroid\qrcode\assets\noto_sans.otf')
				->setErrorCorrectionLevel('high')
				->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
				->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0));
			//添加文字	
			//$qrCode->setLabel($code)->setLabelFontSize(30);
			
			header('Content-Type: '.$qrCode->getContentType());
			//Directly output the QR code
			//$qrCode->writeString();
			// Save it to a file
			$qrCode->writeFile($file);
			//文字生成图片
			$this->CreateStr($code);
			$path_new = $dir.'/'.$pic.'haibao.png';
			//二维码和海报合成图片
			$this->CreateQrcode($file, $path_new);
			
			//文字图片地址
			$Strpath = ROOT_PATH.'public/static/home/qrcode/'.$pic.'code.png';
			//文字和海报合成图片
			$this->StrQrcode($path_new, $Strpath, $end_pic);			
		//}
		return $path_pic;
    }
	
	//文字生成图片
	public function CreateStr($code, $path_new=''){
		$pic = strtolower($code);
		
		$picurl = ROOT_PATH.'public/static/home/qrcode/'.$pic.'code.png';
		
		//生成验证码图片
		Header("Content-type: image/JPEG");
		//建立空白图片
		$im = imagecreate(320,80);
		// 白色背景和蓝色文本
		$black = ImageColorAllocate($im, 255,255,255); 
		//$bg = imagecolorallocate($im, 255, 255, 255);
		$textcolor = imagecolorallocate($im, 0, 122, 255);
		
		// 把字符串写在图像左上角
		$font_file = VENDOR_PATH.'endroid\qrcode\assets\AdobeGothicStd-Bold.otf';
		imagefttext($im,  40, 0, 30, 60, $textcolor, $font_file, $code);
		imagepng($im,$picurl);//根据需要生成相应的图片	
		ImageDestroy($im); 
	}
	
	//二维码和海报合成图片
	public function CreateQrcode($qrcode, $path_new){
		
		//海报地址
		$bigImgPath = ROOT_PATH.'public/static/images/haibao.png';
		//二维码地址
		$qCodePath = $qrcode;
		 
		$bigImg = imagecreatefromstring(file_get_contents($bigImgPath));
		$qCodeImg = imagecreatefromstring(file_get_contents($qCodePath));
		 
		list($qCodeWidth, $qCodeHight, $qCodeType) = getimagesize($qCodePath);
		imagecopymerge($bigImg, $qCodeImg, 270, 780, 0, 0, 220,280, 100);		 
		list($bigWidth, $bigHight, $bigType) = getimagesize($bigImgPath); 
		
		//图片新地址
		$merge = $path_new;
		imagejpeg($bigImg,$merge);		
	}
	
	//文字和海报合成图片
	public function StrQrcode($path_new, $Strpath, $path_pic){
		
		//海报地址
		$bigImgPath = $path_new;
		//文字地址
		$qCodePath = $Strpath;
		 
		$bigImg = imagecreatefromstring(file_get_contents($bigImgPath));
		$qCodeImg = imagecreatefromstring(file_get_contents($qCodePath));
		 
		list($qCodeWidth, $qCodeHight, $qCodeType) = getimagesize($qCodePath);
		imagecopymerge($bigImg, $qCodeImg, 205, 1000, 0, 0, 320,80, 100);		 
		list($bigWidth, $bigHight, $bigType) = getimagesize($bigImgPath); 
		
		//图片新地址
		$merge = $path_pic;
		imagejpeg($bigImg,$merge);		
	}

}
