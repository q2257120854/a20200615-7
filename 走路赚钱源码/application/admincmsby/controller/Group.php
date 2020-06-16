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
use Org\service\GroupService as GroupService;
use Org\service\OperatelogService as OperateService;

class Group extends Cmmcom
{
	//管理权限
    public function powerAll($type=0,$data=array()){
		$where = array();
		$list = array();
		$power = new \Org\service\PowerService();
		$where['pid'] = 0;
		$list = $power->powerList($where);
		//dump($list);die;
		foreach($list as $key=>$v){
			$list[$key]['son'] = array();
			if($type){
				$son = $power->powerList(array('pid'=>$v['id']));	
				foreach($son as $k=>$vv){
					$son[$k]['check'] = 0;
					foreach($data as $j=>$vo){
						if($vv['id']==$vo){
							$son[$k]['check'] = 1;
						}
					}
				}
				$list[$key]['son'] = $son;		
			}else{
				$list[$key]['son'] = $power->powerList(array('pid'=>$v['id']));	
			}		
		}
		
		return $list;
    }
	
	//管理组列表
    public function lists(){
		//权限验证
		parent::adminPower(9);
		
		$group_l = "active";
		$list = array();
		$where = array();
		$group = new GroupService();
		$where['id'] = ['>',0];
		$list = $group->groupList($where);
		//dump($list);die;
		$this->assign('list',$list);
		$this->assign('group_l',$group_l);//导航高亮
        return $this->fetch();
    }
	
	//修改页面
	public function edit(){
		//权限验证
		parent::adminPower(11);

		$group_l = "active";
		$id = input('get.id');
		$where = array();
		$where['id'] = $id;
		$group = new GroupService();
		$result = $group->groupInfo($where);
		//权限
		$role = explode(',',$result['power']);
		$power = $this->powerAll(1,$role);
		//dump($power);die;
		$this->assign('power',$power);//权限列表
		$this->assign('result',$result);
		$this->assign('group_l',$group_l);//导航高亮		
		return $this->fetch();
	}
	
	//更新数据
	public function edit_do(){
		//权限验证
		parent::adminPower(11);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='groupedit'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}	
			if(!input('post.name') || !input('post.power')){
				return json(['s'=>'必填参数不能为空']);	
			}
			
			$where = array();
			$group = new GroupService();
			$where['name'] = input('post.name');
			$where['id'] = ['<>',input('post.id')];
			$count = $group->groupCount($where);			
			if($count){
				return json(['s'=>'管理组名已存在']);				
			}
			$where['id'] = input('post.id');
			$save = $group->groupUpdate($where);

			if($save){
				//更新管理员权限
				$admin = new \Org\service\AdminbrotherService();
				$info = $group->groupInfo($where);
				$power = $info['power'];
				$where2['group'] = input('post.id');
				$list = $admin->adminList($where2);
				foreach($list as $key=>$v){
					$admin->adminUpdate(array('id'=>$v['id']), array('power'=>$power));
				}
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
		parent::adminPower(10);
		
		$group_l = "active";
		$power = $this->powerAll();
		$this->assign('power',$power);//权限列表
		$this->assign('group_l',$group_l);//导航高亮		
		return $this->fetch();
	}
	
	//新增数据
	public function add_do(){
		//权限验证
		parent::adminPower(10);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='groupadd'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			if(!input('post.name') || !input('post.power')){
				return json(['s'=>'必填参数不能为空']);	
			}
			
			$group = new GroupService();
			$where['name'] = input('post.name');
			$count = $group->groupCount($where);			
			if($count){
				return json(['s'=>'管理组名已存在']);				
			}
			$add = $group->groupAdd();

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
	
	//删除管理组
	public function del(){
		//权限验证
		parent::adminPower(13);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='groupdel'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$group = new GroupService();
			
			$where['id'] = ['>',0];
			$count = $group->groupCount($where);			
			if($count<2){
				return json(['s'=>'至少保留一个管理组']);				
			}
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $group->groupInfo($where);
			if(!$info){
				$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $group->groupDel($where);
			if($del){
				//删除管理员权限
				$admin = new \Org\service\AdminbrotherService();
				$where2['group'] = input('post.id');
				$list = $admin->adminList($where2);
				foreach($list as $key=>$v){
					$admin->adminUpdate(array('id'=>$v['id']), array('power'=>0));
				}
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
