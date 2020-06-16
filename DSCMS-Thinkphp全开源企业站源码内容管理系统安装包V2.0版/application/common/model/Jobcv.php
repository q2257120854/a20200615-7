<?php

namespace app\common\model;

use think\Model;

class Jobcv extends Model
{
    public $page_info;

    
    /**
     * 添加简历
     * @author csdeshang
     * @param type $data   数据
     * @return type boolean 
     */
    public function addJobcv($data)
    {
        $data['lang_mark'] = config('default_lang');
        return db('jobcv')->insert($data);
    }
    
    /**
     * 编辑职位
     * @author csdeshang
     * @param type $condition 条件
     * @param type $update    更新数据
     * @return type
     */
    public function editJobcv($condition, $update)
    {
        $condition['lang_mark'] = config('default_lang');
        return db('jobcv')->where($condition)->update($update);
    }

    /**
     * 删除简历
     * @author csdeshang
     * @param type $condition
     * @return type
     */
    public function delJobcv($condition)
    {
        $condition['lang_mark'] = config('default_lang');
        return db('jobcv')->where($condition)->delete();
    }

    /**
     * 获取简历列表
     * @author csdeshang
     * @param type $condition 条件  
     * @param type $field     字段
     * @param type $page      分页
     * @param type $order     排序
     * @param type $limit     限制
     * @return type           数组
     */
    public function getJobcvList($condition, $field = '*', $page = 0, $limit = '', $order = 'jobcv_addtime desc, jobcv_id desc')
    {
        $condition['lang_mark'] = config('default_lang');
        if ($page) {
            $res = db('jobcv')->where($condition)->field($field)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('jobcv')->where($condition)->field($field)->order($order)->page($page)->limit($limit)->select();
        }
    }

    /**
     * 取单个简历内容
     * @author csdeshang
     * @param type $condition
     * @param type $field
     * @return type
     */
    public function getOneJobcv($condition, $field = '*')
    {
        $condition['lang_mark'] = config('default_lang');
        return db('jobcv')->field($field)->where($condition)->find();
    }
}

?>
