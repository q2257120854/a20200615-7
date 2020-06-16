<?php

namespace app\common\model;

use think\Model;

class News extends Model
{
    public $page_info;


    /**
     * 新增新闻
     * @author csdeshang
     * @param type $data
     * @return type
     */
    public function addNews($data)
    {
        $data['lang_mark'] = config('default_lang');
        return db('news')->insertGetId($data);
    }

    /**
     * 编辑新闻
     * @author csdeshang
     * @param type $condition
     * @param type $data
     * @return type
     */
    public function editNews($condition, $data)
    {
        $condition['lang_mark'] = config('default_lang');
        return db('news')->where($condition)->update($data);
    }

    /**
     * 删除新闻
     * @author csdeshang
     * @param type $condition
     * @return type
     */
    public function delNews($condition)
    {
        $condition['lang_mark'] = config('default_lang');
        return db('news')->where($condition)->delete();
    }

    /**
     * 获取新闻列表
     * @author csdeshang
     * @param array $condition 条件数组
     * @param int $limit     数量限制
     * @param str $field     数表字段
     * @param int $page      分页页数
     * @param str $order     排序组合
     * @return array   返回数组类型数据集
     */
    public function getNewsList($condition = array(),$limit='', $field = '*', $page = '', $order = 'news_order desc,news_id desc')
    {
        $condition['lang_mark'] = config('default_lang');
        if ($page) {
            $res = db('news')->where($condition)->field($field)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('news')->where($condition)->field($field)->order($order)->limit($limit)->select();
        }
    }

    /**
     * 取单个新闻
     * @author csdeshang
     * @param type $condition
     * @param type $field
     * @return type
     */
    public function getOneNews($condition, $field = '*')
    {
        $condition['lang_mark'] = config('default_lang');
        return db('news')->field($field)->where($condition)->find();
    }
}
