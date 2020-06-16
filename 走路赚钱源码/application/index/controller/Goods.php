<?php
namespace app\index\controller;
use think\Cache;
use think\Request;
use Org\service\AdService as AdService;
use Org\service\TeamService as TeamService;
use Org\service\GoodsService as GoodsService;
use Org\service\GclassService as GclassService;
use Org\service\AttrService as AttrService;

class Goods  extends Cmmcom
{
	//商品列表
    public function lists()
    {
		$title = '案例作品';
		$goods_ = 'active';
		$keyword = input('get.keyword');
		if(!$keyword){		
			$keyword = \think\Session::get('keyword');
		}		
		$keyword && \think\Session::set('keyword',$keyword);
		
		$moid = input('get.moid');
		if(!$moid){		
			$moid = \think\Session::get('moid');
		}
		$moid && \think\Session::set('moid',$moid);
		
		$banner = array();
		$where = array();
		$team = new TeamService();
		//商品页广告
		$ad = new AdService();
		$banner = $ad->adList(array('pid'=>3,'status'=>1),3);
		//商品列表
		$goods = new GoodsService();
		$where['id'] = ['>',0];
		//分类pid
		$pid = input('get.gcid');
		
		if(input('get.page') && !$pid){
			$pid = \think\Session::get('goods_pid');
		}else{
			\think\Session::set('goods_pid','');
		}
		$gcid = $pid;
		
		if(input('get.gcid')){
			\think\Session::set('goods_pid',input('get.gcid'));
		}
		
		$pid && $where['pid'] = $pid;
		$pid? $cache = $pid : $cache = 'all';
		
		//属性搜索
		$pd_list = input('get.pd');
		$strList = '';
		$pd_tid = input('get.tid');	
		$pd = '';
		$pattern = '/e/';
		
		if($pd_list){
			$pd = input('get.pd');
			$pstr = '';
			if($pid){
				$pstr = "pid='".$pid."' AND status=1  AND ";
			}else{
				$pstr = " status=1  AND ";
			}
			$strList = $pstr;			
			$pd_list = explode(',',$pd_list);
			$sr = "";
			$count = count($pd_list);
			for($i=0;$i<$count;$i++){
				$j = $i+1;
 				if($j<$count){
					$sr = ' AND ';
				}else{
					$sr = '';
				}
				// 需要替换的字符串
				$string = $pd_list[$i]; 
							
				// 检测是否需要替换
				if (preg_match($pattern, $string)) {
					// 开始替换
					$pd_list[$i] = preg_replace($pattern, '_', $string);
					$pd_list[$i] = explode('_',$pd_list[$i]);
					
					if($pd_list[$i][1]){
						$pd_list[$i] = $pd_list[$i][1];
					}
				}else{
					$pd_list[$i] = "";
				}					
				$strList .= "attr_id LIKE '%".$pd_list[$i]."%'".$sr;
			}			
		}
		if($pd_tid){
			$pd = $pd_tid;
			// 需要替换的字符串
			$string = $pd_tid; 							
			// 检测是否需要替换
			if (preg_match($pattern, $string)) {
				// 开始替换
				$pd_tid = preg_replace($pattern, '_', $string);
				$pd_tid = explode('_',$pd_tid);
					
				if($pd_tid[1]){
					$pd_tid = $pd_tid[1];
				}
			}else{
				$pd_tid = "";
			}
			$where['attr_id'] = ['LIKE','%'.$pd_tid.'%'];	
			$cache = '';
		}
		
		//商品列表缓存
		$where['status'] = 1;
		if($strList){
			$where = $strList;
			$cache = '';
		}
		
		if($keyword){
			$where['name'] = ['LIKE','%'.$keyword.'%'];
			$cache = '';
		}
		
		//dump($where);die;
		$list = $goods->goodsPageList($where, $field='*', $cache, $page=12);
		$volist = $list->toArray();	
/* 		foreach($volist['data'] as $key=>$v){
			$volist['data'][$key]['user_pic'] = '';
			$volist['data'][$key]['user_qq'] = '';
			$user = $team->teamInfo(array('name'=>$v['designer']));			
			$user && $volist['data'][$key]['user_pic'] = $user['user_pic'];
			$volist['data'][$key]['user_qq'] = $user['qq'];
		} */
		
		//商品属性	
		if($pid){
			$attr_info = array();
			$attr = new AttrService();
			$gclass = new GclassService();
			$gclass_info = $gclass->gclassInfo(array('id'=>$pid));
			if($gclass_info){
				$title = $gclass_info['classname'];
			}
			
			if($gclass_info['attrid']){
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
						$attr_info[] = $attr->attrInfo(array('id'=>$arr_[0]), 'id,classname,ico');						
					}
					if(isset($arr_[1])){
						$attr_info[$k-1]['son'][] = $attr->attrInfo(array('id'=>$arr_[1]), 'id,classname,ico');						
					}
				}
			}
			
			$this->assign('attr_info',$attr_info);//商品属性
		}
		//dump($moid);die;
		$this->assign('keyword',$keyword);//搜索keyword	
		$this->assign('moid',$moid);//全站搜索moid
		$this->assign('title',$title);
		$this->assign('volist',$volist);//商品列表
		$this->assign('list',$list);//分页
		$this->assign('banner',$banner);//首页广告轮播
		$this->assign('goods',$goods_);//导航高亮
		$this->assign('pd',$pd);//get
		$this->assign('gcid',$gcid);//get
        return $this->fetch();
    }
	//商品详情
	public function index(){

		$goods_ = "active";
	
		//分类
		$gclass = new GclassService();
		$where['id'] = ['>',0];
		
		//信息
		$goods = new GoodsService();
		$result = $goods->goodsInfo(array('id'=>input('get.gid'),'status'=>1));
		if(!$result){
			$this->error('产品已下架');
		}
		$title = $result['name'];
		$keywords = $result['keywords'];
		$description = $result['description'];
		
		$property = explode(',',string_arr($result['property']));
		$photo = array();
		$thumb = array();
		
		if($result['photo']){			
			$photo = explode('\&',$result['photo']);
			$thumb = explode('\&',$result['thumb']);
			//$count = count($photo);		
		}
		//二级推荐
		//$goods_rec = $goods->goodsList(array('rec'=>1,'status'=>1),'id,name,pic,description,pid', 'cmm_rec');
		//dump($result);die;
		$banner = array();
		$where = array();
		$team = new TeamService();
		//商品页广告
		$ad = new AdService();
		$banner = $ad->adList(array('pid'=>3,'status'=>1),3);

		
		$this->assign('banner',$banner);//广告轮播
		$this->assign('thumb',$thumb);//小图
		$this->assign('photo',$photo);//大图
		$this->assign('property',$property);//属性
		$this->assign('result',$result);
		//$this->assign('goods_rec',$goods_rec);
		$this->assign('goods',$goods_);//导航高亮
		$this->assign('title',$title);
		$this->assign('keywords',$keywords);//关键词
		$this->assign('description',$description);//描述
		return $this->fetch();
	}	

}
