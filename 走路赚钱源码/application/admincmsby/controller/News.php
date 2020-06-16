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
use Org\service\NewsService as NewsService;
use Org\service\NewsclassService as NClassService;
use Org\service\OperatelogService as OperateService;

class News extends Cmmcom
{
	
	//分类
	public function classpid(){
		$list = array();
		$where = array();
		$where['id'] = ['>',0];
		$nclass = new NClassService();	
		$list = $nclass->nclassList($where);	
		$class = parent::classid($list);
		return $class;
	}
	
	//新闻分类
    public function nclass(){
		//权限验证
		parent::adminPower(29);
/* 		$html = readRoute($url='class', $address='news/class', $name='新闻分类');
		$write = writeRoute($html);
		dump($write);die; */
		
		$nclass_l = "active";
		$list = array();
		$where = array();
		$nclass = new NClassService();
		$where['id'] = ['>',0];
		$list = $nclass->nclassList($where);

		$list = parent::classid($list);
		//dump($list);die;
		$this->assign('list',$list);
		$this->assign('nclass_l',$nclass_l);//导航高亮
        return $this->fetch();
    }
	
	//新闻分类 新增页面
	public function nclass_add(){
		//权限验证
		parent::adminPower(29);

		$class = $this->classpid();
		return json(['s'=>$class]);
	}
	
