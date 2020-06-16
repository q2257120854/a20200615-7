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
use Org\service\AdminbrotherService as AdminbrotherService;
use Org\service\OperatelogService as OperateService;

class Adminbrother extends Cmmcom
{
	
	//管理员列表
    public function lists(){
		//权限验证
		parent::adminPower(2);
		
		$admin_l = "active";
		$list = array();
		$where = array();
		$admin = new AdminbrotherService();
		$where['id'] = ['>',0];
		$list = $admin->adminList($where);
		$group = new \Org\service\GroupService();
		foreach($list as $key=>$v){
			$groupInfo = $group->groupColumn(array('id'=>$v['group']),'name');
			if($groupInfo){
				$list[$key]['group'] = $groupInfo[0];
			}else{
				$list[$key]['group'] = '无权限';
			}
			
		}
		//dump($list);die;
		$this->assign('list',$list);
		$this->assign('admin_l',$admin_l);//导航高亮
        return $this->fetch();
    }
	
	//修改页面
	public function edit(){
		//权限验证
		parent::adminPower(8);
		
		$admin_l = "active";
		$id = input('get.id');
		$where = array();
		$where['id'] = $id;
		$admin = new AdminbrotherService();
		$result = $admin->adminInfo($where);
		//管理组
		$list = array();
		$group = new \Org\service\GroupService();
		$where['id'] = ['>',0];
		$list = $group->groupList($where);
		//dump($list);die;
		
				
		$this->assign('list',$list);//管理组
		$this->assign('result',$result);
		$this->assign('admin_l',$admin_l);//导航高亮		
		return $this->fetch();
	}
	
	//更新数据
	public function edit_do(){
		//权限验证
		parent::adminPower(8);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='adminedit'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}	
			if(!input('post.account')){
				return json(['s'=>'必填参数不能为空']);	
			}

			//账户验证
			if (!preg_match('/^[a-zA-Z0-9_]{3,16}$/u',input('post.account'))){
				return json(['s'=>'账户名必须是英文、数字或者下划线“_”']);	
			}
			//密码验证
			if (input('post.password')) {
				if (strlen(input('post.password'))<6 || strlen(input('post.password'))>18) {
					return json(['s'=>'请输入6位数以上18位数以下的密码']);	
				}	
			}		
			//邮箱
			$email = input('post.email');
			if($email){
				if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
					return json(['s'=>'无效的 email 格式！']);
				}				
			}
			
			$where = array();		
			$admin = new AdminbrotherService();
			$where['account'] = input('post.account');
			$where['id'] = ['<>',input('post.id')];
			$count = $admin->adminCount($where);			
			if($count){
				return json(['s'=>'账户名已存在']);				
			}
			$where['id'] = input('post.id');
			$save = $admin->adminUpdate($where);

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
		parent::adminPower(7);
		
		$admin_l = "active";
		//管理组
		$list = array();
		$where = array();
		$group = new \Org\service\GroupService();
		$where['id'] = ['>',0];
		$list = $group->groupList($where);
		//dump($list);die;
		$this->assign('list',$list);//管理组
		$this->assign('admin_l',$admin_l);//导航高亮		
		return $this->fetch();
	}
	
	//新增数据
	public function add_do(){
		//权限验证
		parent::adminPower(7);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='adminadd'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			if(!input('post.account') || !input('post.password')){
				return json(['s'=>'必填参数不能为空']);	
			}
			//账户验证
			if (!preg_match('/^[a-zA-Z0-9_]{3,16}$/u',input('post.account'))){
				return json(['s'=>'账户名必须是英文、数字或者下划线“_”']);	
			}
			//密码验证
			if (strlen(input('post.password'))<6 || strlen(input('post.password'))>18) {
				return json(['s'=>'请输入6位数以上18位数以下的密码']);	
			}
			//邮箱
			$email = input('post.email');
			if($email){
				if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
					return json(['s'=>'无效的 email 格式！']);
				}				
			}
			$admin = new AdminbrotherService();
			$where['account'] = input('post.account');
			$count = $admin->adminCount($where);			
			if($count){
				return json(['s'=>'账户名已存在']);				
			}
			$add = $admin->adminAdd();

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
	
	//删除管理员
	public function del(){
		//权限验证
		parent::adminPower(12);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='admindel'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$admin = new AdminbrotherService();
			
			$where['id'] = ['>',0];
			$count = $admin->adminCount($where);			
			if($count<2){
				return json(['s'=>'至少保留一个管理员账户']);				
			}
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $admin->adminInfo($where);
			if(!$info){
				$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $admin->adminDel($where);
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
