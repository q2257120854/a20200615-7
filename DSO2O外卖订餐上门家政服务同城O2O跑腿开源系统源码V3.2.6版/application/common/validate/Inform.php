<?php

namespace app\common\validate;


use think\Validate;
/**
 * ============================================================================
 * DSMall多用户商城
 * ============================================================================
 * 版权所有 2014-2028 长沙德尚网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.csdeshang.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * 验证器
 */
class  Inform extends Validate
{
    protected $rule=[
        ['informtype_name','require|max:50|min:1','举报类型不能为空且不能大于50个字符'],
        ['informtype_desc','require|max:50|min:1','举报类型描述不能为空且不能大于100个字符'],
        ['informsubject_type_name','require|min:1|max:50','举报主题不能为空且不能大于50个字符'],
        ['informsubject_content','require|min:1|max:50','举报内容不能为空且不能大于50个字符'],
        ['informsubject_type_id','require|min:1|max:50','举报ID不能为空且不能大于50个字符'],
        ['inform_handle_message','require|max:100|min:1','处理信息不能为空且不能大于100个字符'],
        ['inform_content', 'require|max:100|min:1', '举报内容不能为空且不能大于100个字符'],
    ];

    protected $scene = [
        'inform_subject_type_save' => ['informtype_name', 'informtype_desc'],
        'inform_subject_save' => ['informsubject_type_name', 'informsubject_content', 'informsubject_type_id'],
        'inform_handle' => ['inform_handle_message'],
        'inform_save' => ['inform_content', 'informsubject_content'],
    ];
}