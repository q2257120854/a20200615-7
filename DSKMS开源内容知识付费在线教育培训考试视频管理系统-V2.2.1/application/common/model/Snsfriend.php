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
class  Snsfriend extends Model {

    public $page_info;

    /**
     * 好友添加
     * @access public
     * @author csdeshang
     * @param type $data 数据
     * @return type
     */
    public function addSnsfriend($data) {
        $result = db('snsfriend')->insertGetId($data);
        return $result;
    }

    /**
     * 好友列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $field 字段
     * @param type $pagesize 分页
     * @param type $type 类型
     * @return type
     */
    public function getSnsfriendList($condition, $field = '*', $pagesize = '', $type = 'simple') {
        //得到条件语句
        $order = isset($condition['order']) ? $condition['order'] : 'friend_id desc';
        switch ($type) {
            case 'simple':
                $data = db('snsfriend')->where($condition)->order($order)->field($field)->paginate($pagesize,false,['query' => request()->param()]);
                $this->page_info = $data;
                $friend_list = $data->items();
                break;
            case 'detail':
                $data = db('snsfriend')->alias('snsfriend')->where($condition)->order($order)->field($field)->join('__MEMBER__ member', 'snsfriend.friend_tomid=member.member_id')->paginate($pagesize,false,['query' => request()->param()]);
                $this->page_info = $data;
                $friend_list = $data->items();
                break;
            case 'fromdetail':
                $data = db('snsfriend')->alias('snsfriend')->where($condition)->order($order)->field($field)->join('__MEMBER__ member', 'snsfriend.friend_frommid=member.member_id')->paginate($pagesize,false,['query' => request()->param()]);
                $this->page_info = $data;
                $friend_list = $data->items();
                break;
        }
        return $friend_list;
    }

    /**
     * 获取好友详细
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $field 字段
     * @return type
     */
    public function getOneSnsfriend($condition, $field = '*') {
        return db('snsfriend')->where($condition)->field($field)->find();
    }

    /**
     * 好友总数
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function getSnsfriendCount($condition) {
        //得到条件语句
        $count = db('snsfriend')->where($condition)->count();
        return $count;
    }

    /**
     * 更新好友信息
     * @access public
     * @author csdeshang
     * @param type $data 更新数据
     * @param type $condition 条件
     * @return boolean
     */
    public function editSnsfriend($data, $condition) {
        if (empty($data)) {
            return false;
        }
        //得到条件语句
        $result = db('snsfriend')->where($condition)->update($data);
        return $result;
    }

    /**
     * 删除关注
     * @access public
     * @author csdeshang
     * @param type $condition
     * @return boolean
     */
    public function delSnsfriend($condition) {
        if (empty($condition)) {
            return false;
        }
        $where = '1=1';
        if ($condition['friend_frommid'] != '') {
            $where .= " and friend_frommid='{$condition['friend_frommid']}' ";
        }
        if ($condition['friend_tomid'] != '') {
            $where .= " and friend_tomid='{$condition['friend_tomid']}' ";
        }
        return db('snsfriend')->where($where)->delete();
    }

}