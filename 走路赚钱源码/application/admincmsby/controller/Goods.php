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
use Org\service\GoodsService as GoodsService;
use Org\service\AttrService as AttrService;
use Org\service\GclassService as GclassService;
use Org\service\OperatelogService as OperateService;
use Org\service\TeamService as TeamService;

class Goods extends Cmmcom
{
	//所有属性
	public function classpid(){
		$list = array();
		$where = array();
		$info = array();
		$where['id'] = ['>',0];
		$attr = new AttrService();
		$list = $attr->attrList($where);	
		$class = parent::classid($list);
		$id = input('post.id');
		if($id){
			$where['id'] = $id;
			$info = $attr->attrInfo($where);
			if($info['pid']==0){
				$class = array();
			}
		}	
		return json(['s'=>$class,'v'=>$info]);
	}
	
	//商品属性
    public function goods_attr(){
		//权限验证
		parent::adminPower(35);		
		$attr_l = "active";
		$list = array();
		$where = array();
		$attr = new AttrService();
		$where['id'] = ['>',0];
		$list = $attr->attrList($where);
		$list = parent::classid($list);
		
		//dump($list);die;		
		$this->assign('list',$list);
		$this->assign('attr_l',$attr_l);//导航高亮
        return $this->fetch();
    }
	//添加属性
    public function attr_add(){
		//权限验证
		parent::adminPower(39);
		
		$operat = new OperateService();
		if (request()->isAjax()){		
			if(input('post.op')!='attradd'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$attr = new AttrService();
			$add = $attr->attrAdd();

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
	//修改属性
    public function attr_edit(){
		//权限验证
		parent::adminPower(40);
		
		$operat = new OperateService();
		if (request()->isAjax()){		
			if(input('post.op')!='attredit'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$attr = new AttrService();
			$where = array();
			$where['id'] = input('post.id');
			$save = $attr->attrUpdate($where);

			if($save){
				$operat->operatelogAdd(request()->path(), 1, '修改成功');
				return json(['s'=>'ok']);					
			}else{
				$operat->operatelogAdd(request()->path(), 0, '修改失败');
				return json(['s'=>'新增失败']);	
			}
		}else{	
			$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}
    }
	//删除属性
	public function attr_del(){
		//权限验证
		parent::adminPower(41);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='attrdel'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$attr = new AttrService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $attr->attrInfo($where);
			if(!$info){
				$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			
			if($info['pid']!=0){
				//上级
				$attrid = $info['pid'].'_'.$info['id'];
				//查询商品分类
				$gclass = new GclassService();
				$where2['attrid'] = ['LIKE','%'.$attrid.'%'];
				$list = $gclass->gclassList($where2);	
				if($list){
					return json(['s'=>'数据被使用不能删除，请先删除相关商品分类']);
				}				
			}
			
			//删除数据
			$del = $attr->attrDel($where);
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

	//商品分类列表
    public function gclass(){
		//权限验证
		parent::adminPower(34);
		$gclass_l = "active";
		$list = array();
		$where = array();
		$gclass = new GclassService();
		$where['id'] = ['>',0];
		$list = $gclass->gclassList($where);
		$list = parent::classid($list);
		
		$this->assign('list',$list);
		$this->assign('gclass_l',$gclass_l);//导航高亮		
        return $this->fetch();
    }	
	
	//添加商品分类页
    public function gclass_add(){
		//权限验证
		parent::adminPower(42);
		$gclass_l = "active";
		$list = array();
		$where = array();
		$attr = array();
		$where2 = array();
		//分类列表
		$gclass = new GclassService();
		$where['id'] = ['>',0];
		$list = $gclass->gclassList($where);
		$list = parent::classid($list);
		//属性列表
		$attr = new AttrService();
		$where2['pid'] = ['<',1];
		$goods_attr = $attr->attrList($where2,0);
		foreach($goods_attr as $key=>$v){
			$son = array();
			$son = $attr->attrList(array('pid'=>$v['id']),$v['id']);
			$goods_attr[$key]['son'] = $son;			
		}
		//dump($goods_attr);die;
		
		$this->assign('goods_attr',$goods_attr);
		$this->assign('list',$list);
		$this->assign('gclass_l',$gclass_l);//导航高亮		
        return $this->fetch();
    }	
	//添加商品分类
    public function gclass_add_do(){
		//权限验证
		parent::adminPower(42);
		
		$operat = new OperateService();
		if (request()->isAjax()){		
			if(input('post.op')!='gclassadd'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			if(!input('post.classname')){
				return json(['s'=>'必填项不能为空']);	
			}
			
			$gclass = new GclassService();
			$add = $gclass->gclassAdd();

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
	
	//修改商品分类
    public function gclass_edit(){
		//权限验证
		parent::adminPower(43);
		$gclass_l = "active";
		$list = array();
		$where = array();
		$attr = array();
		$where2 = array();
		//分类列表
		$gclass = new GclassService();
		$where['id'] = ['>',0];
		$list = $gclass->gclassList($where);
		$list = parent::classid($list);
		//分类信息
		$result = array();
		if(input('get.id')){
			$where['id'] = input('get.id');
			$result = $gclass->gclassInfo($where);
			$attr_ = explode(',',$result['attrid']);
		}
		
		//属性列表
		$attr = new AttrService();
		$where2['pid'] = 0;
		$goods_attr = $attr->attrList($where2,0);
		foreach($goods_attr as $key=>$v){
			$son = array();
			$son = $attr->attrList(array('pid'=>$v['id']), $v['id']);
			foreach($son as $k=>$vv){
				$att_v = '';
				$att_v = $vv['pid'].'_'.$vv['id'];
				$son[$k]['checked'] = 0;
				foreach($attr_ as $kk=>$vo){
					if($att_v==$vo){
						$son[$k]['checked'] = 1;
					}
				}
			}
			//dump($son);die;			
			$goods_attr[$key]['son'] = $son;			
		}	
		
		$this->assign('result',$result);
		$this->assign('goods_attr',$goods_attr);
		$this->assign('list',$list);
		$this->assign('gclass_l',$gclass_l);//导航高亮		
        return $this->fetch();
    }

	//修改商品分类
    public function gclass_edit_do(){
		//权限验证
		parent::adminPower(43);
		
		$operat = new OperateService();
		if (request()->isAjax()){		
			if(input('post.op')!='gclass/edit'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			if(!input('post.classname')){
				return json(['s'=>'必填项不能为空']);	
			}
			
			$gclass = new GclassService();
			$add = $gclass->gclassUpdate();

			if($add){
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
	
	//删除商品分类
	public function gclass_del(){
		//权限验证
		parent::adminPower(41);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='gclassdel'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$gclass = new GclassService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $gclass->gclassInfo($where);
			if(!$info){
				$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $gclass->gclassDel($where);
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
	
	
	//商品列表
    public function lists(){
		//权限验证
		parent::adminPower(36);
		$pid = input('get.pid');
		$keyword = input('get.keyword');
		$designer = input('get.designer');
		$home = input('get.home');
		$status = input('get.status');
		$rec = input('get.rec');
		$nice = input('get.nice');
		$session = "admin_goods";
		if(!input('get.')){
			//dump(input('get.page'));die;
			\think\Session::set($session.'pid','');
			\think\Session::set($session.'keyword','');
			\think\Session::set($session.'designer','');
			\think\Session::set($session.'home','');
			\think\Session::set($session.'status','');
			\think\Session::set($session.'rec','');
			\think\Session::set($session.'nice','');
		}else{
			!$pid && \think\Session::set($session.'pid','');
			!$keyword && \think\Session::set($session.'keyword','');
			!$designer && \think\Session::set($session.'designer','');
			!$home && \think\Session::set($session.'home','');
			!$status && \think\Session::set($session.'status','');
			!$rec && \think\Session::set($session.'rec','');
			!$nice && \think\Session::set($session.'nice','');
		}
		if($rec){
			\think\Session::set($session.'rec',$rec);
		}
		if($nice){
			\think\Session::set($session.'nice',$nice);
		}
		if($pid){
			\think\Session::set($session.'pid',$pid);
		}
		if(\think\Session::get($session.'pid') && input('get.page')){
			$pid = \think\Session::get($session.'pid');
		}
		if($keyword){
			\think\Session::set($session.'keyword',$keyword);
		}
		if(\think\Session::get($session.'keyword') && input('get.page')){
			$keyword = \think\Session::get($session.'keyword');
		}
		if($designer){
			\think\Session::set($session.'designer',$designer);
		}
		if(\think\Session::get($session.'designer') && input('get.page')){
			$designer = \think\Session::get($session.'designer');
		}
		if($home || $home=='0'){
			\think\Session::set($session.'home',$home);
		}
		if(\think\Session::get($session.'home') && input('get.page')){
			$home = \think\Session::get($session.'home');
		}
		if($status || $status=='0'){
			\think\Session::set($session.'status',$status);
		}
		if(\think\Session::get($session.'status') && input('get.page')){
			$status = \think\Session::get($session.'status');
		}
		//dump(input('get.page'));die;
		
		$goods = new GoodsService();
		$goods_l = "active";
		//分类
		$gclass = new GclassService();
		$where2['id'] = ['>',0];
		$list_gc = $gclass->gclassList($where2);
		$class = parent::classid($list_gc);	
		//设计师
		$team = new TeamService();
		$team_list = $team->teamList($where2);
		//搜索 pid='' AND designer='' AND name LIKE '%keyword%'
		$pidStr = '';
		//关键词
		$html = "";	
		$and = '';
		$html_2 = "";
		$and2 = '';
		$and3 = '';
		$and4 = '';
		$and5 = '';
		$and6 = '';
		$otherStr = '';
		
		if($keyword){
			$keyword = "`name` LIKE '%".$keyword."%'";
		}
			
		if($designer){
			$keyword && $and = " AND ";
			$designer = "`designer`='".$designer."'";
		}else{
			$designer = '';
		}
		$otherStr = $designer.$and.$keyword;
		
		if(is_numeric($home)){		
			$home = "`home`=".$home."";
		}else{
			$home = '';
		}
		
		if($otherStr && $home){			
			$and3 = " AND ";			
		}
		
		$otherStr = $otherStr.$and3.$home;
		
		if(is_numeric($status)){		
			$status = "`status`=".$status."";
		}else{
			$status = '';
		}
		
		if($otherStr && $status){			
			$and4 = " AND ";			
		}
		$otherStr = $otherStr.$and4.$status;
		
		if(is_numeric($rec)){		
			$rec = "`rec`=".$rec."";
		}else{
			$rec = '';
		}
		
		if($otherStr && $rec){			
			$and5 = " AND ";			
		}
		$otherStr = $otherStr.$and5.$rec;
		
		if(is_numeric($nice)){		
			$nice = "`nice`=".$nice."";
		}else{
			$nice = '';
		}
		
		if($otherStr && $nice){			
			$and6 = " AND ";			
		}
		$otherStr = $otherStr.$and6.$nice;
		
		if(is_numeric($pid)){
			//搜索分类
			$whStr = '`id`='.$pid.' OR `pid`='.$pid;
			$classList = $gclass->gclassList($whStr);		
			$num = count($classList)-1;			
			
			foreach($classList as $key=>$v){
				if($num!=0){
					$html = "(";
					$html_2 = ")";
				}
				$otherStr && $and2 = " AND ";
				if($key==$num){
					$pidStr .= $html.'`pid`='.$v['id'].$and2.$otherStr.$html_2 ;
				}else{
					$pidStr .= $html.'`pid`='.$v['id'].$and2.$otherStr.$html_2.' OR ';
				}			
			}		
		}else{
			$pidStr = $otherStr;
		}
		
		if(!$pidStr){
			$where['id'] = ['>',0];
			$cache = "";
		}else{
			$where = $pidStr;
			$cache = "";
		}

		$list = $goods->goodsPageList($where, $field='*', $cache);
		$volist = $list->toArray();
		
		$this->assign('status',\think\Session::get($session.'status'));
		$this->assign('home',\think\Session::get($session.'home'));
		$this->assign('designer',\think\Session::get($session.'designer'));
		$this->assign('keyword',\think\Session::get($session.'keyword'));
		$this->assign('pid',$pid);
		$this->assign('team_list',$team_list);
		$this->assign('class',$class);
		$this->assign('volist',$volist);
		$this->assign('list',$list);
		$this->assign('goods_l',$goods_l);//导航高亮
        return $this->fetch();
    }

	//商品新增页面
	public function add(){
		//权限验证
		parent::adminPower(46);
		$goods_l = "active";
	
		//分类
		$gclass = new GclassService();
		$where['id'] = ['>',0];
		$list_gc = $gclass->gclassList($where);
		$class = parent::classid($list_gc);	
		//设计师
		$team = new TeamService();
		$team_list = $team->teamList($where);
		$class_id = '';
		if(input('get.class_id')){
			$class_id = intval(input('get.class_id'));
		}		
		
		//dump($list);die;
		$this->assign('team_list',$team_list);
		$this->assign('class',$class);
		$this->assign('class_id',$class_id);//分类ID
		$this->assign('goods_l',$goods_l);//导航高亮
		return $this->fetch();
	}	
	
	//添加商品处理
	public function add_do(){
		//权限验证
		parent::adminPower(46);
		$operat = new OperateService();
		if (request()->isAjax()){
				
			if(input('post.op')!='goods/add'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			if(!input('post.name') || !input('post.pid') || !input('post.title')){
				return json(['s'=>'必填项不能为空']);	
			}
			if(empty($_FILES["photo_0"]['tmp_name'])){
				return json(['s'=>'请上传产品主图']);
			}
			//return json(['s'=>$_FILES["photo_0"]['tmp_name']]);
			$goods = new GoodsService();
			$add = $goods->goodsAdd();
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
	//商品修改页面
	public function edit(){
		//权限验证
		parent::adminPower(47);
		$goods_l = "active";
	
		//分类
		$gclass = new GclassService();
		$where['id'] = ['>',0];
		$list_gc = $gclass->gclassList($where);
		$class = parent::classid($list_gc);	
		//设计师
		$team = new TeamService();
		$team_list = $team->teamList($where);
		//信息
		$goods = new GoodsService();
		if(!input('get.id')){
			$this->error('参数错误');
		}
		$result = $goods->goodsInfo(array('id'=>input('get.id')));
		$property = explode(',',string_arr($result['property']));
		$str_ = '';	
		$count = 0;
		if($result['photo']){
			$photo = array();
			$photo = explode('\&',$result['thumb']);
			$count = count($photo);			
			for($i=0;$i<count($photo);$i++){
				$str_ .= '<p style="margin:6px 2px;clear:both;" id="photo_'.($i+1).'">主图'.($i+1).'：<img src="'.$photo[$i].'" width="80px">  <a href="#" class="link_icon del" onClick="imgDel('.$result['id'].','.($i+1).')" >删除主图'.($i+1).'</a></p>' ;
			}			
		}
		//分类属性
		$attrid_list = array();
		if($result['attr_id']){
			$attrid_list = $this->g_arrt($result['pid'], $result['attr_id'], $type=1);		
		}
		//dump($attrid_list);die;
		
		$this->assign('attrid_list',$attrid_list);
		$this->assign('count',$count);
		$this->assign('photo',$str_);
		$this->assign('property',$property);
		$this->assign('result',$result);
		$this->assign('team_list',$team_list);
		$this->assign('class',$class);
		$this->assign('goods_l',$goods_l);//导航高亮
		return $this->fetch();
	}
	//修改商品处理
	public function edit_do(){
		//权限验证
		parent::adminPower(47);
		$operat = new OperateService();
		if (request()->isAjax()){
				
			if(input('post.op')!='goods/edit'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			if(!input('post.name') || !input('post.pid') || !input('post.title')){
				return json(['s'=>'必填项不能为空']);	
			}
			$goods = new GoodsService();
			$info = $goods->goodsInfo(array('id'=>input('post.id')));
			
			if(!$info['photo'] && empty($_FILES["photo_0"]['tmp_name'])){
				return json(['s'=>'请上传产品主图']);
			}
			
			$data=array();
			if(input('post.photo_num')>1 && $info['photo']){
				$photo = array();
				$photo = explode('\&',$info['photo']);
				$thumb = explode('\&',$info['thumb']);
				$count = intval(input('post.photo_num')) - 1;
				$data['photo'] = '';
				$data['thumb'] = '';
				$j = $count-1;
				for($i=0;$i<$count;$i++){
					if(empty($_FILES["photo_0"]['tmp_name'])){
						if($i!=$j){
							$data['photo'] .= $photo[$i].'\&';
							$data['thumb'] .= $thumb[$i].'\&';							
						}else{
							$data['photo'] .= $photo[$i];
							$data['thumb'] .= $thumb[$i];							
						}						
					}else{
						$data['photo'] .= $photo[$i].'\&';
						$data['thumb'] .= $thumb[$i].'\&';						
					}	
				}					
			}
			
			//return json(['s'=>$data]);
			$save = $goods->goodsUpdate("", $data, 1);
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
	//删除单个商品主图
	public function delImg(){
		//权限验证
		parent::adminPower(47);
		if (request()->isAjax()){
			if(input('post.op')!='goods/delImg'){
				return json(['s'=>'参数错误']);
			}
			$id = input('post.id');
			if ($id=='' || !is_numeric($id)) {
				return json(['s'=>'参数错误']);
			}
			$num = input('post.num');
			$data = array();
			//信息
			$goods = new GoodsService();
			$info = $goods->goodsInfo(array('id'=>$id));
			$photo = array();
			$photo = explode('\&',$info['photo']);
			$thumb = explode('\&',$info['thumb']);
			$data['photo'] = '';
			$data['thumb'] = '';
			$count = count($photo)-2;
			for($i=0;$i<count($photo);$i++){
				if($i!=$num){
					if($i!=$count){
						$data['photo'] .= $photo[$i]."\&";
						$data['thumb'] .= $thumb[$i]."\&";
					}else{
						$data['photo'] .= $photo[$i];
						$data['thumb'] .= $thumb[$i];
					}	
				}
			}
			//return json(['s'=>$data]);
			$save = $goods->goodsUpdate(array('id'=>input('post.id')), $data);
			if($save){
				//删除原图片
				$Base = new \Org\service\BaseService();
				$Base->DelImg($photo[$num]);
				$Base->DelImg($thumb[$num]);
				return json(['s'=>'ok']);
			}else{
				return json(['s'=>'删除图片失败']);	
			}
		}else{
			return json(['s'=>'非法请求']);	
		}
	}
	
	//删除商品
	public function del(){
		//权限验证
		parent::adminPower(48);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='goods/del'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$goods = new GoodsService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $goods->goodsInfo($where);
			if(!$info){
				$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $goods->goodsDel($where);
			if($del){
				//删除图片
				
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
	
	//批量删除商品
	public function delmost(){
		//权限验证
		parent::adminPower(48);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='goods/DelAll'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.delid');
			if(!$id){
				return json(['s'=>'请选择删除的数据']);
			}
			$goods = new GoodsService();
			//删除数据
			$del = $goods->goodsDelMost($id);
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
	
	//获取商品属性
	public function g_arrt($id=0, $attrid=0, $type=0){
		//权限验证
		//if (request()->isAjax()){
			if(!$id){
				$id = input('post.id');
			}
			
			$attrid_list =  array();
			if(!$attrid){
				$attrid = input('post.attr_id');				
			}
			
			$attrid && $attrid_list = explode(',',$attrid);
			
			$attr_info = array();
			$attr = new AttrService();
			$gclass = new GclassService();
			$gclass_info = $gclass->gclassInfo(array('id'=>$id));
			
			if(isset($gclass_info['attrid'])){
				$g_attr = array();
				$g_attr = explode(',',$gclass_info['attrid']);
				$name = 0;
				$k = 0;
				for($i=0;$i<count($g_attr);$i++){
					$arr_ = array();
					$arr_ = explode('_',$g_attr[$i]);					
					if(isset($arr_[0]) && $name!=$arr_[0]){
						$name = $arr_[0];
						$k = $k+1;
						$attr_info[] = $attr->attrInfo(array('id'=>$arr_[0]), 'id,classname');						
					}
					if(isset($arr_[1])){
						$son_list = $attr->attrInfo(array('id'=>$arr_[1]), 'id,classname');
						if($son_list){
							$son_list['checked'] = 0;							
							foreach($attrid_list as $key=>$v){								
								if($v == $son_list['id']){
									$son_list['checked'] = 1;
								}								
							}						
						}					
						$attr_info[$k-1]['son'][] = $son_list;
						//dump($attr_info);die;
					}
				}
			}
			
			if(!$type){
				return json(['s'=>$attr_info]);
			}else{
				return $attr_info;
			}					
		//}		
	}
	
}
