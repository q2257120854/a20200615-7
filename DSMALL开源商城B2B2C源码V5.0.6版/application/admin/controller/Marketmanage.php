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
 * 营销活动管理  包含刮刮卡\大转盘\砸金蛋\生肖翻翻看
 */
class Marketmanage extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/marketmanage.lang.php');
        //营销活动类型
        $this->marketmanage_type_list = model('marketmanage')->marketmanage_type_list();
        $this->assign('marketmanage_type_list', $this->marketmanage_type_list);
        $this->marketmanage_type = intval(input('param.type'));
        if (!array_key_exists($this->marketmanage_type, $this->marketmanage_type_list)) {
            $this->error(lang('param_error'));
        }
        $this->assign('marketmanage_type', $this->marketmanage_type);
    }

    public function index() {
        $condition = array();
        $marketmanage_name = input('param.marketmanage_name');
        if (!empty($marketmanage_name)) {
            $condition['marketmanage_name'] = array('like', '%' . $marketmanage_name . '%');
        }
        $condition['marketmanage_type'] = $this->marketmanage_type;
        $marketmanage_model = model('marketmanage');
        $marketmanage_list = $marketmanage_model->getMarketmanageList($condition, 10);
        $this->assign('marketmanage_list', $marketmanage_list);
        $this->assign('show_page', $marketmanage_model->page_info->render());
        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    public function add() {
        if (!request()->isPost()) {
            $marketmanage = array(
                'marketmanage_jointype'=>0,
                'marketmanage_point'=>0,
                'marketmanage_begintime' => TIMESTAMP,
                'marketmanage_endtime' => TIMESTAMP+3600*24*7,
            );
            $this->assign('marketmanage', $marketmanage);

            $marketmanageaward_list = array();
            for ($i = 1; $i <= 4; $i++) {
                $marketmanageaward_list[] = array(
                    'marketmanageaward_level' => $i,
                    'marketmanageaward_type' => 1,
                    'marketmanageaward_count' => 0,
                    'marketmanageaward_probability' => 0,
                    'marketmanageaward_point' => 0,
                    'bonus_id' => '',
                    'vouchertemplate_id' => ''
                );
            }
            $this->assign('marketmanageaward_list', $marketmanageaward_list);

            //获取正在进行中的奖品红包活动
            $condition = array();
            $condition['bonus_type'] = 3;
            $condition['bonus_state'] = 1;
            $bonus_model = model('bonus');
            $bonus_list = $bonus_model->getBonusList($condition, '');
            $this->assign('bonus_list', $bonus_list);
            //获取店铺的优惠券列表
            $condition = array();
            $condition['vouchertemplate_state'] = 1;
            $condition['vouchertemplate_enddate'] = array('gt', TIMESTAMP);
            $vouchertemplate_list = db('vouchertemplate')->field('*')->where($condition)->limit(10)->select();
            $this->assign('vouchertemplate_list', $vouchertemplate_list);
            return $this->fetch('form');
        } else {
            $data_marketmanageaward = array();
            $total_marketmanageaward_probability = 0;
            for ($i = 1; $i <= 4; $i++) {
                $marketmanageaward_probability = intval($_POST['probability_' . $i]);
                $total_marketmanageaward_probability +=$marketmanageaward_probability;
                $data_marketmanageaward[] = array(
                    'marketmanageaward_level' => $i,
                    'marketmanageaward_type' => intval($_POST['type_' . $i]),
                    'marketmanageaward_count' => intval($_POST['count_' . $i]),
                    'marketmanageaward_probability' => $marketmanageaward_probability,//中奖概率
                    'marketmanageaward_point'=>intval($_POST['point_' . $i]),
                    'bonus_id'=>isset($_POST['bonus_id_' . $i]) ? intval($_POST['bonus_id_' . $i]) : 0,
                    'vouchertemplate_id'=> isset($_POST['vouchertemplate_id_' . $i]) ? intval($_POST['vouchertemplate_id_' . $i]) : 0,
                );
            }
            //中奖概率之和应小于 400%
            if($total_marketmanageaward_probability>400){
                $this->error(lang('marketmanageaward_probability_error'));
            }
            

            $data_marketmanage = array(
                'marketmanage_name' => input('param.marketmanage_name'),
                'marketmanage_detail' => input('param.marketmanage_detail'),
                'marketmanage_begintime' => strtotime(input('param.marketmanage_begintime')),
                'marketmanage_endtime' => strtotime(input('param.marketmanage_endtime')),
                'marketmanage_jointype' => intval(input('param.marketmanage_jointype')),
                'marketmanage_joincount' => intval(input('param.marketmanage_joincount')),
                'marketmanage_point' => intval(input('param.marketmanage_point_type')) == 0 ? 0 : intval(input('param.marketmanage_point')),
                'marketmanage_addtime' => TIMESTAMP,
                'marketmanage_failed' => input('param.marketmanage_failed'),
                'marketmanage_type' => $this->marketmanage_type,
            );
            //添加营销活动
            $marketmanage_id = model('marketmanage')->addMarketmanage($data_marketmanage);
            //添加营销活动奖品记录
            if ($marketmanage_id > 0) {
                foreach ($data_marketmanageaward as $key => $marketmanageaward) {
                    $data_marketmanageaward[$key]['marketmanage_id'] = $marketmanage_id;
                }
                db('marketmanageaward')->insertAll($data_marketmanageaward);
                $this->log(lang('ds_add') . $this->marketmanage_type_list[$this->marketmanage_type] . '[ID' . $marketmanage_id . ']', 1);
                dsLayerOpenSuccess(lang('ds_common_save_succ'));
            } else {
                $this->error(lang('ds_common_save_fail'));
            }
        }
    }

    public function edit() {
        $marketmanage_model = model('marketmanage');
        $condition = array();
        $marketmanage_id = intval(input('param.marketmanage_id'));
        if ($marketmanage_id <= 0) {
            $this->error(lang('param_error'));
        }
        $condition['marketmanage_id'] = $marketmanage_id;
        if (!request()->isPost()) {
            $marketmanage = $marketmanage_model->getOneMarketmanage($condition);
            $this->assign('marketmanage', $marketmanage);
            $this->assign('marketmanageaward_list', $marketmanage_model->getMarketmanageAwardList($condition));

            //获取正在进行中的奖品红包活动
            $condition = array();
            $condition['bonus_type'] = 3;
            $condition['bonus_state'] = 1;
            $bonus_model = model('bonus');
            $bonus_list = $bonus_model->getBonusList($condition, '');
            $this->assign('bonus_list', $bonus_list);
            //获取店铺的优惠券列表
            $condition = array();
            $condition['vouchertemplate_state'] = 1;
            $condition['vouchertemplate_enddate'] = array('gt', TIMESTAMP);
            $vouchertemplate_list = db('vouchertemplate')->field('*')->where($condition)->limit(10)->select();
            $this->assign('vouchertemplate_list', $vouchertemplate_list);
            return $this->fetch('form');
        } else {
            $data_marketmanageaward = array();
            $total_marketmanageaward_probability = 0;
            for ($i = 1; $i <= 4; $i++) {
                $marketmanageaward_probability = intval($_POST['probability_' . $i]);
                $total_marketmanageaward_probability +=$marketmanageaward_probability;
                $data_marketmanageaward[] = array(
                    'marketmanageaward_id' => intval($_POST['id_' . $i]), //主键ID 稍后用于修改数据
                    'marketmanageaward_level' => $i,
                    'marketmanageaward_type' => intval($_POST['type_' . $i]),
                    'marketmanageaward_count' => intval($_POST['count_' . $i]),
                    'marketmanageaward_probability' => $marketmanageaward_probability,//中奖概率
                    'marketmanageaward_point' => intval($_POST['point_' . $i]),
                    'bonus_id' => isset($_POST['bonus_id_' . $i]) ? intval($_POST['bonus_id_' . $i]) : 0,
                    'vouchertemplate_id' => isset($_POST['vouchertemplate_id_' . $i]) ? intval($_POST['vouchertemplate_id_' . $i]) : 0,
                );
            }
            //中奖概率应小于 400%
            if($total_marketmanageaward_probability>400){
                $this->error(lang('marketmanageaward_probability_error'));
            }
            $data_marketmanage = array(
                'marketmanage_name' => input('param.marketmanage_name'),
                'marketmanage_detail' => input('param.marketmanage_detail'),
                'marketmanage_begintime' => strtotime(input('param.marketmanage_begintime')),
                'marketmanage_endtime' => strtotime(input('param.marketmanage_endtime')),
                'marketmanage_jointype' => intval(input('param.marketmanage_jointype')),
                'marketmanage_joincount' => intval(input('param.marketmanage_joincount')),
                'marketmanage_point' => intval(input('param.marketmanage_point_type')) == 0 ? 0 : intval(input('param.marketmanage_point')),
                'marketmanage_failed' => input('param.marketmanage_failed'),
            );
            //编辑营销活动
            model('marketmanage')->editMarketmanage(array('marketmanage_id' => $marketmanage_id), $data_marketmanage);
            //编辑营销活动奖品记录
            foreach ($data_marketmanageaward as $key => $marketmanageaward) {
                $condition = array();
                $condition['marketmanageaward_id'] = $marketmanageaward['marketmanageaward_id'];
                $condition['marketmanage_id'] = $marketmanage_id;
                db('marketmanageaward')->where($condition)->update($marketmanageaward);
            }
            $this->log(lang('ds_edit') . $this->marketmanage_type_list[$this->marketmanage_type] . '[ID' . $marketmanage_id . ']', 1);
            dsLayerOpenSuccess(lang('ds_common_save_succ'));
        }
    }
    
    //删除活动
    public function del()
    {
        $marketmanage_id = intval(input('param.marketmanage_id'));
        if ($marketmanage_id <= 0) {
            $this->error(lang('param_error'));
        }
        $marketmanage_model = model('marketmanage');
        $marketmanage_model->delMarketmanage($marketmanage_id);
        $this->log(lang('ds_edit') . $this->marketmanage_type_list[$this->marketmanage_type] . '[ID' . $marketmanage_id . ']', 1);
        ds_json_encode(10000, lang('ds_common_op_succ'));
    }
    
    
    //链接信息
    public function link()
    {
        $condition = array();
        $marketmanage_id = intval(input('param.marketmanage_id'));
        if ($marketmanage_id <= 0) {
            $this->error(lang('param_error'));
        }
        $condition['marketmanage_id'] = $marketmanage_id;
        $marketmanage_model = model('marketmanage');
        $marketmanage = $marketmanage_model->getOneMarketmanage($condition);
        $this->assign('marketmanage', $marketmanage);
        
        $market_url = '';
        //1刮刮卡2大转盘3砸金蛋4生肖翻翻看
        switch ($marketmanage['marketmanage_type']) {
            case 1:
                $market_url = config('h5_site_url')."/home/marketcard?marketmanage_id=".$marketmanage['marketmanage_id'];
                break;
            case 2:
                $market_url = config('h5_site_url')."/home/marketwheel?marketmanage_id=".$marketmanage['marketmanage_id'];
                break;
            case 3:
                $market_url = config('h5_site_url')."/home/marketegg?marketmanage_id=".$marketmanage['marketmanage_id'];
                break;
            case 4:
                $market_url = config('h5_site_url')."/home/marketzodiac?marketmanage_id=".$marketmanage['marketmanage_id'];
                break;
            default:
                break;
        }
        $this->assign('market_url', $market_url);
        
        return $this->fetch();
    }

        //活动参与记录
    public function detail() {
        $condition = array();
        $marketmanage_id = intval(input('param.marketmanage_id'));
        if ($marketmanage_id <= 0) {
            $this->error(lang('param_error'));
        }
        $condition['marketmanage_id'] = $marketmanage_id;
        $marketmanage_model = model('marketmanage');
        $marketmanagelog_list = $marketmanage_model->getMarketmanageLogList($condition, 10);
        $this->assign('marketmanagelog_list', $marketmanagelog_list);
        $this->assign('show_page', $marketmanage_model->page_info->render());
        return $this->fetch();
    }

    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'index',
                'text' => lang('ds_manage'),
                'url' => url('Marketmanage/index', ['type' => input('param.type')])
            ),
            array(
                'name' => 'add',
                'text' => lang('ds_add'),
                'url' => "javascript:dsLayerOpen('" . url('Marketmanage/add', ['type' => input('param.type')]) . "','".lang('ds_add')."')"
            ),
        );
        return $menu_array;
    }

}
