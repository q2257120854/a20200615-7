<?php

namespace app\common\model;

use think\Model;

class Cases extends Model
{
    public $page_info;

    /*
     * 新增案例
     */
    /**
     * 新增案例
     * @author csdeshang
     * @param type $param
     * @return type
     */
    public function addCases($data)
    {
        $data['lang_mark'] = config('default_lang');
        return db('cases')->insertGetId($data);
    }

    /**
     * 编辑案例
     * @author csdeshang
     * @param array $condition 条件
     * @param type $update 更新数据
     * @return type
     */
    public function editCases($condition, $update)
    {
        $condition['lang_mark'] = config('default_lang');
        return db('cases')->where($condition)->update($update);
    }

    /**
     * 删除案例
     * @author csdeshang
     * @param unknown $condition
     * @return boolean
     */
    public function delCases($condition)
    {
        $condition['lang_mark'] = config('default_lang');
        $cases_array = $this->getCasesList($condition, 'cases_id,cases_imgurl');
        $casesid_array = array();
        foreach ($cases_array as $value) {
            $casesid_array[] = $value['cases_id'];
            @unlink(BASE_UPLOAD_PATH . DS . ATTACH_CASES . DS . $value['cases_imgurl']);
        }
        return db('cases')->where(array('cases_id' => array('in', $casesid_array)))->delete();
    }

    /**
     * 获取案例列表
     * @author csdeshang
     * @param array $condition 条件
     * @param type $field  字段
     * @param type $page   分页
     * @param type $order  排序
     * @param type $limit  数量限制
     * @return type 数组
     */
    public function getCasesList($condition, $field = '*', $page = 0, $limit = '', $order = 'cases_order desc, cases_id desc')
    {
        $condition['lang_mark'] = config('default_lang');

        if ($page) {
            $res = db('cases')->where($condition)->field($field)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('cases')->where($condition)->field($field)->order($order)->page($page)->limit($limit)->select();
        }
    }

    /**
     * 取单个案例内容
     * @author csdeshang
     * @param array $condition
     * @param type $field
     * @return type
     */
    public function getOneCases($condition, $field = '*')
    {
        $condition['lang_mark'] = config('default_lang');
        return db('cases')->field($field)->where($condition)->find();
    }
}

?>
