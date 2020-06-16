<?php

namespace app\common\model;

use think\Model;

class job extends Model
{
    public $page_info;

    /**
     * 新增职位
     * @author csdeshang
     * @param type $param
     * @return type
     */
    public function addjob($data)
    {
        $data['lang_mark'] = config('default_lang');
        return db('job')->insertGetId($data);
    }

    /**
     * 编辑职位
     * @author csdeshang
     * @param type $condition  条件
     * @param type $update     数据
     * @return type
     */
    public function editjob($condition, $update)
    {
        $condition['lang_mark'] = config('default_lang');
        return db('job')->where($condition)->update($update);
    }

    /**
     * 删除职位
     * @author csdeshang
     * @param type $condition
     * @return type
     */
    public function deljob($condition)
    {
        return db('job')->where($condition)->delete();
    }

    /**
     * 获取职位列表
     * @author csdeshang
     * @param array $condition 条件数组
     * @param str $field  字段
     * @param int $page   分页
     * @param str $order  排序
     * @param int $limit 数量限制
     * @return array 返回数组类型结果
     */
    public function getjobList($condition, $field = '*', $page = 0, $limit = '', $order = 'job_order desc, job_id desc')
    {
        $condition['lang_mark'] = config('default_lang');
        if ($page) {
            $res = db('job')->where($condition)->field($field)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('job')->where($condition)->field($field)->order($order)->page($page)->limit($limit)->select();
        }
    }

    /**
     * 取单个职位内容
     * @author csdeshang
     * @param type $condition 条件
     * @param type $field  字段
     * @return type
     */
    public function getOneJob($condition, $field = '*')
    {
        $condition['lang_mark'] = config('default_lang');
        return db('job')->field($field)->where($condition)->find();
    }
}

?>
