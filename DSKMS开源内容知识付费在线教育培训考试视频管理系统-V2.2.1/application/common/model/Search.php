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
class  Search extends Model {


    /**
     * 删除搜索索引中的无效商品
     * @access public
     * @author csdeshang
     * @param type $goods_list 商品列表
     * @param type $indexer_ids id数组
     */
    public function delInvalidGoods($goods_list, $indexer_ids = array()) {
        $goods_ids = array();
        foreach ($goods_list as $k => $v) {
            $goods_ids[] = $v['goods_id'];
        }
        $_diff_ids = array_diff($indexer_ids, $goods_ids);

        if (!empty($_diff_ids)) {
            file_put_contents(RUNTIME_PATH  . 'log/search.log', date('Y-m-d H:i:s', TIMESTAMP) . "\r\n", FILE_APPEND);
            file_put_contents(RUNTIME_PATH  . 'log/search.log', implode(',', $indexer_ids) . "\r\n", FILE_APPEND);
            file_put_contents(RUNTIME_PATH  . 'log/search.log', implode(',', $goods_ids) . "\r\n", FILE_APPEND);
            file_put_contents(RUNTIME_PATH  . 'log/search.log', implode(',', $_diff_ids) . "\r\n\r\n", FILE_APPEND);
        }
    }


    /**
     * 从TAG中查找分类
     * @access public
     * @author csdeshang
     * @param type $keyword 
     * @return type
     */
    public function getTagCategory($keyword = '') {
        $data = array();
        if ($keyword != '') {
            // 跟据class_tag缓存搜索出与keyword相关的分类
            $tag_list = rkcache('classtag', true);
            if (!empty($tag_list) && is_array($tag_list)) {
                foreach ($tag_list as $key => $val) {
                    $tag_value = $val['gctag_value'];
                    if (strpos($tag_value, $keyword)) {
                        $data[] = $val['gc_id'];
                    }
                }
            }
        }
        return $data;
    }
    /**
     * 获取父级分类，递归调用
     * @access public
     * @author csdeshang
     * @param type $gc_id 分类id
     * @param type $goods_class 商品分类
     * @param type $data 数据
     * @return type
     */
    private function _getParentCategory($gc_id, $goods_class, $data) {
        array_unshift($data, $gc_id);
        if (isset($goods_class[$gc_id]['gc_parent_id']) && $goods_class[$gc_id]['gc_parent_id'] != 0) {
            return $this->_getParentCategory($goods_class[$gc_id]['gc_parent_id'], $goods_class, $data);
        } else {
            return $data;
        }
    }

    /**
     * 显示左侧商品分类
     * @access public
     * @author csdeshang
     * @param type $param 分类id
     * @param type $sign 0为取得最后一级的同级分类，1为不取得
     * @return type
     */
    public function getLeftCategory($param, $sign = 0) {
        $data = array();
        if (!empty($param)) {
            $goods_class = model('goodsclass')->getGoodsclassForCacheModel();
            foreach ($param as $val) {
                $data[] = $this->_getParentCategory($val, $goods_class, array());
            }
        }
        $tpl_data = array();
        $gc_list = model('goodsclass')->get_all_category();
        foreach ($data as $value) {
            //$tpl_data[$val[0]][$val[1]][$val[2]] = $val[2];
            if (!empty($gc_list[$value[0]])) {   // 一级
                $tpl_data[$value[0]]['gc_id'] = $gc_list[$value[0]]['gc_id'];
                $tpl_data[$value[0]]['gc_name'] = $gc_list[$value[0]]['gc_name'];
                if (isset($value[0]) && isset($value[1]) && isset($gc_list[$value[0]]['class2'][$value[1]])) { // 二级
                    $tpl_data[$value[0]]['class2'][$value[1]]['gc_id'] = $gc_list[$value[0]]['class2'][$value[1]]['gc_id'];
                    $tpl_data[$value[0]]['class2'][$value[1]]['gc_name'] = $gc_list[$value[0]]['class2'][$value[1]]['gc_name'];
                    if (isset($value[0]) && isset($value[1]) && isset($value[2]) && isset($gc_list[$value[0]]['class2'][$value[1]]['class3'][$value[2]])) {    // 三级
                        $tpl_data[$value[0]]['class2'][$value[1]]['class3'][$value[2]]['gc_id'] = $gc_list[$value[0]]['class2'][$value[1]]['class3'][$value[2]]['gc_id'];
                        $tpl_data[$value[0]]['class2'][$value[1]]['class3'][$value[2]]['gc_name'] = $gc_list[$value[0]]['class2'][$value[1]]['class3'][$value[2]]['gc_name'];
                        if (!$sign) {   // 取得全部三级分类
                            foreach ($gc_list[$value[0]]['class2'][$value[1]]['class3'] as $val) {
                                $tpl_data[$value[0]]['class2'][$value[1]]['class3'][$val['gc_id']]['gc_id'] = $val['gc_id'];
                                $tpl_data[$value[0]]['class2'][$value[1]]['class3'][$val['gc_id']]['gc_name'] = $val['gc_name'];
                                if ($value[2] == $val['gc_id']) {
                                    $tpl_data[$value[0]]['class2'][$value[1]]['class3'][$val['gc_id']]['default'] = 1;
                                }
                            }
                        }
                    } else {    // 取得全部二级分类
                        if (!$sign) {   // 取得同级分类
                            if (!empty($gc_list[$value[0]]['class2'])) {
                                foreach ($gc_list[$value[0]]['class2'] as $gc2) {
                                    $tpl_data[$value[0]]['class2'][$gc2['gc_id']]['gc_id'] = $gc2['gc_id'];
                                    $tpl_data[$value[0]]['class2'][$gc2['gc_id']]['gc_name'] = $gc2['gc_name'];
                                    if (!empty($gc2['class3'])) {
                                        foreach ($gc2['class3'] as $gc3) {
                                            $tpl_data[$value[0]]['class2'][$gc2['gc_id']]['class3'][$gc3['gc_id']]['gc_id'] = $gc3['gc_id'];
                                            $tpl_data[$value[0]]['class2'][$gc2['gc_id']]['class3'][$gc3['gc_id']]['gc_name'] = $gc3['gc_name'];
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {    // 取得全部一级分类
                    if (!$sign) {   // 取得同级分类
                        if (!empty($gc_list)) {
                            foreach ($gc_list as $gc1) {
                                $tpl_data[$gc1['gc_id']]['gc_id'] = $gc1['gc_id'];
                                $tpl_data[$gc1['gc_id']]['gc_name'] = $gc1['gc_name'];
                                if (!empty($gc1['class2'])) {
                                    foreach ($gc1['class2'] as $gc2) {
                                        $tpl_data[$gc1['gc_id']]['class2'][$gc2['gc_id']]['gc_id'] = $gc2['gc_id'];
                                        $tpl_data[$gc1['gc_id']]['class2'][$gc2['gc_id']]['gc_name'] = $gc2['gc_name'];
                                        if (!empty($gc2['class3'])) {
                                            foreach ($gc2['class3'] as $gc3) {
                                                $tpl_data[$gc1['gc_id']]['class2'][$gc2['gc_id']]['class3'][$gc3['gc_id']]['gc_id'] = $gc3['gc_id'];
                                                $tpl_data[$gc1['gc_id']]['class2'][$gc2['gc_id']]['class3'][$gc3['gc_id']]['gc_name'] = $gc3['gc_name'];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $tpl_data;
    }


}

?>
