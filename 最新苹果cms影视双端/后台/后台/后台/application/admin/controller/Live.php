<?php
namespace app\admin\controller;
use think\Db;
use app\common\util\Pinyin;

class Live extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function data()
    {
        $param = input();
        $param['page'] = intval($param['page']) < 1 ? 1 : $param['page'];
        $param['limit'] = intval($param['limit']) < 1 ? $this->_pagesize : $param['limit'];

        $where = [];
        if (!empty($param['type'])) {
            $where['type_id'] = ['eq', $param['type']];
        }
        if (!empty($param['level'])) {
            $where['live_level'] = ['eq', $param['level']];
        }
        if (in_array($param['status'], ['0', '1'])) {
            $where['live_status'] = ['eq', $param['status']];
        }
        if (!empty($param['lock'])) {
            $where['live_lock'] = ['eq', $param['lock']];
        }
        if(!empty($param['pic'])){
            if($param['pic'] == '1'){
                $where['live_pic'] = ['eq',''];
            }
            elseif($param['pic'] == '2'){
                $where['live_pic'] = ['like','http%'];
            }
            elseif($param['pic'] == '3'){
                $where['live_pic'] = ['like','%#err%'];
            }
        }
        if(!empty($param['wd'])){
            $param['wd'] = htmlspecialchars(urldecode($param['wd']));
            $where['live_name'] = ['like','%'.$param['wd'].'%'];
        }

        if(!empty($param['repeat'])){
            if($param['page'] ==1){
                Db::execute('DROP TABLE IF EXISTS '.config('database.prefix').'tmplive');
                Db::execute('CREATE TABLE IF NOT EXISTS `'.config('database.prefix').'tmplive` as (SELECT min(live_id)as id1,live_name as name1 FROM '.config('database.prefix').'live GROUP BY name1 HAVING COUNT(name1)>1)');
            }
            $order='live_name asc';
            $res = model('Live')->listRepeatData($where,$order,$param['page'],$param['limit']);
        }
        else{
            $order='live_time desc';
            $res = model('Live')->listData($where,$order,$param['page'],$param['limit']);
        }

        foreach($res['list'] as $k=>&$v){
            $v['ismake'] = 1;
            if($GLOBALS['config']['view']['live_detail'] >0 && $v['live_time_make'] < $v['live_time']){
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

        $type_tree = model('Type')->getCache('type_tree');
        $this->assign('type_tree', $type_tree);

        $this->assign('title', '直播管理');
        return $this->fetch('admin@live/index');
    }

    public function batch()
    {
        $param = input();
        if (!empty($param)) {

            mac_echo('<style type="text/css">body{font-size:12px;color: #333333;line-height:21px;}span{font-weight:bold;color:#FF0000}</style>');

            if(empty($param['ck_del']) && empty($param['ck_level']) && empty($param['ck_status']) && empty($param['ck_lock']) && empty($param['ck_hits']) ){
                return $this->error('没有选择任何参数');
            }
            $where = [];
            if(!empty($param['type'])){
                $where['type_id'] = ['eq',$param['type']];
            }
            if(!empty($param['level'])){
                $where['live_level'] = ['eq',$param['level']];
            }
            if(in_array($param['status'],['0','1'])){
                $where['live_status'] = ['eq',$param['status']];
            }
            if(!empty($param['lock'])){
                $where['live_lock'] = ['eq',$param['lock']];
            }
            if(!empty($param['pic'])){
                if($param['pic'] == '1'){
                    $where['live_pic'] = ['eq',''];
                }
                elseif($param['pic'] == '2'){
                    $where['live_pic'] = ['like','http%'];
                }
                elseif($param['pic'] == '3'){
                    $where['live_pic'] = ['like','%#err%'];
                }
            }
            if(!empty($param['wd'])){
                $param['wd'] = htmlspecialchars(urldecode($param['wd']));
                $where['live_name'] = ['like','%'.$param['wd'].'%'];
            }


            if($param['ck_del'] == 1){
                $res = model('Live')->delData($where);
                mac_echo('批量删除完毕');
                mac_jump( url('live/batch') ,3);
                exit;
            }

            if(empty($param['page'])){
                $param['page'] = 1;
            }
            if(empty($param['limit'])){
                $param['limit'] = 100;
            }
            if(empty($total)) {
                $total = model('Live')->countData($where);
                $page_count = ceil($total / $param['limit']);
            }

            if($param['page'] > $page_count) {
                mac_echo('批量设置完毕');
                mac_jump( url('live/batch') ,3);
                exit;
            }
            mac_echo( "<font color=red>共".$total."条数据需要处理，每页".$param['limit']."条，共".$page_count."页，正在处理第".$param['page']."页数据</font>");

            $order='live_id desc';
            $res = model('Live')->listData($where,$order,$param['page'],$param['limit']);

            foreach($res['list'] as  $k=>$v){
                $where2 = [];
                $where2['live_id'] = $v['live_id'];

                $update = [];
                $des = $v['live_id'].','.$v['live_name'];

                if(!empty($param['ck_level']) && !empty($param['val_level'])){
                    $update['live_level'] = $param['val_level'];
                    $des .= '&nbsp;推荐值：'.$param['val_level'].'；';
                }
                if(!empty($param['ck_status']) && isset($param['val_status'])){
                    $update['live_status'] = $param['val_status'];
                    $des .= '&nbsp;状态：'.($param['val_status'] ==1 ? '[已审核]':'[未审核]') .'；';
                }
                if(!empty($param['ck_lock']) && isset($param['val_lock'])){
                    $update['live_lock'] = $param['val_lock'];
                    $des .= '&nbsp;推荐值：'.($param['val_lock']==1 ? '[锁定]':'[解锁]').'；';
                }
                if(!empty($param['ck_hits']) && !empty($param['val_hits_min']) && !empty($param['val_hits_max']) ){
                    $update['live_hits'] = rand($param['val_hits_min'],$param['val_hits_max']);
                    $des .= '&nbsp;人气：'.$update['live_hits'].'；';
                }
                mac_echo($des);
                $res2 = model('Live')->where($where2)->update($update);

            }
            $param['page']++;
            $url = url('live/batch') .'?'. http_build_query($param);
            mac_jump( $url ,3);
            exit;
        }

        $type_tree = model('Type')->getCache('type_tree');
        $this->assign('type_tree',$type_tree);

        $this->assign('title','网址批量操作');
        return $this->fetch('admin@live/batch');
    }

    public function info()
    {
        if (Request()->isPost()) {
          	$yumin= $_SERVER['SERVER_NAME'];  
            $param = input('post.');
          	$lv=db('live')->where('live_id',$param['live_id'])->find();
          	if($lv['live_logo']==$param['live_logo']){
            	$param['live_id']=$lv[''];
            }else{
            	$param['live_logo']='http://'.$yumin.'/'.$param['live_logo'];
            }
            $param['live_content'] = str_replace( $GLOBALS['config']['upload']['protocol'].':','mac:',$param['live_content']);
            $res = model('Live')->saveData($param);
            if($res['code']>1){
                return $this->error($res['msg']);
            }
            return $this->success($res['msg']);
        }

        $id = input('id');
        $where=[];
        $where['live_id'] = ['eq',$id];
        $res = model('Live')->infoData($where);

        $info = $res['info'];
        $this->assign('info',$info);
        $this->assign('live_page_list',$info['live_page_list']);

        $type_tree = model('Type')->getCache('type_tree');
        $this->assign('type_tree',$type_tree);

        $this->assign('title','直播信息');
        return $this->fetch('admin@live/info');
    }

    public function del()
    {
        $param = input();
        $ids = $param['ids'];

        if(!empty($ids)){
            $where=[];
            $where['live_id'] = ['in',$ids];
            $res = model('Live')->delData($where);
            if($res['code']>1){
                return $this->error($res['msg']);
            }
            return $this->success($res['msg']);
        }
        elseif(!empty($param['repeat'])){
            $st = ' not in ';
            if($param['retain']=='max'){
                $st=' in ';
            }
            $sql = 'delete from '.config('database.prefix').'live where live_name in(select name1 from '.config('database.prefix').'tmplive) and live_id '.$st.'(select id1 from '.config('database.prefix').'tmplive)';
            $res = model('Live')->execute($sql);
            if($res===false){
                return $this->success('删除失败');
            }
            return $this->success('删除成功');
        }
        return $this->error('参数错误');
    }

    public function field()
    {
        $param = input();
        $ids = $param['ids'];
        $col = $param['col'];
        $val = $param['val'];
        $start = $param['start'];
        $end = $param['end'];


        if(!empty($ids) && in_array($col,['live_status','live_lock','live_level','live_hits','type_id'])){
            $where=[];
            $where['live_id'] = ['in',$ids];
            $update = [];
            if(empty($start)) {
                $update[$col] = $val;
                if($col == 'type_id'){
                    $type_list = model('Type')->getCache();
                    $id1 = intval($type_list[$val]['type_pid']);
                    $update['type_id_1'] = $id1;
                }
                $res = model('Live')->fieldData($where, $update);
            }
            else{
                if(empty($end)){$end = 9999;}
                $ids = explode(',',$ids);
                foreach($ids as $k=>$v){
                    $val = rand($start,$end);
                    $where['live_id'] = ['eq',$v];
                    $update[$col] = $val;
                    $res = model('Live')->fieldData($where, $update);
                }
            }
            if($res['code']>1){
                return $this->error($res['msg']);
            }
            return $this->success($res['msg']);
        }
        return $this->error('参数错误');
    }

    public function updateToday()
    {
        $param = input();
        $flag = $param['flag'];
        $res = model('Live')->updateToday($flag);
        return json($res);
    }

}
