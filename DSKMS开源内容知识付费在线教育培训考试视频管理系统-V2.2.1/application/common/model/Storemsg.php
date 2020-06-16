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
class  Storemsg extends Model
{
    public $page_info;

    /**
     * 新增机构消息
     * @access public
     * @author csdeshang
     * @param array $data 参数内容
     * @return type
     */
    public function addStoremsg($data) {
        $data['storemsg_addtime'] = TIMESTAMP;
        $storemsg_id = db('storemsg')->insertGetId($data);
        return $storemsg_id;
    }

    /**
     * 更新机构消息表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param array $update 更新数据
     * @return bool
     */
    public function editStoremsg($condition, $update) {
        return db('storemsg')->where($condition)->update($update);
    }

    /**
     * 查看机构消息详细
     * @access public
     * @author csdeshang
     * @param unknown $condition 条件
     * @param string $field 字段
     * @return bool
     */
    public function getStoremsgInfo($condition, $field = '*') {
        return db('storemsg')->field($field)->where($condition)->find();

    }

    /**
     * 机构消息列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $field 字段
     * @param type $pagesize 分页
     * @param type $order 排序
     * @return type
     */
    public function getStoremsgList($condition, $field = '*', $pagesize = '0', $order = 'storemsg_id desc') {
        $return =db('storemsg')->field($field)->where($condition)->order($order)->paginate($pagesize,false,['query' => request()->param()]);
        $this->page_info=$return;
        return $return->items();
    }

    /**
     * 计算消息数量
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return int
     */
    public function getStoremsgCount($condition) {
        return db('storemsg')->where($condition)->count();
    }

    /**
     * 删除机构消息
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return bool
     */
    public function delStoremsg($condition) {
        db('storemsg')->where($condition)->delete();
    }
}