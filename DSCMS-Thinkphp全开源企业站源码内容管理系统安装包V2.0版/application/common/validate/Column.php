<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/10
 * Time: 16:24
 */

namespace app\common\validate;


use think\Validate;

class Column extends Validate
{
    protected $rule = [
        ['column_name','require|max:16','请输入栏目名称!|栏目名称最大16位'],
    ];

    protected $scene = [
        'add' => ['column_name'],
        'edit' => ['column_name'],
    ];
}