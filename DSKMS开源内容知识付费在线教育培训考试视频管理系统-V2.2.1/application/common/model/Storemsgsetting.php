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
class  Storemsgsetting extends Model
{
    public $page_info;
 
    /**
     * 机构消息接收设置列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $field 字段
     * @param type $key 键值
     * @param type $pagesize 分页
     * @param type $order 排序
     * @return type
     */
    public function getStoremsgsettingList($condition, $field = '*', $key = '', $pagesize = 0, $order = 'storemt_code asc') {
        $res=db('storemsgsetting')->field($field)->where($condition)->order($order)->paginate($pagesize,false,['query' => request()->param()]);
        $this->page_info=$res;
        $result= $res->items();
        return ds_change_arraykey($result,$key);

    }

    /**
     * 机构消息接收设置详细
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $field 字段
     * @return type
     */
    public function getStoremsgsettingInfo($condition, $field = '*') {
        return db('storemsgsetting')->field($field)->where($condition)->find();
    }

    /**
     * 添加机构模板接收设置
     * @access public
     * @author csdeshang
     * @param array $data 新增数据
     * @return bool
     */
    public function addStoremsgsetting($data) {
        return db('storemsgsetting')->insert($data);
    }

    /**
     * 编辑机构模板接收设置
     * @access public
     * @author csdeshang
     * @param array $data 更新数据
     * @return bool
     */
    public function editStoremsgsetting($data, $condition) {
        return db('storemsgsetting')->where($condition)->update($data);
    }
}