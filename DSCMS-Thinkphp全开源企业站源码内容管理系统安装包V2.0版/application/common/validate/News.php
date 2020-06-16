<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/10
 * Time: 17:49
 */

namespace app\common\validate;


use think\Validate;

class News extends Validate
{
    protected $rule = [
        ['column_id','require','请输入新闻所属栏目'],
        ['news_title','require|max:12','请输入新闻标题|新闻标题长度不能超过12位'],
        ['news_imgurl','require','请选择新闻缩略图'],
    ];

    protected $scene = [
        'add' => ['column_id','news_title','news_imgurl'],
        'edit' => ['column_id','news_title'],
    ];
}