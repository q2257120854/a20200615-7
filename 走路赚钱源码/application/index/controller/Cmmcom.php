<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Url;
use think\Config;
use think\Cache;
use think\Session;
use Org\service\BaseService;

class Cmmcom extends Controller
{
	//初始化
    public function _initialize()
    {	
		
		//dump(11);die;
		//站点设置
		$set = new \Org\service\SetService();
		$config = array();		
		$where = array();
		$where['id'] = ['>',0];
		$list = $set->setList($where);
		if($list){
			foreach($list as $key=>$v){
				if($v['name']==='WEB_DESCRIPTION' || $v['value']){
					$v['value'] = html_entity_decode($v['value']);
				}		
				if ($v['name']){
					$config[$v['name']] = $v['value'];
				}				
			}
		}
		if($config['WEN_CLOSE']=='1'){
			$close = $config['WEN_CLOSE_WHY'];
			if(!$close){
				$close = "网站维护中，请稍后再试.......";
			}
			exit($close);exit();
			
		}
		
		//判断会员是否可以登陆
		$LoginStatus = 1;
		$price = 1;//鱼苗单价		
		$dayPer = 0;//日交易百分比
		$start_close = 0;
		$end_close = 0;
		$end_close = 0;
		$usable = 0;//POW额度
		$release_go = 0;//每天释放购机币百分比
		
					$uGrade_1 = 0;
					$uGrade_2 = 0;
					$uGrade_3 = 0;
					$uReward_1 = 0;
					$uReward_2 = 0;
					$uReward_3 = 0;
		
		$UserSet = new \Org\service\UserSetService();
		$where = array();		
		$where['id'] = ['>',0];	
		$setInfo = $UserSet->userSetInfo($where);
		$webInfo = unserialize($setInfo['value']);
		foreach($webInfo as $key=>$v){
			if($key=='SET_CLOSE'){
				$LoginStatus = $v;
			}
			if($key=='SET_DAY_PER'){
				$dayPer = $v;
			}
			if($key=='SET_GOODS_PRICE'){
				$price = $v;
			}
			if($key=='SET_start_close'){
				$start_close = $v ;
			}
			if($key=='SET_start_open'){
				$end_close = $v;
			}
			if($key=='SET_usable'){
				$usable = $v;
			}
			if($key=='SET_release'){
				$release_go = $v;
			}
						
		}

		if(!$LoginStatus){
			$close = "系统维护中，暂时关闭会员登陆功能.......";
			exit($close);exit();
		}
		
		Session::set('CmmUser_.release_go',$release_go);
		Session::set('CmmUser_.usable',$usable);
		
		//当天凌晨
		$time = date('Y-m-d',time()) ;

		if(preg_match("/^[1-9][0-9]*$/",$start_close)){
			$start_close = $start_close.':00';
		}
		if(preg_match("/^[1-9][0-9]*$/",$end_close)){
			$end_close = $end_close.':00';
		}
		//dump($end_close);die;
		$start_close = strtotime($start_close);
		
		$end_close = strtotime($end_close) ;
		
		$nowtime = time();
		
		if($nowtime<=$end_close && $nowtime<=$start_close && $start_close>$end_close){
			$close = "网站每天".$webInfo['SET_start_close']."时至".$webInfo['SET_start_open']."时关闭访问，请稍过后再访问.......";
				exit($close);exit();
		}elseif($nowtime<=$end_close && $nowtime>=$start_close && $start_close<$end_close){
			$close = "网站每天".$webInfo['SET_start_close']."时至".$webInfo['SET_start_open']."时关闭访问，请稍过后再访问.......";
			exit($close);exit();		
		}
	
		//判断是否登陆
		$this->checkUser();
			
		$result = Session::get('CmmUser_');		
		
		if(!isset($result['id'])){
			$this->redirect('/login');
		}
		
					/* $log = new \Org\service\LucrelogService();
					$data = array();
					$data['uid'] = $result['id'];
					$data['explain'] = '注册送POW额度';
					$data['money'] = 100;
					$data['type'] = 3;
					$data['days'] = 0;
					$data['addtime'] = time();
					
					$log->lucrelogAdd($data); */
		
		$this->assign('price',$price);//鱼苗价格 单价
		$this->assign('result',$result);//会员信息
		$this->assign('config',$config);//站点设置
    }

	//登录验证
	public function checkUser(){
		
/* 		$request= Request::instance();
		$action=$request->action();
		$controller = $request->controller();
		$module = $request->module();	 */
		//页面跳转
		$Org_check = new BaseService();
		$stats = $Org_check->checkUserSession();
		
		if(false===$stats){
			$this->redirect('/login');
		}	
	}
	
	//强制要求完善资料
	public function perfectInfo(){
		$where = array();
		$where['id']  = Session::get('CmmUser_.id');
		$filed = "id,account,myphone,fullname,weixin,aiplay,eth_purse" ;
		$user = new \Org\service\UsersService();
		$result = $user->userInfo($where,$filed);
		if($result){
			if(!$result['account'] || !$result['fullname'] || !$result['myphone']){
				return false;
			}	
			if(!$result['weixin'] && !$result['aiplay']){
				return false;
			}
		}
		
		return true;
	}
	
    /**
     *  删除所有cache文件
	 * 修改人 杨某
	 * 时间 2017-09-14 21:39:01
     */	
	public function delAllDir() 
	{
		//清楚缓存
		\think\Cache::clear();
		$fileDel = ROOT_PATH.'runtime/cache';
			
		if (!file_exists($fileDel)){
			$fileDel = ROOT_PATH.'runtime/cache';
		}
					
		if (file_exists($fileDel)){
			$this->delDir($fileDel);
		}
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

	
}
