<?php

namespace app\home\controller;

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
class Activity extends BaseMall {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/activity.lang.php');
    }
    
    /*
     * 显示所有活动列表
     */
    function index()
    {
        $condition = array();
        $activity_model = model('activity');
        $condition['activity_type'] = 1;
        $condition['activity_startdate'] = array('elt',TIMESTAMP);
        $condition['activity_enddate'] = array('egt',TIMESTAMP);
        $condition['activity_state'] = 1;
        
        $activity_list = $activity_model->getActivityList($condition, 10);
        $this->assign('activity_list', $activity_list);
        $this->assign('show_page', $activity_model->page_info->render());
        $this->assign('html_title', config('site_name') . ' - '.lang('activity_list'));
        return $this->fetch($this->template_dir.'activity_index');
    }
    

    /**
     * 单个活动信息页
     */
    public function detail() {
        $editable_page_id=intval(input('param.editable_page_id'));
        $editable_page_model=model('editable_page');
        if($editable_page_id){
            if(!session('admin_id','','admin')){
                $this->error('Hacking Attempt');
            }
            
            $editable_page=$editable_page_model->getOneEditablePage(array('editable_page_id'=>$editable_page_id));
            if(!$editable_page){
                $this->error(lang('param_error'));
            }
            $editable_page['if_edit']=1;
            $editable_page['editable_page_theme_config']= json_decode($editable_page['editable_page_theme_config'],true);
            //获取可编辑模块

            $data=$editable_page_model->getEditablePageConfigByPageId($editable_page_id);
            $this->assign('editable_page_config_list',$data['editable_page_config_list']);
            
//            $editable_page_model_list=model('editable_page_model')->getEditablePageModelList(array('editable_page_path'=>array('in',array('','|activity/detail|')),'editable_page_model_client'=>array('in',array('','pc')),'editable_page_theme'=>array('in',array('','|'.$editable_page['editable_page_theme'].'|'))));
//            $this->assign('editable_page_model_list',$editable_page_model_list);
        }else{
            $editable_page=array(
                'if_edit'=>0,
                'editable_page_theme'=>'',
                'editable_page_id'=>0,
            );
        }
        
        //得到导航ID
        $nav_id = intval(input('param.nav_id'));
        $this->assign('index_sign', $nav_id);
        //查询活动信息
        $activity_id = intval(input('param.activity_id'));
        if ($activity_id <= 0) {
            $this->error(lang('param_error')); //'缺少参数:活动编号'
        }
        $activity = model('activity')->getOneActivityById($activity_id);
        if (empty($activity) || $activity['activity_type'] != '1' || $activity['activity_state'] != 1 || $activity['activity_startdate'] > TIMESTAMP || $activity['activity_enddate'] < TIMESTAMP) {
            $this->error(lang('activity_index_activity_not_exists')); //'指定活动并不存在'
        }
        $theme=$activity['activity_style'];
        $page_id=intval(input('param.special_id'));
        if(!$page_id){
            if(strpos($theme,'flex_')===0){
                $page_id=intval(substr($theme,5));
            }
        }
        if($page_id){
            $temp = $editable_page_model->getOneEditablePage(array('editable_page_id' => $page_id));
            if ($temp) {
                $editable_page= array_merge($editable_page,$temp);
                $editable_page['editable_page_theme_config']= json_decode($editable_page['editable_page_theme_config'],true);
                //获取可编辑模块
                $data=$editable_page_model->getEditablePageConfigByPageId($page_id);
                $this->assign('editable_page_config_list',$data['editable_page_config_list']);
            }
        }
        
        $this->assign('editable_page',$editable_page);
        $this->assign('activity', $activity);
        //查询活动内容信息
        $condition = array();
        $condition['activitydetail.activity_id'] = $activity_id;
        $condition['activitydetail.activitydetail_state'] = "1";
        $activitydetail_list = model('activitydetail')->getActivitydetailAndGoodsList($condition);
        $this->assign('activitydetail_list', $activitydetail_list);
        $this->assign('html_title', config('site_name') . ' - ' . $activity['activity_title']);
        return $this->fetch($this->template_dir.'activity_show');
    }
    

}

?>
