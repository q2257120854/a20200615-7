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
class  Exampaper extends Model {

    public $page_info;

    /**
     * 获取试卷列表
     * @author csdeshang
     * @param type $condition 查询条件
     * @param type $pagesize      分页信息
     * @param type $order     排序
     * @return type
     */
    public function getExampaperList($condition, $pagesize = '', $order='') {
        if ($pagesize) {
            $result = db('exampaper')->where($condition)->order($order)->paginate($pagesize, false, ['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        } else {
            return db('exampaper')->where($condition)->order($order)->select();
        }
    }

    /**
     * 删除试卷
     * @author csdeshang
     * @param type $condition 删除条件
     * @return type
     */
    public function delExampaper($condition) {
        return db('exampaper')->where($condition)->delete();
    }
    
    /**
     * 获取单条试卷
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function getOneExampaper($condition) {
        return db('exampaper')->where($condition)->find();
    }
    
    
    /**
     * 增加试卷
     * @author csdeshang
     * @param type $data
     * @return type
     */
    public function addExampaper($data) {
        return db('exampaper')->insertGetId($data);
    }
    /**
     * 更新信息
     * @access public
     * @author csdeshang
     * @param array $data 更新数据
     * @return bool 布尔类型的返回结果
     */
    public function editExampaper($condition,$data){
        $result = db('exampaper')->where($condition)->update($data);
        return $result;
    }

}
