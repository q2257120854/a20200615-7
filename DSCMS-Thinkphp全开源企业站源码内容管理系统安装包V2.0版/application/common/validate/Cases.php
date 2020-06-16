<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/10
 * Time: 15:57
 */

namespace app\common\validate;


use think\Validate;

class Cases extends Validate
{
    protected $rule = [
        ['cases_title','require|max:16','请填写案例标题','案列标题最大长度16位'],
        ['cases_imgurl','require','请选择图片!'],
        ['cases_content','require','请填写案列内容!'],
        ['column_id','require','请选择案例所属栏目!'],
    ];

    protected $scene = [
        'add' => ['cases_title','cases_content','cases_imgurl','column_id'],
        'edit' => ['cases_title','cases_content','cases_imgurl','column_id'],
    ];
}