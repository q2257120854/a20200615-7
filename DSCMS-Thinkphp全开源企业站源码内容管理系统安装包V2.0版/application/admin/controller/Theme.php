<?php

namespace app\admin\controller;

use think\Lang;

class Theme extends AdminControl
{
    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/theme.lang.php');
    }
    
    /**
     * 主题管理
     * @return type
     */
    public function index()
    {
        $themes = list_template('view');
        $theme_list = array();
        foreach ($themes as $theme){
            $theme_list[$theme] = list_style('default',$theme);
        }
        $this->assign('theme_list',$theme_list);
        
        $list_config = rkcache('config', true);
        $this->assign('list_config', $list_config);
        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    /**
     * 更换主题
     */
    function setTemplate()
    {
        $template_name = input('param.template_name');
        $style_name = input('param.style_name');
        if ($template_name && $style_name) {
            $model_config = model('config');
            $update['template_name'] = $template_name;
            $update['style_name'] = $style_name;
            $result = $model_config->updateConfig($update);
            dkcache('config');
            if ($result) {
                $this->log(lang('ds_edit') . lang('ds_admin_group') . '[' . input('post.template_name') . ']');
                ds_json_encode(10000, lang('edit_succ'));
            }else{
                ds_json_encode(10001, lang('edit_fail'));
            }
        }else{
            ds_json_encode(10001, lang('param_error'));
        }
    }

    /**
     * 获取栏目列表,针对控制器下的栏目
     * @return array
     */
    protected function getAdminItemList()
    {
        $menu_array = array(
            array(
                'name' => 'theme',
                'text' => lang('theme_template'),
                'url' => url('Theme/index')
            ),
        );

        return $menu_array;
    }
}