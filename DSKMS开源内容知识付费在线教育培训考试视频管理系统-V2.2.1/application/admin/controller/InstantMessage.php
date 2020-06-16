<?php

/**
 * 商品管理
 */

namespace app\admin\controller;

use think\Lang;
use GatewayClient\Gateway;
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
class InstantMessage extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/instant_message.lang.php');
    }

    /**
     * 商品管理
     */
    public function index() {
        $instant_message_model = model('instant_message');

        /**
         * 查询条件
         */
        $where = array();

        $instant_message_verify = input('param.instant_message_verify');
        if (in_array($instant_message_verify, array('0', '1', '2'))) {
            $where['instant_message_verify'] = $instant_message_verify;
        }

        $instant_message_list = $instant_message_model->getInstantMessageList($where, 10);

        $this->assign('instant_message_list', $instant_message_list);
        $this->assign('show_page', $instant_message_model->page_info->render());



        $this->assign('search', $where);
        if(!config('instant_message_gateway_url')){
            $this->error('未设置直播聊天gateway地址');
        }
        if(!config('instant_message_register_url')){
            $this->error('未设置直播聊天register地址');
        }
        $this->assign('instant_message_url',config('instant_message_gateway_url'));
        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    public function join(){
      $msg='';
        $client_id=input('param.client_id');
        if(!config('instant_message_register_url')){
            ds_json_encode(10001, '未设置直播聊天gateway地址');
        }
        require_once ROOT_PATH.'/GatewayWorker/vendor/workerman/gatewayclient/Gateway.php';
        // 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值(ip不能是0.0.0.0)
        try{
        Gateway::$registerAddress = config('instant_message_register_url');
        // client_id与uid绑定
        Gateway::bindUid($client_id, '-1');
        }catch(\Exception $e){
          ds_json_encode(10001, $e->getMessage());
        }
        ds_json_encode(10000, $msg);
    }
    /**
     * 删除商品
     */
    public function del() {
        $instant_message_id = input('param.instant_message_id');
        $instant_message_id_array = ds_delete_param($instant_message_id);
        if ($instant_message_id_array == FALSE) {
            ds_json_encode('10001', lang('ds_common_op_fail'));
        }
        $condition = array();
        $condition['instant_message_id'] = array('in', $instant_message_id_array);
        model('instant_message')->delInstantMessage($condition);
        $this->log(lang('ds_del') . '聊天' . ' ID:' . implode('、', $instant_message_id_array), 1);
        ds_json_encode('10000', lang('ds_common_op_succ'));
    }

    /**
     * 审核商品
     */
    public function view() {
        $instant_message_id_array = ds_delete_param(input('param.instant_message_id'));
        if ($instant_message_id_array == FALSE) {
            ds_json_encode(10001, lang('param_error'));
        }
        $instant_message_model = model('instant_message');
        $instant_message_list = $instant_message_model->getInstantMessageList(array('instant_message_verify' => 0, 'instant_message_id' => array('in', $instant_message_id_array)));
        if (!$instant_message_list) {
            ds_json_encode(10001, '聊天不存在');
        }


        if (intval(input('param.verify_state')) == 0) {
            $instant_message_model->editInstantMessage(array('instant_message_verify' => 2), array('instant_message_verify' => 0, 'instant_message_id' => array('in', $instant_message_id_array)));
        } else {
            foreach ($instant_message_list as $instant_message_info) {
                $instant_message_model->startTrans();
                try {
                    //立即发送
                    $res = $instant_message_model->sendInstantMessage($instant_message_info);
                    if (!$res['code']) {
                        exception($res['msg']);
                    }
                } catch (\Exception $ex) {
                    $instant_message_model->rollback();
                    ds_json_encode(10001, $e->getMessage());
                }
                $instant_message_model->commit();
            }
        }

        $this->log(lang('ds_verify') . '聊天' . ' ID:' . implode('、', $instant_message_id_array), 1);
        ds_json_encode(10000, lang('ds_common_op_succ'));
    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'index',
                'text' => lang('ds_list'),
                'url' => url('InstantMessage/index')
            ),
        );
        return $menu_array;
    }

}

?>
