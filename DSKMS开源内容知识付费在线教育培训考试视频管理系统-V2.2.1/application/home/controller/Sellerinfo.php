<?php

namespace app\home\controller;
use think\Lang;/**
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
class  Sellerinfo extends BaseSeller
{
    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/sellerinfo.lang.php');
    }
    /**
     * 机构信息
     */
    public function index()
    {
        $store_model = model('store');
        $storebindclass_model = model('storebindclass');
        $storeclass_model = model('storeclass');
        $storegrade_model = model('storegrade');

        // 机构信息
        $store_info = $store_model->getStoreInfoByID(session('store_id'));
        $this->assign('store_info', $store_info);

        // 机构分类信息
        $store_class_info = $storeclass_model->getStoreclassInfo(array('storeclass_id' => $store_info['storeclass_id']));
        $this->assign('store_class_name', $store_class_info['storeclass_name']);

        // 机构等级信息
        $store_grade_info = $storegrade_model->getOneStoregrade($store_info['grade_id']);
        $this->assign('store_grade_name', $store_grade_info['storegrade_name']);

        $storejoinin_model = model('storejoinin');
        $joinin_detail = $storejoinin_model->getOneStorejoinin(array('member_id' => $store_info['member_id']));
        $this->assign('joinin_detail', $joinin_detail);

        $store_bind_class_list = $storebindclass_model->getStorebindclassList(array(
                                                                                    'store_id' => session('store_id'),
                                                                                    'storebindclass_state' => array('in', array(1, 2))
                                                                                ), null);
        $goods_class = model('goodsclass')->getGoodsclassIndexedListAll();
           for ($i = 0, $j = count($store_bind_class_list); $i < $j; $i++) {
               $store_bind_class_list[$i]['class_1_name'] = @$goods_class[$store_bind_class_list[$i]['class_1']]['gc_name'];
               $store_bind_class_list[$i]['class_2_name'] = @$goods_class[$store_bind_class_list[$i]['class_2']]['gc_name'];
               $store_bind_class_list[$i]['class_3_name'] = @$goods_class[$store_bind_class_list[$i]['class_3']]['gc_name'];
           }
        $this->assign('store_bind_class_list', $store_bind_class_list);

        $this->setSellerCurMenu('sellerinfo');
        $this->setSellerCurItem('index');

        return $this->fetch($this->template_dir.'index');
    }

    /**
     * 经营类目列表
     */
    public function bind_class()
    {

        $storebindclass_model = model('storebindclass');

        $store_bind_class_list = $storebindclass_model->getStorebindclassList(array('store_id' => session('store_id')), null);
        $goods_class = model('goodsclass')->getGoodsclassIndexedListAll();
        for ($i = 0, $j = count($store_bind_class_list); $i < $j; $i++) {
            $store_bind_class_list[$i]['class_1_name'] = @$goods_class[$store_bind_class_list[$i]['class_1']]['gc_name'];
            $store_bind_class_list[$i]['class_2_name'] = @$goods_class[$store_bind_class_list[$i]['class_2']]['gc_name'];
            $store_bind_class_list[$i]['class_3_name'] = @$goods_class[$store_bind_class_list[$i]['class_3']]['gc_name'];
        }
        $this->assign('bind_list', $store_bind_class_list);

        $this->setSellerCurMenu('sellerinfo');
        $this->setSellerCurItem('bind_class');
        return $this->fetch($this->template_dir.'bind_class_index');
    }

    /**
     * 申请新的经营类目
     */
    public function bind_class_add()
    {
        $goodsclass_model = model('goodsclass');
        $gc_list = $goodsclass_model->getGoodsclassListByParentId(0);
        $this->assign('gc_list', $gc_list);

        $this->setSellerCurMenu('sellerinfo');
        $this->setSellerCurItem('bind_class');
        return $this->fetch($this->template_dir.'bind_class_add');
    }

    /**
     * 申请新经营类目保存
     */
    public function bind_class_save()
    {
        if (!request()->isPost())
            exit();
        $goods_class_array = input('post.goods_class');#获取数组
        if (preg_match('/^[\d,]+$/', $goods_class_array)) {
            @list($class_1, $class_2, $class_3) = explode(',', trim($goods_class_array));
        }
        else {
            ds_json_encode(10001,lang('ds_common_save_fail'));
        }

        $storebindclass_model = model('storebindclass');

        $param = array();
        $param['store_id'] = session('store_id');
        $param['storebindclass_state'] = 0;
        $param['class_1'] = $class_1;
        $last_gc_id = $class_1;
        if (!empty($class_2)) {
            $param['class_2'] = $class_2;
            $last_gc_id = $class_2;
        }
        if (!empty($class_3)) {
            $param['class_3'] = $class_3;
            $last_gc_id = $class_3;
        }

        // 检查类目是否已经存在
        $store_bind_class_info = $storebindclass_model->getStorebindclassInfo($param);
        if (!empty($store_bind_class_info)) {
            ds_json_encode(10001,'该类目已经存在');
        }

        //取分佣比例
        $goods_class_info = model('goodsclass')->getGoodsclassInfoById($last_gc_id);
        $param['commis_rate'] = $goods_class_info['commis_rate'];
        $result = $storebindclass_model->addStorebindclass($param);

        if ($result) {
            ds_json_encode(10000,'申请成功，请等待系统审核');
        }
        else {
            ds_json_encode(10001,lang('ds_common_save_fail'));
        }
    }

    /**
     * 删除申请的经营类目
     */
    public function bind_class_del()
    {
        $condition = array();
        $condition['storebindclass_id'] = intval(input('param.bid'));
        $condition['store_id'] = session('store_id');
        $condition['storebindclass_state'] = 0;
        $del = model('storebindclass')->delStorebindclass($condition);
        if ($del) {
            ds_json_encode(10000,lang('ds_common_del_succ'));
        }
        else {
            ds_json_encode(10001,lang('ds_common_del_fail'));
        }
    }

    /**
     * 机构续签
     */
    public function reopen()
    {
        $storereopen_model = model('storereopen');
        $reopen_list = $storereopen_model->getStorereopenList(array('storereopen_store_id' => session('store_id')));
        $this->assign('reopen_list', $reopen_list);

        $store_info = $this->store_info;
        if (intval($store_info['store_endtime']) > 0) {
            $store_info['store_endtime_text'] = date('Y-m-d', $store_info['store_endtime']);
            $reopen_time = $store_info['store_endtime'] - 3600 * 24 + 1 - TIMESTAMP;
            if (!check_platform_store() && $store_info['store_endtime'] - TIMESTAMP >= 0 && $reopen_time < 2592000) {
                //(<30天)
                $store_info['reopen'] = true;
            }
            $store_info['allow_applay_date'] = $store_info['store_endtime'] - 2592000;
        }

        if (!empty($reopen_list)) {
            $last = reset($reopen_list);
            $store_endtime = $store_info['store_endtime'];
            if (!check_platform_store() && $store_endtime - TIMESTAMP < 2592000 && $store_endtime - TIMESTAMP >= 0) {
                //(<30天)
                $store_info['reopen'] = true;
            }
            else {
                $store_info['reopen'] = false;
            }
        }
        $this->assign('store_info', $store_info);

        //机构等级
        $grade_list = rkcache('storegrade', true);

        $this->assign('grade_list', $grade_list);

        //默认选中当前级别
        $this->assign('current_grade_id', session('grade_id'));

        //如果存在有未上传凭证或审核中的信息，则不能再申请续签
        $condition = array();
        $condition['storereopen_state'] = array('in', array(0, 1));
        $condition['storereopen_store_id'] = session('store_id');
        $reopen_info = $storereopen_model->getStorereopenInfo($condition);
        if ($reopen_info) {
            if ($reopen_info['storereopen_state'] == '0') {
                $this->assign('upload_cert', true);
                $this->assign('reopen_info', $reopen_info);
            }
        }
        else {
            $this->assign('applay_reopen', isset($store_info['reopen']) ? true : false);
        }

        $this->setSellerCurMenu('sellerinfo');
        $this->setSellerCurItem('reopen');

        return $this->fetch($this->template_dir.'reopen_index');
    }

    /**
     * 申请续签
     */
    public function reopen_add() {
        if (request()->isPost()) {
            
            $storereopen_grade_id = intval(input('post.storereopen_grade_id'));
            $storereopen_year = intval(input('post.storereopen_year'));
            if ($storereopen_grade_id <= 0 || $storereopen_year <= 0)
                exit();

            // 机构信息
            $store_info = $this->store_info;
            if (empty($store_info['store_endtime'])) {
                ds_json_encode(10001,'您的机构使用期限无限制，无须续签');
            }

            $storereopen_model = model('storereopen');

            //如果存在有未上传凭证或审核中的信息，则不能再申请续签
            $condition = array();
            $condition['storereopen_state'] = array('in', array(0, 1));
            $condition['storereopen_store_id'] = session('store_id');
            if ($storereopen_model->getStorereopenCount($condition)) {
                ds_json_encode(10001,'目前尚存在申请中的续签信息，不能重复申请');
            }

            $data = array();
            //取机构等级信息
            $grade_list = rkcache('storegrade', true);
            if (empty($grade_list[$storereopen_grade_id])) {
                exit();
            }

            //取得机构信息

            $data['storereopen_grade_id'] = $storereopen_grade_id;
            $data['storereopen_grade_name'] = $grade_list[$storereopen_grade_id]['storegrade_name'];
            $data['storereopen_grade_price'] = $grade_list[$storereopen_grade_id]['storegrade_price'];

            $data['storereopen_store_id'] = session('store_id');
            $data['storereopen_store_name'] = session('store_name');
            $data['storereopen_year'] = $storereopen_year;
            $data['storereopen_pay_amount'] = $data['storereopen_grade_price'] * $data['storereopen_year'];
            if ($data['storereopen_pay_amount'] == 0) {
                $data['storereopen_state'] = 1;
            }
            $insert = $storereopen_model->addStorereopen($data);
            if ($insert) {
                if ($data['storereopen_pay_amount'] == 0) {
                    ds_json_encode(10000,'您的申请已经提交，请等待管理员审核');
                } else {
                    ds_json_encode(10000,lang('ds_common_save_succ') . '，需付款金额' . ds_price_format($data['storereopen_pay_amount']) . '元，请尽快完成付款，付款完成后请上传付款凭证');
                }
            } else {
                ds_json_encode(10001,lang('ds_common_save_fail'));
            }
        }
    }

    //上传付款凭证
    public function reopen_upload()
    {
        $uploaddir = BASE_UPLOAD_PATH.DS.ATTACH_PATH . DS . 'store_joinin' . DS;
        if (!empty($_FILES['storereopen_pay_cert']['tmp_name'])) {
            $file_object = request()->file('storereopen_pay_cert');
            $info = $file_object->rule('uniqid')->validate(['ext' => ALLOW_IMG_EXT])->move($uploaddir);
            if ($info) {
                $pic_name = $info->getFilename();;
            }
        }
        $data = array();
        $data['storereopen_pay_cert'] = $pic_name;
        $data['storereopen_pay_cert_explain'] = input('post.storereopen_pay_cert_explain');
        $data['storereopen_state'] = 1;
        $storereopen_model = model('storereopen');
        $update = $storereopen_model->editStorereopen($data, array('storereopen_id' => input('post.storereopen_id'), 'storereopen_state' => 0));
        if ($update) {
            $this->success('上传成功，请等待系统审核');
        }
        else {
            $this->error(lang('ds_common_save_fail'));
        }
    }

    /**
     * 删除未上传付款凭证的续签信息
     */
    public function reopen_del()
    {
        $storereopen_model = model('storereopen');
        $condition = array();
        $condition['storereopen_id'] = intval(input('param.storereopen_id'));
        $condition['storereopen_state'] = 0;
        $condition['storereopen_store_id'] = session('store_id');
        $del = $storereopen_model->delStorereopen($condition);
        if ($del) {
            ds_json_encode(10000,lang('ds_common_del_succ'));
        }
        else {
            ds_json_encode(10001,lang('ds_common_del_fail'));
        }
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string $menu_type 导航类型
     * @param string $name 当前导航的name
     * @param array $array 附加菜单
     * @return
     */
    protected function getSellerItemList()
    {
        $menu_array = array();
        switch (request()->action()) {
            case 'index':
                $menu_array []= array(
                    'name' => 'bind_class', 'text' => lang('ds_member_path_bind_class'),
                    'url' => url('Sellerinfo/bind_class')
                );
                $menu_array[] = array(
                    'name' => 'index', 'text' => lang('ds_member_path_store_info'),
                    'url' => url('Sellerinfo/index')
                );
                $menu_array[] = array(
                    'name' => 'reopen', 'text' => lang('ds_member_path_store_reopen'),
                    'url' => url('Sellerinfo/reopen')
                );
                break;
            case 'bind_class':
                $menu_array []= array(
                        'name' => 'bind_class', 'text' => lang('ds_member_path_bind_class'),
                        'url' => url('Sellerinfo/bind_class')
                );
                if (!check_platform_store()) {
                    $menu_array[] = array(
                        'name' => 'index', 'text' => lang('ds_member_path_store_info'),
                        'url' => url('Sellerinfo/index')
                    );
                    $menu_array[] = array(
                        'name' => 'reopen', 'text' => lang('ds_member_path_store_reopen'),
                        'url' => url('Sellerinfo/reopen')
                    );
                }
                break;
            case 'reopen':
            $menu_array = array(
                array(
                    'name' => 'index', 'text' => lang('ds_member_path_bind_class'),
                    'url' => url('Sellerinfo/bind_class')
                ), array(
                    'name' => 'index', 'text' => lang('ds_member_path_store_info'),
                    'url' => url('Sellerinfo/index')
                ),array(
                    'name' => 'reopen', 'text' => lang('ds_member_path_store_reopen'),
                    'url' => url('Sellerinfo/reopen')
                )
            );
                break;
        }
        if (!empty($array)) {
            $menu_array[] = $array;
        }
       return $menu_array;
    }
}