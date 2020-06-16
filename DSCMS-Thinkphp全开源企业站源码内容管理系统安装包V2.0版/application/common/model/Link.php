<?php

namespace app\common\model;

use think\Model;

class link extends Model
{
    public $page_info;


    /**
     * 新增友情链接
     * @author csdeshang
     * @param type $param
     * @return type
     */
    public function addLink($data)
    {
        $data['lang_mark'] = config('default_lang');
        return db('link')->insertGetId($data);
    }

    /**
     * 编辑友情链接
     * @author csdeshang
     * @param type $condition
     * @param type $update
     * @return type
     */
    public function editLink($condition, $update)
    {
        $condition['lang_mark'] = config('default_lang');
        return db('link')->where($condition)->update($update);
    }

    /**
     * 删除友情链接
     * @author csdeshang
     * @param type $condition
     * @return type
     */
    public function delLink($condition)
    {
        $condition['lang_mark'] = config('default_lang');
        $link_array = $this->getlinkList($condition, 'link_id,link_weblogo');
        $linkid_array = array();
        foreach ($link_array as $value) {
            $linkid_array[] = $value['link_id'];
            @unlink(BASE_UPLOAD_PATH . DS . ATTACH_CASES . DS . $value['link_weblogo']);
        }
        return db('link')->where(array('link_id' => array('in', $linkid_array)))->delete();
    }


    /**
     * 获取友情链接列表
     * @author csdeshang
     * @param type $condition 条件
     * @param type $field   字段
     * @param type $page    分页
     * @param type $order   排序
     * @return type
     */
    public function getLinkList($condition, $field = '*', $page = 0, $order = 'link_order asc, link_id desc')
    {
        $condition['lang_mark'] = config('default_lang');
        if ($page) {
            $res = db('link')->where($condition)->field($field)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('link')->where($condition)->field($field)->order($order)->select();
        }
    }

    /**
     * 取单个友链内容
     * @author csdeshang
     * @param type $condition
     * @param type $field
     * @return type
     */
    public function getOneLink($condition, $field = '*')
    {
        $condition['lang_mark'] = config('default_lang');
        return db('link')->field($field)->where($condition)->find();
    }
}

?>
