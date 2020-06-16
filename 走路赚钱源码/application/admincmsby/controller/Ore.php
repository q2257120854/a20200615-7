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
use think\Request;
use Org\service\UsersService as UsersService;
use Org\service\OperatelogService as OperateService;
use Org\service\OreService as OreService;

class Ore extends Cmmcom
{	
	
	//钻箱列表
    public function lists(){
		
		//$name = $this->msmSend("15918525806", "B10001801");
		//权限验证
		parent::adminPower(71);
		$ore_l = "active";
		$ore = new OreService();	
		$status = input('get.status');
		//$keyword = input('get.keyword');
		$pidStr = array();
		
		if($status){
			$pidStr['status'] = $status - 1;
		}
				
		if(!$pidStr){
			$where['id'] = ['>',0];
		}else{
			$where = $pidStr;
		}
		
		$list = $ore->orePageList($where, $field='*');
		$volist = $list->toArray();
		
		$this->assign('list',$list);//分页
		$this->assign('volist',$volist);		
		$this->assign('status',$status);
		//$this->assign('keyword',$keyword);
		$this->assign('ore_l',$ore_l);//导航高亮
        return $this->fetch();
    }
	
	//钻箱新增页面
	public function add(){
		//权限验证
		parent::adminPower(72);
		$oreadd_l = "active";
	
		$this->assign('oreadd_l',$oreadd_l);//导航高亮
		return $this->fetch();
	}
	
	
	//添加钻箱处理
	public function add_do(){
		//权限验证
		parent::adminPower(72);
		$operat = new OperateService();
		if (request()->isAjax()){
				
			//return json(['s'=>input('post.')]);
			if(input('post.op')!='ore/add'){
				//$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			if(!input('post.name')){
				return json(['s'=>'必填项不能为空']);	
			}
			$ore = new OreService();
			$add = $ore->oreAdd();
			if($add){
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
	
	//钻箱修改页面
	public function edit(){
		//权限验证
		parent::adminPower(71);
		$ore_l = "active";

		$ore = new OreService();
		if(!input('get.id')){
			$this->error('参数错误');
		}
		$result = $ore->oreInfo(array('id'=>input('get.id')));

		//dump($attrid_list);die;
		
		$this->assign('result',$result);
		$this->assign('ore_l',$ore_l);//导航高亮
		return $this->fetch();
	}
	
	//修改钻箱处理
	public function edit_do(){
		//权限验证
		parent::adminPower(71);
		$operat = new OperateService();
		if (request()->isAjax()){
				
			if(input('post.op')!='ore/edit'){
				//$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			if(!input('post.name')){
				return json(['s'=>'必填项不能为空']);	
			}
			$ore = new OreService();
			$where['id'] = input('post.id');
			
			$save = $ore->oreUpdate($where);
			if($save){
				$operat->operatelogAdd(request()->path(), 1, '修改成功');
				return json(['s'=>'ok']);					
			}else{
				//$operat->operatelogAdd(request()->path(), 0, '修改失败');
				return json(['s'=>'修改失败']);	
			}
		}else{	
		
			//$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}
	}
	
	//删除
	public function del(){
		//权限验证
		parent::adminPower(71);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='ore/del'){
				//$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$ore = new OreService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $ore->oreInfo($where);
			if(!$info){
				//$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $ore->oreDel($where);
			if($del){
				
				$operat->operatelogAdd(request()->path(), 1, '删除成功');
				return json(['s'=>'ok']);					
			}else{
				//$operat->operatelogAdd(request()->path(), 0, '删除失败');
				return json(['s'=>'删除失败']);	
			}		
		}else{
			//$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}	
	}
	
	//批量删除
	public function delmost(){
		//权限验证
		parent::adminPower(71);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='ore/DelAll_nucm'){
				//$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.delid');
			if(!$id){
				return json(['s'=>'请选择删除的数据']);
			}
			$ore = new OreService();
			//删除数据
			$del = $ore->oreDelMost($id);
			if($del){			
				$operat->operatelogAdd(request()->path(), 1, '批量删除成功');
				return json(['s'=>'ok']);					
			}else{
				//$operat->operatelogAdd(request()->path(), 0, '批量删除失败');
				return json(['s'=>'删除失败']);	
			}		
		}else{
			//$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}		
	}
	
	//钻箱修改页面
	public function set(){
		//权限验证
		parent::adminPower(73);
		$ore_l = "active";

		$this->assign('ore_l',$ore_l);//导航高亮
		return $this->fetch();
	}
	
	//钻箱订单
    public function order(){
		
		//权限验证
		parent::adminPower(75);
		$oreo_l = "active";
		$ore = new OreService();
		$user = new UsersService();
		$Korder = new \Org\service\KorderService();
		$status = input('get.status');
		$keyword = input('get.keyword');
		$uphone = input('get.uphone');
		$type = input('get.type');
		$name = '';
		$oreOne = array();
		$pidStr = array();
		
		if($status){
			$pidStr['status'] = $status - 1;
		}
		
		if($uphone){
			$u_user = $user->userInfo(array('account'=>$uphone));
			if(!$u_user){
				$u_user = $user->userInfo(array('myphone'=>$uphone));
			}
			if($u_user){
				$pidStr['uid'] = $u_user['id'];
			}else{
				$pidStr['uid'] = 'kk';
			}
		}
		
		if($keyword){
			$pidStr['orderid'] = $keyword;
		}

		if($type==1){
			$name = '微型钻箱';
		}elseif($type==2){
			$name = '小型钻箱';
		}elseif($type==3){
			$name = '中型钻箱';
		}elseif($type==4){
			$name = '大型钻箱';
		}
		if($name){
			$oreOne = $ore->oreInfo(array('name'=>$name));
			if(!$oreOne){
				$oreOne = $ore->oreInfo(array('grade'=>$type));
			}	
			if($oreOne){
				$pidStr['kid'] = $oreOne['id'];
			}else{
				$pidStr['kid'] = 'kk';
			}
		}	
		
		if(!$pidStr){
			$where['id'] = ['>',0];
		}else{
			$where = $pidStr;
		}
		
		$list = $Korder->korderPageList($where, $field='*');
		$volist = $list->toArray();
		foreach($volist['data'] as $key => $v){
			//会员信息
			$member = $user->userInfo(array('id'=>$v['uid']));
			$volist['data'][$key]['user'] = $member['myphone'] ;
			//产品类型
			$oreInfo = $ore->oreInfo(array('id'=>$v['kid']));
			$volist['data'][$key]['name'] = $oreInfo['name'] ;
		}
		
		$this->assign('list',$list);//分页
		$this->assign('volist',$volist);		
		$this->assign('status',$status);
		$this->assign('keyword',$keyword);
		$this->assign('uphone',$uphone);
		$this->assign('type',$type);
		$this->assign('oreo_l',$oreo_l);//导航高亮
        return $this->fetch();
    }
	
	
	//删除
	public function order_del(){
		//权限验证
		parent::adminPower(75);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='ore/orderdel'){
				//$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$Korder = new \Org\service\KorderService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $Korder->korderInfo($where);
			if(!$info){
				//$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $Korder->korderDel($where);
			if($del){
				
				$operat->operatelogAdd(request()->path(), 1, '删除成功');
				return json(['s'=>'ok']);					
			}else{
				//$operat->operatelogAdd(request()->path(), 0, '删除失败');
				return json(['s'=>'删除失败']);	
			}		
		}else{
			//$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}	
	}
	
	//批量删除
	public function order_delmost(){
		//权限验证
		parent::adminPower(75);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='order/DelAll_nucm'){
				//$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.delid');
			if(!$id){
				return json(['s'=>'请选择删除的数据']);
			}
			$Korder = new \Org\service\KorderService();
			//删除数据
			$del = $Korder->korderDelMost($id);
			if($del){			
				$operat->operatelogAdd(request()->path(), 1, '批量删除成功');
				return json(['s'=>'ok']);					
			}else{
				//$operat->operatelogAdd(request()->path(), 0, '批量删除失败');
				return json(['s'=>'删除失败']);	
			}		
		}else{
			//$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}		
	}
	
	//收益记录
    public function profit(){
		
		//权限验证
		parent::adminPower(74);
		$orep_l = "active";
		$ore = new OreService();
		$user = new UsersService();
		$Korder = new \Org\service\KorderService();
		$log = new \Org\service\LucrelogService();
		$keyword = input('get.keyword');
		$uphone = input('get.uphone');
		$type = input('get.type');
		$tp = input('get.tp');
		$name = '';
		$oreOne = array();
		$pidStr = array();
		
		
		if($uphone){
			$u_user = $user->userInfo(array('account'=>$uphone));
			if(!$u_user){
				$u_user = $user->userInfo(array('myphone'=>$uphone));
			}
			if($u_user){
				$pidStr['uid'] = $u_user['id'];
			}else{
				$pidStr['uid'] = 'kk';
			}
		}
		
		if($keyword){
			$pidStr['orderid'] = $keyword;
		}

		if($tp){
			$pidStr['type'] = $tp;
		}
		
		if($type==1){
			$name = '微型钻箱';
		}elseif($type==2){
			$name = '小型钻箱';
		}elseif($type==3){
			$name = '中型钻箱';
		}elseif($type==4){
			$name = '大型钻箱';
		}
		if($name){
			$oreOne = $ore->oreInfo(array('name'=>$name));
			if(!$oreOne){
				$oreOne = $ore->oreInfo(array('grade'=>$type));
			}			
			if($oreOne){
				$kid = $oreOne['id'];
				$kf = $Korder->korderInfo(array('kid'=>$kid));
				if($kf){
					$pidStr['orderid'] = $kf['orderid'];
				}else{
					$pidStr['orderid'] = 'kk';
				}
				
			}else{
				$pidStr['orderid'] = 'kk';
			}
		}	
		
		if(!$pidStr){
			$where['id'] = ['>',0];
		}else{
			$where = $pidStr;
		}
		
		$list = $log->lucrelogPageList($where, $field='*');
		$volist = $list->toArray();
		foreach($volist['data'] as $key => $v){
			//会员信息
			$member = $user->userInfo(array('id'=>$v['uid']));
			$volist['data'][$key]['user'] = $member['myphone'] ;
			$volist['data'][$key]['name'] = '';
			//产品类型
			$korderInfo = $Korder->korderInfo(array('orderid'=>$v['orderid']));
			if($korderInfo){
				$oreInfo = $ore->oreInfo(array('id'=>$korderInfo['kid']));
				$volist['data'][$key]['name'] = $oreInfo['name'] ;				
			}
		}
		
		
		$this->assign('list',$list);//分页
		$this->assign('volist',$volist);
		$this->assign('keyword',$keyword);
		$this->assign('uphone',$uphone);
		$this->assign('type',$type);
		$this->assign('tp',$tp);
		$this->assign('orep_l',$orep_l);//导航高亮
        return $this->fetch();
    }
	
	//删除
	public function profit_del(){
		//权限验证
		parent::adminPower(74);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='ore/profitdel'){
				//$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$log = new \Org\service\LucrelogService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $log->lucrelogInfo($where);
			if(!$info){
				//$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $log->lucrelogDel($where);
			if($del){
				
				$operat->operatelogAdd(request()->path(), 1, '删除成功');
				return json(['s'=>'ok']);					
			}else{
				//$operat->operatelogAdd(request()->path(), 0, '删除失败');
				return json(['s'=>'删除失败']);	
			}		
		}else{
			//$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}	
	}
	
	//批量删除
	public function profit_delmost(){
		//权限验证
		parent::adminPower(74);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='profit/DelAll_nucm'){
				//$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.delid');
			if(!$id){
				return json(['s'=>'请选择删除的数据']);
			}
			$log = new \Org\service\LucrelogService();
			//删除数据
			$del = $log->lucrelogDelMost($id);
			if($del){			
				$operat->operatelogAdd(request()->path(), 1, '批量删除成功');
				return json(['s'=>'ok']);					
			}else{
				//$operat->operatelogAdd(request()->path(), 0, '批量删除失败');
				return json(['s'=>'删除失败']);	
			}		
		}else{
			//$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}		
	}
	
}
