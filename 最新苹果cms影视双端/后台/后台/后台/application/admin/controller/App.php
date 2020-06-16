<?php
namespace app\admin\controller;
use think\Db;
use think\Config;
use think\Cache;
use think\Exception;

class App extends Base
{

    public function config()
    {
      $config =db('config')->where('id',1)->find();
        if (Request()->isPost()) {
            $config = input();
            $poster_img = array('0'=>$config['poster_img1'],'1'=>$config['poster_img2'],'2'=>$config['poster_img3']);
            $config['poster_img']=json_encode($poster_img,JSON_UNESCAPED_SLASHES);
          	$res=db('config')->where('id',1)->update($config);
            if ($res === false) {
                return $this->error('保存失败，请重试!');
            }
            return $this->success('保存成功!');
        }
		
        $this->assign('config', $config);
        $this->assign('title', 'app配置');
        return $this->fetch('admin@app/config');
    }
  
    public function notice()
      {
        $config =db('notice')->where('id',1)->find();
          if (Request()->isPost()) {
              $config = input();
              $res=db('notice')->where('id',1)->update($config);
              if ($res === false) {
                  return $this->error('保存失败，请重试!');
              }
              return $this->success('保存成功!');
          }

          $this->assign('config', $config);
          $this->assign('title', '公告配置');
          return $this->fetch('admin@app/notice');
      }
	 public function analysisurl()
      {
        $config =db('analysisurl')->where('id',1)->find();
          if (Request()->isPost()) {
              $config = input();
              $res=db('analysisurl')->where('id',1)->update($config);
              if ($res === false) {
                  return $this->error('保存失败，请重试!');
              }
              return $this->success('保存成功!');
          }

          $this->assign('config', $config);
          $this->assign('title', '解析配置');
          return $this->fetch('admin@app/analysisurl');
      }
  	public function popupmessage()
      {
        $config =db('popupmessage')->where('id',1)->find();
          if (Request()->isPost()) {
              $configu = input();
              $href= $_SERVER['HTTP_HOST'];
              if($config['img']==$configu['img']){
              		$configu['img']=$config['img'];
              }else{
              		$configu['img']='http://'.$href.'/'.$configu['img'];
              }
              $res=db('popupmessage')->where('id',1)->update($configu);
              if ($res === false) {
                  return $this->error('保存失败，请重试!');
              }
              return $this->success('保存成功!');
          }

          $this->assign('config', $config);
          $this->assign('title', '弹窗消息');
          return $this->fetch('admin@app/popupmessage');
      }


    public function apixx()
    {
        $config =db('config')->where('id',1)->find();
          if (Request()->isPost()) {
              $config = input();
              $res=db('config')->where('id',1)->update($config);
              if ($res === false) {
                  return $this->error('保存失败，请重试!');
              }
              return $this->success('保存成功!');
          }


        $this->assign('config', $config);
        $this->assign('title', 'api参数');
        return $this->fetch('admin@app/apixx');
    }

        public function advertisement()
    {
        $param = input();
        $param['page'] = intval($param['page']) < 1 ? 1 : $param['page'];
        $param['limit'] = intval($param['limit']) < 1 ? $this->_pagesize : $param['limit'];

        $where = [];
       if (in_array($param['status'], ['0', '1'])) {
            $where['status'] = ['eq', $param['status']];
        }
        if (!empty($param['type'])) {
            $where['type'] = ['eq', $param['type']];
        }
           
       
       
       
        $order='time desc';
        $res = model('Advertisement')->listData($where,$order,$param['page'],$param['limit']);

        foreach($res['list'] as $k=>&$v){
            $v['ismake'] = 1;
            if($GLOBALS['config']['view']['art_detail'] >0 && $v['art_time_make'] < $v['art_time']){
                $v['ismake'] = 0;
            }
        }

        $this->assign('list', $res['list']);
        $this->assign('total', $res['total']);
        $this->assign('page', $res['page']);
        $this->assign('limit', $res['limit']);

        $param['page'] = '{page}';
        $param['limit'] = '{limit}';
        $this->assign('param', $param);

        $this->assign('title', '广告管理');
        return $this->fetch('admin@app/advertisement');
    }
	public function advertisement_add()
    {
        if (Request()->isPost()) {
            $config = input();
          	$config['time']=time();
          //获取域名或主机地址
			$href= $_SERVER['HTTP_HOST'];
          	$config['image']='http://'.$href.'/'.$config['image'];
          	$res=db('advertisement')->insert($config);
            if ($res === false) {
                return $this->error('保存失败，请重试!');
            }
            return $this->success('保存成功!');
        }

        $this->assign('title', '广告添加');
        return $this->fetch('admin@app/advertisement_add');
    }
  	public function adv_info(){
    	 if (Request()->isPost()) {
            $param = input('post.');
            $find=db('advertisement')->where('id',$param['id'])->find();
           	if($find['image']==$param['image']){
            	$param['image']=$param['image'];
            }else{
            	$href= $_SERVER['HTTP_HOST'];
          		$param['image']='http://'.$href.'/'.$param['image'];
            }
           	
            $res = db('advertisement')->where('id',$param['id'])->update($param);
            if($res){
                return $this->success('保存成功!');
            }else{
            	return $this->error('保存失败!');
            }
            
        }

        $id = input('id');
        $res = db('advertisement')->where('id',$id)->find();

        $info = $res;
        $this->assign('info',$info);

        $this->assign('title','广告信息');
        return $this->fetch('admin@app/adv_info');
    }
  
