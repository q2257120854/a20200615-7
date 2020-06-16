<?php

namespace app\common\model;

use think\Model;

class Member extends Model
{
    public $page_info;

    /**
     * 会员列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @param number $page 分页
     * @param string $order 排序
     * @return array
     */
    public function getMemberList($condition = array(), $field = '*', $page = 0, $order = 'member_id desc')
    {
        if ($page) {
            $member_list = db('member')->where($condition)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $member_list;
            return $member_list->items();
        } else {
            return db('member')->where($condition)->order($order)->select();
        }
    }

    /**
     * 新增用户
     * @author csdeshang
     * @param type $data
     * @return type
     */
    public function addMember($data)
    {
        return db('member')->insertGetId($data);
    }

    /**
     * 编辑用户
     * @author csdeshang
     * @param type $condition
     * @param type $data
     * @return type
     */
    public function editMember($condition, $data)
    {
        return db('member')->where($condition)->update($data);
    }

    /**
     * 删除用户
     * @author csdeshang
     * @param type $condition
     * @return type
     */
    public function delMember($condition)
    {
        return db('member')->where($condition)->delete();
    }

    /**
     * 取单个用户信息
     * @author csdeshang
     * @param type $condition
     * @param type $field
     * @return type
     */
    public function getMemberInfo($condition, $field = '*')
    {
        return db('member')->field($field)->where($condition)->find();
    }

    /**
     * 取得会员详细信息（优先查询缓存）如果未找到，则缓存所有字段
     * @author csdeshang
     * @param int $member_id 会员ID
     * @param string $field  需要取得的缓存键值, 例如：'*','member_name,member_sex'
     * @return array
     */
    public function getMemberInfoByID($member_id, $fields = '*')
    {
        $member_info = rcache($member_id, 'member', $fields);
        if (empty($member_info)) {
            $member_info = $this->getMemberInfo(array('member_id' => $member_id), '*', true);
            wcache($member_id, $member_info, 'member');
        }
        return $member_info;
    }


    /**
     * 用户注册
     * @author csdeshang
     * @param type $register_info
     * @return boolean
     */
    public function register($register_info)
    {
        // 验证用户名是否重复
        $check_member_name = $this->getMemberInfo(array('member_name' => $register_info['member_name']));
        if (is_array($check_member_name) and count($check_member_name) > 0) {
            return array('error' => '用户名已存在');
        }

        // 会员添加
        $member_info = array();
        $member_info['member_name'] = $register_info['member_name'];
        $member_info['member_password'] = md5($register_info['member_password']);

        if (isset($register_info['member_mobilebind'])) {
            $member_info['member_mobile_bind'] = $register_info['member_mobilebind'];
            $member_info['member_mobile'] = $register_info['member_mobile'];
        }
        $member_id = $this->addMember($member_info);
        $member_res = $this->getMemberInfo(['member_id' => $member_id]);
        if ($member_id) {
            return $member_res;
        } else {
            return false;
        }
    }

    /**
     * 7天内自动登录 v3-b12
     * @author csdeshang
     */
    public function auto_login()
    {
        // 自动登录标记 保存7天
        cookie('auto_login', encrypt(session('member_id'), MD5_KEY), 7 * 24 * 60 * 60);
    }

    /**
     * 设置图像cookie
     * @author csdeshang
     */
    public function set_avatar_cookie()
    {
        cookie('member_avatar', session('avatar'), 365 * 24 * 60 * 60);
    }

    /**
     * 登录时创建会话SESSION
     * @author csdeshang
     * @param type $member_info  会员信息
     * @param type $reg
     * @return type
     */
    public function createSession($member_info = array(), $reg = false)
    {
        if (empty($member_info) || !is_array($member_info)) {
            return;
        }
        session('is_login', '1');
        session('member_id', $member_info['member_id']);
        session('member_name', $member_info['member_name']);
        session('member_email', $member_info['member_email']);

        if (!empty($member_info['member_logintime'])) {
            $update_info = array(
                'member_loginnum' => ($member_info['member_loginnum'] + 1),
                'member_logintime' => TIMESTAMP,
                'member_old_logintime' => $member_info['member_logintime'],
                'member_login_ip' => request()->ip(),
                'member_old_login_ip' => $member_info['member_login_ip']
            );
            $this->editMember(array('member_id' => $member_info['member_id']), $update_info);
        }
    }

    /**
     * 会员登录检查
     * @author csdeshang
     */
    public function checkloginMember()
    {
        if (session('is_login') == '1') {
            @header("Location: " . url('Home/Member/index'));
            exit();
        }
    }

}
