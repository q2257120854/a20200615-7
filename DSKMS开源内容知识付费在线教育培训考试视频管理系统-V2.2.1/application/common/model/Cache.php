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
class  Cache extends Model {
    /**
     * @access public
     * @author csdeshang 
     * @param string $method
     * @return boolean
     */
    public function call($method) {
        $method = '_' . strtolower($method);
        if (method_exists($this, $method)) {
            return $this->$method();
        } else {
            return false;
        }
    }

    /**
     * 基本设置
     * @access private
     * @author csdeshang 
     * @return array
     */
    private function _config() {
        $result = db('config')->select();
        if (is_array($result)) {
            $list_config = array();
            foreach ($result as $k => $v) {
                $list_config[$v['code']] = $v['value'];
            }
        }
        unset($result);
        return $list_config;
    }

    /**
     * 商品分类SEO
     * @access private
     * @author csdeshang
     * @return array
     */
    private function _goodsclassseo() {

        $list = db('goodsclass')->field('gc_id,gc_title,gc_keywords,gc_description')->where(array('gc_keywords' => array('neq', '')))->limit(false)->select();
        if (!is_array($list))
            return null;
        $array = array();
        foreach ($list as $k => $v) {
            if ($v['gc_title'] != '' || $v['gc_keywords'] != '' || $v['gc_description'] != '') {
                if ($v['gc_name'] != '') {
                    $array[$v['gc_id']]['name'] = $v['gc_name'];
                }
                if ($v['gc_title'] != '') {
                    $array[$v['gc_id']]['title'] = $v['gc_title'];
                }
                if ($v['gc_keywords'] != '') {
                    $array[$v['gc_id']]['key'] = $v['gc_keywords'];
                }
                if ($v['gc_description'] != '') {
                    $array[$v['gc_id']]['desc'] = $v['gc_description'];
                }
            }
        }
        return $array;
    }


    /**
     * 商城主要频道SEO
     * @access private
     * @author csdeshang
     * @return array
     */
    private function _seo() {
        $list = db('seo')->limit(false)->select();
        if (!is_array($list))
            return null;
        $array = array();
        foreach ($list as $key => $value) {
            $array[$value['seo_type']] = $value;
        }
        return $array;
    }


    /**
     * 自定义导航
     * @access private
     * @author csdeshang
     * @return array
     */
    private function _nav() {
        $list = db('navigation')->order('nav_sort')->limit(false)->select();
        if (!is_array($list))
            return null;
        return $list;
    }



    /**
     * 机构分类
     * @access private
     * @author csdeshang
     * @return array
     */
    private function _storeclass() {
        $store_class_tmp = db('storeclass')->limit(false)->order('storeclass_sort asc,storeclass_id asc')->select();
        $store_class = array();
        if (is_array($store_class_tmp) && !empty($store_class_tmp)) {
            foreach ($store_class_tmp as $k => $v) {
                $store_class[$v['storeclass_id']] = $v;
            }
        }
        return $store_class;
    }

    /**
     * 机构等级
     * @access private
     * @author csdeshang
     * @return array
     */
    private function _storegrade() {
        $list = db('storegrade')->limit(false)->select();
        $array = array();
        foreach ((array) $list as $v) {
            $array[$v['storegrade_id']] = $v;
        }
        unset($list);
        return $array;
    }

    /**
     * 机构消息模板
     * @access private
     * @author csdeshang
     * @return array
     */
    private function _storemsgtpl() {
        $list = model('storemsgtpl')->getStoremsgtplList(array());
        $array = array();
        foreach ((array) $list as $v) {
            $array[$v['storemt_code']] = $v;
        }
        unset($list);
        return $array;
    }

    /**
     * 用户消息模板
     * @access private
     * @author csdeshang
     * @return array
     */
    private function _membermsgtpl() {
        $list = model('membermsgtpl')->getMembermsgtplList(array());
        $array = array();
        foreach ((array) $list as $v) {
            $array[$v['membermt_code']] = $v;
        }
        unset($list);
        return $array;
    }

    /**
     * 咨询类型
     * @access private
     * @author csdeshang
     * @return array
     */
    private function _consulttype() {
        $list = model('consulttype')->getConsulttypeList(array());
        $array = array();
        foreach ((array) $list as $val) {
            $val['consulttype_introduce'] = html_entity_decode($val['consulttype_introduce']);
            $array[$val['consulttype_id']] = $val;
        }
        unset($list);
        return $array;
    }


}
