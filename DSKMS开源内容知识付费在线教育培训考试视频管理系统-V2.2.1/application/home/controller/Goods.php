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
class  Goods extends BaseGoods {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/' . config('default_lang') . '/goods.lang.php');
    }

    /**
     * 单个商品信息页
     */
    public function index() {
        $goods_id = intval(input('param.goods_id'));

        // 商品详细信息
        $goods_model = model('goods');
        $goods_detail = $goods_model->getGoodsDetail($goods_id);
        $goods_info = $goods_detail['goods_info'];

        if (empty($goods_info)) {
            $this->error(lang('goods_index_no_goods'), HOME_SITE_URL);
        }
        // 获取销量 END
        $this->getStoreInfo($goods_info['store_id']);
        // 看了又看（同分类本店随机商品）
        $goods_rand_list = model('goods')->getGoodsGcStoreRandList($goods_info['gc_id_1'], $goods_info['store_id'], $goods_info['goods_id'], 2);
        $this->assign('goods_rand_list', $goods_rand_list);
        $this->assign('goods_image', $goods_detail['goods_image']);
        $inform_switch = true;
        // 检测商品是否下架,检查是否为店主本人
        if ($goods_info['goods_state'] != 1 || $goods_info['goods_verify'] != 1 || $goods_info['store_id'] == session('store_id')) {
            $inform_switch = false;
        }
        $this->assign('inform_switch', $inform_switch);

        //判断当前用户是否已购买此商品
        $if_have_buy = $this->_check_buy_goods($goods_id);
        $this->assign('if_have_buy', $if_have_buy);
        //获取当前商品下的章节
        $this->assign('goodscourses_list', $this->_getGoodscoursesList($goods_info, $if_have_buy));

        //获取商品的推广佣金
        $inviter_model = model('inviter');
        $goods_info['inviter_money'] = 0;
        if (config('inviter_show') && config('inviter_open') && $goods_info['inviter_open'] && session('member_id') && $inviter_model->getInviterInfo('i.inviter_id=' . session('member_id') . ' AND i.inviter_state=1')) {
            $inviter_money = round($goods_info['inviter_ratio_1'] / 100 * $goods_info['goods_price'], 2);
            if ($inviter_money > 0) {
                $goods_info['inviter_money'] = $inviter_money;
            }
        }
        // halt($goods_info);
        $this->assign('goods', $goods_info);


        $storeplate_model = model('storeplate');
        // 顶部关联版式
        if ($goods_info['plateid_top'] > 0) {
            $plate_top = $storeplate_model->getStoreplateInfoByID($goods_info['plateid_top']);
            $this->assign('plate_top', $plate_top);
        }
        // 底部关联版式
        if ($goods_info['plateid_bottom'] > 0) {
            $plate_bottom = $storeplate_model->getStoreplateInfoByID($goods_info['plateid_bottom']);
            $this->assign('plate_bottom', $plate_bottom);
        }
        $this->assign('store_id', $goods_info['store_id']);
        
        // 当前位置导航
        $nav_link_list = model('goodsclass')->getGoodsclassnav($goods_info['gc_id'], 0);
        $nav_link_list[] = array('title' => $goods_info['goods_name']);
        $this->assign('nav_link_list', $nav_link_list);
        
        //评价信息
        $goods_evaluate_info = model('evaluategoods')->getEvaluategoodsInfoByGoodsID($goods_id);
        $this->assign('goods_evaluate_info', $goods_evaluate_info);

        //SEO 设置
        $seo_param = array();
        $seo_param['name'] = $goods_info['goods_name'];
        $seo_param['description'] = ds_substing(htmlspecialchars_decode($goods_info['goods_body']));
        $this->_assign_seo(model('seo')->type('product')->param($seo_param)->show());

        return $this->fetch($this->template_dir . 'goods');
    }

    /**
     * 显示当前产品的课程列表
     */
    public function courses() {
        $goodscourses_id = intval(input('param.goodscourses_id'));
        $goods_id = intval(input('param.goods_id'));
        if($goods_id<=0){
            $this->error(lang('param_error'));
        }
        if($goodscourses_id>0){
            $condition['goodscourses_id'] = $goodscourses_id;
        }
        $condition['goods_id'] = $goods_id;
        $goodscourses = model('goodscourses')->getOneGoodscourses($condition);
        $if_have_buy = $this->_check_buy_goods($goods_id);
        //判断此商品是否被购买
        if ($goodscourses['goodscourses_free'] || $if_have_buy) {
            // 商品详细信息
            $goods_model = model('goods');
            $goods_detail = $goods_model->getGoodsDetail($goods_id);
            $goods_info = $goods_detail['goods_info'];
            if (empty($goods_info)) {
                $this->error(lang('goods_index_no_goods'), HOME_SITE_URL);
            }
            $this->assign('goods', $goods_info);
            $this->assign('goods_id', $goods_id);
            
            $this->assign('goodscourses', $goodscourses);
            //获取当前商品下的章节
            $this->assign('goodscourses_list', $this->_getGoodscoursesList($goods_info, $if_have_buy));
            return $this->fetch($this->template_dir . 'courses');
        } else {
            $this->error('您没有观看权限');
        }
    }

    /**
     * 获取当前商品下的视频
     * @param type $goods_info
     * @return type
     */
    private function _getGoodscoursesList($goods_info, $if_have_buy) {
        $goodscourses_list = model('goodscourses')->getGoodscoursesList(array('goods_id' => $goods_info['goods_id']));
        //查看商品是否免费
        $if_goods_free = FALSE;
        if($goods_info['goods_price'] == 0.00){
            $if_goods_free = TRUE;
        }
        if (!empty($goodscourses_list)) {
            foreach ($goodscourses_list as $key => $goodscourses) {
                //根据课程是否免费以及是否购买判断
                if ($goodscourses['goodscourses_free'] || $if_have_buy || $if_goods_free) {
                    $goodscourses_list[$key]['goodscourses_view'] = url('Goods/Courses', ['goodscourses_id' => $goodscourses['goodscourses_id'], 'goods_id' => $goodscourses['goods_id']]);
                }
                if ($if_have_buy || $if_goods_free) {
                    $goodscourses_list[$key]['goodscourses_text'] = '开始学习';
                } elseif ($goodscourses['goodscourses_free']) {
                    $goodscourses_list[$key]['goodscourses_text'] = '免费试看';
                }else{
                    $goodscourses_list[$key]['goodscourses_text'] = '您需要先购买课程才能观看本章节';
                }
            }
        }
        return $goodscourses_list;
    }

    /**
     * 检测当前用户是否购买此商品
     */
    private function _check_buy_goods($goods_id) {
        $if_have_buy = FALSE;
        if (session('member_id')) {
            $condition = array();
            $condition['buyer_id'] = session('member_id');
            $condition['goods_id'] = $goods_id;
            $condition['order_state'] = array('in', array(ORDER_STATE_PAY,ORDER_STATE_SUCCESS));
            $condition['refund_state'] = 0;
            $vrorder = model('vrorder')->getVrorderInfo($condition);
            if (!empty($vrorder)) {
                $if_have_buy = TRUE;
            }
        }
        return $if_have_buy;
    }

    /**
     * 记录浏览历史
     */
    public function addbrowse() {
        $goods_id = intval(input('param.gid'));
        model('goodsbrowse')->addViewedGoods($goods_id, session('member_id'), session('store_id'));
        exit();
    }

    /**
     * 商品评论
     */
    public function comments() {
        $goods_id = intval(input('param.goods_id'));
        $type = input('param.type');
        $this->_get_comments($goods_id, $type, 1);
        echo $this->fetch($this->template_dir . 'goods_comments');
    }

    /**
     * 商品评价详细页
     */
    public function comments_list() {
        $goods_id = intval(input('param.goods_id'));

        // 商品详细信息
        $goods_model = model('goods');
        $goods_info = $goods_model->getGoodsInfoByID($goods_id);
        // 验证商品是否存在
        if (empty($goods_info)) {
            $this->error(lang('goods_index_no_goods'));
        }
        $this->assign('goods', $goods_info);

        $this->getStoreInfo($goods_info['store_id']);

        //评价信息
        $goods_evaluate_info = model('evaluategoods')->getEvaluategoodsInfoByGoodsID($goods_id);
        $this->assign('goods_evaluate_info', $goods_evaluate_info);

        //SEO 设置
        $seo_param = array();
        $seo_param['name'] = $goods_info['goods_name'];
        $seo_param['description'] = ds_substing($goods_info['goods_name']);
        $this->_assign_seo(model('seo')->type('product')->param($seo_param)->show());

        $this->_get_comments($goods_id, input('param.type'), 20);

        return $this->fetch($this->template_dir . 'comments_list');
    }

    private function _get_comments($goods_id, $type, $page) {
        $condition = array();
        $condition['geval_goodsid'] = $goods_id;
        switch ($type) {
            case '1':
                $condition['geval_scores'] = array('in', '5,4');
                $this->assign('type', '1');
                break;
            case '2':
                $condition['geval_scores'] = array('in', '3,2');
                $this->assign('type', '2');
                break;
            case '3':
                $condition['geval_scores'] = array('in', '1');
                $this->assign('type', '3');
                break;
            default:
                $this->assign('type', '');
                break;
        }

        //查询商品评分信息
        $evaluategoods_model = model('evaluategoods');
        $goodsevallist = $evaluategoods_model->getEvaluategoodsList($condition, $page);
        foreach($goodsevallist as $key => $val){
            if(preg_match('/^phone_1[3|5|6|7|8]\d{9}$/', $val['geval_frommembername'])){
                $goodsevallist[$key]['geval_frommembername'] = substr_replace($val['geval_frommembername'], '****', 9, 4);
            }
        }
        $this->assign('goodsevallist', $goodsevallist);
        $this->assign('show_page', $evaluategoods_model->page_info->render());
    }

    /**
     * 销售记录
     */
    public function salelog() {
        $goods_id = intval(input('param.goods_id'));
        $vrorder_model = model('vrorder');
        $sales = $vrorder_model->getVrorderAndOrderGoodsSalesRecordList(array('goods_id' => $goods_id), '*', 10);
        $this->assign('show_page', $vrorder_model->page_info->render());
        $this->assign('sales', $sales);
        $this->assign('order_type', array(2 => lang('ds_xianshi_rob'), 3 => lang('ds_xianshi_flag'), '4' => lang('ds_xianshi_suit')));
        echo $this->fetch($this->template_dir . 'goods_salelog');
    }

    /**
     * 产品咨询
     */
    public function consulting() {
        $goods_id = intval(input('param.goods_id'));
        if ($goods_id <= 0) {
            $this->error(lang('param_error'), '', 'html', 'error');
        }

        //得到商品咨询信息
        $consult_model = model('consult');
        $where = array();
        $where['goods_id'] = $goods_id;

        $ctid = intval(input('param.ctid'));
        if ($ctid > 0) {
            $where['consulttype_id'] = $ctid;
        }
        $consult_list = $consult_model->getConsultList($where, '*', '10');
        $this->assign('consult_list', $consult_list);

        // 咨询类型
        $consult_type = rkcache('consulttype', true);
        $this->assign('consult_type', $consult_type);

        $this->assign('consult_able', $this->checkConsultAble());
        echo $this->fetch($this->template_dir . 'goods_consulting');
    }

    /**
     * 产品咨询
     */
    public function consulting_list() {

        $this->assign('hidden_nctoolbar', 1);
        $goods_id = intval(input('param.goods_id'));
        if ($goods_id <= 0) {
            $this->error(lang('param_error'));
        }

        // 商品详细信息
        $goods_model = model('goods');
        $goods_info = $goods_model->getGoodsInfoByID($goods_id);
        // 验证商品是否存在
        if (empty($goods_info)) {
            $this->error(lang('goods_index_no_goods'));
        }
        $this->assign('goods', $goods_info);

        $this->getStoreInfo($goods_info['store_id']);


        //得到商品咨询信息
        $consult_model = model('consult');
        $where = array();
        $where['goods_id'] = $goods_id;
        if (intval(input('param.ctid')) > 0) {
            $where['consulttype_id'] = intval(input('param.ctid'));
        }
        $consult_list = $consult_model->getConsultList($where, '*');
        $this->assign('consult_list', $consult_list);
        $this->assign('show_page', $consult_model->page_info->render());

        // 咨询类型
        $consult_type = rkcache('consulttype', true);
        $this->assign('consult_type', $consult_type);

        //SEO 设置
        $seo_param = array();
        $seo_param['name'] = $goods_info['goods_name'];
        $seo_param['description'] = ds_substing($goods_info['goods_name']);
        $this->_assign_seo(model('seo')->type('product')->param($seo_param)->show());

        $this->assign('consult_able', $this->checkConsultAble($goods_info['store_id']));
        return $this->fetch($this->template_dir . 'consulting_list');
    }

    private function checkConsultAble($store_id = 0) {
        //检查是否为店主本身
        $store_self = false;
        if (session('store_id')) {
            if (($store_id == 0 && intval(input('param.store_id')) == session('store_id')) || ($store_id != 0 && $store_id == session('store_id'))) {
                $store_self = true;
            }
        }
        //查询会员信息
        $member_info = array();
        $member_model = model('member');
        if (session('member_id'))
            $member_info = $member_model->getMemberInfoByID(session('member_id'));
        //检查是否可以评论
        $consult_able = true;
        if ((!config('guest_comment') && !session('member_id') ) || $store_self == true || (session('member_id') > 0 && $member_info['is_allowtalk'] == 0)) {
            $consult_able = false;
        }
        return $consult_able;
    }

    /**
     * 商品咨询添加
     */
    public function save_consult() {
        //检查是否可以评论
        if (!config('guest_comment') && !session('member_id')) {
            ds_json_encode(10001, lang('goods_index_goods_noallow'));
        }
        $goods_id = intval(input('post.goods_id'));
        if ($goods_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }
        //咨询内容的非空验证
        if (trim(input('post.goods_content')) == "") {
            ds_json_encode(10001, lang('goods_index_input_consult'));
        }
        //表单验证
        $data = [
            'goods_content' => input('post.goods_content')
        ];
        $goods_validate = validate('goods');
        if (!$goods_validate->scene('save_consult')->check($data)) {
            ds_json_encode(10001, $goods_validate->getError());
        }

        if (session('member_id')) {
            //查询会员信息
            $member_model = model('member');
            $member_info = $member_model->getMemberInfo(array('member_id' => session('member_id')));
            if (empty($member_info) || $member_info['is_allowtalk'] == 0) {
                ds_json_encode(10001, lang('goods_index_goods_noallow'));
            }
        }
        //判断商品编号的存在性和合法性
        $goods = model('goods');
        $goods_info = $goods->getGoodsInfoByID($goods_id);
        if (empty($goods_info)) {
            ds_json_encode(10001, lang('goods_index_goods_not_exists'));
        }
        //判断是否是店主本人
        if (session('store_id') && $goods_info['store_id'] == session('store_id')) {
            ds_json_encode(10001, lang('goods_index_consult_store_error'));
        }
        //检查机构状态
        $store_model = model('store');
        $store_info = $store_model->getStoreInfoByID($goods_info['store_id']);
        if ($store_info['store_state'] == '0' || intval($store_info['store_state']) == '2' || (intval($store_info['store_endtime']) != 0 && $store_info['store_endtime'] <= TIMESTAMP)) {
            ds_json_encode(10001, lang('goods_index_goods_store_closed'));
        }
        //接收数据并保存
        $input = array();
        $input['goods_id'] = $goods_id;
        $input['goods_name'] = $goods_info['goods_name'];
        $input['member_id'] = intval(session('member_id')) > 0 ? session('member_id') : 0;
        $input['member_name'] = session('member_name') ? session('member_name') : '';
        $input['store_id'] = $store_info['store_id'];
        $input['store_name'] = $store_info['store_name'];
        $input['consulttype_id'] = intval(input('post.consult_type_id', 1));
        $input['consult_addtime'] = TIMESTAMP;
        $input['consult_content'] = input('post.goods_content');
        $input['consult_isanonymous'] = input('post.hide_name') == 'hide' ? 1 : 0;
        $consult_model = model('consult');
        if ($consult_model->addConsult($input)) {
            ds_json_encode(10000, lang('goods_index_consult_success'));
        } else {
            ds_json_encode(10001, lang('goods_index_consult_fail'));
        }
    }

    public function json_area() {
        echo input('param.callback') . '(' . json_encode(model('area')->getAreaArrayForJson()) . ')';
    }

}

?>
