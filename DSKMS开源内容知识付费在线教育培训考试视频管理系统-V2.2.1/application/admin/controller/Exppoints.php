<?php
/**
 * 经验值管理
 */
namespace app\admin\controller;
use think\Lang;
/**
 * ============================================================================
 * DSMall多用户商城
 * ============================================================================
 * 版权所有 2014-2028 长沙德尚网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.csdeshang.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * 控制器
 */
class  Exppoints extends AdminControl
{
    const EXPORT_SIZE = 5000;
    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/membergrade.lang.php');
    }
    /**
     * 设置经验值获取规则
     */
    public function expsetting() {
        $config_model = model('config');
        if (request()->isPost()) {
            $exp_arr = array();
            $exp_arr['exp_login'] = intval(input('post.exp_login'));
            $exp_arr['exp_comments'] = intval(input('post.exp_comments'));
            $exp_arr['exp_orderrate'] = intval(input('post.exp_orderrate'));
            $exp_arr['exp_ordermax'] = intval(input('post.exp_ordermax'));
            $result = $config_model->editConfig(array('exppoints_rule' => serialize($exp_arr)));
            if ($result === true) {
                $this->log(lang('ds_edit') . lang('ds_exppoints_manage') . lang('ds_exppoints_setting'), 1);
                dsLayerOpenSuccess(lang('ds_common_save_succ'));
            } else {
                $this->error(lang('ds_common_save_fail'));
            }
        } else {
            $list_setting = $config_model->getOneConfigByCode('exppoints_rule');
            $list_setting = unserialize($list_setting['value']);
            $this->assign('list_setting', $list_setting);
            return $this->fetch();
        }
    }

    /**
     * 积分日志列表
     */
    public function index(){
        $where = array();
        $search_mname = trim(input('param.mname'));
        if(!empty($search_mname)){
            $where['explog_membername'] = array('like',"%{$search_mname}%");
        }
        if (input('param.stage')){
            $where['explog_stage'] = trim(input('param.stage'));
        }
        $stime = input('param.stime')?strtotime(input('param.stime')):0;
        $etime = input('param.etime')?strtotime(input('param.etime')):0;
        if ($stime > 0 && $etime>0){
            $where['explog_addtime'] = array('between',array($stime,$etime));
        }elseif ($stime > 0){
            $where['explog_addtime'] = array('egt',$stime);
        }elseif ($etime > 0){
            $where['explog_addtime'] = array('elt',$etime);
        }
        $search_desc = trim(input('param.description'));
        if(!empty($search_desc)){
            $where['explog_desc'] = array('like',"%".$search_desc."%");
        }
        

        //查询积分日志列表
        $exppoints_model = model('exppoints');
        $list_log = $exppoints_model->getExppointslogList($where, '*', 20, 'explog_id desc');
        //信息输出
        
        $this->assign('stage_arr',$exppoints_model->getExppointsStage());
        $this->assign('show_page',$exppoints_model->page_info->render());
        $this->assign('list_log',$list_log);
        $this->setAdminCurItem('explog');
        return $this->fetch();
    }



    /**
     * 积分日志列表导出
     */
    public function export_step1(){
        $where = array();
        $search_mname = trim(input('param.mname'));
        $where['explog_membername'] = array('like',"%{$search_mname}%");
        if (input('param.stage')){
            $where['explog_stage'] = trim(input('param.stage'));
        }
        $stime = input('param.stime')?strtotime(input('param.stime')):0;
        $etime = input('param.etime')?strtotime(input('param.etime')):0;
        if ($stime > 0 && $etime>0){
            $where['explog_addtime'] = array('between',array($stime,$etime));
        }elseif ($stime > 0){
            $where['explog_addtime'] = array('egt',$stime);
        }elseif ($etime > 0){
            $where['explog_addtime'] = array('elt',$etime);
        }
        $search_desc = trim(input('param.description'));
        $where['explog_desc'] = array('like',"%$search_desc%");

        //查询积分日志列表
        $exppoints_model = model('exppoints');
        $list_log = $exppoints_model->getExppointslogList($where, '*', self::EXPORT_SIZE,  'explog_id desc');
        if (!is_numeric(input('param.curpage'))){
            $count = $exppoints_model->getExppointslogCount($where);
            $export_list = array();
            if ($count > self::EXPORT_SIZE ){	//显示下载链接
                $page = ceil($count/self::EXPORT_SIZE);
                for ($i=1;$i<=$page;$i++){
                    $limit1 = ($i-1)*self::EXPORT_SIZE + 1;
                    $limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
                    $export_list[$i] = $limit1.' ~ '.$limit2 ;
                }
                $this->assign('export_list',$export_list);
                return $this->fetch('/public/excel');
            }else{	//如果数量小，直接下载
                $this->createExcel($list_log);
            }
        }else{	//下载
            $this->createExcel($list_log);
        }
    }

    /**
     * 生成excel
     *
     * @param array $data
     */
    private function createExcel($data = array()){
        Lang::load(APP_PATH .'admin/lang/'.config('default_lang').'/export.lang.php');
        $excel_obj = new \excel\Excel();
        $excel_data = array();
        //设置样式
        $excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
        //header
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'会员名称');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'经验值');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'添加时间');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'操作阶段');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'描述');
        $stage_arr = model('exppoints')->getExppointsStage();
        foreach ((array)$data as $k=>$v){
            $tmp = array();
            $tmp[] = array('data'=>$v['explog_membername']);
            $tmp[] = array('format'=>'Number','data'=>ds_price_format($v['explog_points']));
            $tmp[] = array('data'=>date('Y-m-d H:i:s',$v['explog_addtime']));
            $tmp[] = array('data'=>$stage_arr[$v['explog_stage']]);
            $tmp[] = array('data'=>$v['explog_desc']);
            $excel_data[] = $tmp;
        }
        $excel_data = $excel_obj->charset($excel_data,CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset('经验值明细',CHARSET));
        $excel_obj->generateXML($excel_obj->charset('经验值明细',CHARSET).input('param.curpage').'-'.date('Y-m-d-H',TIMESTAMP));
    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'explog',
                'text' => '经验值明细',
                'url' =>  url('Exppoints/index')
            ),
            array(
                'name' => 'expset',
                'text' => '规则设置',
                'url' =>  "javascript:dsLayerOpen('".url('Exppoints/expsetting')."','规则设置')"
            ),
        );
        return $menu_array;
    }
}