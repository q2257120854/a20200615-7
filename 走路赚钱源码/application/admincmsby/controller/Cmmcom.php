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
use Org\service\BaseService;
use think\Config;
use think\Request;
use think\Session;


class Cmmcom extends Controller
{
	public $expire;//缓存时间
	
    public function _initialize()
    {
		//禁止IP
		$ban = $this->banIP();
		if(false==$ban){
			exit('网站禁止访问');
		}
		//判断是否登陆
		$this->checkAamin();
		$account = Session::get('CmmAdmin.account');
		$adminid = Session::get('CmmAdmin.id');
		//dump($adminid);die;
		$menu = $this->menu();



		
		$this->assign('menu',$menu);//菜单
		$this->assign('account',$account);
		$this->assign('adminid',$adminid);
		$this->assign('admin_l','');//导航高亮
		$this->assign('group_l','');//导航高亮
		$this->assign('power_l','');//导航高亮
		$this->assign('operate_l','');//导航高亮
		$this->assign('loginlog_l','');//导航高亮
		$this->assign('web_l','');//导航高亮
		$this->assign('trade_l','');//导航高亮
		$this->assign('backup_l','');//导航高亮
		$this->assign('restore_l','');//导航高亮
		$this->assign('code_l','');//导航高亮
		$this->assign('makec_l','');//导航高亮
		$this->assign('contact_l','');//导航高亮		
		$this->assign('msg_l','');//导航高亮
		$this->assign('notice_l','');//导航高亮		
		$this->assign('user_l','');//导航高亮
		$this->assign('recharge_l','');//导航高亮
		$this->assign('rec_log_l','');//导航高亮
		$this->assign('set_l','');//导航高亮
		$this->assign('bonus_l','');//导航高亮
		$this->assign('buyo_l','');//导航高亮
		$this->assign('sello_l','');//导航高亮
		$this->assign('market_l','');//导航高亮
		
		$this->assign('ad_l','');//导航高亮
		$this->assign('partner_l','');//导航高亮
		$this->assign('recruit_l','');//导航高亮
		
		$this->assign('ore_l','');//导航高亮
		$this->assign('oreadd_l','');//导航高亮
		$this->assign('oreset_l','');//导航高亮
		$this->assign('oreo_l','');//导航高亮
		$this->assign('orep_l','');//导航高亮
		$this->assign('gift_l','');//导航高亮
		
		$this->assign('release_l','');//导航高亮 
		

		//dump(\think\Session::get('CmmAdmin.account'));die;
    }
	
	//登录验证
	public function checkAamin(){
		
		$request= Request::instance();
		$action=$request->action();
		$controller = $request->controller();
		$module = $request->module();	
			
		$adminurl = Config::get('cmm_admin');
		//dump($module);die;
		//页面跳转
		$Org_check = new BaseService();
		$stats = $Org_check->checkAdminSession();
		if(false===$stats){
			$this->error('您还没有登录',url('/'.$adminurl));
		}	
	}
	
    /**
     *  一键清空缓存
	 * 修改人 杨某
	 * 时间 2017-09-14 21:39:01
     */	
	public function clearcache() 
	{
		//验证用户权限
        $request = Request::instance();
		if ($request->isAjax()){
			if (input('request.clear')=='ok'){
				//清楚缓存
				self::delAllDir();
				//加载网站设置
				//$set = new \app\data\service\system\SetService();
				//$list = $set->setListShow();
				return json(['s'=>'ok']);
			}else {
				return json(['s'=>'非法请求']);
			}
		}else{
			return json(['s'=>'非法请求']);
		}
		
	}
	
    /**
     *  删除所有Runtime文件
	 * 修改人 杨某
	 * 时间 2017-09-14 21:39:01
     */	
	public function delAllDir() 
	{
        $request = Request::instance();
		//清楚缓存
		\think\Cache::clear();
		$fileDel = ROOT_PATH.'runtime';
			
		if (!file_exists($fileDel)){
			$fileDel = ROOT_PATH.'runtime';
		}
					
		if (file_exists($fileDel)){
			$this->delDir($fileDel);
			/*$operat = new \Org\service\OperatelogService();
			$operat->operatelogAdd($request->path(), 1, '清空站点缓存');*/
			return json(['s'=>'ok']);
		}else{
			return json(['s'=>'缓存目录不存在']);
		}	return json(['s'=>'非法请求']);
	}

