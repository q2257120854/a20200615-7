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
use Org\service\AdService as AdService;
use Org\service\AddressService as AddressService;
use Org\service\OperatelogService as OperateService;
use Org\service\TeamService as TeamService;
use Org\service\MessageService as MessageService;
use Org\service\PartnerService as PartnerService;
use Org\service\NoticeService as NoticeService;
use Org\service\RecruitService as RecruitService;

class Other extends Cmmcom
{
	
	//广告管理列表
    public function adlist(){
		//权限验证
		parent::adminPower(38);
		
		$ad_l = "active";
		$list = array();
		$where = array();
		$ad = new AdService();
		$where['id'] = ['>',0];
		$list = $ad->adList($where);

		//dump($list);die;
		$this->assign('list',$list);
		$this->assign('ad_l',$ad_l);//导航高亮
        return $this->fetch();
    }

	//新增广告页面
	public function ad_add(){
		//权限验证
		parent::adminPower(38);		
		$ad_l = "active";

		$this->assign('ad_l',$ad_l);//导航高亮		
		return $this->fetch();
	}
	//新增广告处理
	public function ad_add_do(){
		//权限验证
		parent::adminPower(38);
		
		$operat = new OperateService();
		if (request()->isAjax()){		
			if(input('post.op')!='ad/add'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$ad = new AdService();
			$add = $ad->adAdd();

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
	//修改广告页面
	public function ad_edit(){
		//权限验证
		parent::adminPower(38);
		
		$ad_l = "active";
		$id = input('get.id');
		$where = array();
		$where['id'] = $id;
		$ad = new AdService();
		$result = $ad->adInfo($where);
		//dump($result);die;		
		$this->assign('result',$result);
		$this->assign('ad_l',$ad_l);//导航高亮		
		return $this->fetch();
	}
	//更新广告数据处理
	public function ad_edit_do(){
		//权限验证
		parent::adminPower(38);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='ad/edit'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();		
			$ad = new AdService();
			$where['id'] = input('post.id');
			$save = $ad->adUpdate($where);

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
	//删除广告
	public function ad_del(){
		//权限验证
		parent::adminPower(38);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='ad/del'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$ad = new AdService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $ad->adInfo($where);
			if(!$info){
				$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $ad->adDel($where);
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
	//批量删除广告
	public function ad_delmost(){
		//权限验证
		parent::adminPower(38);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='adDelAll'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.delid');
			if(!$id){
				return json(['s'=>'请选择删除的数据']);
			}
			$ad = new AdService();
			//删除数据
			$del = $ad->adDelMost($id);
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
	//联系我们
	public function contact(){
		//权限验证
		parent::adminPower(45);
		
		$contact_l = "active";
		$where = array();
		$address = new AddressService();
		$where['id'] = ['>',0];
		$result = $address->AddreInfo($where);

		//dump($result);die;
		$this->assign('result',$result);
		$this->assign('contact_l',$contact_l);//导航高亮
        return $this->fetch();		
	}
	//修改联系地址
	public function contact_edit(){
		//权限验证
		parent::adminPower(45);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='address/edit'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();		
			$address = new AddressService();
			$save = $address->AddreRoomEditDoo();

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
	//公司团队
    public function team(){
		//权限验证
		parent::adminPower(49);
		
		$team_l = "active";
		$list = array();
		$where = array();
		$team = new TeamService();
		$where['id'] = ['>',0];
		$list = $team->teamList($where);

		//dump($list);die;
		$this->assign('list',$list);
		$this->assign('team_l',$team_l);//导航高亮
        return $this->fetch();
    }
	//新增团队
    public function team_add(){
		//权限验证
		parent::adminPower(49);		
		$team_l = "active";
		
		$this->assign('team_l',$team_l);//导航高亮
        return $this->fetch();
    }
	
	//添加团队处理
    public function team_add_do(){
		//权限验证
		parent::adminPower(49);		
		$operat = new OperateService();
		if (request()->isAjax()){		
			if(input('post.op')!='team/add'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			if(!input('post.name')){
				return json(['s'=>'必填项不能为空']);	
			}
			$team = new TeamService();
			$add = $team->teamAdd();

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
	//修改团队
    public function team_edit(){
		//权限验证
		parent::adminPower(49);
		
		$team_l = "active";
		$where = array();
		$team = new TeamService();
		$where['id'] = input('get.id');
		$result = $team->teamInfo($where);
		$property = array();
		if($result){
			$result['property'] = string_arr($result['property']);
			$property = explode(',',$result['property']);
		}else{
			$this->error('参数错误');
		}
		//dump($property);die;
		$this->assign('result',$result);
		$this->assign('property',$property);
		$this->assign('team_l',$team_l);//导航高亮
        return $this->fetch();
    }	
	//添加团队处理
    public function team_edit_do(){
		//权限验证
		parent::adminPower(49);		
		$operat = new OperateService();
		if (request()->isAjax()){		
			if(input('post.op')!='team/edit'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			if(!input('post.name')){
				return json(['s'=>'必填项不能为空']);	
			}			
			$team = new TeamService();
			$save = $team->teamUpdate();	
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
	//删除团队
	public function team_del(){
		//权限验证
		parent::adminPower(49);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='team/del'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$team = new TeamService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $team->teamInfo($where);
			if(!$info){
				$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $team->teamDel($where);
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
	//批量删除团队
	public function team_delmost(){
		//权限验证
		parent::adminPower(49);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='teamDelAll'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.delid');
			if(!$id){
				return json(['s'=>'请选择删除的数据']);
			}
			$team = new TeamService();
			//删除数据
			$del = $team->teamDelMost($id);
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
	//留言列表
    public function message(){
		//权限验证
		parent::adminPower(51);
		
		$msg_l = "active";
		$list = array();
		$where = array();
		$msg = new MessageService();
		$admin = new \Org\service\AdminbrotherService();
		
		$where['id'] = ['>',0];
		$list = $msg->msgPageList($where);
		$volist = $list->toArray();
		foreach($volist['data'] as $key=>$v){
			$volist['data'][$key]['username'] = '';
			if($v['uid']){
				$user = $admin->adminInfo(array('id'=>$v['uid']),'account');
				$volist['data'][$key]['username'] = $user['account'];
			}
		}
		//dump($volist);die;
		$this->assign('volist',$volist);
		$this->assign('list',$list);
		$this->assign('msg_l',$msg_l);//导航高亮
        return $this->fetch();
    }
	//留言查看
	public function message_view(){
		//权限验证
		parent::adminPower(51);
		$msg_l = "active";
		
		$where['id'] = input('get.id');
		$msg = new MessageService();
		$result = $msg->msgInfo($where);
		//修改状态
		if($result && $result['status']==0){
			$data['status']=1;
			$data['uid']= \think\Session::get('CmmAdmin.id');
			$save = $msg->msgUpdate($where,$data);
		}
		//dump($result);die;
		
		$this->assign('result',$result);
		$this->assign('msg_l',$msg_l);//导航高亮
		return $this->fetch();
	}
	
	//留言处理
	public function message_edit(){
		//权限验证
		parent::adminPower(51);
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='message/edit'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.id');
			if(!input('post.remark')){
				return json(['s'=>'备注不能为空']);
			}
			$msg = new MessageService();
			$save = $msg->msgUpdate();	
			if($save){
				$operat->operatelogAdd(request()->path(), 1, '处理成功');
				return json(['s'=>'ok']);					
			}else{
				$operat->operatelogAdd(request()->path(), 0, '处理失败');
				return json(['s'=>'处理失败']);	
			}		
		}else{
			$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}
	}
	
	//删除留言
    public function message_del(){
		//权限验证
		parent::adminPower(51);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='message/del'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$msg = new MessageService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $msg->msgInfo($where);
			if(!$info){
				$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $msg->msgDel($where);
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
	//批量删除留言
	public function message_delmost(){
		//权限验证
		parent::adminPower(51);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='msg/DelAll'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.delid');
			if(!$id){
				return json(['s'=>'请选择删除的数据']);
			}
			$msg = new MessageService();
			//删除数据
			$del = $msg->msgDelMost($id);
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
	//合作伙伴列表
    public function partner(){
		//权限验证
		parent::adminPower(50);
		
		$partner_l = "active";
		$list = array();
		$where = array();
		$part = new PartnerService();
		$where['id'] = ['>',0];
		$list = $part->partnerList($where);

		//dump($list);die;
		$this->assign('list',$list);
		$this->assign('partner_l',$partner_l);//导航高亮
        return $this->fetch();
    }

	//新增合作伙伴
	public function partner_add(){
		//权限验证
		parent::adminPower(50);		
		$partner_l = "active";

		$this->assign('partner_l',$partner_l);//导航高亮		
		return $this->fetch();
	}
	//新增合作伙伴处理
	public function partner_add_do(){
		//权限验证
		parent::adminPower(50);
		
		$operat = new OperateService();
		if (request()->isAjax()){		
			if(input('post.op')!='part/add'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$part = new PartnerService();
			$add = $part->partnerAdd();

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
	//修改合作伙伴页面
	public function partner_edit(){
		//权限验证
		parent::adminPower(50);
		
		$partner_l = "active";
		$id = input('get.id');
		$where = array();
		$where['id'] = $id;
		$part = new PartnerService();
		$result = $part->partnerInfo($where);
		//dump($result);die;		
		$this->assign('result',$result);
		$this->assign('partner_l',$partner_l);//导航高亮		
		return $this->fetch();
	}
	//更新合作伙伴数据处理
	public function partner_edit_do(){
		//权限验证
		parent::adminPower(50);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='part/edit'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();		
			$part = new PartnerService();
			$where['id'] = input('post.id');
			$save = $part->partnerUpdate($where);

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
	
	//删除合作伙伴
	public function partner_del(){
		//权限验证
		parent::adminPower(50);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='part/del'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$part = new PartnerService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $part->partnerInfo($where);
			if(!$info){
				$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $part->partnerDel($where);
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
	//批量删除合作伙伴
	public function partner_delmost(){
		//权限验证
		parent::adminPower(50);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='part/DelAll'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.delid');
			if(!$id){
				return json(['s'=>'请选择删除的数据']);
			}
			$part = new PartnerService();
			//删除数据
			$del = $part->partnerDelMost($id);
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
	//站内公告列表
    public function notice(){
		//权限验证
		parent::adminPower(52);
		
		$notice_l = "active";
		$list = array();
		$where = array();
		$notice = new NoticeService();
		$admin = new \Org\service\AdminbrotherService();
		
		$where['id'] = ['>',0];
		$list = $notice->noticePageList($where);
		$volist = $list->toArray();
		foreach($volist['data'] as $key=>$v){
			$volist['data'][$key]['username'] = '';
			if($v['uid']){
				$user = $admin->adminInfo(array('id'=>$v['uid']),'account');
				$volist['data'][$key]['username'] = $user['account'];
			}
		}
		//dump($volist);die;
		$this->assign('volist',$volist);
		$this->assign('list',$list);
		$this->assign('notice_l',$notice_l);//导航高亮
        return $this->fetch();
    }


	//新增站内公告
	public function notice_add(){
		//权限验证
		parent::adminPower(52);
		$notice_l = "active";

		$this->assign('notice_l',$notice_l);//导航高亮		
		return $this->fetch();
	}
	//新增站内公告处理
	public function notice_add_do(){
		//权限验证
		parent::adminPower(52);
		
		$operat = new OperateService();
		if (request()->isAjax()){		
			if(input('post.op')!='notice/add'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$notice = new NoticeService();
			$add = $notice->noticeAdd();

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
	//修改站内公告页面
	public function notice_edit(){
		//权限验证
		parent::adminPower(52);
		
		$notice_l = "active";
		$id = input('get.id');
		$where = array();
		$where['id'] = $id;
		$notice = new NoticeService();
		$result = $notice->noticeInfo($where);
		//dump($result);die;		
		$this->assign('result',$result);
		$this->assign('notice_l',$notice_l);//导航高亮		
		return $this->fetch();
	}
	//更新站内公告数据处理
	public function notice_edit_do(){
		//权限验证
		parent::adminPower(52);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='notice/edit'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();		
			$notice = new NoticeService();
			$where['id'] = input('post.id');
			$save = $notice->noticeUpdate($where);

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
	
	//删除站内公告
	public function notice_del(){
		//权限验证
		parent::adminPower(52);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='notice/del'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$notice = new NoticeService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $notice->noticeInfo($where);
			if(!$info){
				$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $notice->noticeDel($where);
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
	//批量删除站内公告
	public function notice_delmost(){
		//权限验证
		parent::adminPower(52);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='notice/DelAll'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.delid');
			if(!$id){
				return json(['s'=>'请选择删除的数据']);
			}
			$notice = new NoticeService();
			//删除数据
			$del = $notice->noticeDelMost($id);
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
	
	//人才招聘列表
    public function recruit(){
		//权限验证
		parent::adminPower(53);
		
		$recruit_l = "active";
		$list = array();
		$where = array();
		$recruit = new RecruitService();
		$admin = new \Org\service\AdminbrotherService();
		
		$where['id'] = ['>',0];
		$list = $recruit->recruitPageList($where);
		$volist = $list->toArray();
		foreach($volist['data'] as $key=>$v){
			$volist['data'][$key]['username'] = '';
			if($v['uid']){
				$user = $admin->adminInfo(array('id'=>$v['uid']),'account');
				$volist['data'][$key]['username'] = $user['account'];
			}
		}
		//dump($volist);die;
		$this->assign('volist',$volist);
		$this->assign('list',$list);
		$this->assign('recruit_l',$recruit_l);//导航高亮
        return $this->fetch();
    }


	//新增人才招聘
	public function recruit_add(){
		//权限验证
		parent::adminPower(53);
		$recruit_l = "active";

		$this->assign('recruit_l',$recruit_l);//导航高亮		
		return $this->fetch();
	}
	//新增人才招聘处理
	public function recruit_add_do(){
		//权限验证
		parent::adminPower(53);
		
		$operat = new OperateService();
		if (request()->isAjax()){		
			if(input('post.op')!='recruit/add'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$recruit = new NoticeService();
			$add = $recruit->recruitAdd();

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
	//修改人才招聘页面
	public function recruit_edit(){
		//权限验证
		parent::adminPower(53);
		
		$recruit_l = "active";
		$id = input('get.id');
		$where = array();
		$where['id'] = $id;
		$recruit = new RecruitService();
		$result = $recruit->recruitInfo($where);
		//dump($result);die;		
		$this->assign('result',$result);
		$this->assign('recruit_l',$recruit_l);//导航高亮		
		return $this->fetch();
	}
	//更新人才招聘数据处理
	public function recruit_edit_do(){
		//权限验证
		parent::adminPower(53);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='recruit/edit'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();		
			$recruit = new RecruitService();
			$where['id'] = input('post.id');
			$save = $recruit->recruitUpdate($where);

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
	
	//删除人才招聘
	public function recruit_del(){
		//权限验证
		parent::adminPower(53);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='recruit/del'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$recruit = new RecruitService();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $recruit->noticeInfo($where);
			if(!$info){
				$operat->operatelogAdd(request()->path(), 0, '数据不存在');
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $recruit->noticeDel($where);
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
	//批量删人才招聘
	public function recruit_delmost(){
		//权限验证
		parent::adminPower(53);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='recruit/DelAll'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.delid');
			if(!$id){
				return json(['s'=>'请选择删除的数据']);
			}
			$recruit = new RecruitService();
			//删除数据
			$del = $recruit->recruitDelMost($id);
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
