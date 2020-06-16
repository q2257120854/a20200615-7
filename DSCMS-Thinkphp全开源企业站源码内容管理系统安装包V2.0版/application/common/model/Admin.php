<?php
namespace app\common\model;
use think\Model;
class Admin extends Model
{

    /**
     * 获取管理员列表
     * @author csdeshang
     * @param type $condition 条件
     * @param type $field     字段
     * @param type $page      分页
     * @param type $order     排序
     * @return type
     */
    public function getAdminList($condition = array(), $field = '*', $page = 0, $order = 'admin_id desc')
    {
        if ($page) {
            $member_list = db('admin')->alias('a')->join('__ADMINGROUP__ g', 'g.group_id = a.admin_group_id', 'LEFT')->where($condition)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $member_list;
            return $member_list->items();
        } else {
            return db('admin')->alias('a')->join('__ADMINGROUP__ g', 'g.group_id = a.admin_group_id', 'LEFT')->where($condition)->order($order)->select();
        }
    }

    /**
     * 新增管理员
     * @author csdeshang
     * @param type $data
     * @return type
     */
    public function addAdmin($data)
    {
        return db('admin')->insertGetId($data);
    }

    /**
     * 编辑管理员
     * @author csdeshang
     * @param type $condition
     * @param type $data
     * @return type
     */
    public function editAdmin($condition, $data)
    {
        return db('admin')->where($condition)->update($data);
    }

    /**
     * 删除管理员
     * @author csdeshang
     * @param type $condition
     * @return type
     */
    public function delAdmin($condition)
    {
        return db('admin')->where($condition)->delete();
    }

    /**
     * 取单个管理员
     * @author csdeshang
     * @param type $condition
     * @param type $field
     * @return type
     */
    public function getOneAdmin($condition, $field = '*')
    {
        return db('admin')->field($field)->where($condition)->find();
    }
}