<?php

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
class EditablePage extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/editable_page.lang.php');
        Lang::load(APP_PATH . 'home/lang/' . config('default_lang') . '.php');
    }

    /**
     * 页面列表
     */
    public function page_list() {
        $editable_page_path = input('param.editable_page_path','special/index');
        $editable_page_item_id = intval(input('param.editable_page_item_id'));
        $temp = explode(',', input('param.editable_page_param'));
        $editable_page_param = array();
        $type=input('param.type','pc');
        
        $keyword=input('param.editable_page_name');
        
        $condition=array();
        if($keyword){
            $condition['editable_page_name']=array('like','%'.$keyword.'%');
        }
        $this->assign('filtered',empty($condition)?0:1);
        if(!in_array($type, array('pc','h5'))){
            $type='pc';
        }
        foreach ($temp as $t) {
            if($t){
                $v = explode('|', $t);
                $editable_page_param[$v[0]] = $v[1];
            }
        }
        if (!in_array($editable_page_path, array('special/index','index/index', 'activity/detail'))) {
            $this->error(lang('param_error'));
        }
        $this->assign('editable_page_path', $editable_page_path);
        $this->assign('editable_page_item_id', $editable_page_item_id);

        $editable_page_model = model('editable_page');
        $condition= array_merge(array('editable_page_client'=>$type,'editable_page_path' => $editable_page_path, 'editable_page_item_id' => $editable_page_item_id),$condition);
        $editable_page_list = $editable_page_model->getEditablePageList($condition, 10);
        foreach ($editable_page_list as $key => $val) {
            $temp1 = $temp2 = $editable_page_param;
            $temp1['editable_page_id'] = $val['editable_page_id'];
            $temp2['special_id'] = $val['editable_page_id'];
            if($val['editable_page_client']=='pc'){
                $editable_page_list[$key]['edit_url'] = url('home/' . $editable_page_path, $temp1);
                $editable_page_list[$key]['view_url'] = url('home/' . $editable_page_path, $temp2);
            }else{
                $editable_page_list[$key]['edit_url'] = url('EditablePage/mobile_page_setting',array('editable_page_id'=>$val['editable_page_id']));
                $mobile_page=$editable_page_path;
                switch($editable_page_path){
                    case 'special/index':
                        $mobile_page='home/special';
                        break;
                }
                $editable_page_list[$key]['view_url'] = config('h5_site_url').'/'.$mobile_page.'?'.http_build_query($temp2);
            }
        }
        
        $this->assign('show_page', $editable_page_model->page_info->render());
        $this->assign('editable_page_list', $editable_page_list);
        $this->setAdminCurItem($type.'_page_list');
        return $this->fetch();
    }

    /**
     * 新增页面
     */
    public function page_add() {
        $editable_page_path = input('param.editable_page_path','special/index');
        $editable_page_item_id = intval(input('param.editable_page_item_id'));
        if (!in_array($editable_page_path, array('special/index','index/index', 'activity/detail'))) {
            $this->error(lang('param_error'));
        }
        $editable_page_model = model('editable_page');
        if (!request()->isPost()) {
            return $this->fetch('page_form');
        } else {
            $result = $editable_page_model->addEditablePage(array(
                'editable_page_name' => input('post.editable_page_name'),
                'editable_page_path' => $editable_page_path,
                'editable_page_item_id' => $editable_page_item_id,
                'editable_page_client' => input('post.editable_page_client'),
                'editable_page_theme' => 'style_1',
                'editable_page_edit_time' => TIMESTAMP,
                'editable_page_theme_config' => json_encode(array(
                    'back_color' => input('param.back_color')
                ))
            ));
            if ($result) {
                $this->log(lang('ds_add') . lang('editable_page') . '[flex_' . $result . ':' . input('post.editable_page_name') . ']', null);
                dsLayerOpenSuccess(lang('ds_common_op_succ'));
            } else {
                $this->error(lang('ds_common_op_fail'));
            }
        }
    }

    /**
     * 设置手机端页面
     */
    public function mobile_page_setting(){
        $this->setAdminCurItem('mobile_page_setting');
        return $this->fetch('mobile_page_setting');
    }
    
    public function mobile_page_view() {
        //获取配置列表
        $editable_page_id = intval(input('param.editable_page_id'));
        $editable_page_model = model('editable_page');
        $editable_page = $editable_page_model->getOneEditablePage(array('editable_page_id' => $editable_page_id));
        if (!$editable_page) {
            $this->error(lang('param_error'));
        }
        $editable_page['if_edit'] = 1;
        $editable_page['editable_page_theme_config'] = json_decode($editable_page['editable_page_theme_config'], true);
        $this->assign('editable_page',$editable_page);
        $data = $editable_page_model->getEditablePageConfigByPageId($editable_page_id);
        $this->assign('editable_page_config_list', $data['editable_page_config_list']);
        return $this->fetch('mobile_page_view');
    }

    /**
     * 编辑页面
     */
    public function page_edit() {
        $editable_page_id = intval(input('param.editable_page_id'));

        $editable_page_model = model('editable_page');
        $editable_page_info = $editable_page_model->getOneEditablePage(array('editable_page_id' => $editable_page_id));
        if (!$editable_page_info) {
            $this->error(lang('param_error'));
        }
        $editable_page_info['editable_page_theme_config'] = json_decode($editable_page_info['editable_page_theme_config'], true);
        if (!request()->isPost()) {
            $this->assign('editable_page', $editable_page_info);
            return $this->fetch('page_form');
        } else {
            $result = $editable_page_model->editEditablePage(array('editable_page_id' => $editable_page_id), array(
                'editable_page_name' => input('post.editable_page_name'),
                'editable_page_theme_config' => json_encode(array(
                    'back_color' => input('param.back_color')
                ))
            ));
            if ($result) {
                $this->log(lang('ds_edit') . lang('editable_page') . '[' . $editable_page_info['editable_page_name'] . ']', null);
                dsLayerOpenSuccess(lang('ds_common_op_succ'));
            } else {
                $this->error(lang('ds_common_op_fail'));
            }
        }
    }

    /**
     * 删除页面
     */
    public function page_del() {
        $editable_page_id = intval(input('param.editable_page_id'));

        $editable_page_model = model('editable_page');
        $editable_page_info = $editable_page_model->getOneEditablePage(array('editable_page_id' => $editable_page_id));
        if (!$editable_page_info) {
            ds_json_encode(10001, lang('param_error'));
        }
        if (!$editable_page_model->delEditablePage($editable_page_id)) {
            ds_json_encode(10001, lang('ds_common_op_fail'));
        }
        $this->log(lang('ds_del') . lang('editable_page') . '[flex_' . $editable_page_info['editable_page_id'] . ':' . $editable_page_info['editable_page_name'] . ']', null);
        ds_json_encode(10000, lang('ds_common_del_succ'));
    }

    private function updatePage($data) {
        //更新页面编辑时间
        model('editable_page')->editEditablePage(array('editable_page_id' => $data['editable_page_id']), array('editable_page_edit_time' => TIMESTAMP));
        //日志
        $this->log(lang('ds_update').lang('editable_page_model') . '[' . $data['editable_page_config_id'] . ']', null);
        if (isset($data['editable_page_config_content']['goods'])) {
            $data['goods_list'] = array();
            foreach ($data['editable_page_config_content']['goods'] as $key => $val) {
                $data['goods_list'][$key] = model('editable_page_config')->getEditablePageConfigGoods($val);
                
                foreach ($data['goods_list'][$key] as $i => $goods) {
                    $data['goods_list'][$key][$i]['goods_image_url'] = goods_thumb($goods, 240);
                }
            }
        }
        if(isset($data['editable_page_config_content']['cate'])){
          $data['cate_list'] = array();
          foreach ($data['editable_page_config_content']['cate'] as $key => $val) {
            $data['cate_list'][$key] = model('editable_page_config')->getEditablePageConfigCate($val,$data['editable_page_model_id']);
          }
          
                
        }
        if(isset($data['editable_page_config_content']['brand'])){
          $data['brand_list'] = array();
          foreach ($data['editable_page_config_content']['brand'] as $key => $val) {
            $data['brand_list'][$key] = model('editable_page_config')->getEditablePageConfigBrand($val);
          }
          
                
        }
        return $data;
    }

    /**
     * 新增模块
     */
    public function model_add() {
        $page_id = intval(input('param.editable_page_id'));
        if (!$page_id) {
            ds_json_encode(10001, lang('param_error'));
        }
        $editable_page_model = model('editable_page');
        $editable_page = $editable_page_model->getOneEditablePage(array('editable_page_id' => $page_id));
        if (!$editable_page) {
            ds_json_encode(10001, lang('param_error'));
        }
        $model_id = intval(input('param.model_id'));
        $type=input('param.type','pc');
        if (!$model_id) {
            $editable_page_model_list = model('editable_page_model')->getEditablePageModelList(array('editable_page_path' => array('in', array('', '|' . $editable_page['editable_page_path'] . '|')), 'editable_page_model_client' => array('in', array('', $type)), 'editable_page_theme' => array('in', array('', '|' . $editable_page['editable_page_theme'] . '|'))));
            $this->assign('editable_page_model_list', $editable_page_model_list);
            echo $this->fetch('model_add');exit;
        } else {

            $config_id = intval(input('param.config_id'));

      
            $editable_page_config_model = model('editable_page_config');
            $editable_page_model_model = model('editable_page_model');
            //测试start
//            $model_id=15;
//            $editable_page_model_model->addEditablePageModel(array(
//              'editable_page_model_id'=>$model_id,
//              'editable_page_model_name'=>'商品排行',
//              'editable_page_model_intro'=>'',
//              'editable_page_model_client'=>'h5',
//              'editable_page_model_content'=>json_encode(array(
//              'back_color'=>'unset',
//              'margin_top'=>'0',
//              'margin_bottom'=>'0',
//              'goods'=>array(array('count'=>10,'gc_id'=>0,'sort'=>'new','if_fix'=>0,'goods_id'=>array())),
//              )),
//            ));
            //测试end
            $editable_page_model_info = $editable_page_model_model->getOneEditablePageModel(array('editable_page_model_id' => $model_id));
            if (!$editable_page_model_info) {
                ds_json_encode(10001, lang('editable_page_model_not_exist'));
            }
            $sort = 255;
            if ($config_id) {
                trace('model_add@step0@'.$page_id.':'. var_export(db('editable_page_config')->field('editable_page_config_id,editable_page_config_sort_order')->where('editable_page_id',$page_id)->select(),true),'debug');
                $editable_page_config_info = $editable_page_config_model->getOneEditablePageConfig(array('editable_page_config_id' => $config_id));
                if ($editable_page_config_info) {
                
                $old_sort = $editable_page_config_info['editable_page_config_sort_order'];
                $sort = $old_sort;
                //上一个排序是否和现在的排序一样
                $prev_sort = db('editable_page_config')->where(array('editable_page_id' => $page_id, 'editable_page_config_sort_order' => array('<',$old_sort)))->order('editable_page_config_sort_order desc')->value('editable_page_config_sort_order');
                if ($prev_sort) {
                    $sort = intval(($old_sort + $prev_sort) / 2);
                }
                if ($old_sort != $sort) {
                    $editable_page_config_model->editEditablePageConfig(array('editable_page_id' => $page_id, 'editable_page_config_sort_order' => $old_sort, 'editable_page_config_id' => array('<=', $config_id)), array('editable_page_config_sort_order' => $sort));
                    trace('model_add@step1@old:'.$old_sort.',new:'.$sort.'@'.$page_id.':'. var_export(db('editable_page_config')->field('editable_page_config_id,editable_page_config_sort_order')->where('editable_page_id',$page_id)->select(),true),'debug');
                } else {
                    $next_sort = db('editable_page_config')->where(array('editable_page_id' => $page_id, 'editable_page_config_sort_order' => array('>',$old_sort)))->order('editable_page_config_sort_order asc')->value('editable_page_config_sort_order');
                    if($next_sort){
                        $sort=intval(($old_sort + $next_sort) / 2);
                        if($old_sort != $sort){
                            $editable_page_config_model->editEditablePageConfig(array('editable_page_id' => $page_id, 'editable_page_config_sort_order' => $old_sort, 'editable_page_config_id' => array('>', $config_id)), array('editable_page_config_sort_order' => $sort));
                            trace('model_add@step2@old:'.$old_sort.',new:'.$sort.'@'.$page_id.':'. var_export(db('editable_page_config')->field('editable_page_config_id,editable_page_config_sort_order')->where('editable_page_id',$page_id)->select(),true),'debug');
                        }else{
                            $sort=$next_sort;
                            try{
                                $this->setSort($page_id, $config_id, $next_sort);
                                trace('model_add@step3@old:'.$old_sort.',new:'.$sort.'@'.$page_id.':'. var_export(db('editable_page_config')->field('editable_page_config_id,editable_page_config_sort_order')->where('editable_page_id',$page_id)->select(),true),'debug');
                            } catch (\Exception $e){
                                ds_json_encode(10001, $e->getMessage());
                            }
                        }
                    }
                    
                }
                }

            }
            if($type=='h5'){
                $editable_page_model_info['editable_page_model_content']=str_replace('1200px', '100%', $editable_page_model_info['editable_page_model_content']);
            }
            $data = array(
                'editable_page_id' => $page_id,
                'editable_page_config_sort_order' => $sort,
                'editable_page_model_id' => $model_id,
                'editable_page_config_content' => $editable_page_model_info['editable_page_model_content'],
            );
            $new_config_id = $editable_page_config_model->addEditablePageConfig($data);
            $data['editable_page_config_id'] = $new_config_id;
            $data['editable_page_config_content'] = json_decode($data['editable_page_config_content'], true);

            
            $data=$this->updatePage($data);
            $this->assign('page_config',$data);
            ds_json_encode(10000,'',array('config_id'=>$data['editable_page_config_id'],'model_html'=>$this->fetch('../../home/view/default/base/editable_page_model/'.($type=='h5'?'h5_':'').$model_id)));
        }
    }

    public function model_del() {
        if (!model('editable_page_config')->delEditablePageConfig(array('editable_page_id' => intval(input('param.editable_page_id')), 'editable_page_config_id' => intval(input('param.config_id'))))) {
            ds_json_encode(10001, lang('ds_common_op_fail'));
        } else {
            ds_json_encode(10000);
        }
    }

    public function model_move() {
        $config_id = intval(input('param.config_id'));
        $direction = intval(input('param.direction'));
        if (!$config_id) {
            ds_json_encode(10001, lang('param_error'));
        }
        $editable_page_config_model = model('editable_page_config');
        $editable_page_config_info = $editable_page_config_model->getOneEditablePageConfig(array('editable_page_config_id' => $config_id));
        if (!$editable_page_config_info) {
            ds_json_encode(10001, lang('param_error'));
        }
        $old_sort = $editable_page_config_info['editable_page_config_sort_order'];
        
        if($direction){//下移
            $temp=db('editable_page_config')->where('editable_page_id='.$editable_page_config_info['editable_page_id'].' AND ((editable_page_config_sort_order='.$editable_page_config_info['editable_page_config_sort_order'].' AND editable_page_config_id>'.$config_id.') OR (editable_page_config_sort_order>'.$editable_page_config_info['editable_page_config_sort_order'].'))')->order('editable_page_config_sort_order asc')->find();
            if(!$temp){
                ds_json_encode(10001, lang('param_error'));
            }
            $move_config_id_1=$temp['editable_page_config_id'];
            $move_config_id_2=$editable_page_config_info['editable_page_config_id'];
        }else{
            $temp=db('editable_page_config')->where('editable_page_id='.$editable_page_config_info['editable_page_id'].' AND ((editable_page_config_sort_order='.$editable_page_config_info['editable_page_config_sort_order'].' AND editable_page_config_id<'.$config_id.') OR (editable_page_config_sort_order<'.$editable_page_config_info['editable_page_config_sort_order'].'))')->order('editable_page_config_sort_order desc,editable_page_config_id desc')->find();
            if(!$temp){
                ds_json_encode(10001, lang('param_error'));
            }
            $move_config_id_1=$editable_page_config_info['editable_page_config_id'];
            $move_config_id_2=$temp['editable_page_config_id'];
        }
        trace('model_move@step0@'.$editable_page_config_info['editable_page_id'].':'. var_export(db('editable_page_config')->field('editable_page_config_id,editable_page_config_sort_order')->where('editable_page_id',$editable_page_config_info['editable_page_id'])->select(),true),'debug');
        if($temp['editable_page_config_sort_order']!=$editable_page_config_info['editable_page_config_sort_order']){
            $flag = model('editable_page_config')->editEditablePageConfig(array('editable_page_config_id' => $temp['editable_page_config_id']), array('editable_page_config_sort_order' => $editable_page_config_info['editable_page_config_sort_order']));
            if (!$flag) {
                ds_json_encode(10001, lang('model_sort_fail'));
            }
            $flag = model('editable_page_config')->editEditablePageConfig(array('editable_page_config_id' => $editable_page_config_info['editable_page_config_id']), array('editable_page_config_sort_order' => $temp['editable_page_config_sort_order']));
            if (!$flag) {
                ds_json_encode(10001, lang('model_sort_fail'));
            }
            trace('model_move@step1@model1:'.$temp['editable_page_config_id'].',model2:'.$editable_page_config_info['editable_page_config_id'].'@'.$editable_page_config_info['editable_page_id'].':'. var_export(db('editable_page_config')->field('editable_page_config_id,editable_page_config_sort_order')->where('editable_page_id',$editable_page_config_info['editable_page_id'])->select(),true),'debug');
        }else{
            //上一个排序
            $prev_sort = db('editable_page_config')->where(array('editable_page_id' => $editable_page_config_info['editable_page_id'], 'editable_page_config_sort_order' => array('<',$editable_page_config_info['editable_page_config_sort_order'])))->order('editable_page_config_sort_order desc')->value('editable_page_config_sort_order');
            $prev_sort=intval($prev_sort);
            $sort=intval(($prev_sort+$editable_page_config_info['editable_page_config_sort_order'])/2);
            if($sort!=$prev_sort){
                db('editable_page_config')->where('editable_page_id='.$editable_page_config_info['editable_page_id'].' AND editable_page_config_sort_order='.$editable_page_config_info['editable_page_config_sort_order'].' AND (editable_page_config_id='.$move_config_id_1.' OR editable_page_config_id<'.$move_config_id_2.')')->update(array('editable_page_config_sort_order' => $sort));
            }else{
                $next_sort = db('editable_page_config')->where(array('editable_page_id' => $editable_page_config_info['editable_page_id'], 'editable_page_config_sort_order' => array('>',$editable_page_config_info['editable_page_config_sort_order'])))->order('editable_page_config_sort_order asc')->value('editable_page_config_sort_order');
                if($next_sort){
                    $sort=intval(($next_sort+$editable_page_config_info['editable_page_config_sort_order'])/2);
                }else{
                    $sort=$editable_page_config_info['editable_page_config_sort_order']+1;
                }
                db('editable_page_config')->where('editable_page_id='.$editable_page_config_info['editable_page_id'].' AND editable_page_config_sort_order='.$editable_page_config_info['editable_page_config_sort_order'].' AND (editable_page_config_id='.$move_config_id_2.' OR editable_page_config_id>'.$move_config_id_1.')')->update(array('editable_page_config_sort_order' => $sort));
            }
            trace('model_move@step2@prev:'.$prev_sort.',new:'.$sort.(isset($next_sort)?(',next:'.$next_sort):'').'@'.$editable_page_config_info['editable_page_id'].':'. var_export(db('editable_page_config')->field('editable_page_config_id,editable_page_config_sort_order')->where('editable_page_id',$editable_page_config_info['editable_page_id'])->select(),true),'debug');
        }

        ds_json_encode(10000);
    }

    private function setSort($page_id, $config_id, $sort) {
        $next_sort = db('editable_page_config')->where(array('editable_page_id' => $page_id, 'editable_page_config_sort_order' => array('>', $sort)))->order('editable_page_config_sort_order asc')->lock(true)->value('editable_page_config_sort_order');
        if ($next_sort == ($sort + 1)) {
            $this->setSort($page_id, $config_id, $next_sort);
        } else {
            $next_sort = $sort + 1;
        }
        $flag = model('editable_page_config')->editEditablePageConfig(array('editable_page_id' => $page_id, 'editable_page_config_sort_order' => $sort, 'editable_page_config_id' => array('>', $config_id)), array('editable_page_config_sort_order' => $next_sort));
        if (!$flag) {
//            exception(lang('model_sort_fail'));
        }
    }

    /**
     * 编辑模块
     */
    public function model_edit() {
        $config_id = intval(input('param.config_id'));
        if (!$config_id) {
            ds_json_encode(10001, lang('param_error'));
        }
        $editable_page_config_model = model('editable_page_config');
        $editable_page_config_info = $editable_page_config_model->getOneEditablePageConfig(array('editable_page_config_id' => $config_id));
        if (!$editable_page_config_info) {
            ds_json_encode(10001, lang('editable_page_config_not_exist'));
        }
        $config_info = json_decode($editable_page_config_info['editable_page_config_content'], true);
        if (!request()->isPost()) {
            $this->assign('base_config', $config_info);
            $this->assign('model_type', $editable_page_config_info['editable_page_model_id']);
            echo $this->fetch('model_edit');exit;
        } else {
            $config_info = $this->getBaseConfig($editable_page_config_info['editable_page_model_id'], $config_info);

            if (!$editable_page_config_model->editEditablePageConfig(array('editable_page_config_id' => $config_id), array('editable_page_config_content' => json_encode($config_info)))) {
                ds_json_encode(10001, lang('ds_common_op_fail'));
            }
            $editable_page_config_info['editable_page_config_content'] = $config_info;
            
            $editable_page_config_info=$this->updatePage($editable_page_config_info);
            $type=input('param.type','pc');
            $this->assign('page_config',$editable_page_config_info);
            ds_json_encode(10000,'',array('config_id'=>$editable_page_config_info['editable_page_config_id'],'model_html'=>$this->fetch('../../home/view/default/base/editable_page_model/'.($type=='h5'?'h5_':'').$editable_page_config_info['editable_page_model_id'])));
        }
    }

    private function getBaseConfig($model_id, $config_info) {

        $config_info['back_color'] = input('post.back_color');
        $config_info['margin_top'] = input('post.margin_top');
        $config_info['margin_bottom'] = input('post.margin_bottom');
        switch ($model_id) {
            case 1:
                $config_info['width'] = input('post.width');
                $config_info['height'] = input('post.height');
                $config_info['image'][0]['count'] = $config_info['link'][0]['count'] = intval(input('post.image_count'));
                if($config_info['image'][0]['count']<1){
                  ds_json_encode(10001, lang('param_error'));
                }
                break;
            case 2:
                $config_info['width'] = input('post.width');
                $config_info['height'] = input('post.height');
                break;
            case 3:
            case 5:
            case 6:
                $config_info['goods'][0]['count'] = intval(input('post.goods_count'));
                if($config_info['goods'][0]['count']<1){
                  ds_json_encode(10001, lang('param_error'));
                }
                break;
            case 11:
                $config_info['image'][0]['count'] = $config_info['link'][0]['count'] = intval(input('post.image_count'));
                $config_info['goods'][0]['count'] = intval(input('post.goods_count'));
                if($config_info['image'][0]['count']<1 || $config_info['goods'][0]['count']<1){
                  ds_json_encode(10001, lang('param_error'));
                }
                for($i=0;$i<$config_info['image'][0]['count'];$i++){
                  if(!isset($config_info['goods'][$i])){
                    $config_info['goods'][$i]=$config_info['goods'][0];
                  }
                  $config_info['goods'][$i]['count']=$config_info['goods'][0]['count'];
                }
                $config_info['goods']=array_slice($config_info['goods'],0,$config_info['image'][0]['count']);
                break;
            case 12:
                $config_info['image'][0]['count'] = $config_info['link'][0]['count'] = $config_info['text'][0]['count'] = intval(input('post.image_count'));
                if($config_info['image'][0]['count']<1){
                  ds_json_encode(10001, lang('param_error'));
                }
                break;
            case 13:
                $config_info['text'][1]['count'] = $config_info['link'][1]['count'] = intval(input('post.text_count'));
                if($config_info['text'][1]['count']<1){
                  ds_json_encode(10001, lang('param_error'));
                }
                break;
            case 14:
                $config_info['image'][0]['count'] = intval(input('post.image_count'));
                if($config_info['image'][0]['count']<1){
                  ds_json_encode(10001, lang('param_error'));
                }
                for($i=0;$i<$config_info['image'][0]['count'];$i++){
                  if(!isset($config_info['image'][$i+1])){
                    $config_info['image'][$i+1]=$config_info['image'][1];
                  }
                }
                $config_info['image']=array_slice($config_info['goods'],0,$config_info['image'][0]['count']+1);
                break;
        }
        return $config_info;
    }

    /**
     * 商品模块
     */
    public function model_goods() {
        $config_id = intval(input('param.config_id'));
        $item_id = intval(input('param.item_id'));
        if (!$config_id) {
            ds_json_encode(10001, lang('param_error'));
        }
        $editable_page_config_model = model('editable_page_config');
        $editable_page_config_info = $editable_page_config_model->getOneEditablePageConfig(array('editable_page_config_id' => $config_id));
        if (!$editable_page_config_info) {
            ds_json_encode(10001, lang('editable_page_config_not_exist'));
        }
        $config_info = json_decode($editable_page_config_info['editable_page_config_content'], true);
        if (!isset($config_info['goods']) || !isset($config_info['goods'][$item_id])) {
            ds_json_encode(10001, lang('param_error'));
        }
        $goods_info = $config_info['goods'][$item_id];
        if (!isset($goods_info['gc_id']) || !isset($goods_info['sort']) || !isset($goods_info['if_fix']) || !isset($goods_info['goods_id']) || !is_array($goods_info['goods_id'])) {
            ds_json_encode(10001, lang('param_error'));
        }
        if (!request()->isPost()) {
            $this->assign('goods_info', $goods_info);
            $goods_list = array();
            if ($goods_info['if_fix'] && !empty($goods_info['goods_id'])) {
                $goods_model = model('goods');
                $goods_list = $goods_model->getGoodsOnlineList(array('goods_id' => array('in', $goods_info['goods_id'])));
            }
            $this->assign('goods_list', $goods_list);
            /**
             * 处理商品分类
             */
            $choose_gcid = ($t = intval($goods_info['gc_id'])) > 0 ? $t : 0;
            $gccache_arr = model('goodsclass')->getGoodsclassCache($choose_gcid, 3);
            $this->assign('gc_json', json_encode($gccache_arr['showclass']));
            $this->assign('gc_choose_json', json_encode($gccache_arr['choose_gcid']));

            echo $this->fetch('model_goods');exit;
        } else {
            $sort = input('param.sort');
            if (!in_array($sort, array('new', 'hot', 'good'))) {
                ds_json_encode(10001, lang('param_error'));
            }
            $if_fix = intval(input('param.if_fix'));
            if (!in_array($if_fix, array(0, 1))) {
                ds_json_encode(10001, lang('param_error'));
            }
            $goods_id = input('param.goods_id/a');
            if (!is_array($goods_id)) {
                $goods_id = array();
            }
            $temp = array(
                'gc_id' => intval(input('param.choose_gcid')),
                'sort' => $sort,
                'if_fix' => $if_fix,
                'goods_id' => $goods_id,
            );
            $config_info['goods'][$item_id] = array_merge($config_info['goods'][$item_id],$temp);
            if (!$editable_page_config_model->editEditablePageConfig(array('editable_page_config_id' => $config_id), array('editable_page_config_content' => json_encode($config_info)))) {
                ds_json_encode(10001, lang('ds_common_op_fail'));
            }
            $editable_page_config_info['editable_page_config_content'] = $config_info;  
            $editable_page_config_info=$this->updatePage($editable_page_config_info);
            $type=input('param.type','pc');
            $this->assign('page_config',$editable_page_config_info);
            ds_json_encode(10000,'',array('config_id'=>$editable_page_config_info['editable_page_config_id'],'model_html'=>$this->fetch('../../home/view/default/base/editable_page_model/'.($type=='h5'?'h5_':'').$editable_page_config_info['editable_page_model_id'])));
        }
    }

    /**
     * 店铺模块
     */
    public function model_store() {

        $config_id = intval(input('param.config_id'));
        $item_id = intval(input('param.item_id'));
        if (!$config_id) {
            ds_json_encode(10001, lang('param_error'));
        }
        $editable_page_config_model = model('editable_page_config');
        $editable_page_config_info = $editable_page_config_model->getOneEditablePageConfig(array('editable_page_config_id' => $config_id));
        if (!$editable_page_config_info) {
            ds_json_encode(10001, lang('editable_page_config_not_exist'));
        }
        $config_info = json_decode($editable_page_config_info['editable_page_config_content'], true);
        if (!isset($config_info['store']) || !isset($config_info['store'][$item_id])) {
            ds_json_encode(10001, lang('param_error'));
        }
        $store_info = $config_info['store'][$item_id];
        if (!isset($store_info['storeclass_id']) || !isset($store_info['sort']) || !isset($store_info['if_fix']) || !isset($store_info['store_id']) || !is_array($store_info['store_id'])) {
            ds_json_encode(10001, lang('param_error'));
        }
        if (!request()->isPost()) {
            $this->assign('store_info', $store_info);
            $store_list = array();
            if ($store_info['if_fix'] && !empty($store_info['store_id'])) {
                $store_model = model('store');
                $store_list = $store_model->getStoreOnlineList(array('store_id' => array('in', $store_info['store_id'])));
            }
            $this->assign('store_list', $store_list);

            $storeclass_list = model('storeclass')->getStoreclassList();
            $this->assign('storeclass_list', $storeclass_list);
            echo $this->fetch('model_store');exit;
        } else {
            $sort = input('param.sort');
            if (!in_array($sort, array('grade', 'hot', 'good'))) {
                ds_json_encode(10001, lang('param_error'));
            }
            $if_fix = intval(input('param.if_fix'));
            if (!in_array($if_fix, array(0, 1))) {
                ds_json_encode(10001, lang('param_error'));
            }
            $store_id = input('param.store_id/a');
            if (!is_array($store_id)) {
                $store_id = array();
            }
            $temp = array(
                'storeclass_id' => intval(input('param.storeclass_id')),
                'sort' => $sort,
                'if_fix' => $if_fix,
                'store_id' => $store_id,
            );
            $config_info['store'][$item_id] = array_merge($config_info['store'][$item_id],$temp);
            if (!$editable_page_config_model->editEditablePageConfig(array('editable_page_config_id' => $config_id), array('editable_page_config_content' => json_encode($config_info)))) {
                ds_json_encode(10001, lang('ds_common_op_fail'));
            }
            $editable_page_config_info['editable_page_config_content'] = $config_info;
            $editable_page_config_info=$this->updatePage($editable_page_config_info);
            $type=input('param.type','pc');
            $this->assign('page_config',$editable_page_config_info);
            ds_json_encode(10000,'',array('config_id'=>$editable_page_config_info['editable_page_config_id'],'model_html'=>$this->fetch('../../home/view/default/base/editable_page_model/'.($type=='h5'?'h5_':'').$editable_page_config_info['editable_page_model_id'])));
        }
    }

    /**
     * 搜索店铺
     */
    public function search_store() {
        $store_model = model('store');

        /**
         * 查询条件
         */
        $where = array();
        $search_store_name = trim(input('param.keyword'));
        if ($search_store_name != '') {
            $where['store_name'] = array('like', '%' . $search_store_name . '%');
        }

        $store_list = $store_model->getStoreOnlineList($where, 12);
        $this->assign('store_list', $store_list);
        $this->assign('show_page', $store_model->page_info->render());
        echo $this->fetch('search_store');
        exit;
    }

    /**
     * 代金券模块
     */
    public function model_voucher() {

        $config_id = intval(input('param.config_id'));
        $item_id = intval(input('param.item_id'));
        if (!$config_id) {
            ds_json_encode(10001, lang('param_error'));
        }
        $editable_page_config_model = model('editable_page_config');
        $editable_page_config_info = $editable_page_config_model->getOneEditablePageConfig(array('editable_page_config_id' => $config_id));
        if (!$editable_page_config_info) {
            ds_json_encode(10001, lang('editable_page_config_not_exist'));
        }
        $config_info = json_decode($editable_page_config_info['editable_page_config_content'], true);
        if (!isset($config_info['voucher']) || !isset($config_info['voucher'][$item_id])) {
            ds_json_encode(10001, lang('param_error'));
        }
        $voucher_info = $config_info['voucher'][$item_id];
        if (!isset($voucher_info['price'])) {
            ds_json_encode(10001, lang('param_error'));
        }
        if (!request()->isPost()) {
            $this->assign('voucher_info', $voucher_info);
            $voucher_model = model('voucher');
            $voucherprice_list = $voucher_model->getVoucherpriceList('', 'voucherprice asc');
            $this->assign('voucherprice_list', $voucherprice_list);
            echo $this->fetch('model_voucher');exit;
        } else {

            $temp = array(
                'price' => input('param.price'),
            );
            $config_info['voucher'][$item_id] = array_merge($config_info['voucher'][$item_id],$temp);
            if (!$editable_page_config_model->editEditablePageConfig(array('editable_page_config_id' => $config_id), array('editable_page_config_content' => json_encode($config_info)))) {
                ds_json_encode(10001, lang('ds_common_op_fail'));
            }
            $editable_page_config_info['editable_page_config_content'] = $config_info;
            $editable_page_config_info=$this->updatePage($editable_page_config_info);
            $type=input('param.type','pc');
            $this->assign('page_config',$editable_page_config_info);
            ds_json_encode(10000,'',array('config_id'=>$editable_page_config_info['editable_page_config_id'],'model_html'=>$this->fetch('../../home/view/default/base/editable_page_model/'.($type=='h5'?'h5_':'').$editable_page_config_info['editable_page_model_id'])));
        }
    }

    /**
     * 编辑器模块
     */
    public function model_editor() {
        $config_id = intval(input('param.config_id'));
        $item_id = intval(input('param.item_id'));
        if (!$config_id) {
            ds_json_encode(10001, lang('param_error'));
        }
        $editable_page_config_model = model('editable_page_config');
        $editable_page_config_info = $editable_page_config_model->getOneEditablePageConfig(array('editable_page_config_id' => $config_id));
        if (!$editable_page_config_info) {
            ds_json_encode(10001, lang('editable_page_config_not_exist'));
        }
        $config_info = json_decode($editable_page_config_info['editable_page_config_content'], true);
        if (!isset($config_info['editor']) || !isset($config_info['editor'][$item_id])) {
            ds_json_encode(10001, lang('param_error'));
        }
        $editor_content = $config_info['editor'][$item_id];
        if (!request()->isPost()) {
            $this->assign('editor_content', $editor_content);
            $this->assign('file_upload',model('upload')->getUploadList(array('upload_type'=>7,'item_id'=>$config_id)));
            echo $this->fetch('model_editor');exit;
        } else {
            $config_info['editor'][$item_id] = input('post.editor');
            if (!$editable_page_config_model->editEditablePageConfig(array('editable_page_config_id' => $config_id), array('editable_page_config_content' => json_encode($config_info)))) {
                ds_json_encode(10001, lang('ds_common_op_fail'));
            }
            $config_info['editor'][$item_id] = htmlspecialchars_decode($config_info['editor'][$item_id]);
            $editable_page_config_info['editable_page_config_content'] = $config_info;
            $editable_page_config_info=$this->updatePage($editable_page_config_info);
            $type=input('param.type','pc');
            $this->assign('page_config',$editable_page_config_info);
            ds_json_encode(10000,'',array('config_id'=>$editable_page_config_info['editable_page_config_id'],'model_html'=>$this->fetch('../../home/view/default/base/editable_page_model/'.($type=='h5'?'h5_':'').$editable_page_config_info['editable_page_model_id'])));
        }
    }

    /**
     * 搜索商品
     */
    public function search_goods() {
        $goods_model = model('goods');

        /**
         * 查询条件
         */
        $where = array();
        $search_goods_name = trim(input('param.keyword'));
        if ($search_goods_name != '') {
            $where['goods_name|store_name'] = array('like', '%' . $search_goods_name . '%');
        }

        $goods_list = $goods_model->getGoodsOnlineList($where, '*', 12);
        $this->assign('goods_list', $goods_list);
        $this->assign('show_page', $goods_model->page_info->render());
        echo $this->fetch('search_goods');
        exit;
    }

    /**
     * 搜索商品
     */
    public function model_brand() {
        $config_id = intval(input('param.config_id'));
        $item_id = intval(input('param.item_id'));
        if (!$config_id) {
            ds_json_encode(10001, lang('param_error'));
        }
        $editable_page_config_model = model('editable_page_config');
        $editable_page_config_info = $editable_page_config_model->getOneEditablePageConfig(array('editable_page_config_id' => $config_id));
        if (!$editable_page_config_info) {
            ds_json_encode(10001, lang('editable_page_config_not_exist'));
        }
        $config_info = json_decode($editable_page_config_info['editable_page_config_content'], true);
        if (!isset($config_info['brand']) || !isset($config_info['brand'][$item_id])) {
            ds_json_encode(10001, lang('param_error'));
        }
        $brand_info = $config_info['brand'][$item_id];
        if (!isset($brand_info['gc_id']) || !isset($brand_info['if_fix']) || !isset($brand_info['brand_id']) || !is_array($brand_info['brand_id'])) {
            ds_json_encode(10001, lang('param_error'));
        }
        if (!request()->isPost()) {
            $this->assign('brand_info', $brand_info);
            $brand_list = array();
            if ($brand_info['if_fix'] && !empty($brand_info['brand_id'])) {
                $brand_model = model('brand');
                $brand_list = $brand_model->getBrandList(array('brand_id' => array('in', $brand_info['brand_id'])));
            }
            $this->assign('brand_list', $brand_list);
            /**
             * 处理商品分类
             */
            $choose_gcid = ($t = intval($brand_info['gc_id'])) > 0 ? $t : 0;
            $gccache_arr = model('goodsclass')->getGoodsclassCache($choose_gcid, 3);
            $this->assign('gc_json', json_encode($gccache_arr['showclass']));
            $this->assign('gc_choose_json', json_encode($gccache_arr['choose_gcid']));
            echo $this->fetch('model_brand');exit;
        } else {

            $if_fix = intval(input('param.if_fix'));
            if (!in_array($if_fix, array(0, 1))) {
                ds_json_encode(10001, lang('param_error'));
            }
            $brand_id = input('param.brand_id/a');
            if (!is_array($brand_id)) {
                $brand_id = array();
            }
            $temp = array(
                'gc_id' => intval(input('param.choose_gcid')),
                'if_fix' => $if_fix,
                'brand_id' => $brand_id,
            );
            $config_info['brand'][$item_id] = array_merge($config_info['brand'][$item_id],$temp);
            $config_info['brand'][$item_id]['list'] = $this->array_msort($brand_id, array('sort' => SORT_ASC));
            if (!$editable_page_config_model->editEditablePageConfig(array('editable_page_config_id' => $config_id), array('editable_page_config_content' => json_encode($config_info)))) {
                ds_json_encode(10001, lang('ds_common_op_fail'));
            }
            $editable_page_config_info['editable_page_config_content'] = $config_info;
            $editable_page_config_info=$this->updatePage($editable_page_config_info);
            $type=input('param.type','pc');
            $this->assign('page_config',$editable_page_config_info);
            ds_json_encode(10000,'',array('config_id'=>$editable_page_config_info['editable_page_config_id'],'model_html'=>$this->fetch('../../home/view/default/base/editable_page_model/'.($type=='h5'?'h5_':'').$editable_page_config_info['editable_page_model_id'])));
        }
    }

    /**
     * 商品分类模块
     */
    public function model_cate() {
        $config_id = intval(input('param.config_id'));
        $item_id = intval(input('param.item_id'));
        if (!$config_id) {
            ds_json_encode(10001, lang('param_error'));
        }
        $editable_page_config_model = model('editable_page_config');
        $editable_page_config_info = $editable_page_config_model->getOneEditablePageConfig(array('editable_page_config_id' => $config_id));
        if (!$editable_page_config_info) {
            ds_json_encode(10001, lang('editable_page_config_not_exist'));
        }
        $config_info = json_decode($editable_page_config_info['editable_page_config_content'], true);
        if (!isset($config_info['cate']) || !isset($config_info['cate'][$item_id])) {
            ds_json_encode(10001, lang('param_error'));
        }
        $cate_info = $config_info['cate'][$item_id];
        if (!isset($cate_info['gc_id']) || !isset($cate_info['list']) || !is_array($cate_info['list'])) {
            ds_json_encode(10001, lang('param_error'));
        }
        if (!request()->isPost()) {
            $this->assign('cate_info', $cate_info);

            /**
             * 处理商品分类
             */
            $choose_gcid = ($t = intval($cate_info['gc_id'])) > 0 ? $t : 0;
            $gccache_arr = model('goodsclass')->getGoodsclassCache($choose_gcid, 3);
            $this->assign('gc_json', json_encode($gccache_arr['showclass']));
            $this->assign('gc_choose_json', json_encode($gccache_arr['choose_gcid']));
            echo $this->fetch('model_cate');exit;
        } else {

            $cate_id = input('param.cate_id/a');
            if (!is_array($cate_id)) {
                $cate_id = array();
            }
            $temp = array(
                'gc_id' => intval(input('param.choose_gcid')),
                'list' => $cate_id,
            );
            $config_info['cate'][$item_id] = array_merge($config_info['cate'][$item_id],$temp);
            $config_info['cate'][$item_id]['list'] = $this->array_msort($cate_id, array('sort' => SORT_ASC));
            if (!$editable_page_config_model->editEditablePageConfig(array('editable_page_config_id' => $config_id), array('editable_page_config_content' => json_encode($config_info)))) {
                ds_json_encode(10001, lang('ds_common_op_fail'));
            }
            $editable_page_config_info['editable_page_config_content'] = $config_info;
            $editable_page_config_info=$this->updatePage($editable_page_config_info);
            $type=input('param.type','pc');
            $this->assign('page_config',$editable_page_config_info);
            ds_json_encode(10000,'',array('config_id'=>$editable_page_config_info['editable_page_config_id'],'model_html'=>$this->fetch('../../home/view/default/base/editable_page_model/'.($type=='h5'?'h5_':'').$editable_page_config_info['editable_page_model_id'])));
        }
    }

    /**
     * 搜索品牌
     */
    public function search_brand() {
        $brand_model = model('brand');
        /**
         * 查询条件
         */
        $where = array('brand_apply' => 1);
        $search_brand_name = trim(input('param.keyword'));
        if ($search_brand_name != '') {
            $where['brand_name'] = array('like', '%' . $search_brand_name . '%');
        }

        $brand_list = $brand_model->getBrandList($where, '*', 12);
        $this->assign('brand_list', $brand_list);
        $this->assign('show_page', $brand_model->page_info->render());
        echo $this->fetch('search_brand');
        exit;
    }

    /**
     * 文字模块
     */
    public function model_text() {
        $config_id = intval(input('param.config_id'));
        $item_id = intval(input('param.item_id'));
        if (!$config_id) {
            ds_json_encode(10001, lang('param_error'));
        }
        $editable_page_config_model = model('editable_page_config');
        $editable_page_config_info = $editable_page_config_model->getOneEditablePageConfig(array('editable_page_config_id' => $config_id));
        if (!$editable_page_config_info) {
            ds_json_encode(10001, lang('editable_page_config_not_exist'));
        }
        $config_info = json_decode($editable_page_config_info['editable_page_config_content'], true);
        if (!isset($config_info['text']) || !isset($config_info['text'][$item_id]) || !isset($config_info['text'][$item_id]['count']) || !isset($config_info['text'][$item_id]['list'])) {
            ds_json_encode(10001, lang('param_error'));
        }
        $text_info = $config_info['text'][$item_id];
        if (!request()->isPost()) {
            $this->assign('text_info', $text_info);
            $this->assign('editable_type', 'text');
            echo $this->fetch('model_text');exit;
        } else {
            $text_list = input('post.text/a');
            if (!is_array($text_list) || empty($text_list)) {
                ds_json_encode(10001, lang('param_error'));
            }
//            $sort = array_column($text_list, 'sort');
//            array_multisort($sort, SORT_ASC, $text_list);
            $config_info['text'][$item_id]['list'] = $this->array_msort($text_list, array('sort' => SORT_ASC));
            if (!$editable_page_config_model->editEditablePageConfig(array('editable_page_config_id' => $config_id), array('editable_page_config_content' => json_encode($config_info)))) {
                ds_json_encode(10001, lang('ds_common_op_fail'));
            }
            $editable_page_config_info['editable_page_config_content'] = $config_info;
            $editable_page_config_info=$this->updatePage($editable_page_config_info);
            $type=input('param.type','pc');
            $this->assign('page_config',$editable_page_config_info);
            ds_json_encode(10000,'',array('config_id'=>$editable_page_config_info['editable_page_config_id'],'model_html'=>$this->fetch('../../home/view/default/base/editable_page_model/'.($type=='h5'?'h5_':'').$editable_page_config_info['editable_page_model_id'])));
        }
    }

    /**
     * 链接模块
     */
    public function model_link() {
        $config_id = intval(input('param.config_id'));
        $item_id = intval(input('param.item_id'));
        if (!$config_id) {
            ds_json_encode(10001, lang('param_error'));
        }
        $editable_page_config_model = model('editable_page_config');
        $editable_page_config_info = $editable_page_config_model->getOneEditablePageConfig(array('editable_page_config_id' => $config_id));
        if (!$editable_page_config_info) {
            ds_json_encode(10001, lang('editable_page_config_not_exist'));
        }
        $config_info = json_decode($editable_page_config_info['editable_page_config_content'], true);
        if (!isset($config_info['link']) || !isset($config_info['link'][$item_id]) || !isset($config_info['link'][$item_id]['count']) || !isset($config_info['link'][$item_id]['list'])) {
            ds_json_encode(10001, lang('param_error'));
        }
        $link_info = $config_info['link'][$item_id];
        if (!request()->isPost()) {
            $this->assign('text_info', $link_info);
            $this->assign('editable_type', 'link');
            echo $this->fetch('model_text');exit;
        } else {
            $link_list = input('post.text/a');
            if (!is_array($link_list) || empty($link_list)) {
                ds_json_encode(10001, lang('param_error'));
            }
//            $sort = array_column($link_list, 'sort');
//            array_multisort($sort, SORT_ASC, $link_list);
            $config_info['link'][$item_id]['list'] = $this->array_msort($link_list, array('sort' => SORT_ASC));
            if (!$editable_page_config_model->editEditablePageConfig(array('editable_page_config_id' => $config_id), array('editable_page_config_content' => json_encode($config_info)))) {
                ds_json_encode(10001, lang('ds_common_op_fail'));
            }
            $editable_page_config_info['editable_page_config_content'] = $config_info;
            $editable_page_config_info=$this->updatePage($editable_page_config_info);
            $type=input('param.type','pc');
            $this->assign('page_config',$editable_page_config_info);
            ds_json_encode(10000,'',array('config_id'=>$editable_page_config_info['editable_page_config_id'],'model_html'=>$this->fetch('../../home/view/default/base/editable_page_model/'.($type=='h5'?'h5_':'').$editable_page_config_info['editable_page_model_id'])));
        }
    }

    /**
     * 图片模块
     */
    public function model_image() {
        $config_id = intval(input('param.config_id'));
        $item_id = intval(input('param.item_id'));
        if (!$config_id) {
            ds_json_encode(10001, lang('param_error'));
        }
        $editable_page_config_model = model('editable_page_config');
        $editable_page_config_info = $editable_page_config_model->getOneEditablePageConfig(array('editable_page_config_id' => $config_id));
        if (!$editable_page_config_info) {
            ds_json_encode(10001, lang('editable_page_config_not_exist'));
        }
        $config_info = json_decode($editable_page_config_info['editable_page_config_content'], true);
        if (!isset($config_info['image']) || !isset($config_info['image'][$item_id]) || !isset($config_info['image'][$item_id]['count']) || !isset($config_info['image'][$item_id]['list'])) {
            ds_json_encode(10001, lang('param_error'));
        }
        $image_info = $config_info['image'][$item_id];
        if (!request()->isPost()) {
            $this->assign('image_info', $image_info);
            echo $this->fetch('model_image');exit;
        } else {
            $image_list = input('post.img/a');
            if (!is_array($image_list) || empty($image_list)) {
                ds_json_encode(10001, lang('param_error'));
            }
//            $sort = array_column($image_list, 'sort');
//            array_multisort($sort, SORT_ASC, $image_list);
            $config_info['image'][$item_id]['list'] = $this->array_msort($image_list, array('sort' => SORT_ASC));
            if (!$editable_page_config_model->editEditablePageConfig(array('editable_page_config_id' => $config_id), array('editable_page_config_content' => json_encode($config_info)))) {
                ds_json_encode(10001, lang('ds_common_op_fail'));
            }
            $editable_page_config_info['editable_page_config_content'] = $config_info;
            $editable_page_config_info=$this->updatePage($editable_page_config_info);
            $type=input('param.type','pc');
            $this->assign('page_config',$editable_page_config_info);
            ds_json_encode(10000,'',array('config_id'=>$editable_page_config_info['editable_page_config_id'],'model_html'=>$this->fetch('../../home/view/default/base/editable_page_model/'.($type=='h5'?'h5_':'').$editable_page_config_info['editable_page_model_id'])));
        }
    }

    public function image_del() {
        $file_id = intval(input('param.upload_id'));
        $upload_model = model('upload');
        /**
         * 删除图片
         */
        $file_array = $upload_model->getOneUpload($file_id);
        @unlink(BASE_UPLOAD_PATH . DS . ATTACH_EDITABLE_PAGE . DS . $file_array['file_name']);
        /**
         * 删除信息
         */
        $condition = array();
        $condition['upload_id'] = $file_id;
        $upload_model->delUpload($condition);
        ds_json_encode(10000);
    }

    /**
     * 图片上传
     */
    public function image_upload() {
        $file_name = '';
        $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_EDITABLE_PAGE . DS;
        $file_object = request()->file(input('param.name'));
        if ($file_object) {
            $info = $file_object->rule('uniqid')->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file);
            if ($info) {
                $file_name = $info->getFilename();
            } else {
                ds_json_encode(10001, $file_object->getError());
            }
        } else {
            ds_json_encode(10001, lang('param_error'));
        }
        /**
         * 模型实例化
         */
        $upload_model = model('upload');
        /**
         * 图片数据入库
         */
        $insert_array = array();
        $insert_array['file_name'] = $file_name;
        $insert_array['upload_type'] = '7';
        $insert_array['file_size'] = $_FILES[input('param.name')]['size'];
        $insert_array['item_id'] = intval(input('param.config_id'));
        $insert_array['upload_time'] = TIMESTAMP;
        $result = $upload_model->addUpload($insert_array);
        if ($result) {
            $data = array();
            $data['file_id'] = $result;
            $data['file_name'] = $file_name;
            $data['file_path'] = UPLOAD_SITE_URL . '/' . ATTACH_EDITABLE_PAGE . '/' . $file_name;
            /**
             * 整理为json格式
             */
            ds_json_encode(10000, '', $data);
        }
    }

    /**
     * 多维数组排序（多用于文件数组数据）
     *
     * @param array $array
     * @param array $cols
     * @return array
     *
     * e.g. $data = array_msort($data, array('sort_order'=>SORT_ASC, 'add_time'=>SORT_DESC));
     */
    private function array_msort($array, $cols) {
        $colarr = array();
        foreach ($cols as $col => $order) {
            $colarr[$col] = array();
            foreach ($array as $k => $row) {
                $colarr[$col]['_' . $k] = strtolower($row[$col]);
            }
        }
        $eval = 'array_multisort(';
        foreach ($cols as $col => $order) {
            $eval .= '$colarr[\'' . $col . '\'],' . $order . ',';
        }
        $eval = substr($eval, 0, -1) . ');';
        eval($eval);
        $ret = array();
        foreach ($colarr as $col => $arr) {
            foreach ($arr as $k => $v) {
                $k = substr($k, 1);
                if (!isset($ret[$k]))
                    $ret[$k] = $array[$k];
                $ret[$k][$col] = $array[$k][$col];
            }
        }
        return $ret;
    }

    /**
     * 菜单列表
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'pc_page_list',
                'text' => 'pc'.lang('ds_list'),
                'url' => url('EditablePage/page_list'),
            ),
            array(
                'name' => 'h5_page_list',
                'text' => 'h5'.lang('ds_list'),
                'url' => url('EditablePage/page_list',array('type'=>'h5')),
            ),
            array(
                'name' => 'page_add',
                'text' => lang('ds_new'),
                'url' => "javascript:dsLayerOpen('" . url('EditablePage/page_add', ['editable_page_path' => input('param.editable_page_path','special/index'), 'editable_page_item_id' => input('param.editable_page_item_id')]) . "','" . lang('ds_new') . "')",
            ),
        );
        if(request()->action()=='mobile_page_setting'){
            $menu_array[]=array(
                'name' => 'mobile_page_setting',
                'text' => lang('mobile_page_setting'),
                'url' => 'javascript:void(0)',
            );
            $menu_array[0]['url']=$menu_array[1]['url']='javascript:history.go(-1)';
        }
        return $menu_array;
    }

}

?>
