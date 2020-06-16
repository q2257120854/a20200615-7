<?php
namespace app\common\validate;
use think\Validate;

class Live extends Validate
{
    protected $rule =   [
        'live_name'  => 'require|max:255',
        'type_id'  => 'require',
      'live_epg'  => 'require',
    ];

    protected $message  =   [
        'live_name.require' => '名称必须',
      'live_epg.require' => 'EPG必须',
        'live_name.max'     => '名称最多不能超过255个字符',
        'type_id.require' => '分类必须',
    ];

    protected $scene = [
        'add'  =>  ['live_name','type_id','live_epg'],
        'edit'  =>  ['live_name','type_id','live_epg'],
    ];

}