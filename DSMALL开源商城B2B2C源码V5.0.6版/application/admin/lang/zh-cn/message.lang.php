<?php
$lang['message_mobile'] = '短信平台设置';
$lang['message_smslog'] = '短信记录';
$lang['message_seller_tpl'] = '商家消息模板';
$lang['message_member_tpl'] = '用户消息模板';
$lang['message_email_tpl'] = '其他模板';
$lang['message_seller_tpl_edit'] = '编辑商家消息模板';
$lang['message_member_tpl_edit'] = '编辑用户消息模板';
$lang['message_email_tpl_edit'] = '编辑其他消息模板';
$lang['message_ali_tpl'] = '阿里云短信模板';


$lang['smtp_server'] = 'SMTP 服务器';
$lang['set_smtp_server_address'] = '设置 SMTP 服务器的地址，如 smtp.163.com';
$lang['email_secure'] = 'SMTP 协议';
$lang['email_secure_tls'] = '非SSL协议';
$lang['email_secure_ssl'] = 'SSL协议';
$lang['set_email_secure'] = '设置 SMTP 协议';
$lang['email_port'] = 'SMTP 端口';
$lang['set_email_port'] = '设置 SMTP 服务器的端口，非SSL协议默认为 25，SSL协议默认为465';
$lang['sender_mail_address'] = '发信人邮件地址';
$lang['if_smtp_authentication'] = '使用SMTP协议发送的邮件地址，如 deshang@163.com';
$lang['smtp_user_name'] = 'SMTP 身份验证用户名';
$lang['smtp_user_name_tip'] = '如 deshang@163.com';
$lang['smtp_user_pwd'] = 'SMTP 身份验证密码';
$lang['smtp_user_pwd_tip'] = 'deshang@163.com邮件的密码，如 123456';
$lang['test_email_send_fail'] = '测试邮件发送失败，请重新配置邮件服务器';
$lang['test_email_send_ok'] = '测试邮件发送成功';
$lang['this_is_to'] = '这是一封来自';
$lang['email_set'] = '邮件设置';
$lang['test_email_set_ok'] = '的测试邮件，证明您所邮件设置正常';
$lang['test_mail_address'] = '测试邮件地址';
$lang['test_mail'] = '测试';

/**
 * 邮件模板index
 */
$lang['mailtemplates_index_desc'] = '模板描述';


/**
 * 邮件模板编辑
 */
$lang['ds_current_edit'] = '正在编辑';
$lang['mailtemplates_edit_succ'] = '更新通知模板成功';
$lang['mailtemplates_edit_fail'] = '更新通知模板失败';
$lang['mailtemplates_edit_code_null'] = '代码不能为空';
$lang['mailtemplates_edit_title'] = '标题';
$lang['mailtemplates_edit_content'] = '正文';
/**
 * 消息模板编辑
 */
$lang['message_help1'] = '平台可以选择开启一种或多种通知方式供商家选择。平台给商家提供站内信、短消息、邮件三种通知方式。';
$lang['message_help2'] = '开启强制接收后，商家不能取消该方式通知的信息接收。';
$lang['message_help3'] = '短消息需要商家设置正确的手机号码后才能正常接收、邮件需要商家设置邮箱号码后才能正常接收。';

$lang['message_mt_name'] = '模板名称';
$lang['message_member_tpl_help1'] = '平台可以选择开启一种或多种消息通知的方式。';
$lang['message_member_tpl_help2'] = '短消息需要用户绑定手机才可以正常接收，邮件需要用户绑定邮箱后才能正常接收。';
$lang['mt_message_switch'] = '站内信';
$lang['mt_message_switch_tpl'] = '站内信模板';
$lang['mt_short_switch'] = '短消息';
$lang['mt_short_switch_tpl'] = '短消息模板';
$lang['mt_mail_switch'] = '邮件';
$lang['mt_mail_switch_tpl'] = '邮件模板';
$lang['message_content'] = '消息内容';
$lang['mail_subject'] = '邮件标题';
$lang['mail_content'] = '邮件内容';
$lang['mt_mail_forced'] = '强制接收';


/*
 * 短信记录
 */
$lang['member_name'] = '用户名';
$lang['smslog_phone'] = '接收手机';
$lang['smslog_captcha'] = '手机验证码';
$lang['smslog_msg'] = '短信内容';
$lang['smslog_type'] = '短信类别';
$lang['smslog_smstime'] = '发送时间';

/**
 * 短信设置
 */
$lang['smscf_wj_username'] = '短信平台账号';
$lang['smscf_wj_key'] = '短信平台Key';
$lang['smscf_num'] = '可用短信条数';
$lang['sms_register'] = '手机注册';
$lang['sms_login'] = '手机登录';
$lang['sms_password'] = '找回密码';
$lang['test_mobile_address'] = '测试手机短信';
$lang['test_mobile_content'] = '测试短信内容';
$lang['smscf_type'] = '短信服务商';
$lang['smscf_type_wj'] = '网建';
$lang['smscf_type_ali'] = '阿里云';
$lang['smscf_ali_id'] = '主账号AccessKey的ID';
$lang['smscf_ali_secret'] = '主账号AccessKey的Secret';
$lang['smscf_sign'] = '短信签名';
$lang['smscf_sign_tips'] = '请将短信签名同步设置到短信服务商后台';
$lang['ali_template_param'] = '短信模板变量';
$lang['ali_template_param_tips'] = 'JSON格式';

$lang['ali_template_name'] = '模板名称';
$lang['ali_template_code'] = '模板code';
$lang['ali_template_content'] = '模板内容';
$lang['ali_template_check'] = '模板检查';
$lang['ali_template_check_same'] = '一致';
$lang['ali_template_check_not_same'] = '不一致';
$lang['ali_template_state'] = '模板状态';
$lang['message_ali_tpl_help1']='请先在阿里云短信中申请对应的模板，然后将申请到的模板code保存到平台';
$lang['message_ali_tpl_help2']='请保持模板中的变量数量及名称不变';
$lang['message_ali_tpl_help3']='请保证阿里云的模板和平台短信模板一致';
$lang['ali_template_state_text'][0] = '审核中';
$lang['ali_template_state_text'][1] = '审核通过';
$lang['ali_template_state_text'][2] = '审核失败';

$lang['ali_template_param_error'] = '短信模板变量错误';
?>
