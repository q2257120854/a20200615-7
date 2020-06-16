<?php
/**
 * 权限组
 */
namespace app\common\validate;


use think\Validate;

class Admingroup extends Validate
{
    protected $rule = [
        ['group_name','require|length:2,6','请填写权限组名称|管理员密码2-6的密码'],
        ['group_limits','require','请选择权限组'],
    ];

    protected $scene = [
        'add' => ['group_name'],
        'edit' => ['group_name'],
    ];
}