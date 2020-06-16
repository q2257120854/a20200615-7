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
use Org\service\PowerService as PowerService;
use Org\service\OperatelogService as OperateService;

class Power extends Cmmcom
{	
	//分类
	public function classpid(){
		$list = array();
		$where = array();
		$where['id'] = ['>',0];
		$power = new PowerService();	
		$list = $power->powerList($where);		
		foreach($list as $key=>$v){
			$list[$key]['classname'] = $v['name'];
		}			
		$class = parent::classid($list);
		return $class;
	}
	
	//管理权限列表
    public function lists(){
		//权限验证
		parent::adminPower(15);
		
		$power_l = "active";
		$list = array();
		$where = array();
		$power = new PowerService();
		$where['id'] = ['>',0];
		$list = $power->powerList($where);
		foreach($list as $key=>$v){
			$list[$key]['classname'] = $v['name'];
		}
		$list = parent::classid($list);
		//dump($list);die;
		$this->assign('list',$list);
		$this->assign('power_l',$power_l);//导航高亮
        return $this->fetch();
    }
	
	//修改页面
	public function edit(){
		//权限验证
		parent::adminPower(17);
		
		$power_l = "active";
		$id = input('post.id');
		$class = array();
		$where = array();
		$where['id'] = $id;
		$power = new PowerService();
		$result = $power->powerInfo($where);
		
		if($result['pid']!=0){
			$class = $this->classpid();			
		}
		return json(['s'=>$class,'v'=>$result]);
	}
	
	//更新数据
	public function edit_do(){
		//权限验证
		parent::adminPower(17);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='poweredit'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}	
			if(!input('post.name')){
				return json(['s'=>'必填参数不能为空']);	
			}
			$power = new PowerService();
			$where['name'] = input('post.name');
			$where['id'] = ['<>',input('post.id')];
			$count = $power->powerCount($where);			
			if($count){
				return json(['s'=>'权限名已存在']);				
			}			
			$where = array();
			$where['id'] = input('post.id');		
			$save = $power->powerUpdate($where);

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
	
	//新增页面
	public function add(){
		//权限验证
		parent::adminPower(16);
		
		$class = $this->classpid();
		return json(['s'=>$class]);
	}
	
	//新增数据
	public function add_do(){
		//权限验证
		parent::adminPower(16);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='poweradd'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			if(!input('post.name')){
				return json(['s'=>'必填参数不能为空']);	
			}
			$power = new PowerService();
			$where['name'] = input('post.name');
			$count = $power->powerCount($where);			
			if($count){
				return json(['s'=>'权限名已存在']);				
			}		
			$add = $power->powerAdd();
			if($add){
				$operat->operatelogAdd(request()->path(), 1, '新增成功');
				return json(['s'=>'ok']);					
			}else{
				$operat->operatelogAdd(request()->path(), 0, '新增失败');
				return json(['s'=>'新增失败']);	
			}
		}else{	

			$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}
	}
	
	//删除管理权限
	public function del(){
		//权限验证
		parent::adminPower(18);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='powerdel'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$power = new PowerService();			
			$where['id'] = ['>',0];
			$count = $power->powerCount($where);			
			if($count<2){
				return json(['s'=>'至少保留一个管理权限']);				
			}
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $power->powerInfo($where);
			if(!$info){
				$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $power->powerDel($where);
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
}
