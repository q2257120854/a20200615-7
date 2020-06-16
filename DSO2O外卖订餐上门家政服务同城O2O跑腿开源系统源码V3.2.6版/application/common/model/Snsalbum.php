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
class  Snsalbum extends Model
{
    public $page_info;
    /**
     * 获取默认相册分类
     * @access public
     * @author csdeshang
     * @param type $member_id 会员id
     * @return bool
     */
    public function getSnsAlbumClassDefault($member_id) {
        if(empty($member_id)) {
            return '0';
        }

        $condition = array();
        $condition['member_id'] = $member_id;
        $condition['ac_isdefault'] = 1;
        $info = db('snsalbumclass')->where($condition)->find();

        if(!empty($info)) {
            return $info['ac_id'];
        } else {
            return '0';
        }
    }
    /**
     * 获取会员相册分类列表
     * @param type $condition
     * @param type $pagesize
     * @param type $field
     * @return type
     */
    public function getSnsalbumclassList($condition,$pagesize,$field){
        if($pagesize){
            $result = db('snsalbumclass')->alias('a')->field('a.*,m.member_name')->join('__MEMBER__ m', 'a.member_id=m.member_id', 'LEFT')->where($condition)->paginate($pagesize,false,['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        } else {
            return db('snsalbumclass')->alias('a')->field('a.*,m.member_name')->join('__MEMBER__ m', 'a.member_id=m.member_id', 'LEFT')->where($condition)->select();
        }
        
    }
    /**
     * 获取会员相册数量列表
     * @param type $condition
     * @param type $field
     * @param type $group
     * @return type
     */
    public function getSnsalbumpicCountList($condition,$field,$group){
        return db('snsalbumpic')->field($field)->where($condition)->group($group)->select();
    }
    /**
     * 获取图片列表
     * @param type $condition
     * @return type
     */
    public function getSnsalbumpicList($condition,$pagesize=''){
        if($pagesize){
            $pic_list = db('snsalbumpic')->where($condition)->paginate($pagesize, false, ['query' => request()->param()]);
            $this->page_info=$pic_list;
            return $pic_list->items();
        } else {
            $pic_list = db('snsalbumpic')->where($condition)->select();
            return $pic_list;
        }
        
    }
    /**
     * 删除图片
     * @param type $condition
     * @return type
     */
    public function delSnsalbumpic($condition){
        return db('snsalbumpic')->where($condition)->delete();
    }
    /**
     * 获取单个图片
     * @param type $id
     * @return type
     */
    public function getOneSnsalbumpic($id){
        return db('snsalbumpic')->find($id);
    }
    /**
     * 根据ID删除图片
     * @param type $id
     * @return type
     */
    public function delPic($id){
        return db('snsalbumpic')->delete($id);
    }
}