<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/10
 * Time: 14:34
 */

namespace app\common\validate;


use think\Validate;

class Advposition extends Validate
{
    protected $rule = [
        ['ap_name','require|length:5,16','请填写广告位名称!|广告位名称5-16长度'],
        ['ap_width','require|elt:1200','请填写广告位宽度!|广告位宽度最大为1200像素'],
        ['ap_height','require|elt:600','请填写广告位高度!|广告位高度最大为600像素'],
//        ['ap_width','number','广告位宽度为数字!'],
//        ['ap_height','number','广告位高度为数字!'],
    ];

    protected $scene = [
        'add' => ['ap_name','ap_width','ap_height'],
        'edit' => ['ap_name','ap_width','ap_height'],
    ];
}