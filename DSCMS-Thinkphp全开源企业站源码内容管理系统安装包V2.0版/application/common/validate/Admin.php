<?php
/**
 * 管理员
 */
namespace app\common\validate;


use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        ['admin_name','require|length:3,12|unique:admin,admin_name','请填写管理员名称|管理员名称3-12长度|该管理员已存在'],
        ['admin_password','require|length:6,12','请填写管理员密码|管理员密码6-12的密码'],
    ];

    protected $scene = [
        'add' => ['admin_name','admin_password'],
        'edit' => ['admin_name','admin_password'],
    ];
}