  	    public function adv_del()
    {
        $param = input();
        $id = $param['id'];

        if($id){
          $res = db('advertisement')->where('id',$id)->delete();
            if($res===false){
                return $this->success('删除失败');
            }
            return $this->success('删除成功');
        }
        return $this->error('参数错误');
    }
    
    public function comprehensive()
    {
        $param = input();
        $param['page'] = intval($param['page']) < 1 ? 1 : $param['page'];
        $param['limit'] = intval($param['limit']) < 1 ? $this->_pagesize : $param['limit'];

        $where = [];
       if (in_array($param['status'], ['0', '1'])) {
            $where['status'] = ['eq', $param['status']];
        }
        if (!empty($param['type'])) {
            $where['type'] = ['eq', $param['type']];
        }
           
        $order='id asc';
        $res = model('Comprehensive')->listData($where,$order,$param['page'],$param['limit']);

        foreach($res['list'] as $k=>&$v){
            $v['ismake'] = 1;
            if($GLOBALS['config']['view']['art_detail'] >0 && $v['art_time_make'] < $v['art_time']){
                $v['ismake'] = 0;
            }
        }

        $this->assign('list', $res['list']);
        $this->assign('total', $res['total']);
        $this->assign('page', $res['page']);
        $this->assign('limit', $res['limit']);

        $param['page'] = '{page}';
        $param['limit'] = '{limit}';
        $this->assign('param', $param);

        $this->assign('title', '综合管理');
        return $this->fetch('admin@app/comprehensive');
    }
    
    	public function comprehensive_add()
    {
        if (Request()->isPost()) {
            $config = input();
          	$config['time']=time();
          //获取域名或主机地址
			$href= $_SERVER['HTTP_HOST'];
          	$config['image']='http://'.$href.'/'.$config['image'];
          	$res=db('comprehensive')->insert($config);
            if ($res === false) {
                return $this->error('保存失败，请重试!');
            }
            return $this->success('保存成功!');
        }

        $this->assign('title', '综合添加');
        return $this->fetch('admin@app/comprehensive_add');
    }
  	public function comprehensive_info(){
    	 if (Request()->isPost()) {
            $param = input('post.');
            $find=db('comprehensive')->where('id',$param['id'])->find();
           	if($find['image']==$param['image']){
            	$param['image']=$param['image'];
            }else{
            	$href= $_SERVER['HTTP_HOST'];
          		$param['image']='http://'.$href.'/'.$param['image'];
            }
           	
            $res = db('comprehensive')->where('id',$param['id'])->update($param);
            if($res){
                return $this->success('保存成功!');
            }else{
            	return $this->error('保存失败!');
            }
            
        }

        $id = input('id');
        $res = db('comprehensive')->where('id',$id)->find();

        $info = $res;
        $this->assign('info',$info);

        $this->assign('title','综合信息');
        return $this->fetch('admin@app/comprehensive_info');
    }
  
  	    public function comprehensive_del()
    {
        $param = input();
        $id = $param['id'];

        if($id){
          $res = db('comprehensive')->where('id',$id)->delete();
            if($res===false){
                return $this->success('删除失败');
            }
            return $this->success('删除成功');
        }
        return $this->error('参数错误');
    }
}
