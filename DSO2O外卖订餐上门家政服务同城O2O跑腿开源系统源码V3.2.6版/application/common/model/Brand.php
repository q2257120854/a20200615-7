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
class  Brand extends Model {
    
public $page_info;
    /**
     * 添加品牌
     * @access public
     * @author csdeshang 
     * @param array $data 参数内容
     * @return boolean
     */
    public function addBrand($data) {
        return db('brand')->insertGetId($data);
    }
    
    /**
     * 编辑品牌
     * @access public
     * @author csdeshang 
     * @param array $condition 检索条件
     * @param array $update 更新数据
     * @return boolean
     */
    public function editBrand($condition, $update) {
        return db('brand')->where($condition)->update($update);
    }
    
    /**
     * 删除品牌
     * @access public
     * @author csdeshang
     * @param array $condition 检索条件
     * @return boolean
     */
    public function delBrand($condition) {
        $brand_array = $this->getBrandList($condition, 'brand_id,brand_pic');
        $brandid_array = array();
        foreach ($brand_array as $value) {
            $brandid_array[] = $value['brand_id'];
            @unlink(BASE_UPLOAD_PATH.DS.ATTACH_BRAND.DS.$value['brand_pic']);
        }
        return db('brand')->where(array('brand_id' => array('in', $brandid_array)))->delete();
    }
    
    /**
     * 查询品牌数量
     * @access public
     * @author csdeshang
     * @param array $condition 检索条件
     * @return array
     */
    public function getBrandCount($condition) {
        return db('brand')->where($condition)->count();
    }
    
    /**
     * 品牌列表
     * @access public
     * @author csdeshang 
     * @param array $condition 检索条件
     * @param str $field 字段
     * @param int $pagesize 分页信息
     * @param str $order 排序
     * @return array
     */
    public function getBrandList($condition, $field = '*', $pagesize = 0, $order = 'brand_sort asc, brand_id desc') {
        if($pagesize) {
            $res= db('brand')->where($condition)->field($field)->order($order)->paginate($pagesize,false,['query' => request()->param()]);
            $this->page_info=$res;
            return $res->items();
        }else{
            return db('brand')->where($condition)->field($field)->order($order)->select();
        }
    }
    
    /**
     * 通过的品牌列表
     * @access public
     * @author csdeshang 
     * @param array $condition 检索条件
     * @param str $field 字段
     * @param int $pagesize 分页信息
     * @param str $order 排序
     * @return array
     */
    public function getBrandPassedList($condition, $field = '*', $pagesize = 0, $order = 'brand_sort asc, brand_id desc') {
        $condition['brand_apply'] = 1;
        return $this->getBrandList($condition, $field, $pagesize, $order);
    }
    
    /**
     * 未通过的品牌列表
     * @access public
     * @author csdeshang 
     * @param array $condition 检索条件
     * @param string $field 字段
     * @param string $pagesize 分页信息
     * @return array
     */
    public function getBrandNoPassedList($condition, $field = '*', $pagesize = 0) {
        $condition['brand_apply'] = 0;
        return $this->getBrandList($condition, $field, $pagesize);
    }
    
    /**
     * 取单个品牌内容
     * @access public
     * @author csdeshang 
     * @param array $condition 检索条件
     * @param string $field 字段
     * @return array
     */
    public function getBrandInfo($condition, $field = '*') {
        return db('brand')->field($field)->where($condition)->find();
    }
}
?>
