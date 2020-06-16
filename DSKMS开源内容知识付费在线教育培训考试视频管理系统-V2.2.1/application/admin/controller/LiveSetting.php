<?php

/**
 * 商品管理
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
class LiveSetting extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/live_setting.lang.php');
    }

    public function index() {
        $config_model = model('config');
        if (!request()->isPost()) {
            $list_config = rkcache('config', true);
            $this->assign('list_config', $list_config);
            $this->setAdminCurItem('index');
            return $this->fetch();
        } else {
            $update_array=array();
            $update_array['instant_message_gateway_url'] = input('param.instant_message_gateway_url');
            $update_array['instant_message_register_url'] = input('param.instant_message_register_url');
            $update_array['instant_message_verify'] = input('param.instant_message_verify');
            $update_array['live_push_domain'] = input('param.live_push_domain');
            $update_array['live_push_key'] = input('param.live_push_key');
            $update_array['live_play_domain'] = input('param.live_play_domain');
            $result = $config_model->editConfig($update_array);
            if ($result) {
                dkcache('config');
                $this->log(lang('ds_edit') . lang('live_setting'), 1);
                $this->success(lang('ds_common_save_succ'));
            } else {
                $this->log(lang('ds_edit') . lang('live_setting'), 0);
            }
        }
    }
    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'index',
                'text' => lang('ds_setting'),
                'url' => url('LiveSetting/setting')
            ),
        );
        return $menu_array;
    }

}

?>
