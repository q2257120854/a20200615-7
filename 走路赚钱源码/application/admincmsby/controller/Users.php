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
use Org\service\RechargeLogService as RechLogService;
use Org\service\BonusLogService as BonusLogService;
use Org\service\UserSetService as UserSetService;
use Org\service\RedeemService as RedeemService;

class Users extends Cmmcom
{	
	
	//会员列表
    public function lists(){
		//权限验证
		parent::adminPower(55);
		$user_l = "active";
		$keyword = input('get.keyword');
		$status = input('get.status');
		
		if(!$keyword){
			$where['id'] = ['>',0];
		}else{
			$where['account'] = $keyword;
		}
		if($status){
			$where['status'] = $status-1;
		}
		$user = new UsersService();
		$list = $user->userPageList($where, $field='*');
		$volist = $list->toArray();
		foreach($volist['data'] as $key=>$v){
			$volist['data'][$key]['parent'] = '--';
			if($v['refereeid']){
				$info = $user->userInfo(array('id'=>$v['refereeid']),'account');
				if($info){
					$volist['data'][$key]['parent'] = $info['account'];
				}
			}
		}
		$time = strtotime(date('Y-m-d',time()));
		//会员总人数统计
		$userTotal = $user->userCount(array('id'=>['>',0]));
		//会员最新（今天）注册人数统计
		$newNum = $user->userCount(array('addtime'=>['>=',$time]));
		$this->assign('list',$list);//分页
		$this->assign('volist',$volist);
		$this->assign('keyword',$keyword);//关键词
		$this->assign('userTotal',$userTotal);//会员总人数统计
		$this->assign('newNum',$newNum);//会员最新（今天）注册人数统计
		$this->assign('user_l',$user_l);//导航高亮
        return $this->fetch();
    }



public function recharge_details(){
		//权限验证
		if($_POST){
			if($_POST['czsl']==''){
				echo('充值数量不能为空！');exit;
			}
			if($_POST['jymm']==''){
				echo('交易密码不能为空！');exit;
			}
			if($_POST['userid']==''){
				echo('用户信息不能为空！');exit;
			}
		$data['recharge_quantity'] = $_POST['czsl'];
		//$data['transaction_password'] = $_POST['jymm'];
		$data['addtime'] = time();
		$data['user_id'] = $_POST['userid'];
		$recharge_details_is=Db::name('recharge_details')->insert($data);
		if($recharge_details_is){
			echo "提交成功";
		}else{
			echo "提交失败！";
		}
		}else{ 
			//将所有提交的订单信息展示出来
			
			$volist=Db::name('recharge_details')->select();
			
			$this->assign('volist',$volist);
			return $this->fetch();
		}
    }

	public function recharge_details_edit(){
		//查询到这个订单
		$cmm_recharge_details=Db::table('cmm_recharge_details')->where('id',$_POST['id'])->find();

			$cmm_users=Db::table('cmm_users')->where('id',$cmm_recharge_details['user_id'])->setInc('usdt', $cmm_recharge_details['recharge_quantity']);

if($cmm_users){
	echo '充值成功，请刷新后重试！';
}else{
	echo '充值出错，请刷新后重试！';
}
	}
	
	
	
		public function recharge_details_del(){

$cmm_recharge_details=Db::table('cmm_recharge_details')->where('id',$_POST['id'])->setField('status', '0');
if($cmm_recharge_details){
	echo '删除成功，请刷新后重试！';
}else{
	echo '删除出错，请刷新后重试！';
}

	}
	
	
	//提现
	public function tixian_details(){
		//权限验证
		if($_POST){
			if($_POST['txsl']==''){
				echo('提现数量不能为空！');exit;
			}
			if($_POST['qbdz']==''){
				echo('钱包地址不能为空！');exit;
			}
			if($_POST['jymm']==''){
				echo('交易密码不能为空！');exit;
			}
			if($_POST['pz']==''){
				echo('凭证上传失败！');exit;
			}
			if($_POST['userid']==''){
				echo('用户信息不能为空！');exit;
			}
		$data['recharge_quantity'] = $_POST['txsl'];
		$data['wallet_address'] = $_POST['qbdz'];
		$data['addtime'] = time();
		$data['image_url'] = $_POST['pz'];
		$data['user_id'] = $_POST['userid'];
		$tixian_details_is=Db::name('tixian_details')->insert($data);
		if($tixian_details_is){
			echo "提交成功";
		}else{
			echo "提交失败！";
		}
		}else{ 
			//将所有提交的订单信息展示出来
			
			$volist=Db::name('tixian_details')->select();
			
			$this->assign('volist',$volist);
			return $this->fetch();
		}
    }
	
