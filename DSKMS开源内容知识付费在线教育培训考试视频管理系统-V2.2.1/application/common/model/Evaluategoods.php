<?php

namespace app\common\model;

use think\Model;
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
class  Evaluategoods extends Model {

    public $page_info;

    /**
     * 查询评价列表
     * @access public
     * @author csdeshang
     * @param array $condition 查询条件
     * @param int $pagesize 分页数
     * @param string $order 排序
     * @param string $field 字段
     * @return array
     */
    public function getEvaluategoodsList($condition, $pagesize = null, $order = 'geval_id desc', $field = '*') {
        if ($pagesize) {
            $list = db('evaluategoods')->field($field)->where($condition)->order($order)->paginate($pagesize,false,['query' => request()->param()]);
            $this->page_info = $list;
            return $list->items();
        } else {
            $list = db('evaluategoods')->field($field)->where($condition)->order($order)->select();
            return $list;
        }
    }

    /**
     * 根据编号查询商品评价
     * @access public
     * @author csdeshang
     * @param int $geval_id 编号
     * @param int $store_id 机构ID
     * @return type
     */
    public function getEvaluategoodsInfoByID($geval_id, $store_id = 0) {
        if (intval($geval_id) <= 0) {
            return null;
        }

        $info = db('evaluategoods')->where(array('geval_id' => $geval_id))->find();

        if ($store_id > 0 && intval($info['geval_storeid']) !== $store_id) {
            return null;
        } else {
            return $info;
        }
    }

    /**
     * 根据商品编号查询商品评价信息
     * @access public
     * @author csdeshang
     * @param int $goods_id 商品ID
     * @return array
     */
    public function getEvaluategoodsInfoByGoodsID($goods_id) {
        $prefix = 'goods_evaluation';
        $info = rcache($goods_id, $prefix);
        if (empty($info)) {
            $info = array();
            $count_array = db('evaluategoods')->field('count(*) as count,geval_scores')->where(array('geval_goodsid' => $goods_id))->group('geval_scores')->select();
            $count_array = ds_change_arraykey($count_array, 'geval_scores');
            $star1 = isset($count_array['1']['count']) ? intval($count_array['1']['count']) : 0;
            $star2 = isset($count_array['2']['count']) ? intval($count_array['2']['count']) : 0;
            $star3 = isset($count_array['3']['count']) ? intval($count_array['3']['count']) : 0;
            $star4 = isset($count_array['4']['count']) ? intval($count_array['4']['count']) : 0;
            $star5 = isset($count_array['5']['count']) ? intval($count_array['5']['count']) : 0;
            $info['good'] = $star4 + $star5;
            $info['normal'] = $star2 + $star3;
            $info['bad'] = $star1;
            $info['all'] = $star1 + $star2 + $star3 + $star4 + $star5;
            if (intval($info['all']) > 0) {
                $info['good_percent'] = intval($info['good'] / $info['all'] * 100);
                $info['normal_percent'] = intval($info['normal'] / $info['all'] * 100);
                $info['bad_percent'] = intval($info['bad'] / $info['all'] * 100);
                $info['good_star'] = ceil($info['good'] / $info['all'] * 5);
                $info['star_average'] = ceil(($star1 + $star2 * 2 + $star3 * 3 + $star4 * 4 + $star5 * 5) / $info['all']);
            } else {
                $info['good_percent'] = 100;
                $info['normal_percent'] = 0;
                $info['bad_percent'] = 0;
                $info['good_star'] = 5;
                $info['star_average'] = 5;
            }

            //更新商品表好评星级和评论数
            $goods_model = model('goods');
            $update = array();
            $update['evaluation_good_star'] = $info['star_average'];
            $update['evaluation_count'] = $info['all'];
            $goods_model->editGoodsById($update, $goods_id);
            wcache($goods_id, $info, $prefix);
        }
        return $info;
    }


    /**
     * 批量添加商品评价
     * @access public
     * @author csdeshang
     * @param array $datas 参数内容
     * @param array $goodsid_array 商品id数组，更新缓存使用
     * @return boolean
     */
    public function addEvaluategoodsArray($datas, $goodsid_array) {
        $result = db('evaluategoods')->insertAll($datas);
        // 删除商品评价缓存
        if ($result && !empty($goodsid_array)) {
            foreach ($goodsid_array as $goods_id) {
                dcache($goods_id, 'goods_evaluation');
            }
        }
        return $result;
    }

    /**
     * 更新商品评价
     * 
     * 现在此方法只是编辑晒单，不需要更新缓存
     * 如果使用此方法修改大星星数量请根据goods_id删除缓存
     * 例：dcache($goods_id, 'goods_evaluation');
     * @access public
     * @author csdeshang
     * @param array $update 更新数据
     * @param array $condition 条件
     * @return bool
     */
    public function editEvaluategoods($update, $condition) {
        return db('evaluategoods')->where($condition)->update($update);
    }

    /**
     * 删除商品评价
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return bool
     */
    public function delEvaluategoods($condition) {
        return db('evaluategoods')->where($condition)->delete();
    }

}

?>
