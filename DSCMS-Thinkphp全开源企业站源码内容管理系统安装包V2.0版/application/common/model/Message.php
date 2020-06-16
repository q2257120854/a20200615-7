<?php

namespace app\common\model;

use think\Model;

class Message extends Model
{
    public $page_info;
    
    
    /**
     * 添加留言
     * @author csdeshang
     * @param type $param
     * @return type
     */
    public function addMessage($data)
    {
        return db('message')->insertGetId($data);
    }

    /**
     * 删除留言
     * @author csdeshang
     * @param type $condition
     * @return type
     */
    public function delMessage($condition)
    {
        return db('message')->where($condition)->delete();
    }

    /**
     * 回复留言
     * @author csdeshang
     * @param type $condition
     * @param type $update
     * @return type
     */
    public function editMessage($condition, $update)
    {
        return db('message')->where($condition)->update($update);
    }

    /**
     * 获取留言列表
     * @author csdeshang
     * @param type $condition 条件
     * @param type $field 字段
     * @param type $page  分页
     * @param type $order 排序
     * @param type $limit 限制
     * @return type
     */
    public function getMessageList($condition, $field = '*', $page = 0, $limit = '', $order = 'message_addtime asc, message_id desc')
    {
        if ($page) {
            $res = db('message')->where($condition)->field($field)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('message')->where($condition)->field($field)->order($order)->page($page)->limit($limit)->select();
        }
    }

    /**
     * 取单个留言内容
     * @author csdeshang
     * @param type $condition
     * @param type $field
     * @return type
     */
    public function getOneMessage($condition, $field = '*')
    {
        return db('message')->field($field)->where($condition)->find();
    }
}

?>