	public function tixian_details_edit(){
		//查询到这个订单
		$cmm_tixian_details=Db::table('cmm_tixian_details')->where('id',$_POST['id'])->find();

		$cmm_users=Db::table('cmm_users')->where('id',$cmm_tixian_details['user_id'])->setDec('usdt', $cmm_tixian_details['recharge_quantity']);

		if($cmm_users){
			echo '提现成功，请刷新后重试！';
		}else{
			echo '提现出错，请刷新后重试！';
		}
	}
	
	
	
	public function tixian_details_del(){

		$cmm_tixian_details=Db::table('cmm_tixian_details')->where('id',$_POST['id'])->setField('status', '0');
		if($cmm_tixian_details){
			echo '删除成功，请刷新后重试！';
		}else{
			echo '删除出错，请刷新后重试！';
		}

	}
	
	
	

	//会员新增页面
	public function add(){
		//权限验证
		parent::adminPower(56);
		$user_l = "active";
	
		$this->assign('user_l',$user_l);//导航高亮
		return $this->fetch();
	}
	
	//添加会员处理
	public function add_do(){
		//权限验证
		parent::adminPower(56);
		$operat = new OperateService();
		if (request()->isAjax()){
				
			if(input('post.op')!='user/add_cmmu'){
				//$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			if(!input('post.account') || !input('post.password')){
				return json(['s'=>'必填项不能为空']);	
			}
			$phone = input('post.myphone');
			if($phone && strlen($phone) > 11){
				return json(['s'=>'手机格式错误']);
			}
			$user = new UsersService();
			
			$where = array();
			$where['account'] = input('post.account');
			
			$info = $user->userInfo($where);
			if($info){
				return json(['s'=>'账号已存在']);
			}
			if($phone){
				$info = array();
				unset($where);
				$where['myphone'] = input('post.myphone');
				$info = $user->userInfo($where);
				if($info){
					return json(['s'=>'手机号码已存在']);
				}				
			}
			$parent = array();
			if(input('post.groom')){
				$where = array();
				$where['account'] = input('post.groom');
				$parent = $user->userInfo($where);
				if(!$parent){
					$where = array();
					$where['myphone'] = input('post.groom');
					$parent = $user->userInfo($where);					
				}
				
				if(!$parent){
					return json(['s'=>'推荐人不存在']);
				}
			}
			$data = array();
			if($parent){
				$data['refereeid'] = $parent['id'];
			}	
			$data['rank'] = 1;
			$data['eth_purse'] =uniqid('0x').uniqid('av');
			$add = $user->userAdd($data);
			if($add){
				if($parent){
					parentAll($add, $parent['id']) ;
				}
				$operat->operatelogAdd(request()->path(), 1, '新增成功');
				return json(['s'=>'ok']);					
			}else{
				//$operat->operatelogAdd(request()->path(), 0, '新增失败');
				return json(['s'=>'新增失败']);	
			}
		}else{	
		
			//$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}
	}
	
	//会员修改页面
	public function edit(){
		//权限验证
		parent::adminPower(57);
		$user_l = "active";

		//信息
		$user = new UsersService();
		if(!input('get.id')){
			$this->error('参数错误');
		}
		$result = $user->userInfo(array('id'=>input('get.id')));

		//dump($attrid_list);die;
		
		$this->assign('result',$result);
		$this->assign('user_l',$user_l);//导航高亮
		return $this->fetch();
	}
	
		//会员修改页面

	
	//修改会员处理
	public function edit_do(){
		//权限验证
		parent::adminPower(57);
		$operat = new OperateService();
		if (request()->isAjax()){
				
			if(input('post.op')!='user/edit_cmmu'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			if(!input('post.account')){
				return json(['s'=>'必填项不能为空']);	
			}
			$phone = input('post.myphone');
			if($phone && strlen($phone) > 11){
				return json(['s'=>'手机格式错误']);
			}
			$user = new UsersService();
			
			$where = array();
			$where['id'] = ['<>',input('post.id')];
			$where['account'] = input('post.account');
			
			$info = $user->userInfo($where);
			if($info){
				return json(['s'=>'账号已存在']);
			}
			
			if($phone){
				$info = array();
				unset($where);
				$where['id'] = ['<>',input('post.id')];
				$where['myphone'] = input('post.myphone');
				$info = $user->userInfo($where);
				if($info){
					return json(['s'=>'手机号码已存在']);
				}				
			}
			unset($where);
			$where['id'] = input('post.id');
			
			$save = $user->userUpdate($where);
			if($save){
				$operat->operatelogAdd(request()->path(), 1, '修改成功');
				return json(['s'=>'ok']);					
			}else{
				$operat->operatelogAdd(request()->path(), 0, '修改失败');
				return json(['s'=>'修改失败']);	
			}
		}else{	
		
			$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}
	}
	
	//删除会员
	public function del(){
		//权限验证
		parent::adminPower(58);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='users/del_nucm'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$user = new UsersService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $user->userInfo($where);
			if(!$info){
				$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $user->userDel($where);
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
	//批量删除会员
	public function delmost(){
		//权限验证
		parent::adminPower(58);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='users/DelAll_nucm'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.delid');
			if(!$id){
				return json(['s'=>'请选择删除的数据']);
			}
			$user = new UsersService();
			//删除数据
			$del = $user->userDelMost($id);
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
	
    /**
     *  会员充值
	 * 修改人 杨某
	 * 时间 2017-09-14 21:39:01
     */	
	public function give_gift(){
		parent::adminPower(76);
		$gift_l = 'active';
		
		$this->assign('gift_l',$gift_l);//导航高亮
		return $this->fetch();	
	}
	
    /**
     * 赠送钻箱
	 * 修改人 杨某
	 * 时间 2017-09-14 21:39:01
     */	
	public function give_gift_do(){
		//权限验证
		parent::adminPower(76);
		$operat = new OperateService();
		if (request()->isAjax()){
				
			if(input('post.op')!='user/gift_cmmu'){
				//$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			if(!input('post.account') || !input('post.grade')){
				return json(['s'=>'必填项不能为空']);	
			}

			$user = new UsersService();			
			$where = array();
			$where['account'] = input('post.account');
			
			$info = $user->userInfo($where);
			if(!$info){
				return json(['s'=>'账号不存在']);
			}
			//判断钻箱是否存在
			$ore = new \Org\service\OreService();
			$where = array();
			$where['grade'] = input('post.grade');			
			$oreInfo = $ore->oreInfo($where);
			if(!$info){
				return json(['s'=>'钻箱类型不存在']);
			}
			$orderM = new \Org\service\KorderService();
			$data=array();
					
			$data['uid'] = $info['id'];
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
					
				$rech_log = new RechLogService();
				
				//充值记录
				$data2 = array();
				$data2['users_id'] = $info['id'];
				$data2['explain'] = '赠送钻箱';
				$data2['type'] = input('post.grade') + 3;				
				$rech_log->RechLogAdd($data2);
				
				$operat->operatelogAdd(request()->path(), 1, '赠送成功');
				return json(['s'=>'ok']);					
			}else{
				$operat->operatelogAdd(request()->path(), 0, '赠送失败');
				return json(['s'=>'充值失败']);	
			}
		}else{	
		
			$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}
	}

    /**
     *  会员充值
	 * 修改人 杨某
	 * 时间 2017-09-14 21:39:01
     */	
	public function recharge(){
		parent::adminPower(60);
		$recharge_l = 'active';
		
		$this->assign('recharge_l',$recharge_l);//导航高亮
		return $this->fetch();	
	}
	
    /**
     *  会员充值处理
	 * 修改人 杨某
	 * 时间 2017-09-14 21:39:01
     */	
	public function recharge_do(){
		//权限验证
		parent::adminPower(60);
		$operat = new OperateService();
		if (request()->isAjax()){
				
			if(input('post.op')!='user/recharge_cmmu'){
				//$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			if(!input('post.account') || !input('post.type')){
				return json(['s'=>'必填项不能为空']);	
			}

			$user = new UsersService();
			
			$where = array();
			$where['account'] = input('post.account');
			
			$info = $user->userInfo($where);
			if(!$info){
				return json(['s'=>'账号不存在']);
			}
			$data = 0;
			$data = input('post.money_on');
			if(!is_numeric($data)){
				return json(['s'=>'充值金额必须是数字']);
			}
			$field = 0;
			if(input('post.type')==1){
				$field='money_wallet';
			}elseif(input('post.type')==2){
				$field='ore_wallet';
			}elseif(input('post.type')==3){
				$field='fry_data';
			}
			
			if(!$field){
				return json(['s'=>'参数错误']);	
			}
			
			
			$save = $user->userSetInc($where, $field, $data);
			if($save){
				
				if($field=='money_wallet'){
					$where = array();		
					$where['id'] = ['>',0];	
					$UserSet = new \Org\service\UserSetService();
					$setInfo = $UserSet->userSetInfo($where);
					$webInfo = unserialize($setInfo['value']);	
					$usable =0;
					foreach($webInfo as $key=>$v){
						if($key=='SET_usable'){
							$usable = $v;
						}
					}
			
					//POW额度增加
					$where = array();		
					$where['id'] = $info['id'];
					$field='forepart_money';
					$data = 0;
					$data = input('post.money_on') * $usable /100;
					$save = $user->userSetInc($where, $field, $data);
				}
				
				$rech_log = new RechLogService();
				
				/*---------------------------充值奖励------------------------*/
				
				//会员设置数据
				$task = 0;//兑换码任务金额
				$teamNum = 0;//直推团队任务【完成充值人数】
				$card_num = 0;//赠送兑换码数
				//$pay_num = 0;//团队奖 充值金额
				$reward = 0;//团队奖 领导奖励百分百
				$setInfo = array();
				$result = array();
				$where = array();						
				$where['id'] = ['>',0];
				$set = new UserSetService();
				$setInfo = $set->userSetInfo($where);
				$result = unserialize($setInfo['value']);
				foreach($result as $key=>$v){
					if($key=='SET_CODE_AMOUNT'){
						$task = $v;
					}
					if($key=='SET_CODE_TEAM'){
						$teamNum = $v;
					}
					if($key=='SET_CODE_NUM'){
						$card_num = $v;
					}
					if($key=='SET_PAY_AMOUNT'){
						$pay_num = $v;
					}
					if($key=='SET_REWARD_PER'){
						$reward = $v;
					}
				}
				
				$team_num = array();
				if($reward){
					$team_num = explode(',',$reward);
				}
				//dump($team_num);die;
				
				//统计充值金额（完成交易总金额）
				$sum  = $this->countTrade($info['id'], input('post.money_on'), $rech_log);
						
				if(!$sum){
					$sum = 0;
				}
				
				//后台设置
				$task = $task*100;
				$sum = $sum * 100;
				$num = $sum%$task ;//求余
				
				$nowTask = $num + input('post.money_on') * 100;
				$amount =  $nowTask/$task ;//本次任务次数 求整				
				$amount = intval($amount) ;
					//return json(['s'=>$amount]);
				if($amount>=1){
					//更新数据
					$user->userSetInc(array('id'=>$info['id']),  $field='num_task', $amount);
					//奖励兑换码 自动生成兑换码
					$this->giveCode($info['id'], $amount, $card_num);
				}
				////------------结束
				
				/*----------------------团队奖---------------*/
				/*if(input('post.money_on')>1){
					$this->parentTeam($info['refereeid'], input('post.money_on'), $team_num, $user);
				}*/
				
				////------------结束
				
				/*----------------------直推领导奖励兑换码---------------*/
				//直推会员	
				if(!$info['st_task'] && $info['refereeid']){
					$data = array();
					$data['st_task'] = 1;//充值后是否更新上级数据，0未更新，1已更新
					$user->userUpdate(array('id'=>$info['id']), $data);
					//上级会员信息
					$parent = $user->userInfo(array('id'=>$info['refereeid']));
					if($parent){
						if($parent['st_rec']){
							$count = $user->userCount(array('refereeid'=>$info['refereeid'], 'st_task'=>1));
							//完成任务下级人数
							if($count>$teamNum){
								//奖励兑换码 自动生成兑换码
								$this->giveCode($parent['id'], $card_num);
							}									
						}

					}
				}
				////------------结束
				
				//充值记录
				$data2 = array();
				$data2['users_id'] = $info['id'];
				$data2['explain'] = '充值';
				$data2['type'] = input('post.type');				
				$rech_log->RechLogAdd($data2);
				
				$operat->operatelogAdd(request()->path(), 1, '充值成功');
				return json(['s'=>'ok']);					
			}else{
				$operat->operatelogAdd(request()->path(), 0, '充值失败');
				return json(['s'=>'充值失败']);	
			}
		}else{	
		
			$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
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
				$user = new UsersService();
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
						$bonus = new BonusLogService();
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
	public function countTrade($uid=0, $money=0, $object='') 
	{
		if($uid && $money){
			
			if(!$object){
				$object = new RechLogService();
			}
			
			$where['users_id'] = $uid;
			$field = "num";
			
			$sum = $object->RechLogSum($where, $field);
			if(!$sum){
				$sum = 0;
			}
			
			$market = new \Org\service\MarketService();
			$buy = new \Org\service\BuyOrderService();
			
			$where = '';
			$where = 'a.status=1 and b.uid='.$uid;
			$field = "*";
			$b_table = $buy->buyDb().' b';
			$join = "a.buyid = b.id";
			$name = "a.price";//交易金额
			
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
			
			$redeem = new RedeemService();
					
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
	
	//充值日志
	public function recharge_log(){
		parent::adminPower(61);
		
		$rech_log = new RechLogService();
		$user = new UsersService();	
		
		$rec_log_l = 'active';
		$keyword = input('get.keyword');
		$pidStr = array();
		
		if($keyword){
			$member = $user->userInfo(array('account'=>$keyword));
			if($member){
				$pidStr['users_id'] = $member['id'];
			}else{
				$pidStr['users_id'] = $keyword;
			}
		}
				
		if(!$pidStr){
			$where['id'] = ['>',0];
		}else{
			$where = $pidStr;
		}

		$list = $rech_log->RechLogPageList($where, $field='*');
		$volist = $list->toArray();
		foreach($volist['data'] as $key=>$v){
			$volist['data'][$key]['username'] = '';
			
			$info = $user->userInfo(array('id'=>$v['users_id']));
			if($info){
				$volist['data'][$key]['username'] = $info['account'];
			}
		}
		
		$this->assign('list',$list);//分页
		$this->assign('volist',$volist);
		
		$this->assign('keyword',$keyword);//
		$this->assign('rec_log_l',$rec_log_l);//导航高亮
		return $this->fetch();	
	}
	
	//删除充值日志
	public function recharge_del(){
		//权限验证
		parent::adminPower(61);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='recharge/del_nucm'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$rech_log = new RechLogService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $rech_log->RechLogInfo($where);
			if(!$info){
				$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $rech_log->RechLogDel($where);
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
	//批量删除充值日志
	public function recharge_delmost(){
		//权限验证
		parent::adminPower(61);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='recharge/DelAll_nucm'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.delid');
			if(!$id){
				return json(['s'=>'请选择删除的数据']);
			}
			$rech_log = new RechLogService();
			//删除数据
			$del = $rech_log->RechLogDelMost($id);
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
	
	//会员设置
	public function set(){
		//权限验证
		parent::adminPower(59);
		$set_l = "active";
		$set = new UserSetService();
		
		$info = array();
		$where = array();		
		$where['id'] = ['>',0];	
		
		$info = $set->userSetInfo($where);
		$result = unserialize($info['value']);
		//dump($result);die;
		$this->assign('result',$result);
		$this->assign('set_l',$set_l);//导航高亮
		return $this->fetch();
	}
	
	//会员设置修改
	public function uset_edit(){
		//权限验证
		parent::adminPower(59);
		$operat = new OperateService();
		if (request()->isAjax()){
			
			
			if(input('post.op')!='userset/edit'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			
			$set = new UserSetService();
			
			$save = $set->userSetUpdate();
			if($save){
				$operat->operatelogAdd(request()->path(), 1, '修改成功');
				return json(['s'=>'ok']);					
			}else{
				$operat->operatelogAdd(request()->path(), 0, '修改失败');
				return json(['s'=>'修改失败']);	
			}		
		}else{	
		
			$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}
	}
	
	//奖金记录
	public function bonuslog(){
		//权限验证
		parent::adminPower(62);
		$bonus_l = "active";
		
		$bonus = new BonusLogService();
		$user = new UsersService();		
		
		$keyword = input('get.keyword');
		$pidStr = array();
		
		if($keyword){
			$member = $user->userInfo(array('account'=>$keyword));
			if($member){
				$pidStr['uid'] = $member['id'];
			}else{
				$pidStr['uid'] = $keyword;
			}
		}
				
		if(!$pidStr){
			$where['id'] = ['>',0];
		}else{
			$where = $pidStr;
		}
		
		$list = $bonus->bonuslogPageList($where, $field='*');
		$volist = $list->toArray();
		foreach($volist['data'] as $key=>$v){
			$volist['data'][$key]['username'] = '';
			
			$info = $user->userInfo(array('id'=>$v['uid']));
			if($info){
				$volist['data'][$key]['username'] = $info['account'];
			}
		}
		
		$this->assign('list',$list);//分页
		$this->assign('volist',$volist);		
		$this->assign('keyword',$keyword);
		$this->assign('bonus_l',$bonus_l);//导航高亮
		return $this->fetch();
	}
	
	//删除奖金日志
	public function bonus_del(){
		//权限验证
		parent::adminPower(62);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='bonus/del_nucm'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$bonus = new BonusLogService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $bonus->bonuslogInfo($where);
			if(!$info){
				$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $bonus->bonuslogDel($where);
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
	//批量删除奖金日志
	public function bonus_delmost(){
		//权限验证
		parent::adminPower(62);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='bonus/DelAll_nucm'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.delid');
			if(!$id){
				return json(['s'=>'请选择删除的数据']);
			}
			$bonus = new BonusLogService();
			//删除数据
			$del = $bonus->bonuslogDelMost($id);
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
	
	//释放日志
	public function release(){
		//权限验证
		parent::adminPower(77);
		$release_l = "active";
		
		$log = new \Org\service\ReleaseLogService();
		$user = new UsersService();		
		
		$keyword = input('get.keyword');
		$pidStr = array();
		
		if($keyword){
			$member = $user->userInfo(array('account'=>$keyword));
			if($member){
				$pidStr['uid'] = $member['id'];
			}else{
				$pidStr['uid'] = $keyword;
			}
		}
				
		if(!$pidStr){
			$where['id'] = ['>',0];
		}else{
			$where = $pidStr;
		}
		
		$list = $log->releaselogPageList($where, $field='*');
		$volist = $list->toArray();
		foreach($volist['data'] as $key=>$v){
			$volist['data'][$key]['username'] = '';
			
			$info = $user->userInfo(array('id'=>$v['uid']));
			if($info){
				$volist['data'][$key]['username'] = $info['account'];
			}
		}
		
		$this->assign('list',$list);//分页
		$this->assign('volist',$volist);		
		$this->assign('keyword',$keyword);
		$this->assign('release_l',$release_l);//导航高亮
		return $this->fetch();
	}
	
	//删除释放日志
	public function release_del(){
		//权限验证
		parent::adminPower(77);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='release/del_nucm'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$log = new \Org\service\ReleaseLogService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $log->releaselogInfo($where);
			if(!$info){
				$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $log->releaselogDel($where);
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
	//批量删除释放日志
	public function release_delmost(){
		//权限验证
		parent::adminPower(77);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='release/DelAll_nucm'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.delid');
			if(!$id){
				return json(['s'=>'请选择删除的数据']);
			}
			$log = new \Org\service\ReleaseLogService();
			//删除数据
			$del = $log->releaselogDelMost($id);
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
	
	//兑换码管理
	public function redeemcode(){
		//权限验证
		parent::adminPower(65);
		$code_l = "active";
		
		$redeem = new RedeemService();
		$user = new UsersService();		
		
		$keyword = input('get.keyword');
		$code = trimall(input('get.code'));
		$status = trimall(input('get.status'));
		$pidStr = array();
		
		if($keyword){
			$member = $user->userInfo(array('account'=>$keyword));
			if($member){
				$pidStr['uid'] = $member['id'];
			}else{
				$pidStr['uid'] = $keyword;
			}
		}
		
		if($code){
			$pidStr['code'] = $code;
		}
		
		if($status){
			$pidStr['status'] = $status-1;
		}
				
		if(!$pidStr){
			$where['id'] = ['>',0];
		}else{
			$where = $pidStr;
		}
		
		$list = $redeem->redeemPageList($where, $field='*');
		$volist = $list->toArray();
		foreach($volist['data'] as $key=>$v){
			$volist['data'][$key]['username'] = '';
			
			$info = $user->userInfo(array('id'=>$v['uid']));
			if($info){
				$volist['data'][$key]['username'] = $info['account'];
			}
			if($v['endtime']<time() && $v['status']=='2'){
				$data=array();
				$data['status'] = 0;//已到期
				$redeem->redeemUpdate(array('id'=>$v['id'], 'uid'=>$v['uid']), $data);				
			}
		}
		
		$this->assign('list',$list);//分页
		$this->assign('volist',$volist);		
		$this->assign('keyword',$keyword);
		$this->assign('code',$code);
		$this->assign('status',$status);
		$this->assign('code_l',$code_l);//导航高亮
		return $this->fetch();
	}
	
	//删除兑换码
	public function redeemcode_del(){
		//权限验证
		parent::adminPower(65);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='code/del_nucm'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$redeem = new RedeemService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $redeem->redeemInfo($where);
			if(!$info){
				$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $redeem->redeemDel($where);
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
	//批量删除兑换码
	public function redeemcode_delmost(){
		//权限验证
		parent::adminPower(65);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='code/DelAll_nucm'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.delid');
			if(!$id){
				return json(['s'=>'请选择删除的数据']);
			}
			$redeem = new RedeemService();
			//删除数据
			$del = $redeem->redeemDelMost($id);
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
	
	//生成兑换码
	public function makecode(){
		//权限验证
		parent::adminPower(66);
		$makec_l = "active";
		
		//dump($nub);die;
		$this->assign('makec_l',$makec_l);//导航高亮
		return $this->fetch();		
	}
	
	//生成兑换码操作
	public function makecode_do(){
		//权限验证
		parent::adminPower(66);
		$operat = new OperateService();
		if (request()->isAjax()){
			if(input('post.op')!='makecode/add_cmm'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			
			if(!input('post.account') || !input('post.number')){
				return json(['s'=>'必填项不能为空']);
			}
			
			if(!is_numeric(input('post.number'))){
				return json(['s'=>'数量必须是数字']);
			}
			
			if(input('post.term')){			
				if(!is_numeric(input('post.term'))){
					return json(['s'=>'使用期限必须是数字！']);
				}				
			}
			
			if(input('post.number')<1 || input('post.number')>50){
				return json(['s'=>'数量不能小于1或大于50']);
			}
			
			$user = new UsersService();
			$redeem = new RedeemService();
			
			//查询会员是否存在
			$info = $user->userInfo(array('account'=>input('post.account')));
			if(!$info){
				return json(['s'=>'会员不存在']);
			}
			
			$num = input('post.number');
			$k = 0;
			$rand = rand(100,999);
			$code = 0;
			
			for($i=0;$i<$num;$i++){
				//随机字符串
				$str = '';				
				$code = $rand;
				if($code==$rand){
					$rand = rand(100,999);
				}else{
					$code = rand(100,999);
				}
				if(!$code){
					return json(['s'=>'参数错误']);
				}
				$str = time().$code;	
				unset($code);
				if($str){
					$data = array();
					$data['uid'] = $info['id'];
					$data['code'] = number_encode($str, 16);
					$add = $redeem->redeemAdd($data);
					unset($str);
					if($add){
						$k++;
					}					
				}else{
					return json(['s'=>'参数错误']);
				}
			}
			
			if($k==$num){			
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
	

}
