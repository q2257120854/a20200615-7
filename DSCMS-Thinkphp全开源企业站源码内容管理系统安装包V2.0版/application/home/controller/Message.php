<?php
namespace app\home\controller;
use think\Validate;
use think\Lang;
class Message extends BaseMall {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/message.lang.php');
    }

    /**
     * 留言
     * @return type
     */
    public function index() {
        if (!request()->isPost()) {
            return $this->fetch($this->template_dir . 'index');
        } else {
            //需要完善地方 1.对录入数据进行判断  2.对判断用户名是否存在
            $message_model = model('message');
            $data = array(
                'message_customer' => empty(session('member_name')) ? '' : session('member_name'),
                'message_title' => input('post.message_title'),
                'message_ctitle' => input('post.message_ctitle'),
                'message_content' => input('post.message_content'),
                'message_addtime' => TIMESTAMP,
            );
            //验证数据  BEGIN
            $rule = [
                    ['message_title', 'require|length:3,120', '标题不能为空|标题长度在3到120位'],
                    ['message_content', 'require|length:1,180', '内容不能为空|留言内容超出限制'],
            ];
            $validate = new Validate($rule);
            $validate_result = $validate->check($data);
            if (!$validate_result) {
                $this->error($validate->getError());
            }
            //验证数据  END
            $result = $message_model->addMessage($data);
            if ($result) {
                $this->success(lang('留言成功'), 'Message/index');
            } else {
                $this->error(lang('member_add_fail'));
            }
        }
    }

}
