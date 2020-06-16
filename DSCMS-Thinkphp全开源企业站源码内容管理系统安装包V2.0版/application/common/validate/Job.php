<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/10
 * Time: 16:50
 */

namespace app\common\validate;


use think\Validate;

class Job extends Validate
{
    protected  $rule = [
        ['job_position','require|max:16','请输入职位名称|职位名称不能超过最大长度16'],
        ['job_count','egt:0','招聘人数至少1人'],
        ['job_place','require','请输入工作地点'],
        ['job_deal','require','请输入薪资水平!'],
        ['job_email','email','请输入正确的邮箱!'],
        ['job_content','require','请输入详细信息!'],
    ];

    protected  $scene = [
        'add' => ['job_position','job_count','job_place', 'job_deal', 'job_content', 'job_email',],
        'edit' => ['job_position','job_count','job_place', 'job_deal', 'job_content', 'job_email',],
    ];
}