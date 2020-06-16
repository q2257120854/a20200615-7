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
class  LiveApply extends Model {

    public $page_info;

    public function getLiveApplyList($condition, $field = '*', $pagesize,$order='live_apply_id desc') {
        if ($pagesize) {
            $result = db('live_apply')->field($field)->where($condition)->order($order)->paginate($pagesize, false, ['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        } else {
            $result = db('live_apply')->field($field)->where($condition)->order($order)->select();
            return $result;
        }
    }

    /**
     * 取单个内容
     * @access public
     * @author csdeshang
     * @param int $id 分类ID
     * @return array 数组类型的返回结果
     */
    public function getLiveApplyInfo($condition) {
        $result = db('live_apply')->where($condition)->find();
        return $result;
    }

    /**
     * 新增
     * @access public
     * @author csdeshang
     * @param array $data 参数内容
     * @return bool 布尔类型的返回结果
     */
    public function addLiveApply($data) {
        $result = db('live_apply')->insertGetId($data);
        return $result;
    }

    /**
     * 更新信息
     * @access public
     * @author csdeshang
     * @param array $data 数据
     * @param array $condition 条件
     * @return bool
     */
    public function editLiveApply($data, $condition) {
        $result = db('live_apply')->where($condition)->update($data);
        return $result;
    }

    /**
     * 删除分类
     * @access public
     * @author csdeshang
     * @param int $condition 记录ID
     * @return bool 
     */
    public function delLiveApply($condition) {
        return db('live_apply')->where($condition)->delete();
    }

    function getPushUrl($domain, $streamName, $key = null, $time = null) {
        if ($key && $time) {
            $txTime = strtoupper(base_convert($time, 10, 16));
            $txSecret = md5($key . $streamName . $txTime);
            $ext_str = "?" . http_build_query(array(
                        "txSecret" => $txSecret,
                        "txTime" => $txTime
            ));
        }
        return "rtmp://" . $domain . "/live/" . $streamName . (isset($ext_str) ? $ext_str : "");
    }
    
    function getPlayUrl($domain, $streamName){
        return HTTP_TYPE.$domain.'/live/'.$streamName.'.m3u8';
    }
}
