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
use think\Controller;
use think\Url;
use think\Cache;
use think\Request;
//use Org\service\AdminbrotherService as AdminbrotherService;


class Index extends Controller
{
	
    public function index()
    {
        return $this->fetch();
    }
	
	//会员登陆
	public function login(){
		$request = Request::instance();
		
		if (request()->isAjax()){
			
			//账户验证
			if (!preg_match('/^[a-zA-Z0-9_]{3,16}$/u',input('request.username'))){
				return json(['s'=>'账户名必须是英文、数字或者下划线“_”']);	
			}
			//密码验证
			if (strlen(input('request.password'))<6 || strlen(input('request.password'))>18) {
				return json(['s'=>'请输入6位数以上18位数以下的密码']);	
			}
			//验证码验证
			if (!captcha_check(input('request.code'))){
				return json(['s'=>'请输入正确的验证码']);					
			}
			
			$Base = new \Org\service\BaseService();
			//地理位置信息获取
			$area = $Base->area();
			//自动验证IP(禁止IP)
	
			//账户验证
			$admin = new \Org\service\AdminbrotherService();
			$ruesult = $admin->adminLogin($area);
			
			return json(['s'=>$ruesult]);	
 		}else{	
			$operat = new \Org\service\OperatelogService();
			$operat->operatelogAdd($request->path(), $status=0, $name='非法请求');
			return json(['s'=>'非法请求']);
		} 
	}	
	
    /**
     * 退出登录
	 * 创建人 杨某
	 * 时间 2017-09-06 21:15:11
     */
	public function quit() 
	{
	    \think\Session::clear();
		//后台地址
		$adminurl = \think\Config::get('cmm_admin');
	    $this->redirect('/'.$adminurl);
	}
	
    /**
     * 管理界面
	 * 创建人 杨某
	 * 时间 2017-09-06 21:15:11
     */	
	public function main() 
	{
		new \app\admincmsby\controller\Cmmcom;
        //获取系统信息
        $systeminfo['THINK_VERSION'] = THINK_VERSION;
        $systeminfo['SERVER_SOFTWARE'] = $_SERVER["SERVER_SOFTWARE"];
        $systeminfo['PHP_OS'] = PHP_OS;
        $mysql=\think\Db::query("select version() AS version");
        $systeminfo['mysql']['version'] =$mysql[0]['version'];
		
	    $info = $systeminfo;
		
		//---------------------超时封号----------------------
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
		$market = new \Org\service\MarketService();
		$user = new \Org\service\UsersService();
		$buy = new \Org\service\BuyOrderService();
		$sell = new \Org\service\SellOrderService();
		
		$where = array();
		$where['id'] =['>',0];
		$where['status'] =['>',1];
		$marketList = $market->marketList($where);
		$buyType = 0;
		$sellType = 0;
		foreach($marketList as $key=>$v){
			if($pay_end>0 && $v['status']==2){
				$pay_end = $pay_end  *60 * 60 + $v['addtime'] ;
			}
			if($yes_end>0 && $v['status']==3){
				$yes_end = $yes_end  *60 * 60 + $v['paytime'];
			}	
			$save = 0;
			if($pay_end>100000 && $pay_end<time()){
				$buyType = 1;				
			}
			if($yes_end>100000 && $yes_end<time()){
				$sellType = 1;
			}
			//dump($sellType);die;
			if($buyType || $sellType){
				//冻结账号
				$data = array();
				$data['status'] = 0;//冻结
				$save = $market->marketUpdate(array('id'=>$v['id']), $data);
				$save = $buy->buyUpdate(array('id'=>$v['buyid']), $data);
				$save = $sell->sellUpdate(array('id'=>$v['sellid']), $data);
				if($buyType){
					$where = array();
					$where['id'] = $v['buyid'];
					
					$ures = $buy->buyInfo($where);
				}else{
					$where = array();
					$where['id'] = $v['sellid'];
					$ures = $sell->sellInfo($where);
				}
				$where = array();
				$where['id'] = $ures['uid'];
				$data = array();
				$data['status'] = 0;//冻结
				$user->userUpdate($where, $data);
				$buyType = 0;
				$sellType = 0;
			}
		}
		//-----------------------会员释放乐豆--------------------------

		
		$this->assign('info',$info);
	    return $this->fetch();
	}	
}
