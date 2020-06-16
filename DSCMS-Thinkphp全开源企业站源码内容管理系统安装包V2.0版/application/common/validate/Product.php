<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/10
 * Time: 18:05
 */

namespace app\common\validate;


use think\Validate;

class Product extends Validate
{
    protected $rule = [
        ['column_id','require','请选择产品所属栏目!'],
        ['product_title','require|max:12','请输入产品标题|产品标题长度不能超过12位'],
        ['product_imgurl','require','请选择图片!'],
        ['product_content','require','请输入产品的内容!'],
    ];

    protected $scene = [
        'add' => ['column_id','product_title','product_imgurl','product_content'],
        'edit' => ['column_id','product_title','product_content'],
    ];
}