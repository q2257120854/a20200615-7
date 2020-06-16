<?php

namespace app\home\controller;

use think\Lang;
use think\Loader;
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
 * 控制器
 */
class  Cloudtencent extends BaseMall {

    public function _initialize() {
        parent::_initialize();
    }

    public function sign() {
// 确定 App 的云 API 密钥
        $secret_id = "AKIDJnjJr0Fc0PwZjMh24b5Oeme1HtJeod0c";
        $secret_key = "1zrbZOCqhpuovsVdhxulM65tXxCmxWGI";

// 确定签名的当前时间和失效时间
        $current = TIMESTAMP;
        $expired = $current + 86400;  // 签名有效期：1天
// 向参数列表填入参数
        $arg_list = array(
            "secretId" => $secret_id,
            "currentTimeStamp" => $current,
            "expireTime" => $expired,
            "random" => rand());

// 计算签名
        $orignal = http_build_query($arg_list);
        $signature = base64_encode(hash_hmac('SHA1', $orignal, $secret_key, true) . $orignal);

        ds_json_encode(10000,'',$signature);
    }

    public function test() {

        return $this->fetch($this->template_dir . 'test');
    }

}
