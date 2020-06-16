<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/10
 * Time: 17:40
 */

namespace app\common\validate;


use think\Validate;

class Nav extends Validate
{
    protected $rule = [
        ['nav_title','require|max:12','请输入导航标题|导航最大长度为12'],
        ['nav_url','require|url','请输入导航链接|请输入正确的导航链接'],
    ];

    protected $scene = [
        'add' => ['nav_title','nav_url'],
        'edit' => ['nav_title','nav_url'],
    ];
}