<?php
namespace app\home\controller;
use think\Lang;
class Member extends BaseMember
{
    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/member.lang.php');
    }

    /**
     * 个人中心
     * @return mixed
     */
    public function index()
    {
        $field = 'member_name,member_truename,member_sex,member_email,member_mobile,member_areainfo,member_avatar,member_privacy';
        $this->_get_member_info($field);
        return $this->fetch($this->template_dir . 'index');
    }

    /**
     * 修改信息
     */
    public function change_info()
    {
        if (request()->isPost()) {
            $condition['member_id'] = session('member_id');
            $data = array(
                'member_name' => input('post.member_name'),
                'member_truename' => input('post.member_truename'),
                'member_sex' => input('post.member_sex') ? 1 : 0,
                'member_birthday' => strtotime(input('post.member_birthday')),
                'member_mobile' => input('post.member_mobile'),
                'member_email' => input('post.member_email'),
                'member_qq' => input('post.member_qq'),
                'member_privacy' => input('post.member_privacy'),
            );
            if (model('member')->editMember($condition, $data)) {
                $this->success('资料修改成功', url('member/index'));
            } else {
                $this->error('资料修改失败');
            }
        } else {
            $this->_get_member_info();
            return $this->fetch($this->template_dir . 'info');
        }
    }

    /**
     * 修改密码
     */
    public function change_password()
    {
        if (request()->isPost()) {
            $condition = array();
            $member_old_password = trim(input('post.member_old_password'));
            $member_new_password = trim(input('post.member_new_password'));
            $member_confirm_password = trim(input('post.member_confirm_password'));
            if ($member_new_password !== $member_confirm_password) {
                $this->error('两次密码输入不一致');
            }
            $condition['member_id'] = session('member_id');
            //查询管理员信息
            $member_model = model('member');
            $memberinfo = $member_model->getmemberInfo($condition);
            if (!is_array($memberinfo) || count($memberinfo) <= 0) {
                $this->error('密码修改失败');
            }
            //旧密码是否正确
            if ($memberinfo['member_password'] != md5($member_old_password)) {
                $this->error('原密码错误');
            }
            $data['member_password'] = md5($member_new_password);
            if ($member_model->editMember($condition, $data)) {
                session(null);
                $this->success('密码修改成功！请重新登录', url('login/login'));
            } else {
                $this->error('密码修改失败');
            }
        } else {
            return $this->fetch($this->template_dir . 'password');
        }
    }

    /**
     * 修改头像
     */
    public function change_portrait()
    {
        if (request()->isPost()) {
            //上传文件保存路径
            $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_MEMBER;
            if (!empty($_FILES['member_avatar']['name'])) {
                //释放原来头像
                $condition['member_id'] = session('member_id');
                $member_info = model('member')->getMemberInfo($condition, $field = '*');
                $old_member_avatar = $upload_file . '/' . $member_info['member_avatar'];
                @unlink($old_member_avatar);
                
                $file = request()->file('member_avatar');
                $info = $file->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file);
                if ($info) {
                    $data['member_avatar'] = $info->getSaveName(); //图片带路径
                } else {
                    // 上传失败获取错误信息
                    $this->error($file->getError());
                }
            } else {
                $this->error('头像修改失败');
            }
            $condition['member_id'] = session('member_id');
            if (model('member')->editMember($condition, $data)) {
                $this->success('头像修改成功', url('member/change_portrait'));
            }
            $this->error('头像修改失败');
        } else {
            $field = 'member_avatar';
            $this->_get_member_info($field);
            return $this->fetch($this->template_dir . 'portrait');
        }
    }

    private function _get_member_info($field = '*')
    {
        $condition = array();
        $condition['member_id'] = session('member_id');
        $member_info = model('member')->getMemberInfo($condition, $field);
        $this->assign('member_info', $member_info);
    }
}