    /**
     *  删除文件
	 * 修改人 杨某
	 * 时间 2017-09-14 21:39:01
     */	
	public function delDir($dirName) 
	{
		 $dh = opendir($dirName);
		 
		 //循环读取文件
		 while ($file = readdir($dh)) 
		 {
			 if($file != '.' && $file != '..'){
				 $fullpath = $dirName . '/' . $file;
				 
				 if(!is_dir($fullpath)){					
					 //判断是否是日志文件,不删除日志文件
					 $path = pathinfo($fullpath,PATHINFO_EXTENSION);
					  if($path!='log'){
						  //dump($path);die;
						 //如果不是,删除该文件
						 if(!unlink($fullpath)){
							 echo $fullpath . '无法删除,可能是没有权限!<br>';
						 }
					  }
				 }else{
					 //如果是目录,递归本身删除下级目录
					 $this->delDir($fullpath);
				 }
			 }
		 }
		 //关闭目录
		 closedir($dh);
	}
	
	//无限循环分类
	public function classid($volist,$nan=0,$html='─',$level=0,$nbsp='&nbsp;&nbsp;&nbsp;') {
		$level2 = 0;
		if($level>1){
			$level2 = $level;
		}
		$arr=array();
		foreach($volist as $val) {
			if ($val['pid'] == $nan) {
				$val['classname'] = $val['classname'];
				//$val['html'] = str_repeat($html,$level);
				if($level){
					$val['html'] = $html;
				}else{
					$val['html'] = '';
				}
				if($level2){
					$val['nbsp'] =  str_repeat($nbsp,$level2);
				}else{
					$val['nbsp'] =  '';
				}
				
				$arr[] = $val;
				
				$arr = array_merge($arr,self::classid($volist,$val['id'],$html,$level+1));
			}
		}
		//dump($arr);die;
		return $arr;
	}
	
	//权限验证
	public function adminPower($id=0) {
		$power = Session::get('CmmAdmin.power');
		$data = explode(',',$power);	
		$result = false;
		
		foreach($data as $key=>$v){
			if($v==$id){
				$result = true;
			}
		}
		
		if(false==$result){
			//$this->error('您没有访问权限');
			echo "<script>alert('您没有访问权限');window.history.back(-1); </script>";exit();
		}
	}
	
