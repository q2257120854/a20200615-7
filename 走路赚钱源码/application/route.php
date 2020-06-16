<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

return [
	'massege' => 'index/index/massege_do',//提交留言
	'contact' => 'index/other/contact',//联系我们
	'feedback' => 'index/other/feedback',//在线留言
	
	'news_show' => 'index/news/show',//新闻详情
	'reg' => 'index/reg/reg',//会员注册
	'msm_send' => 'index/reg/regmm_msm_send',//发送短信
	'register' => 'index/reg/reg_do_cmm',//注册操作
	'login' => 'index/login/login',//会员登陆
	'userland' => 'index/login/login_do_cmm',//登陆操作
	'findpw_msm_send' => 'index/login/findpw_msm_send',
	'resetpw' => 'index/login/reset_password',
	'quit' => 'index/index/quit',//会员退出登录
	'myfishb' => 'index/member/mygiro',//会员转账
	'transfer' => 'index/member/transfer_money_cmm',//转账操作
	'tuiguang' => 'index/member/propagating',//推广
	'shezhi' => 'index/member/my_uset',//设置
	'xiugaipass' => 'index/member/edit_mypaws',//修改密码
	'editpassword' => 'index/member/editPawsDoCmm',//修改密码操作
	'myziliao'  => 'index/member/my_information',//编辑资料
	'edit_info'  => 'index/member/editInfoDoCmm',//编辑资料操作
	'qian_dao'  => 'index/index/signInDoCmm',//签到操作
	'teamlib'  => 'index/member/myteam',//团队
	'fishf'  => 'index/member/mycode',//兑换码
	'zichan'  => 'index/index/zichan',//我的资产
	'chongzhi'  => 'index/index/chongzhi',//我的充值
	'convert_code'  => 'index/member/redeemCodeDooCmm',//兑换码兑换操作
	'delcace'  => 'index/index/delAllCache',//删除缓存
	'mairu'  => 'index/market/buyorder',//买入
	'maichu'  => 'index/market/sellorder',//卖出
	'buy_yu'  => 'index/market/buyDooCmm',//买入操作
	'sell_yu'  => 'index/market/sellDooCmm',//卖出操作
	'xiangqing'  => 'index/market/order_show',//订单详情
	'cancel_order'  => 'index/market/abolishOrderDoo',//取消订单
	'payment'  => 'index/market/paymentOrderDoo',//确认付款
	'make_order'  => 'index/market/makeMoneyDoo',//确认收款
	'fish_fry'  => 'index/index/FryDoCmm',//打捞鱼苗
	
	'buy_goods' => 'index/index/buyShopOre',//购买钻箱操作
	'kuangjilog' => 'index/member/orelog',//钻箱购买记录
	'shouyilog' => 'index/member/lucrelog',//收益记录
	'orderlist' => 'index/member/order_cmm_list',//订单列表
	'duihuan'  => 'index/market/exchange',//兑换乐豆
	'go_duihuan'  => 'index/market/exchangeDooCmm',//兑换乐豆操作
	'shifanglog'  => 'index/member/releaselog',//每日释放记录
	'teamlog'  => 'index/member/team_rreward_log',//团队奖记录
	'shouyicaiji'  => 'index/index/shouyicaiji',//释放页面
	'shouyicaiji_do'  => 'index/index/shifang_shuibi',//释放页面
	'sellit_do'  => 'index/index/sellOrderDooCmm',//卖给他
	'findpw'  => 'index/login/findpw',//找回密码
	
	'getimage'  => 'index/index/getimage',//接收图片文件
	'tixian'  => 'index/index/tixian',//我的提现
	'zizhubuy'  => 'index/index/zizhubuy',//自助购买
	
	'__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
    '__rest__'     => [
		'adminbrother'   => 'admincmsby/index',
		//'congfeicomm'   => 'index/index',
    ],
];
