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
class  Sellerjoinin extends Validate
{
    protected $rule = [
        ['company_name', 'require|length:1,50', '公司名称不能为空|公司名称必须小于50个字'],
//            ['company_address', 'require|length:1,50', '公司地址不能为空|公司地址必须小于50个字'],
        ['company_address_detail', 'require|length:1,50', '公司详细地址不能为空|公司详细地址必须小于50个字'],
        ['company_registered_capital', 'require|number', '注册资金不能为空|注册资金必须为数字'],
        ['contacts_name', 'require|length:1,20', '联系人姓名不能为空|联系人姓名必须小于20个字'],
        ['contacts_phone', 'require|length:1,20', '联系人电话不能为空|联系人电话必须小于20个字'],
        ['contacts_email', 'require|email', '电子邮箱不能为空|电子邮箱格式不正确'],
        ['business_licence_number', 'require|length:1,20', '营业执照号不能为空|营业执照号必须小于20个字'],
//            ['business_licence_address', 'require|length:1,50', '营业执照所在地不能为空|营业执照所在地必须小于50个字'],
        ['business_licence_start', 'require', '营业执照有效期不能为空'],
        ['business_licence_end', 'require', '营业执照有效期不能为空'],
        ['bank_account_name', 'require|length:1,50', '银行开户名不能为空|银行开户名必须小于50个字'],
        ['bank_account_number', 'require|length:1,30', '银行账号不能为空|银行账号必须小于20个字'],
        ['bank_name', 'require|length:1,50', '开户银行支行不能为空|开户银行支行必须小于50个字'],
//            ['bank_address', 'require', '开户行所在地不能为空'],
        ['settlement_bank_account_name', 'require|length:1,50', '银行开户名不能为空|银行开户名必须小于50个字'],
        ['settlement_bank_account_number', 'require|length:1,50', '银行账号不能为空|银行账号必须小于50个字'],
        ['settlement_bank_name', 'require|length:1,50', '开户银行支行不能为空|开户银行支行必须小于50个字'],
        ['store_name', 'require|length:1,50', '店铺名称不能为空|店铺名称必须小于50个字'],
        ['storegrade_id', 'require', '店铺等级不能为空'],
        ['storeclass_id', 'require', '店铺分类不能为空'],
        //sellerjoininc2c
        ['business_sphere', 'require|length:1,20', '姓名不能为空|姓名不能小于50个字'],
        ['business_licence_number_electronic', 'require', '请上传营业执照电子版']
    ];

    protected $scene = [
        'step2_save_valid' => ['company_name','company_address_detail','company_registered_capital','contacts_name','contacts_phone','contacts_email','business_licence_number','business_licence_start','business_licence_end','business_licence_number_electronic'],
        'step3_save_valid' => ['bank_account_name','bank_account_number','bank_name','settlement_bank_account_name','settlement_bank_account_number','settlement_bank_name'],
        'step4_save_valid' => ['store_name','storegrade_id','storeclass_id'],
        //sellerjoininc2c
        'step2_save_valid2' => ['company_name','company_address_detail','contacts_name','contacts_phone','contacts_email','business_licence_number','business_licence_start','business_licence_end','business_licence_number_electronic'],
        'step3_save_valid3' => ['settlement_bank_account_name','settlement_bank_account_number'],
        'step4_save_valid4' => ['store_name','storegrade_id','storeclass_id'],

    ];
}