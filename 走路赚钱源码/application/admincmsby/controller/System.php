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
use \tp5er\Backup;
use Org\service\OperatelogService as OperateService;

class System extends Cmmcom
{	
	
	//操作日志
    public function operatelog(){
		//权限验证
		parent::adminPower(26);
		
		$operate_l = "active";
		$list = array();
		$where = array();
		$operate = new OperateService();
		$where['id'] = ['>',0];
		$list = $operate->operatePageList($where);
		$volist = $list->toArray();
		//dump($volist);die;
		$this->assign('list',$list);
		$this->assign('volist',$volist);
		$this->assign('operate_l',$operate_l);//导航高亮
        return $this->fetch();
    }
	
	//删除操作日志
	public function operate_del(){
		//权限验证
		parent::adminPower(28);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='operatedel'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$where = array();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $operat->operateInfo($where);
			if(!$info){
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $operat->operateDel($where);
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

	//批量删除操作日志
	public function Op_delmost(){
		//权限验证
		parent::adminPower(32);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='opDelAll'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.delid');
			if(!$id){
				return json(['s'=>'请选择删的数据']);
			}
			//删除数据
			$del = $operat->operateDelMost($id);
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
	
	//登陆日志
    public function loginlog(){
		//权限验证
		parent::adminPower(25);
		
		$loginlog_l = "active";
		$list = array();
		$where = array();
		$log = new \Org\service\LoginlogService();
		$where['id'] = ['>',0];
		$list = $log->loginlogPageList($where);
		$volist = $list->toArray();
		//dump($volist);die;
		$this->assign('list',$list);
		$this->assign('volist',$volist);
		$this->assign('loginlog_l',$loginlog_l);//导航高亮
        return $this->fetch();
    }
	//删除登陆日志
	public function log_del(){
		//权限验证
		parent::adminPower(27);
		$operat = new OperateService();
		
		if (request()->isAjax()){
			
			if(input('post.op')!='logdel'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$log = new \Org\service\LoginlogService();
			$where = array();
			$where['id'] = input('post.id');
			//数据是否存在
			$info = $log->loginlogInfo($where);
			if(!$info){
				return json(['s'=>'数据不存在']);
			}
			//删除数据
			$del = $log->loginlogDel($where);
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
	
	//批量删除操作日志
	public function log_delmost(){
		//权限验证
		parent::adminPower(27);
		
		$operat = new OperateService();
		if (request()->isAjax()){
			
			if(input('post.op')!='logDelAll'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			$id = input('post.delid');
			if(!$id){
				return json(['s'=>'请选择删的数据']);
			}
			$log = new \Org\service\LoginlogService();
			//删除数据
			$del = $log->loginlogDelMost($id);
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
	
	//站点基础设置
    public function web(){
		//权限验证
		parent::adminPower(24);
		
		$web_l = "active";
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
		//dump($config);die;
		$this->assign('config',$config);
		$this->assign('web_l',$web_l);//导航高亮
        return $this->fetch();
    }
	
	//修改站点设置
    public function web_edit(){
		//权限验证
		parent::adminPower(24);
		$operat = new OperateService();
		if (request()->isAjax()){
			//return json(['s'=>$_FILES]);	
			$set = new \Org\service\SetService();			
			$save = $set->setRoomEditDoo();
			
			if($save){			
				$operat->operatelogAdd(request()->path(), 1, '修改成功');
				return json(['s'=>'ok']);					
			}else{
				$operat->operatelogAdd(request()->path(), 0, '修改失败');
				return json(['s'=>'修改失败']);	
			}
		}else{
			//return json(['s'=>$_FILES]);
			$operat->operatelogAdd(request()->path(), 0, '非法请求');
			return json(['s'=>'非法请求']);			
		}
    }	
	
	//数据库备份
    public function backup(){
		//权限验证
		parent::adminPower(30);
		$backup_l = "active";
		$db_back = new Backup(\think\Config::get('backup'));
		//数据类表列表
		$tables = $db_back->dataList();
	
		//备份表
		if (request()->isAjax()){	
			$operat = new OperateService();
			
			if(input('post.op')=='backup'){
				 //备份一个数据表
				$file = ['name' => date('Ymd-His'), 'part' => input('post.name')];
				$backup =  $db_back->setFile($file)->backup(input('post.name'), $start=0);
	
				if($backup!=false || $backup==0){
					$operat->operatelogAdd(request()->path(), 1, '备份数据表');
					return json(['s'=>'ok']);
				}else{
					$operat->operatelogAdd(request()->path(), 0, '备份失败');
					return json(['s'=>'备份失败']);	
				}
			}elseif(input('post.op')=='backupAll'){
				//数据库名称
				//$database = \think\Config::get('database.database');
				$arr = explode(',',input('post.name_str'));
				//文件名
				$file = ['name' => date('Ymd-His'), 'part' => 1];
				$j =0 ;
				foreach($tables as $key=>$v){					
					for($i=0;$i<count($arr);$i++){
						if($arr[$i]==$v['name']){
							$backup =  $db_back->setFile($file)->backup($v['name'], $start=0);
							$j++;
						}
					}			
				}
				if($j>0){
					$operat->operatelogAdd(request()->path(), 1, '备份数据表');
					return json(['s'=>'ok']);					
				}
			}else{
				$operat->operatelogAdd(request()->path(), 0, '非法请求');
				return json(['s'=>'非法请求']);					
			}			
		}else{
			$this->assign('backup_l',$backup_l);//导航高亮
			$this->assign('tables',$tables);
			return $this->fetch();			
		}
    }
	
	//数据库还原
	public function restore(){
		//权限验证
		parent::adminPower(31);
		$restore_l = "active";
		$db_back = new Backup(\think\Config::get('backup'));
		//备份文件列表
		$importlist = $db_back->fileList();
		//dump($importlist);die;
		$this->assign('restore_l',$restore_l);//导航高亮
		$this->assign('importlist',$importlist);
		return $this->fetch();		
	}
	
	//删除数据库备份文件
	public function restore_del(){
		//权限验证
		parent::adminPower(31);
		$operat = new OperateService();
		$db_back = new Backup(\think\Config::get('backup'));
		if (request()->isAjax()){				
			if(input('post.op')!='restoredel'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			//删除数据
			$del = $db_back->delFile(input('post.time'));
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
	
	//批量删除数据库备份文件
	public function restore_delAll(){
		//权限验证
		parent::adminPower(31);
		$operat = new OperateService();
		$db_back = new Backup(\think\Config::get('backup'));
		if (request()->isAjax()){					
			if(input('post.op')!='restdelAll'){
				$operat->operatelogAdd(request()->path(), 0, '参数错误');
				return json(['s'=>'参数错误']);	
			}
			//删除数据
			$j = 0;
			$arr = explode(',',input('post.time_str'));
			for($i=0;$i<count($arr);$i++ ){
				$db_back->delFile($arr[$i]);
				$j++;
			}
			
			if($j){
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
	//数据还原操作
	public function DBrestore(){
		//权限验证
		parent::adminPower(31);
		$operat = new OperateService();
		$db_back = new Backup(\think\Config::get('backup'));
		
		if (request()->isAjax()){
				
			if(input('post.op')=='restoreOne'){
				//还原一条数据
				$operat->operatelogAdd(request()->path(), 1, '还原数据');
				return json(['s'=>'ok']);	
			}
			
			//删除数据
			$del = $db_back->delFile(input('post.time'));
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
	
    /**
     * 还原数据库
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function import($time = 0, $part = null, $start = null,$i = 0){
		
		$time = input('get.time');
		$part = input('get.part');
		$start = input('get.start');
		
		//dump($part);die;
        if(is_numeric($time) && is_null($part) && is_null($start)){ //初始化
            //获取备份文件信息
            $name  = date('Ymd-His', $time) . '-*.sql*';
			
            $path  = realpath(\think\Config::get('backup.path')) . DIRECTORY_SEPARATOR . $name;
            $files = glob($path);
            $list  = array();
			
            foreach($files as $name){
                $basename = basename($name);
                $match    = sscanf($basename, '%4s%2s%2s-%2s%2s%2s-%d');
				if($basename){
					$gz       = preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql.gz$/', $basename);
					if(!$gz){
						$gz = 1;
					}
				}
                if(!$match[6]){
					$match[6] = 1;
				}		
                $list[$match[6]] = array($match[6], $name, $gz);
            }
            ksort($list);
			
            //检测文件正确性
            $last = end($list);
            if(count($list) === $last[0]){
                \think\Session::set('backup_list', $list); //缓存备份列表
                $this->success('初始化完成！', url('system/import')."?part=1&start=0");
            } else {
                $this->error('备份文件可能已经损坏，请检查！');
            }
			
        } elseif(is_numeric($part) && is_numeric($start)) {
            $list  = \think\Session::get('backup_list');
			$config = array(
                'path'     => realpath(\think\Config::get('backup.path')) . DIRECTORY_SEPARATOR,
                'compress' => $list[$part][2]
			);
            $db_back = new Backup($config,$list);
			//dump($list[$part]);die;
            $start = $db_back->import($start);

            if(false === $start){
                $this->error('还原数据出错！');
            } elseif(0 === $start) { //下一卷
                if(isset($list[++$part])){
                    $data = array('part' => $part, 'start' => 0);
					$this->success("正在还原...#{$part}", url('system/import')."?part=".$part."&start=0");
                } else {
					$i++;
                    \think\Session::set('backup_list', null);
                    $this->success('还原完成！',url('system/restore'));
                }
            } else {
                $data = array('part' => $part, 'start' => $start[0]);
                if($start[1]){
                    $rate = floor(100 * ($start[0] / $start[1]));
					$this->success("正在还原...#{$part} ({$rate}%)", url('system/import')."?part=".$part."&start=".$start[0]."");
                } else {
                    $data['gz'] = 1;
					$this->success("正在还原...#{$part}", url('system/import')."?part=".$part."&start=".$start[0]."");
                }
            }

        } else {
            $this->error('参数错误！');
        }
    }
	
	
}
