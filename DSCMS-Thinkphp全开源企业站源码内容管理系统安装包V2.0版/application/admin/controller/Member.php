<?php

namespace app\admin\controller;

use think\Validate;
use think\Lang;

class Member extends AdminControl
{

    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/member.lang.php');
    }

    /**
     * 用户列表
     * @return mixed
     */
    public function index()
    {
        $model_member = Model('member');
        $condition = array();
        $member_list = $model_member->getMemberList($condition, '*', 5);
        $this->assign('member_list', $member_list);
        $this->assign('show_page', $model_member->page_info->render());
        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    /**
     * 添加用户
     * @return mixed
     */
    public function add()
    {
        if (request()->isPost()) {
            $model_member = Model('member');
            //判断用户名是否存在
            if ($model_member->getMemberInfo(['member_name' => input('post.member_name')])) {
                $this->error(lang('member_existence'));
            }
            $data = array(
                'member_mobile' => input('post.member_mobile'),
                'member_email_bind' => input('post.member_email_bind') ? input('post.member_email_bind') : 0,
                'member_mobile_bind' => input('post.member_mobile_bind') ? input('post.member_mobile_bind') : 0,
                'member_email' => input('post.member_email'),
                'member_name' => input('post.member_name'),
                'member_password' => input('post.member_password') ? md5(input('post.member_password')) : md5('123'),
                'member_truename' => input('post.member_truename'),
                'member_add_time' => TIMESTAMP
            );
            //添加到数据库
            $result = $model_member->addMember($data);
            if ($result) {
                dsLayerOpenSuccess(lang('member_add_succ'));
            } else {
                $this->error(lang('member_add_fail'));
            }
        } else {
            $member_array = array(
                'member_mobile_bind' => 0,
                'member_email_bind' => 0,
                'add' => 1,
            );
            $this->assign('member', $member_array);
            $this->setAdminCurItem('add');
            return $this->fetch('form');
        }
    }

    /**
     * 编辑用户
     * @return type
     */
    public function edit()
    {
        $member_id = input('param.member_id');
        if (empty($member_id)) {
            $this->error(lang('param_error'));
        }
        $model_member = Model('member');
        if (!request()->isPost()) {
            $condition['member_id'] = $member_id;
            $member_array = $model_member->getMemberInfo($condition);
            $member_array['add'] = 0;
            $this->assign('member', $member_array);
            $this->setAdminCurItem('edit');
            return $this->fetch('form');
        } else {
            $data = array(
                'member_name' => input('post.member_name'),
                'member_truename' => input('post.member_truename'),
                'member_mobile' => input('post.member_mobile'),
                'member_email' => input('post.member_email'),
                'member_email_bind' => input('post.member_email_bind') ? input('post.member_email_bind') : 0,
                'member_mobile_bind' => input('post.member_mobile_bind') ? input('post.member_mobile_bind') : 0,
            );
            if (input('post.member_password')) {
                $data['member_password'] = md5(input('post.member_password'));
            }
            //验证数据  BEGIN
            $rule = [
                ['member_email', 'email', lang('mailbox_format_error')]
            ];
            $validate = new Validate($rule);
            $validate_result = $validate->check($data);
            if (!$validate_result) {
                $this->error($validate->getError());
            }
            //验证数据  END
            $result = $model_member->editMember(array('member_id' => intval($member_id)), $data);
            if ($result) {
                dsLayerOpenSuccess(lang('member_edit_succ'));
            } else {
                $this->error(lang('member_edit_fail'));
            }
        }
    }

    /**
     * 删除用户
     */
    public function del()
    {
        $member_id = input('param.member_id');
        if (empty($member_id)) {
            $this->error(lang('param_error'));
        }
        $result = db('member')->delete($member_id);
        if ($result) {
            ds_json_encode(10000, lang('member_del_succ'));
        } else {
            ds_json_encode(10001, lang('member_del_fail'));
        }
    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     * @return array
     */
    protected function getAdminItemList()
    {
        $menu_array = array(
            array(
                'name' => 'index', 'text' => lang('ds_manage'), 'url' => url('Member/index')
            ), array(
                'name' => 'add', 'text' => lang('ds_add'), 'url' => "javascript:dsLayerOpen('".url('Member/add')."','".lang('ds_add')."')"
            ),
        );
        return $menu_array;
    }

}
