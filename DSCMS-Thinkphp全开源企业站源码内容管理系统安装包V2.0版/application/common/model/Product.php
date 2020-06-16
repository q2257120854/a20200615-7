<?php

namespace app\common\model;

use think\Model;

class Product extends Model
{
    public $page_info;


    /**
     * 新增产品
     * @author csdeshang
     * @param type $param
     * @return type
     */
    public function addProduct($data)
    {
        $data['lang_mark'] = config('default_lang');
        return db('product')->insertGetId($data);
    }

    /**
     * 编辑产品
     * @author csdeshang
     * @param type $condition
     * @param type $update
     * @return type
     */
    public function editProduct($condition, $update)
    {
        $condition['lang_mark'] = config('default_lang');
        return db('product')->where($condition)->update($update);
    }

    /**
     * 删除产品
     * @author csdeshang
     * @param type $condition
     * @return type
     */
    public function delProduct($condition)
    {
        $condition['lang_mark'] = config('default_lang');
        $product_array = $this->getProductList($condition, 'product_id,product_imgurl');
        $productid_array = array();
        foreach ($product_array as $value) {
            $productid_array[] = $value['product_id'];
            @unlink(BASE_UPLOAD_PATH . DS . ATTACH_PRODUCT . DS . $value['product_img']);
        }
        return db('product')->where(array('product_id' => array('in', $productid_array)))->delete();
    }

    /**
     * 获取产品列表
     * @author csdeshang
     * @param type $condition 条件
     * @param type $field  字段
     * @param type $page   分页
     * @param type $order  排序
     * @param type $limit  数量限制
     * @return type
     */
    public function getProductList($condition, $field = '*', $page = 0, $limit = '', $order = 'product_order desc, product_id desc')
    {
        $condition['lang_mark'] = config('default_lang');
        if ($page) {
            $res = db('product')->where($condition)->field($field)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('product')->where($condition)->field($field)->order($order)->page($page)->limit($limit)->select();
        }
    }

    /**
     * 取单个产品内容
     * @author csdeshang
     * @param type $condition
     * @param type $field
     * @return type
     */
    public function getOneProduct($condition, $field = '*')
    {
        $condition['lang_mark'] = config('default_lang');
        return db('product')->field($field)->where($condition)->find();
    }
}

?>
