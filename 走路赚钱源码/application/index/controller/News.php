<?php
namespace app\index\controller;
use think\Url;
use think\Cache;
use think\Request;
use Org\service\NewsService as NewsService;

class News  extends Cmmcom
{	 
	 //新闻详情
	 public function show(){
		$result = array();
		$where = array();
		
		if(input('get.notice_id')){
			$notice = new \Org\service\NoticeService();
			$notice_id = input('get.notice_id');
			$where['id'] = $notice_id;
			$result = $notice->noticeInfo($where);
		}
		
		//dump($result);die;
		$this->assign('result',$result);
		return $this->fetch(); 
	 }	
}
