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
class Special extends BaseMall {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/special.lang.php');
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/editable_page.lang.php');
    }

    public function index() {
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
        

        $page_id=intval(input('param.special_id'));

        if($page_id){
            $temp = $editable_page_model->getOneEditablePage(array('editable_page_id' => $page_id));
            if ($temp) {
                $editable_page= array_merge($editable_page,$temp);
                $editable_page['editable_page_theme_config']= json_decode($editable_page['editable_page_theme_config'],true);
                //获取可编辑模块
                $data=$editable_page_model->getEditablePageConfigByPageId($page_id);
                $this->assign('editable_page_config_list',$data['editable_page_config_list']);
            }else{
                $this->error(lang('param_error'));
            }
        }
        if(!$editable_page['editable_page_id']){
            $this->error(lang('param_error'));
        }
        $this->assign('editable_page',$editable_page);
//var_export(json_decode('{"back_color":"unset","margin_top":"0","margin_bottom":"0","image":[{"count":1,"list":[]},{"count":1,"list":[]},{"count":1,"list":[]}],"cate":[{"gc_id":0,"list":[]}],"link":{"1":{"count":1,"list":[]},"2":{"count":1,"list":[]}},"text":[{"count":2,"list":[]}],"goods":[{"count":6,"gc_id":0,"sort":"new","if_fix":0,"goods_id":[]}],"brand":[{"count":10,"gc_id":0,"if_fix":0,"brand_id":[]}]}',true));
        return $this->fetch($this->template_dir.'index');
    }
    

}

?>
