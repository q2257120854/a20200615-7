<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/10
 * Time: 17:18
 */

namespace app\common\validate;


use think\Validate;

class Link extends Validate
{
    protected $rule = [
        ['link_webname','require|max:12','网站名称不能超过12位'],
        ['link_weburl','require|url','请输入网站链接|请输入真确的网站链接'],
        ['link_weblogo','require','请选择网站Logo'],
        ['link_info','require','请输入描述文字'],
    ];

    protected $scene = [
        'add' => ['link_webname','link_weburl', 'link_weblogo', 'link_info'],
        'edit' => ['link_webname','link_weburl', 'link_info'],
    ];
}