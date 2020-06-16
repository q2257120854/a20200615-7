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
class  Exambank extends Model {

    public $page_info;

    /**
     * 获取题库列表
     * @author csdeshang
     * @param type $condition 查询条件
     * @param type $pagesize      分页信息
     * @param type $order     排序
     * @return type
     */
    public function getExambankList($condition, $pagesize = '', $order='') {
        if ($pagesize) {
            $result = db('exambank')->where($condition)->order($order)->paginate($pagesize, false, ['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        } else {
            return db('exambank')->where($condition)->order($order)->select();
        }
    }

    /**
     * 删除题库
     * @author csdeshang
     * @param type $condition 删除条件
     * @return type
     */
    public function delExambank($condition) {
        return db('exambank')->where($condition)->delete();
    }
    
    /**
     * 获取单条题库
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function getOneExambank($condition) {
        return db('exambank')->where($condition)->find();
    }
    
    
    /**
     * 增加题库
     * @author csdeshang
     * @param type $data
     * @return type
     */
    public function addExambank($data) {
        return db('exambank')->insertGetId($data);
    }
    /**
     * 更新信息
     * @access public
     * @author csdeshang
     * @param array $data 更新数据
     * @return bool 布尔类型的返回结果
     */
    public function editExambank($condition,$data){
        $result = db('exambank')->where($condition)->update($data);
        return $result;
    }
    /**
     * 获取题库难度列表
     */
    public function getLevelList()
    {
        return array(
            '1'=>'非常容易',
            '2'=>'比较容易',
            '0'=>'常规',
            '3'=>'较难',
            '4'=>'非常难',
        );
    }
    /**
     * 获取题型类型列表
     */
    public function getExamtypeList() {
        return array(
            '1' => '单选题',
            '2' => '多选题',
            '3' => '判断题',
            '4' => '填空题',
            '5' => '问答题',
        );
    }
}