	//新闻分类 新增数据
	public function nclass_add_do(){
		//权限验证
		parent::adminPower(29);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='nclassadd'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			if(!input('post.classname')){
				return json(['s'=>'必填参数不能为空']);	
			}
			$nclass = new NClassService();
			$where['classname'] = input('post.classname');
			$where['pid'] = input('post.pid');
			$count = $nclass->nclassCount($where);			
			if($count){
				return json(['s'=>'分类名已存在']);				
			}	
			$where2['id'] = ['<>',input('post.id')];
			$where2['url'] = input('post.url');
			$url = $nclass->nclassCount($where2);	
			if($url){
				return json(['s'=>'URL地址已存在']);				
			}			
			$add = $nclass->nclassAdd();
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
	
	//新闻分类 修改页面
	public function nclass_edit(){
		//权限验证
		parent::adminPower(29);
		
		$power_l = "active";
		$id = input('post.id');
		$class = array();
		$where = array();
		$where['id'] = $id;
		$nclass = new NClassService();
		$result = $nclass->nclassInfo($where);
		
		if($result['pid']!=0){
			$class = $this->classpid();			
		}
		return json(['s'=>$class,'v'=>$result]);
	}

	
	//新闻分类 更新数据
	public function nclass_edit_do(){
		//权限验证
		parent::adminPower(29);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='nclassedit'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}	
			if(!input('post.classname')){
				return json(['s'=>'必填参数不能为空']);	
			}
			$nclass = new NClassService();		
			$where['classname'] = input('post.classname');
			$where['id'] = ['<>',input('post.id')];
			$where['pid'] = input('post.pid');
			$count = $nclass->nclassCount($where);			
			if($count){
				return json(['s'=>'分类名已存在']);				
			}

			$where2['id'] = ['<>',input('post.id')];
			$where2['url'] = input('post.url');
			$url = $nclass->nclassCount($where2);	
			if($url){
				return json(['s'=>'URL地址已存在']);				
			} 
				
			$save = $nclass->nclassUpdate();
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

	//分类循环查询
	public function classInfo_($id=2){
		
		$news = new NewsService();
		$nclass = new NClassService();
		
		$where['pid'] = $id;
		$list = $nclass->nclassList($where);
		//dump($list);die;
		foreach($list as $key=>$v){
			//是否可删除
			$news_info = array();
			$news_info = $news->newsInfo(array('pid'=>$v['id']));	
			
			if($news_info){		
				//dump($news_info);die;
				return false;
			}else{
				$info = array();
				$info = $nclass->nclassInfo(array('pid'=>$v['id']));
				
				if($info){
					$this->classInfo_($v['id']);
				}				
			}
		}
		return true;
	}
	
	//删除新闻分类
	public function nclass_del(){
		//权限验证
		parent::adminPower(29);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='nclassdel'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			
			//return json(['s'=>input('request.all')]);
			$where = array();
			$nclass = new NClassService();
			$where['id'] = input('post.id');
			$id = input('post.id');
			if($id=='2'){
				return json(['s'=>'不能删除公司介绍']);
			}
			//数据是否存在
			$info = $nclass->nclassInfo($where);
			if(!$info){
				$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//子分类下面有新闻数据
			if($info['pid']==0){
				$checkInfo = $this->classInfo_(input('post.id'));
				if(false==$checkInfo){
					return json(['s'=>'该分类下有数据，不能删除']);
				}
			}
			
			$news = new NewsService();
			$where2['pid'] = input('post.id');
			//是否可删除
			$news_info = $news->newsInfo($where2);
			if($news_info){
				return json(['s'=>'该分类下有数据，不能删除']);
			}

			//删除数据
			$del = $nclass->nclassDel($where);
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
	
	//新闻列表 后台数据缓存
    public function lists(){
		//权限验证
		parent::adminPower(19);
		
		$news_l = "active";
		$list = array();
		$where = array();
		$pid = input('get.pid');
		$keyword = input('get.keyword');
		$session = "admin_news";
		$keyword && $where['title'] = ['LIKE',"%".$keyword."%"];
		
		if(!input('get.')){
			\think\Session::set($session.'pid','');
			\think\Session::set($session.'keyword','');
		}
		if($pid){
			\think\Session::set($session.'pid',$pid);
			if(!$keyword){
				\think\Session::set($session.'keyword','');
			}			
		}
		if($keyword){
			\think\Session::set($session.'keyword',$keyword);
			if(!$pid){
				\think\Session::set($session.'pid','');
			}
		}	

		if(\think\Session::get($session.'pid') && input('get.page')){
			$pid = \think\Session::get($session.'pid');
		}
		if(\think\Session::get($session.'keyword') && input('get.page')){
			$keyword = \think\Session::get($session.'keyword');
		}
		
		$news = new NewsService();
		$admin = new \Org\service\AdminbrotherService();
		$nclass = new NClassService();
		$html = "";
		$html_2 = "";
			
		$pidStr = '';			
		if(is_numeric($pid)){
			if($keyword){
				$keyword = " AND title LIKE '%".$keyword."%'";
			}
			$whStr = 'id='.$pid.' OR pid='.$pid;
			$class = $nclass->nclassList($whStr);
			$num = count($class)-1;
			foreach($class as $key=>$v){
				if($num!=0){
					$html = "(";
					$html_2 = ")";
				}
				if($key==$num){
					$pidStr .= $html.' pid='.$v['id'].$keyword.$html_2 ;
				}else{
					$pidStr .= $html.' pid='.$v['id'] .$keyword.$html_2.' OR ';
				}			
			}			
		}
		if(!$pidStr){
			$where['id'] = ['>',0];
		}else{
			$where = $pidStr;
		}
		//dump($where);die;
		$list = $news->newsPageList($where);
		$volist = $list->toArray();
		
		foreach($volist['data'] as $key=>$v){
			//管理员名		
			$res = array();
			$res = $admin->adminInfo(array('id'=>$v['uid']),'account');
			if($res){
				$volist['data'][$key]['username'] = $res['account'];
			}else{
				$volist['data'][$key]['username'] = '';
			}
			//分类名
			$class = $nclass->nclassInfo(array('id'=>$v['pid']),'classname');
			$volist['data'][$key]['classname'] = $class['classname'];			
		}
		//所有分类
		$class = $this->classpid();
		
		$this->assign('pid',$pid);
		$this->assign('keyword',\think\Session::get($session.'keyword'));
		$this->assign('class',$class);
		$this->assign('list',$list);
		$this->assign('volist',$volist);
		$this->assign('news_l',$news_l);//导航高亮
        return $this->fetch();
    }

	//新闻新增页面
	public function add(){
		//权限验证
		parent::adminPower(20);
		$news_l = "active";
		$class_id = '';
		if(input('get.class_id')){
			$class_id = intval(input('get.class_id'));
		}
		$list = $this->classpid();
		//dump($class_id);die;
		$this->assign('list',$list);
		$this->assign('class_id',$class_id);
		$this->assign('news_l',$news_l);//导航高亮
		return $this->fetch();
	}	
	
	//添加新闻处理
	public function add_do(){
		//权限验证
		parent::adminPower(20);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='newsadd'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}	
			if(!input('post.title')){
				return json(['s'=>'标题不能为空']);	
			}
			
			$news = new NewsService();
			$where['title'] = input('post.title');
			$count = $news->newsCount($where);			
			if($count){
				return json(['s'=>'标题已存在']);				
			}	
			
			$add = $news->newsAdd();
			//return json(['s'=>$add]);
			if($add){			
				$operat->operatelogAdd(request()->path(), 1, '添加成功');
				return json(['s'=>'ok']);					
			}else{
				$operat->operatelogAdd(request()->path(), 0, '添加失败');
				return json(['s'=>'添加失败']);	
			}
		}else{	
			$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}
	}
	
	//新闻修改页面
	public function edit(){
		//权限验证
		parent::adminPower(21);
		$news_l = "active";
		$list = $this->classpid();
		$news = new NewsService();
		$where['id'] = input('get.id');
		$result = $news->newsInfo($where);
		
		//dump($list);die;
		$this->assign('list',$list);
		$this->assign('result',$result);
		$this->assign('news_l',$news_l);//导航高亮
		return $this->fetch();
	}
	
	//新闻修改处理
	public function edit_do(){
		//权限验证
		parent::adminPower(21);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='newsedit'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}	
			
			if(!input('post.title')){
				return json(['s'=>'标题不能为空']);	
			}
			
			$news = new NewsService();
			$where['title'] = input('post.title');
			$where['id'] = ['<>',input('post.id')];
			$count = $news->newsCount($where);			
			if($count){
				return json(['s'=>'标题已存在']);				
			}
	
			$where = array();
			$where['id'] = input('post.id');		
			$save = $news->newsUpdate($where);
			//return json(['s'=>'1111']);		
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
	//删除新闻
	public function del(){
		//权限验证
		parent::adminPower(22);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='newsdel'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$news = new NewsService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $news->newsInfo($where);
			if(!$info){
				$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $news->newsDel($where);
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
	//批量删除新闻
	public function delmost(){
		//权限验证
		parent::adminPower(22);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='newsDelAll'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.delid');
			if(!$id){
				return json(['s'=>'请选择删除的数据']);
			}
			$news = new NewsService();
			//删除数据
			$del = $news->newsDelMost($id);
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
}
