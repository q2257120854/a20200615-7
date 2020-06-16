<?php

namespace app\common\model;

use think\Model;
use think\Db;
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
 * 数据层模型
 */
class  Goods extends Model {

    const STATE1 = 1;       // 出售中
    const STATE0 = 0;       // 下架
    const STATE10 = 10;     // 违规
    const VERIFY1 = 1;      // 审核通过
    const VERIFY0 = 0;      // 审核失败
    const VERIFY10 = 10;    // 等待审核

    public $page_info;

    /**
     * 新增商品数据
     * @access public
     * @author csdeshang
     * @param type $data 数据
     * @return type
     */
    public function addGoods($data) {
        $result = db('goods')->insertGetId($data);
        if ($result) {
            $this->_dGoodsCache($result);
        }
        return $result;
    }


    /**
     * 商品SKU列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $field 字段
     * @param type $group 分组
     * @param type $order 排序
     * @param type $limit 限制
     * @param type $pagesize 分页
     * @return array
     */
    public function getGoodsList($condition, $field = '*', $pagesize = 0,$order = '',$limit='') {
        $condition = $this->_getRecursiveClass($condition);
        if ($pagesize) {
            $result = db('goods')->field($field)->where($condition)->order($order)->paginate($pagesize, false, ['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        } else {
            $result = db('goods')->field($field)->where($condition)->limit($limit)->order($order)->select();
            return $result;
        }
    }

    
    /**
     * 获取指定分类指定机构下的随机商品列表 
     * @access public
     * @author csdeshang
     * @param int $gcId 一级分类ID
     * @param int $storeId 机构ID
     * @param int $notEqualGoodsId 此商品ID除外
     * @param int $size 列表最大长度
     * @return array|null
     */
    public function getGoodsGcStoreRandList($gcId, $storeId, $notEqualGoodsId = 0, $size = 4) {
        $where = array(
            'store_id' => (int) $storeId,
            'gc_id_1' => (int) $gcId,
        );
        if ($notEqualGoodsId > 0) {
            $where['goods_id'] = array('neq', (int) $notEqualGoodsId);
        }
        return db('goods')->where($where)->limit($size)->select();
    }

    /**
     * 出售中的商品SKU列表（只显示不同颜色的商品，前台商品索引，机构也商品列表等使用）
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param string $field 字段
     * @param type $order 排序
     * @param type $pagesize 分页
     * @param type $limit 限制
     * @return type
     */
    public function getGoodsListByColorDistinct($condition, $field = '*', $order = 'goods_id asc', $pagesize = 0, $limit = 0) {
        $condition['goods_state'] = self::STATE1;
        $condition['goods_verify'] = self::VERIFY1;
        $condition = $this->_getRecursiveClass($condition);
        
        $count = db('goods')->where($condition)->field("distinct CONCAT(goods_id)")->count();
        $goods_list = array();
        if ($count != 0) {
            $goods_list = $this->getGoodsOnlineList($condition, $field, $pagesize, $order, $limit, 'CONCAT(goods_id)', false, $count);
        }
        return $goods_list;
    }


    /**
     * 在售商品SKU列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param str $field 字段
     * @param int $pagesize 分页
     * @param str $order 排序
     * @param int $limit 限制
     * @param str $group 分组
     * @param bool $lock 是否锁定
     * @param int $count 计数
     * @return array
     */
    public function getGoodsOnlineList($condition, $field = '*', $pagesize = 0, $order = 'goods_id desc', $limit = 0, $group = '', $lock = false, $count = 0) {
        $condition['goods_state'] = self::STATE1;
        $condition['goods_verify'] = self::VERIFY1;
        return $this->getGoodsList($condition, $field, $pagesize, $order,$limit);
    }

    /**
     * 出售中的普通商品列表，即不包括虚拟商品、F码商品、预售商品
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $field 字段
     * @param type $pagesize 分页
     * @param type $type 类型
     * @return array
     */
    public function getGoodsListForPromotion($condition, $field = '*', $pagesize = 0, $type = '') {
        switch ($type) {
            case 'combo':
                $condition['goods_state'] = self::STATE1;
                $condition['goods_verify'] = self::VERIFY1;
                break;
            default:
                break;
        }
        return $this->getGoodsList($condition, $field, $pagesize);
    }





    /**
     * 仓库中的商品列表 卖家中心使用
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param array $field 字段
     * @param string $pagesize 分页
     * @param string $order 排序
     * @return array
     */
    public function getGoodsOfflineList($condition, $field = '*', $pagesize = 10, $order = "goods_id desc") {
        $condition['goods_state'] = self::STATE0;
        $condition['goods_verify'] = self::VERIFY1;
        return $this->getGoodsList($condition, $field, $pagesize, $order);
    }

    /**
     * 违规的商品列表 卖家中心使用
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param array $field 字段
     * @param string $pagesize 分页
     * @param string $order 排序
     * @return array
     */
    public function getGoodsLockUpList($condition, $field = '*', $pagesize = 10, $order = "goods_id desc") {
        $condition['goods_state'] = self::STATE10;
        $condition['goods_verify'] = self::VERIFY1;
        return $this->getGoodsList($condition, $field, $pagesize, $order);
    }

    /**
     * 等待审核或审核失败的商品列表 卖家中心使用
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param array $field 字段
     * @param string $pagesize 分页
     * @param string $order 排序
     * @return array
     */
    public function getGoodsWaitVerifyList($condition, $field = '*', $pagesize = 10, $order = "goods_id desc") {
        if (!isset($condition['goods_verify'])) {
            $condition['goods_verify'] = array('neq', self::VERIFY1);
        }
        return $this->getGoodsList($condition, $field, $pagesize, $order);
    }

    /**
     * 查询商品SUK及其机构信息
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @return array
     */
    public function getGoodsStoreList($condition, $field = '*') {
        $condition = $this->_getRecursiveClass($condition);
        return db('goods')->alias('goods')->field($field)->join('__STORE__ store', 'goods.store_id = store.store_id', 'inner')->where($condition)->select();
    }

    /**
     * 查询推荐商品(随机排序) 
     * @access public
     * @author csdeshang
     * @param int $store_id 机构
     * @param int $limit 限制
     * @return array
     */
    public function getGoodsCommendList($store_id, $limit = 5) {
        $goods_commend_list = $this->getGoodsOnlineList(array('store_id' => $store_id, 'goods_commend' => 1), 'goods_id,goods_name,goods_advword,goods_image,store_id,goods_price', 0, '', $limit, 'goods_id');
        if (!empty($goods_id_list)) {
            $tmp = array();
            foreach ($goods_id_list as $v) {
                $tmp[] = $v['goods_id'];
            }
            $goods_commend_list = $this->getGoodsOnlineList(array('goods_id' => array('in', $tmp)), 'goods_id,goods_name,goods_advword,goods_image,store_id', 0, '', $limit);
        }
        return $goods_commend_list;
    }


    /**
     * 更新商品SUK数据
     * @access public
     * @author csdeshang
     * @param array $update 更新数据
     * @param array $condition 条件
     * @return boolean
     */
    public function editGoods($update, $condition) {
        $goods_list = $this->getGoodsList($condition, 'goods_id');
        if (empty($goods_list)) {
            return true;
        }
        $goodsid_array = array();
        foreach ($goods_list as $value) {
            $goodsid_array[] = $value['goods_id'];
        }
        return $this->editGoodsById($update, $goodsid_array);
    }

    
    /**
     * 更新商品SUK数据
     * @access public
     * @author csdeshang
     * @param array $update 更新数据
     * @param int|array $goodsid_array 商品ID
     * @return boolean|unknown
     */
    public function editGoodsById($update, $goodsid_array) {
        if (empty($goodsid_array)) {
            return true;
        }
        $condition['goods_id'] = array('in', $goodsid_array);
        $update['goods_edittime'] = TIMESTAMP;
        $result = db('goods')->where($condition)->update($update);
        if ($result) {
            foreach ((array) $goodsid_array as $value) {
                $this->_dGoodsCache($value);
            }
        }
        return $result;
    }



    /**
     * 锁定商品
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return boolean
     */
    public function editGoodsLock($condition) {
        $update = array('goods_lock' => 1);
        return $this->editGoods($update, $condition);
    }

    /**
     * 解锁商品
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return boolean
     */
    public function editGoodsUnlock($condition) {
        $update = array('goods_lock' => 0);
        return $this->editGoods($update, $condition);
    }

    /**
     * 更新商品信息
     * @access public
     * @author csdeshang
     * @param array $condition 更新条件
     * @param array $update1 更新数据1
     * @param array $update2 更新数据2
     * @return boolean
     */
    public function editProduces($condition, $update1, $update2 = array()) {
        $update2 = empty($update2) ? $update1 : $update2;
        $goods_array = $this->getGoodsList($condition, 'goods_id');
        if (empty($goods_array)) {
            return true;
        }
        $goods_id_array = array();
        foreach ($goods_array as $val) {
            $goods_id_array[] = $val['goods_id'];
        }
        $return2 = $this->editGoods($update2, array('goods_id' => array('in', $goods_id_array)));
        if ($return2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 更新商品信息（审核失败）
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param array $update1 更新数据1
     * @param array $update2 更新数据2
     * @return boolean
     */
    public function editProducesVerifyFail($condition, $update1, $update2 = array()) {
        $result = $this->editProduces($condition, $update1, $update2);
        if ($result) {
            $commonlist = $this->getGoodsList($condition, 'goods_id,gc_id,goods_name,store_id,goods_verifyremark');
            foreach ($commonlist as $val) {
                $message = array();
                $message['goods_id'] = $val['goods_id'];
                $message['remark'] = $val['goods_verifyremark'];
                $weixin_param = array(
                    'url' => config('h5_site_url').'/seller/goods_form_2?goods_id='.$val['goods_id'].'&class_id='.$val['gc_id'],
                    'data'=>array(
                        "keyword1" => array(
                            "value" => $val['goods_name'],
                            "color" => "#333"
                        ),
                        "keyword2" => array(
                            "value" => $val['goods_verifyremark'],
                            "color" => "#333"
                        )
                        )
                    );
                $this->_sendStoremsg('goods_verify', $val['store_id'], $message,$weixin_param);
            }
        }
    }

    /**
     * 更新未锁定商品信息
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param array $update1 更新数据1
     * @param array $update2 更新数据2
     * @return boolean
     */
    public function editProducesNoLock($condition, $update1, $update2 = array()) {
        $condition['goods_lock'] = 0;
        return $this->editProduces($condition, $update1, $update2);
    }

    /**
     * 商品下架
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return boolean
     */
    public function editProducesOffline($condition) {
        $update = array('goods_state' => self::STATE0);
        return $this->editProducesNoLock($condition, $update);
    }

    /**
     * 商品上架
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return boolean
     */
    public function editProducesOnline($condition) {
        $update = array('goods_state' => self::STATE1);
        // 禁售商品、审核失败商品不能上架。
        $condition['goods_state'] = self::STATE0;
        $condition['goods_verify'] = array('neq', self::VERIFY0);
        return $this->editProduces($condition, $update);
    }

    /**
     * 违规下架
     * @access public
     * @author csdeshang
     * @param array $update 数据
     * @param array $condition 条件
     * @return boolean
     */
    public function editProducesLockUp($update, $condition) {
        $update_param['goods_state'] = self::STATE10;
        $update = array_merge($update, $update_param);
        $return = $this->editProduces($condition, $update, $update_param);
        if ($return) {
            // 商品违规下架发送机构消息
            $common_list = $this->getGoodsList($condition, 'goods_id,gc_id,goods_name,store_id,goods_stateremark');
            foreach ($common_list as $val) {
                $message = array();
                $message['remark'] = $val['goods_stateremark'];
                $message['goods_id'] = $val['goods_id'];
                $weixin_param = array(
                    'url' => config('h5_site_url').'/seller/goods_form_2?goods_id='.$val['goods_id'].'&class_id='.$val['gc_id'],
                    'data'=>array(
                        "keyword1" => array(
                            "value" => $val['goods_name'],
                            "color" => "#333"
                        ),
                        "keyword2" => array(
                            "value" => $val['goods_stateremark'],
                            "color" => "#333"
                        ),
                        "keyword3" => array(
                            "value" => $val['goods_commonid'],
                            "color" => "#333"
                        )
                        )
                    );
                $this->_sendStoremsg('goods_violation', $val['store_id'], $message,$weixin_param);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取单条商品SKU信息
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @return array
     */
    public function getGoodsInfo($condition, $field = '*') {

        return db('goods')->field($field)->where($condition)->find();
    }

    /**
     * 获取单条商品SKU信息及其促销信息
     * @access public
     * @author csdeshang
     * @param int $goods_id 商品ID
     * @return type
     */
    public function getGoodsOnlineInfoForShare($goods_id) {
        $goods_info = $this->getGoodsOnlineInfoAndPromotionById($goods_id);
        if (empty($goods_info)) {
            return array();
        }
        return $goods_info;
    }

    /**
     * 查询出售中的商品详细信息及其促销信息
     * @access public
     * @author csdeshang
     * @param int $goods_id 商品ID
     * @return array
     */
    public function getGoodsOnlineInfoAndPromotionById($goods_id) {
        $goods_info = $this->getGoodsInfoAndPromotionById($goods_id);
        if (empty($goods_info) || $goods_info['goods_state'] != self::STATE1 || $goods_info['goods_verify'] != self::VERIFY1) {
            return array();
        }
        return $goods_info;
    }

    /**
     * 查询商品详细信息及其促销信息
     * @access public
     * @author csdeshang
     * @param int $goods_id 商品ID
     * @return array
     */
    public function getGoodsInfoAndPromotionById($goods_id) {
        $goods_info = $this->getGoodsInfoByID($goods_id);
        if (empty($goods_info)) {
            return array();
        }
        return $goods_info;
    }

    /**
     * 查询出售中的商品列表及其促销信息
     * @access public
     * @author csdeshang
     * @param array $goodsid_array 商品ID数组
     * @return array
     */
    public function getGoodsOnlineListAndPromotionByIdArray($goodsid_array) {
        if (empty($goodsid_array) || !is_array($goodsid_array))
            return array();

        $goods_list = array();
        foreach ($goodsid_array as $goods_id) {
            $goods_info = $this->getGoodsOnlineInfoAndPromotionById($goods_id);
            if (!empty($goods_info))
                $goods_list[] = $goods_info;
        }

        return $goods_list;
    }
    
    /**
     * 获得商品SKU数量
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return int
     */
    public function getGoodsCount($condition) {
        return db('goods')->where($condition)->count();
    }

    /**
     * 获得出售中商品SKU数量
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @return int
     */
    public function getGoodsOnlineCount($condition, $field = '*') {
        $condition['goods_state'] = self::STATE1;
        $condition['goods_verify'] = self::VERIFY1;
        return db('goods')->where($condition)->count($field);
    }



    /**
     * 仓库中的商品数量
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return int
     */
    public function getGoodsOfflineCount($condition) {
        $condition['goods_state'] = self::STATE0;
        $condition['goods_verify'] = self::VERIFY1;
        return $this->getGoodsCount($condition);
    }

    /**
     * 等待审核的商品数量
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return int
     */
    public function getGoodsWaitVerifyCount($condition) {
        $condition['goods_verify'] = self::VERIFY10;
        return $this->getGoodsCount($condition);
    }

    /**
     * 审核失败的商品数量
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return int
     */
    public function getGoodsVerifyFailCount($condition) {
        $condition['goods_verify'] = self::VERIFY0;
        return $this->getGoodsCount($condition);
    }

    /**
     * 违规下架的商品数量
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return int
     */
    public function getGoodsLockUpCount($condition) {
        $condition['goods_state'] = self::STATE10;
        $condition['goods_verify'] = self::VERIFY1;
        return $this->getGoodsCount($condition);
    }

    /**
     * 删除商品SKU信息
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return boolean
     */
    public function delGoods($condition) {
        $goods_list = $this->getGoodsList($condition, 'goods_id,goods_id,store_id');
        if (!empty($goods_list)) {
            $goodsid_array = array();
            // 删除商品二维码
            foreach ($goods_list as $val) {
                $goodsid_array[] = $val['goods_id'];
                @unlink(BASE_UPLOAD_PATH . DS . ATTACH_STORE . DS . $val['store_id'] . DS . $val['goods_id'] . '.png');
                // 删除商品缓存
                $this->_dGoodsCache($val['goods_id']);
            }
            //删除商品浏览记录
            model('goodsbrowse')->delGoodsbrowse(array('goods_id' => array('in', $goodsid_array)));
            // 删除买家收藏表数据
            model('favorites')->delFavorites(array('fav_id' => array('in', $goodsid_array), 'fav_type' => 'goods'));
            // 删除商品课程表数据
            model('goodscourses')->delGoodscourses(array('goods_id' => array('in', $goodsid_array)));
            // 删除推荐组合
            model('goodscombo')->delGoodscombo(array('goods_id' => array('in', $goodsid_array)));
            model('goodscombo')->delGoodscombo(array('combo_goodsid' => array('in', $goodsid_array)));
        }
        return db('goods')->where($condition)->delete();
    }

    /**
     * 商品删除及相关信息
     * @access public
     * @author csdeshang
     * @param  array $condition 列表条件
     * @return boolean
     */
    public function delGoodsAll($condition) {
        $goods_list = $this->getGoodsList($condition, 'goods_id,goods_id,store_id');
        if (empty($goods_list)) {
            return false;
        }
        $goodsid_array = array();
        $goods_id_array = array();
        foreach ($goods_list as $val) {
            $goodsid_array[] = $val['goods_id'];
            $goods_id_array[] = $val['goods_id'];
            // 商品公共缓存
            $this->_dGoodsCache($val['goods_id']);
        }
        $goods_id_array = array_unique($goods_id_array);

        // 删除商品表数据
        $this->delGoods(array('goods_id' => array('in', $goodsid_array)));
        return true;
    }

    /*     * 删除未锁定商品
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return type
     */

    public function delGoodsNoLock($condition) {
        $condition['goods_lock'] = 0;
        $common_array = $this->getGoodsList($condition, 'goods_id');
        $common_array = array_under_reset($common_array, 'goods_id');
        $goods_id_array = array_keys($common_array);
        return $this->delGoodsAll(array('goods_id' => array('in', $goods_id_array)));
    }

    /**
     * 发送机构消息
     * @access public
     * @author csdeshang
     * @param string $code 编码
     * @param int $store_id 机构OD
     * @param array $param 参数
     */
    private function _sendStoremsg($code, $store_id, $param,$weixin_param=array()) {
        \mall\queue\QueueClient::push('sendStoremsg', array('code' => $code, 'store_id' => $store_id, 'param' => $param, 'weixin_param' => $weixin_param));
    }

    /**
     * 获得商品子分类的ID
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return array
     */
    private function _getRecursiveClass($condition) {
        if (isset($condition['gc_id']) && !is_array($condition['gc_id'])) {
            $gc_list = model('goodsclass')->getGoodsclassForCacheModel();
            if (!empty($gc_list[$condition['gc_id']])) {
                $gc_id[] = $condition['gc_id'];
                $gcchild_id = empty($gc_list[$condition['gc_id']]['child']) ? array() : explode(',', $gc_list[$condition['gc_id']]['child']);
                $gcchildchild_id = empty($gc_list[$condition['gc_id']]['childchild']) ? array() : explode(',', $gc_list[$condition['gc_id']]['childchild']);
                $gc_id = array_merge($gc_id, $gcchild_id, $gcchildchild_id);
                $condition['gc_id'] = array('in', $gc_id);
            }
        }
        return $condition;
    }

    /**
     * 由ID取得在售单个虚拟商品信息
     * @access public
     * @author csdeshang
     * @param array $goods_id 商品ID
     * @return array
     */
    public function getVirtualGoodsOnlineInfoByID($goods_id) {
        $goods_info = $this->getGoodsInfoByID($goods_id);
        return $goods_info;
    }

    /**
     * 取得商品详细信息（优先查询缓存）（在售）
     * 如果未找到，则缓存所有字段
     * @access public
     * @author csdeshang
     * @param int $goods_id 商品ID
     * @return array
     */
    public function getGoodsOnlineInfoByID($goods_id) {
        $goods_info = $this->getGoodsInfoByID($goods_id);
        if ($goods_info['goods_state'] != self::STATE1 || $goods_info['goods_verify'] != self::VERIFY1) {
            $goods_info = array();
        }
        return $goods_info;
    }

    /**
     * 取得商品详细信息（优先查询缓存）
     * 如果未找到，则缓存所有字段
     * @access public
     * @author csdeshang
     * @param int $goods_id 商品ID
     * @return array
     */
    public function getGoodsInfoByID($goods_id) {
        $goods_info = $this->_rGoodsCache($goods_id);
        if (empty($goods_info)) {
            $goods_info = $this->getGoodsInfo(array('goods_id' => $goods_id));
            $this->_wGoodsCache($goods_id, $goods_info);
        }
        return $goods_info;
    }



    /**
     * 读取商品缓存
     * @access public
     * @author csdeshang
     * @param type $goods_id 商品id
     * @return type
     */
    private function _rGoodsCache($goods_id) {
        return rcache($goods_id, 'goods');
    }

    /**
     * 写入商品缓存
     * @access public
     * @author csdeshang
     * @param int $goods_id 商品id
     * @param array $goods_info 商品信息
     * @return boolean
     */
    private function _wGoodsCache($goods_id, $goods_info) {
        return wcache($goods_id, $goods_info, 'goods');
    }

    /**
     * 删除商品缓存
     * @access public
     * @author csdeshang
     * @param int $goods_id 商品id
     * @return boolean
     */
    private function _dGoodsCache($goods_id) {
        return dcache($goods_id, 'goods');
    }



    /**
     * 获取单条商品信息
     * @access public
     * @author csdeshang
     * @param int $goods_id 商品ID 
     * @return array
     */
    public function getGoodsDetail($goods_id) {
        if ($goods_id <= 0) {
            return null;
        }
        $result1 = $this->getGoodsInfoAndPromotionById($goods_id);

        if (empty($result1)) {
            return null;
        }
        $result2 = $this->getGoodsInfoByID($result1['goods_id']);
        $goods_info = array_merge($result2, $result1);
        // 手机商品描述
        if ($goods_info['mobile_body'] != '') {
            $mobile_body_array = unserialize($goods_info['mobile_body']);
            if (is_array($mobile_body_array)) {
                $mobile_body = '';
                foreach ($mobile_body_array as $val) {
                    switch ($val['type']) {
                        case 'text':
                            $mobile_body .= '<div>' . $val['value'] . '</div>';
                            break;
                        case 'image':
                            $mobile_body .= '<img src="' . $val['value'] . '">';
                            break;
                    }
                }
                $goods_info['mobile_body'] = $mobile_body;
            }
        }


        $goods_image = array();
        $goods_image[] = array(goods_thumb($goods_info, 270), goods_thumb($goods_info, 1260));


        // 商品受关注次数加1
        $goods_info['goods_click'] = intval($goods_info['goods_click']) + 1;
        if (config('cache_open')) {
            wcache('updateRedisDate', array($goods_id => $goods_info['goods_click']), 'goodsClick');
        } else {
            $this->editGoodsById(array('goods_click' => Db::raw('goods_click+1')), $goods_id);
        }
        $result = array();
        $result['goods_info'] = $goods_info;
        $result['goods_image'] = $goods_image;
        return $result;
    }

    /**
     * 获取移动端商品
     * @access public
     * @author csdeshang
     * @param type $goods_id 商品ID
     * @return array
     */
    public function getMobileBodyByGoodsID($goods_id) {
        $common_info = $this->_rGoodsCache($goods_id);
        if (empty($common_info)) {
            $common_info = $this->getGoodsInfo(array('goods_id' => $goods_id));
            $this->_wGoodsCache($goods_id, $common_info);
        }


        // 手机商品描述
        if ($common_info['mobile_body'] != '') {
            $mobile_body_array = unserialize($common_info['mobile_body']);
            if (is_array($mobile_body_array)) {
                $mobile_body = '';
                foreach ($mobile_body_array as $val) {
                    switch ($val['type']) {
                        case 'text':
                            $mobile_body .= '<div>' . $val['value'] . '</div>';
                            break;
                        case 'image':
                            $mobile_body .= '<img src="' . $val['value'] . '">';
                            break;
                    }
                }
                $common_info['mobile_body'] = $mobile_body;
            }
        }
        return $common_info;
    }

}
