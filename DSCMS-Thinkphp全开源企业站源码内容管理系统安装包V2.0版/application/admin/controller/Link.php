<?php

namespace app\admin\controller;

use think\Lang;
use think\Validate;

class Link extends AdminControl
{
    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/link.lang.php');
    }

    /**
     * 友链管理
     */
    public function index()
    {
        $model_link = Model('link');
        $condition = array();
        $link_list = $model_link->getLinkList($condition, '*', 5);
        $this->assign('link_list', $link_list);
        $this->assign('show_page', $model_link->page_info->render());
        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    /**
     * 添加友链
     */
    public function add()
    {
        if (request()->isPost()) {
            $data = array(
                'link_webname' => input('post.link_webname'),
                'link_weburl' => input('post.link_weburl'),
                'link_type' => input('post.link_type')?1:0,
                'link_info' => input('post.link_info'),
                'link_order' => input('post.link_order'),
                'link_com_ok' => input('post.link_com_ok') ? 1 : 0,
                'link_show_ok' => 1,
                'link_ip' => request()->ip()
            );
            if (!input('param.link_addtime')) {
                $data['link_addtime'] = TIMESTAMP;
            } else {
                $data['link_addtime'] = strtotime(input('param.link_addtime'));
            }

            if (!empty($_FILES['link_weblogo']['name'])) {
                $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_LINK;
                $file = request()->file('link_weblogo');
                $info = $file->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file);
                if ($info) {
                    $data['link_weblogo'] = $info->getSaveName();//图片带路径
                } else {
                    // 上传失败获取错误信息
                    $this->error($file->getError());
                }
            }
            $link_validate = validate('link');
            if (!$link_validate->scene('add')->check($data)){
                $this->error($link_validate->getError());
            }

            $result = model('link')->addlink($data);
            if ($result) {
                $this->log(lang('ds_link').'-'.lang('add_succ') . '[' . $data['link_webname'] . ']', null);
                $this->success(lang('add_succ'), url('link/index'));
            } else {
                $this->error(lang('add_fail'));
            }
        } else {
            $link = array(
                'link_type' => 1,
                'link_com_ok' => 1,
                'link_addtime' => TIMESTAMP,
            );
            $this->assign('link', $link);
            $this->setAdminCurItem('add');
            return $this->fetch('form');
        }
    }

    /**
     * 修改友链
     */
    public function edit()
    {
        $link_id = intval(input('param.link_id'));
        if ($link_id <= 0) {
            $this->error('系统错误');
        }
        $link = model('link')->getOneLink(['link_id' => $link_id]);
        if(empty($link)){
            $this->error('系统错误');
        }
        if (!request()->isPost()) {
            $this->assign('link', $link);
            $this->setAdminCurItem('edit');
            return $this->fetch('form');
        } else {
            $data = array(
                'link_webname' => input('post.link_webname'),
                'link_weburl' => input('post.link_weburl'),
                'link_type' => input('post.link_type')?1:0,
                'link_info' => input('post.link_info'),
                'link_order' => input('post.link_order'),
                'link_com_ok' => input('post.link_com_ok') ? 1 : 0,
                'link_show_ok' => 1,
                'link_ip' => request()->ip()
            );
            if (!input('param.link_addtime')) {
                $data['link_addtime'] = TIMESTAMP;
            } else {
                $data['link_addtime'] = strtotime(input('param.link_addtime'));
            }

            if (!empty($_FILES['link_weblogo']['name'])) {
                $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_LINK;
                $file = request()->file('link_weblogo');
                $info = $file->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file);
                if ($info) {
                    //还需删除原来图片
                    $link_code_ori = $link['link_weblogo'];
                    if ($link_code_ori) {
                        @unlink($upload_file . DS . $link_code_ori);
                    }
                    $data['link_weblogo'] = $info->getSaveName();
                } else {
                    // 上传失败获取错误信息
                    $this->error($file->getError());
                }
            }
            $link_validate = validate('link');
            if (!$link_validate->scene('edit')->check($data)){
                $this->error($link_validate->getError());
            }

            $result = model('link')->editLink(['link_id' => $link_id], $data);
            if ($result) {
                $this->log(lang('ds_link').'-'.lang('edit_succ') . '[' . $data['link_webname'] . ']', null);
                $this->success(lang('edit_succ'), url('link/index'));
            } else {
                $this->error(lang('edit_fail'));
            }
        }
    }

    /**
     * 删除友链
     */
    public function del()
    {
        $link_id = intval(input('param.link_id'));
        if ($link_id>0) {
            $condition['link_id'] = $link_id;
            $result = model('link')->dellink($condition);
            if ($result) {
                $this->log(lang('ds_link').'-'.lang('del_succ') . '[' . $link_id . ']', null);
                ds_json_encode(10000, lang('del_succ'));
            } else {
                ds_json_encode(10001, lang('del_fail'));
            }
        } else {
            ds_json_encode(10001, lang('del_fail'));
        }

    }

    /**
     * 设置友情链接
     */
    function setlink()
    {
        $link_type = input('param.link_type');
        $link_id = input('param.link_id');
        $res = model('link')->getOneLink(['link_id' => $link_id], $link_type);
        $id = $res[$link_type] == 0 ? 1 : 0;
        $update[$link_type] = $id;
        $condition['link_id'] = $link_id;
        if (model('link')->editLink($condition, $update)) {
            ds_json_encode(10000, lang('edit_succ'));
        } else {
            $this->error(lang('edit_fail'));
        }
    }

    /**
     * ajax操作
     */
    public function ajax()
    {
        $branch = input('param.branch');
        switch ($branch) {
            case 'link':
                $link_mod = model('link');
                $condition = array('link_id' => intval(input('param.id')));
                $update[input('param.column')] = input('param.value');
                $link_mod->editLink($condition, $update);
                echo 'true';
        }
    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     * @return type
     */
    protected function getAdminItemList()
    {
        $menu_array = array(
            array(
                'name' => 'index', 'text' => lang('ds_manage'), 'url' => url('link/index')
            ), array(
                'name' => 'add', 'text' => lang('ds_add'), 'url' => url('link/add')
            )
        );
        if (request()->action() == 'edit') {
            $menu_array[] = array(
                'name' => 'edit', 'text' => lang('ds_edit'), 'url' => url('link/edit')
            );
        }
        return $menu_array;
    }

}

?>
