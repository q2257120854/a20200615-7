<?php

/**
 * 商品管理
 */

namespace app\admin\controller;

use think\Lang;
use TencentCloud\Common\Credential;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Live\V20180801\LiveClient;
use TencentCloud\Live\V20180801\Models\DropLiveStreamRequest;
use TencentCloud\Live\V20180801\Models\DescribeLiveStreamStateRequest;
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
class LiveApply extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/live_apply.lang.php');
    }

    /**
     * 商品管理
     */
    public function index() {
        $live_apply_model = model('live_apply');

        /**
         * 查询条件
         */
        $where = array();

        $live_apply_state = input('param.live_apply_state');
        if (in_array($live_apply_state, array('0', '1', '2'))) {
            $where['live_apply_state'] = $live_apply_state;
        }

        $live_apply_list = $live_apply_model->getLiveApplyList($where, '*', 10, 'live_apply_state asc,live_apply_id desc');
        $store_model = model('store');
        $store_list = array();
        foreach ($live_apply_list as $key => $val) {
            $live_apply_list[$key]['live_apply_user_name'] = '';
            switch ($val['live_apply_user_type']) {
                case 3:
                    if (!isset($store_list[$val['live_apply_user_id']])) {
                        $store_list[$val['live_apply_user_id']] = $store_model->getStoreInfo(array('store_id' => $val['live_apply_user_id']));
                    }
                    $live_apply_list[$key]['live_apply_user_name'] = $store_list[$val['live_apply_user_id']]['store_name'];
                    break;
            }
        }
        $this->assign('live_apply_list', $live_apply_list);
        $this->assign('show_page', $live_apply_model->page_info->render());



        $this->assign('search', $where);

        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    /**
     * 删除商品
     */
    public function del() {
        $live_apply_id = input('param.live_apply_id');
        $live_apply_id_array = ds_delete_param($live_apply_id);
        if ($live_apply_id_array == FALSE) {
            ds_json_encode('10001', lang('ds_common_op_fail'));
        }
        $condition = array();
        $condition['live_apply_id'] = array('in', $live_apply_id_array);
        model('live_apply')->delLiveApply($condition);
        $this->log(lang('ds_del') . '直播' . ' ID:' . implode('、', $live_apply_id_array), 1);
        ds_json_encode('10000', lang('ds_common_op_succ'));
    }

    /**
     * 审核商品
     */
    public function view() {
        $live_apply_id = input('param.live_apply_id');
        $live_apply_model = model('live_apply');
        $live_apply_info = $live_apply_model->getLiveApplyInfo(array('live_apply_id' => $live_apply_id));
        if (!$live_apply_info) {
            $this->error('直播不存在');
        }
        if (request()->isPost()) {


            $live_apply_model = model('live_apply');
            $data = array(
                'live_apply_end_time' => strtotime(input('param.live_apply_end_time')),
                'live_apply_video' => input('param.live_apply_video'),
            );
            if (!$data['live_apply_end_time']) {
                $this->error('请设置过期时间');
            }

            if ($live_apply_info['live_apply_state'] == 0) {
                if (intval(input('param.verify_state')) == 0) {
                    $state = 2;
                    $remark = input('param.verify_reason');
                    if ($remark) {
                        $store_ids = $live_apply_model->where(array('live_apply_user_type' => 3, 'live_apply_id' => $live_apply_id))->column('live_apply_user_id');
                        if ($store_ids) {
                            $store_model = model('store');
                            $store_list = $store_model->getStoreList(array('store_id' => array('in', $store_ids)));
                            if ($store_list) {
                                $education_notice_model = model('education_notice');
                                foreach ($store_list as $store) {
                                    $param = array();
                                    $param['code'] = 'live_apply_verify';
                                    $param['store_id'] = $store['store_id'];
                                    $param['param'] = array(
                                        'remark' => $remark,
                                        'live_apply_id' => $live_apply_id
                                    );
                                    $param['weixin_param'] = array(
                                        'url' => config('h5_site_url').'/seller/live_apply_list',
                                        'data'=>array(
                                            "keyword1" => array(
                                                "value" => $live_apply_info['live_apply_remark'],
                                                "color" => "#333"
                                            ),
                                            "keyword2" => array(
                                                "value" => $remark,
                                                "color" => "#333"
                                            )
                                        ),
                                    );
                                    \mall\queue\QueueClient::push('sendStoremsg', $param);
            
                                }
                            }
                        }
                    }
                } else {
                    $state = 1;
                    //生成小程序码
                    model('wechat')->getOneWxconfig();
                    $a = model('wechat')->getMiniProCode($live_apply_id, 'pages/livepush/livepush');
                    if (@imagecreatefromstring($a) == false) {
                        $a = json_decode($a);
                        $this->error('生成直播小程序码失败：' . $a->errmsg);
                    } else {
                        if (is_dir(BASE_UPLOAD_PATH . DS . ATTACH_LIVE_APPLY) || (!is_dir(BASE_UPLOAD_PATH . DS . ATTACH_LIVE_APPLY) && mkdir(BASE_UPLOAD_PATH . DS . ATTACH_LIVE_APPLY, 0755, true))) {
                            file_put_contents(BASE_UPLOAD_PATH . DS . ATTACH_LIVE_APPLY . DS . $live_apply_id . '.png', $a);
                        } else {
                            $this->error('生成直播小程序码失败：没有权限生成目录');
                        }
                    }
                }
                $data['live_apply_state'] = $state;
            }
            $live_apply_model->editLiveApply($data, array('live_apply_id' => $live_apply_id));
            $this->log(lang('ds_verify') . '直播' . ' ID:' . $live_apply_id, 1);
            dsLayerOpenSuccess(lang('ds_common_op_succ'));
        } else {
            if (!config('live_push_domain')) {
                $this->error('未设置推流域名');
            }
            if (!config('live_push_key')) {
                $this->error('未设置推流key');
            }
            if (!config('live_play_domain')) {
                $this->error('未设置拉流域名');
            }
            //判断当前流状态
            $live_apply_info['active'] = false;
            if ($live_apply_info['live_apply_state'] == 1) {
                try {

                    $cred = new Credential(config('vod_tencent_secret_id'), config('vod_tencent_secret_key'));
                    $httpProfile = new HttpProfile();
                    $httpProfile->setEndpoint("live.tencentcloudapi.com");

                    $clientProfile = new ClientProfile();
                    $clientProfile->setHttpProfile($httpProfile);
                    $client = new LiveClient($cred, "", $clientProfile);

                    $req = new DescribeLiveStreamStateRequest();

                    $params = '{"AppName":"live","DomainName":"' . config('live_push_domain') . '","StreamName":"' . 'live_apply_' . $live_apply_info['live_apply_id'] . '"}';
                    $req->fromJsonString($params);


                    $resp = $client->DescribeLiveStreamState($req);
                } catch (TencentCloudSDKException $e) {
                    $this->error($e->getMessage());
                }
                if ($resp->StreamState == 'active') {
                    $live_apply_info['active'] = true;
                    //生成播放地址
                    $live_apply_info['live_apply_play_url'] = model('live_apply')->getPlayUrl(config('live_play_domain'), 'live_apply_' . $live_apply_info['live_apply_id']);
                }
            }



            $this->assign('live_apply_info', $live_apply_info);
            echo $this->fetch('view');
        }
    }

    public function close() {
        $live_apply_id = input('param.live_apply_id');
        $live_apply_model = model('live_apply');
        $live_apply = $live_apply_model->getLiveApplyInfo(array('live_apply_id' => $live_apply_id));
        if (!$live_apply) {
            ds_json_encode(10001, '直播不存在');
        }
        try {

            $cred = new Credential(config('vod_tencent_secret_id'), config('vod_tencent_secret_key'));
            $httpProfile = new HttpProfile();
            $httpProfile->setEndpoint("live.tencentcloudapi.com");

            $clientProfile = new ClientProfile();
            $clientProfile->setHttpProfile($httpProfile);
            $client = new LiveClient($cred, "", $clientProfile);

            $req = new DropLiveStreamRequest();

            $params = '{"AppName":"live","DomainName":"'.config('live_push_domain').'","StreamName":"'.'live_apply_' . $live_apply['live_apply_id'].'"}';
            $req->fromJsonString($params);


            $resp = $client->DropLiveStream($req);

        } catch (TencentCloudSDKException $e) {
            ds_json_encode(10001, $e->getMessage());
        }
        $this->log('直播断流' . ' ID:' . $live_apply_id, 1);
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
                'url' => url('LiveApply/index')
            ),
        );
        return $menu_array;
    }

}

?>
