<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/13 0013
 * Time: 11:27
 */

namespace app\common\model;


use think\Model;

class Pic extends Model
{
    
    /**
     * 增加图片
     * @author csdeshang
     * @param type $data
     * @return type
     */
    public function addPic($data)
    {
        return db('pic')->insertGetId($data);
    }

    /**
     * 编辑更新图片
     * @author csdeshang
     * @param type $condition
     * @param type $data
     * @return type
     */
    public function editPic($condition, $data)
    {
        return db('pic')->where($condition)->update($data);
    }

    /**
     * 获取图片列表
     * @author csdeshang
     * @param type $condition 条件
     * @param type $page 分页
     * @param type $order 排序
     * @return type
     */
    public function getPicList($condition, $page = '', $order = 'pic_id desc')
    {
        if ($page) {
            $res = db('pic')->where($condition)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('pic')->where($condition)->order($order)->select();
        }
    }

    /**
     * 删除图片
     * @author csdeshang
     * @param type $condition
     * @param type $attach_type
     * @return type
     */
    public function delPic($condition, $attach_type)
    {
        switch ($attach_type) {
            case 'cases':
                $attach_type = ATTACH_CASES;
                break;
            case 'news':
                $attach_type = ATTACH_NEWS;
                break;
            case 'product':
                $attach_type = ATTACH_PRODUCT;
            default:
                break;
        }
        $casespic_list = $this->getpicList($condition);
        foreach ($casespic_list as $key => $casespic) {
            @unlink(BASE_UPLOAD_PATH . DS . $attach_type . DS . $casespic['pic_cover']);
        }
        return db('pic')->where($condition)->delete();
    }
}