	//导航菜单
	public function menu() {
		//权限列表
		$power = Session::get('CmmAdmin.power');
		$arr = explode(',',$power);
		//$powerid = array(2,9,15,19);
		$data2 = array(
			0=>array(
				'title'=>'管理员',
				'list'=>array()
			),
			1=>array(
				'title'=>'系统设置',
				'list'=>array()
			),
			2=>array(
				'title'=>'会员管理',
				'list'=>array()
			),
			5=>array(
				'title'=>'TMC商城',
				'list'=>array()
			),
			3=>array(
				'title'=>'交易管理',
				'list'=>array()
			),	
			4=>array(
				'title'=>'其他',
				'list'=>array()
			), 

		);		
		
		foreach($arr as $key=>$v){
			switch($v){
				case 2:
					$data2[0]['list'][] = array(			
							'url'=> url('adminbrother/lists'),
							'name' =>"管理员列表",
							'op'=>'admin'
					);			
				break;
				case 9:
					$data2[0]['list'][] = array(			
							'url'=> url('group/lists'),
							'name' =>"管理组",
							'op'=>'group'
					);			
				break;
				/*case 15:
					$data2[0]['list'][] = array(			
							'url'=> url('power/lists'),
							'name' =>"管理权限",
							'op'=>'power'
					);			
				break;
				/*case 24:
					$data2[1]['list'][] = array(			
							'url'=> url('system/web'),
							'name' =>"站点基础设置",
							'op'=>'web'
					);			
				break;*/
				case 25:
					$data2[1]['list'][] = array(			
							'url'=> url('system/loginlog'),
							'name' =>"登陆日志",
							'op'=>'loginlog'
					);			
				break;
				case 26:
					$data2[1]['list'][] = array(			
							'url'=> url('system/operatelog'),
							'name' =>"操作日志",
							'op'=>'operatelog'
					);			
				break;
				/*case 30:
					$data2[1]['list'][] = array(			
							'url'=> url('system/backup'),
							'name' =>"数据库备份",
							'op'=>'backup'
					);			
				break;
				/*case 31:
					$data2[1]['list'][] = array(			
							'url'=> url('system/restore'),
							'name' =>"数据库还原",
							'op'=>'restore'
					);			
				break;*/
				case 45:
					$data2[4]['list'][] = array(			
							'url'=> url('other/contact'),
							'name' =>"联系我们",
							'op'=>'contact'
					);			
				break;
				case 51:
					$data2[4]['list'][] = array(			
							'url'=> url('other/message'),
							'name' =>"留言信息",
							'op'=>'message'
					);			
				break;
				case 52:
					$data2[4]['list'][] = array(			
							'url'=> url('other/notice'),
							'name' =>"站内公告",
							'op'=>'notice'
					);			
				break;	
				case 55:
					$data2[2]['list'][] = array(			
							'url'=> url('users/lists'),
							'name' =>"会员列表",
							'op'=>'userlist'
					);			
				break;
				case 56:
					$data2[2]['list'][] = array(			
							'url'=> url('users/recharge_details'),
							'name' =>"充值详情",
							'op'=>'recharge_details'
					);			 
				break;
				case 57:
					$data2[2]['list'][] = array(			
							'url'=> url('users/tixian_details'),
							'name' =>"提现详情",
							'op'=>'tixian_details'
					);			 
				break;
				case 59:
					$data2[2]['list'][] = array(			
							'url'=> url('users/set'),
							'name' =>"交易设置",
							'op'=>'userset'
					);			
				break;	
				case 60:
					$data2[2]['list'][] = array(			
							'url'=> url('users/recharge'),
							'name' =>"会员充值",
							'op'=>'recharge'
					);			
				break;
				
				case 61:
					$data2[2]['list'][] = array(			
							'url'=> url('users/recharge_log'),
							'name' =>"赠送/充值记录",
							'op'=>'recharge_log'
					);			
				break;
				case 62:
					$data2[2]['list'][] = array(			
							'url'=> url('users/bonuslog'),
							'name' =>"奖金记录",
							'op'=>'bonuslog'
					);			
				break;
				case 77:
					$data2[2]['list'][] = array(			
							'url'=> url('users/release'),
							'name' =>"释放日志",
							'op'=>'release'
					);			
				break;
				case 65:
					$data2[2]['list'][] = array(			
							'url'=> url('users/redeemcode'),
							'name' =>"兑换码管理",
							'op'=>'redeemcode'
					);			
				break;
				case 66:
					$data2[2]['list'][] = array(			
							'url'=> url('users/makecode'),
							'name' =>"生成兑换码",
							'op'=>'makecode'
					);			
				break; 
				/*case 76:
					$data2[2]['list'][] = array(			
							'url'=> url('users/give_gift'),
							'name' =>"赠送钻箱",
							'op'=>'gift'
					);			
				break;*/
				
				case 64:
					$data2[3]['list'][] = array(			
							'url'=> url('trade/tradelog'),
							'name' =>"交易记录",
							'op'=>'tradelog'
					);			
				break;
				case 67:
					$data2[3]['list'][] = array(			
							'url'=> url('trade/buyorder'),
							'name' =>"买入订单",
							'op'=>'buyorder'
					);			
				break;
				case 68:
					$data2[3]['list'][] = array(			
							'url'=> url('trade/sellorder'),
							'name' =>"卖出订单",
							'op'=>'sellorder'
					);			
				break;
				case 69:
					$data2[3]['list'][] = array(			
							'url'=> url('trade/market'),
							'name' =>"交易市场",
							'op'=>'market'
					);			
				break;
				case 71:
					$data2[5]['list'][] = array(			
							'url'=> url('ore/lists'),
							'name' =>"乐豆产品",
							'op'=>'ore'
					);			
				break;
				/*case 72:
					$data2[5]['list'][] = array(			
							'url'=> url('ore/add'),
							'name' =>"添加产品",
							'op'=>'oreadd'
					);			
				break;
/* 				case 73:
					$data2[5]['list'][] = array(			
							'url'=> url('ore/set'),
							'name' =>"钻箱设置",
							'op'=>'oreset'
					);			
				break;	 */	
				/*case 75:
					$data2[5]['list'][] = array(			
							'url'=> url('ore/order'),
							'name' =>"产品订单",
							'op'=>'ore_o'
					);			
				break;			
				case 74:
					$data2[5]['list'][] = array(			
							'url'=> url('ore/profit'),
							'name' =>"收益记录",
							'op'=>'ore_p'
					);			
				break;*/
				
				
			}			
		}		
		//dump($data2);die;
		return $data2;	
	}
	
	//禁止IP
	public function banIP(){
		return true;	
	}	

	
}
