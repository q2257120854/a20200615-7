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
class Vrgroupbuyclass extends Model
{
    /**
     * 线下分类信息
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @return array
     */
    public function getVrgroupbuyclassInfo($condition, $field = '*')
    {
        return db('vrgroupbuyclass')->field($field)->where($condition)->find();
    }

    /**
     * 线下分类列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param str $field 字段
     * @param str $order 排序
     * @param int $limit 限制
     * @return array
     */
    public function getVrgroupbuyclassList($condition = array(), $field = '*', $order = 'vrgclass_sort', $limit = '0,1000')
    {
        return db('vrgroupbuyclass')->where($condition)->order($order)->limit($limit)->select();
    }

    /**
     * 添加线下分类
     * @access public
     * @author csdeshang
     * @param array $data 数据
     * @return type
     */
    public function addVrgroupbuyclass($data)
    {
        return db('vrgroupbuyclass')->insertGetId($data);
    }

    /**
     * 编辑线下分类
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $data 更新数据
     * @return type
     */
    public function editVrgroupbuyclass($condition, $data)
    {
        return db('vrgroupbuyclass')->where($condition)->update($data);
    }

    /**
     * 删除线下分类
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return bool
     */
    public function delVrgroupbuyclass($condition)
    {
        return db('vrgroupbuyclass')->where($condition)->delete();
    }
}