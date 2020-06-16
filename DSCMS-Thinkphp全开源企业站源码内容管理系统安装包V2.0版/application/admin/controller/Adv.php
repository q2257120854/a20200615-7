<?php

namespace app\admin\controller;

use think\Lang;
use think\Validate;

class Adv extends AdminControl
{
    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/adv.lang.php');
    }

    /* -------广告------ */
    /**
     * 广告管理
     */
    public function adv_manage()
    {
        $adv_model = model('adv');

        $ap_id = intval(input('param.ap_id'));
        $condition = array();
        if ($ap_id>0) {
            $condition['a.ap_id'] = $ap_id;
        }
        $adv_list = $adv_model->getAdvList($condition, 10);
        $ap_list = $adv_model->getAdvpositionList();
        if ($ap_id>0) {
            $ap_condition = array();
            $ap_condition['ap_id'] = $ap_id;
            $ap = $adv_model->getOneAdvposition($ap_condition);
            $this->assign('ap_name', $ap['ap_name']);
        } else {
            $this->assign('ap_name', '');
        }
        $this->assign('adv_list', $adv_list);
        $this->assign('ap_list', $ap_list);
        $this->assign('show_page', $adv_model->page_info->render());
        $this->assign('filtered', $condition ? 1 : 0); //是否有查询条件
        $this->setAdminCurItem('adv');
        return $this->fetch('adv');
    }

    /**
     * 添加广告
     */
    public function adv_add()
    {
        if (request()->isPost()) {
            $data = array(
                'adv_title' => input('post.adv_title'),
                'ap_id' => input('post.ap_id'),
                'adv_link' => input('post.adv_link'),
                'adv_code' => input('post.adv_code'),
                'adv_order' => input('post.adv_order'),
                'adv_enabled' => input('post.adv_enabled') ? 1 : 0,
            );
            if (!input('param.adv_starttime')) {
                $data['adv_starttime'] = TIMESTAMP;
            } else {
                $data['adv_starttime'] = strtotime(input('param.adv_starttime'));
            }
            if (!input('param.adv_endtime')) {
                $data['adv_endtime'] = TIMESTAMP;
            } else {
                $data['adv_endtime'] = strtotime(input('param.adv_endtime'));
            }

            if (!empty($_FILES['adv_code']['name'])) {
                $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_ADV;
                $file = request()->file('adv_code');
                $info = $file->rule('uniqid')->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file);
                if ($info) {
                    $data['adv_code'] = $info->getSaveName();//图片带路径
                } else {
                    // 上传失败获取错误信息
                    $this->error($file->getError());
                }
            }
            $adv_validate = validate('adv');
            if (!$adv_validate->scene('add')->check($data)){
                $this->error($adv_validate->getError());
            }
            $result = model('adv')->addadv($data);
            if ($result) {
                $this->success(lang('add_succ'), url('adv/adv_manage'));
            } else {
                $this->error(lang('add_fail'));
            }
        } else {
            $ap_list = model('adv')->getAdvpositionList();
            $this->assign('ap_list', $ap_list);
            $adv = array(
                'ap_id' => 0,
                'adv_enabled' => '1',
                'adv_starttime' => TIMESTAMP,
                'adv_endtime' => TIMESTAMP + 24 * 3600 * 365,
            );
            $this->assign('adv', $adv);
            $this->setAdminCurItem('add');
            return $this->fetch('adv_form');
        }
    }

    /**
     * 修改广告
     */
    public function adv_edit()
    {
        $adv_id = intval(input('param.adv_id'));
        if($adv_id<=0){
            $this->error('param_error');
        }
        $adv_model = model('adv');
        if (!request()->isPost()) {
            $ap_list = model('adv')->getAdvpositionList();
            $this->assign('ap_list', $ap_list);
            $adv = model('adv')->getOneAdv(['adv_id' => $adv_id]);
            $this->assign('adv', $adv);
            $this->setAdminCurItem('edit');
            return $this->fetch('adv_form');
        } else {
            $param['adv_id'] = $adv_id;
            $param['adv_title'] = input('post.adv_title');
            $param['ap_id'] = input('post.ap_id');
            $param['adv_link'] = input('post.adv_link');
            $param['adv_order'] = input('post.adv_order');
            $param['adv_enabled'] = input('post.adv_enabled')? 1 : 0;
            if (!input('param.adv_starttime')) {
                $data['adv_starttime'] = TIMESTAMP;
            } else {
                $data['adv_starttime'] = strtotime(input('param.adv_starttime'));
            }
            if (!input('param.adv_endtime')) {
                $data['adv_endtime'] = TIMESTAMP;
            } else {
                $data['adv_endtime'] = strtotime(input('param.adv_endtime'));
            }

            if (!empty($_FILES['adv_code']['name'])) {
                $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_ADV;
                $file = request()->file('adv_code');
                $info = $file->rule('uniqid')->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file);
                if ($info) {
                    //还需删除原来图片
                    $adv_code_ori = input('param.adv_code_ori');
                    if ($adv_code_ori) {
                        @unlink($upload_file . DS . $adv_code_ori);
                    }
                    $param['adv_code'] = $info->getSaveName();
                } else {
                    // 上传失败获取错误信息
                    $this->error($file->getError());
                }
            }
            $adv_validate = validate('adv');
            if (!$adv_validate->scene('edit')->check($param)){
                $this->error($adv_validate->getError());
            }
            $result = $adv_model->editAdv($param);
            if ($result >= 0) {
                $this->log(lang('adv_change_succ') . '[' . input('post.ap_name') . ']', null);
                $this->success(lang('adv_change_succ'), url('adv/adv_manage'));
            } else {
                $this->error(lang('adv_change_fail'));
            }
        }
    }

    /**
     * 删除广告
     */
    public function adv_del()
    {
        $adv_model = model('adv');
        // 删除一个广告
        $adv_id = intval(input('param.adv_id'));
        $result = $adv_model->delAdv($adv_id);
        if ($result) {
            $this->log(lang('adv_del_succ') . '[' . $adv_id . ']', null);
            ds_json_encode(10000, lang('adv_del_succ'));
        } else {
            $this->error(lang('adv_del_fail'));
        }
    }

    /* -------广告位------ */
    /**
     * 管理广告位
     */
    public function ap_manage()
    {
        $adv_model = model('adv');
        if (!request()->isPost()) {
            //显示广告位管理界面
            $condition = array();
            $orderby = '';
            $search_name = trim(input('get.search_name'));
            if ($search_name != '') {
                $condition['ap_name'] = $search_name;
            }
            $ap_list = $adv_model->getAdvpositionList($condition, 5, $orderby);
            $adv_list = $adv_model->getAdvList();
            $this->assign('ap_list', $ap_list);
            $this->assign('adv_list', $adv_list);
            $this->assign('showpage', $adv_model->page_info->render());

            $this->assign('filtered', $condition ? 1 : 0); //是否有查询条件

            $this->setAdminCurItem('ap');
            return $this->fetch('ap');
        }
    }

    /**
     * 修改广告位
     */
    public function ap_edit()
    {
        $ap_id = intval(input('param.ap_id'));
        
        if($ap_id<=0){
            $this->error('param_error');
        }
        
        $adv_model = model('adv');
        if (!request()->isPost()) {
            $ap = model('adv')->getOneAdvposition(['ap_id' => $ap_id]);
            $this->assign('ap', $ap);
            $this->setAdminCurItem('add');
            return $this->fetch('ap_form');
        } else {
            $param['ap_id'] = $ap_id;
            $param['ap_name'] = trim(input('post.ap_name'));
            $param['ap_intro'] = trim(input('post.ap_intro'));
            $param['ap_width'] = intval(trim(input('post.ap_width')));
            $param['ap_height'] = intval(trim(input('post.ap_height')));
            $param['ap_isuse'] = intval(input('post.ap_isuse')) ? 1 : 0;
            //验证数据  BEGIN
            $advposition_validate = validate('advposition');
            if (!$advposition_validate->scene('edit')->check($param)){
                $this->error($advposition_validate->getError());
            }
            //验证数据  END
            $result = $adv_model->editAdvposition($param);

            if ($result >= 0) {
                $this->log(lang('ap_change_succ') . '[' . input('post.ap_name') . ']', null);
                dsLayerOpenSuccess(lang('ap_change_succ'));
            } else {
                $this->error(lang('ap_change_fail'));
            }
        }
    }

    /**
     * 新增广告位
     */
    public function ap_add()
    {
        if (!request()->isPost()) {
            $ap = array(
                'ap_isuse' => 1,
            );
            $this->assign('ap', $ap);
            $this->setAdminCurItem('add');
            return $this->fetch('ap_form');
        } else {
            $adv_model = model('adv');

            $insert_array['ap_name'] = trim(input('post.ap_name'));
            $insert_array['ap_intro'] = trim(input('post.ap_intro'));
            $insert_array['ap_isuse'] = intval(input('post.ap_isuse'));
            $insert_array['ap_width'] = intval(input('post.ap_width'));
            $insert_array['ap_height'] = intval(input('post.ap_height'));

            //验证数据
            $advposition_validate = validate('advposition');
            if (!$advposition_validate->scene('add')->check($insert_array)){
                $this->error($advposition_validate->getError());
            }
            //验证数据  END

            $result = $adv_model->addAdvposition($insert_array);

            if ($result) {
                $this->log(lang('ap_add_succ') . '[' . input('post.ap_name') . ']', null);
                dsLayerOpenSuccess(lang('ap_add_succ'));
            } else {
                $this->error(lang('ap_add_fail'));
            }
        }
    }

    /**
     * 删除广告位
     */
    public function ap_del()
    {
        $adv_model = model('adv');
        // 删除一个广告
        $ap_id = intval(input('param.ap_id'));
        $result = $adv_model->delAdvposition($ap_id);

        if ($result) {
            $this->log(lang('ds_ap') . '-' . lang('ap_del_succ') . '[' . $ap_id . ']', null);
            ds_json_encode(10000, lang('ap_del_succ'));

        } else {
            $this->error(lang('ap_del_fail'));
        }
    }

    /**
     * ajax操作
     */
    public function ajax()
    {
        $adv_model = model('adv');
        switch (input('get.branch')) {
            case 'ap':
                $column = trim(input('param.column'));
                $value = trim(input('param.value'));
                $adv_id = intval(input('param.id'));
                $param['ap_id'] = $adv_id;
                $param[$column] = trim($value);
                $result = $adv_model->editAdvposition($param);
                break;
            //ADV数据表更新
            case 'adv':
                $column = trim(input('param.column'));
                $value = trim(input('param.value'));
                $adv_id = intval(input('param.id'));
                $param[$column] = trim($value);
                $result = $adv_model->editAdv(array_merge($param, array('adv_id' => $adv_id)));
                break;
        }
        if ($result >= 0) {
            echo 'true';
        } else {
            echo false;
        }
    }

    /**
     * 广告设置
     */
    public function setadv()
    {
        $adv_value = input('param.adv_value') == 1 ? 0 : 1;
        $adv_id = input('param.adv_id');
        $update['adv_enabled'] = $adv_value;
        $condition['adv_id'] = $adv_id;
        $adv_res = db('adv')->where($condition)->update($update);
        if ($adv_res) {
            ds_json_encode(10000, lang('edit_succ'));
        } else {
            $this->error(lang('edit_fail'));
        }
    }

    /**
     * 广告位设置
     */
    public function ap_setadv()
    {
        $ap_value = input('param.ap_value') == 1 ? 0 : 1;
        $ap_id = input('param.ap_id');
        $update['ap_isuse'] = $ap_value;
        $condition['ap_id'] = $ap_id;
        $adv_res = db('advposition')->where($condition)->update($update);
        if ($adv_res) {
            ds_json_encode(10000, lang('edit_succ'));
        } else {
            $this->error(lang('edit_fail'));
        }
    }

    /**
     * 获取栏目列表,针对控制器下的栏目
     * @return type
     */
    protected function getAdminItemList()
    {
        $menu_array = array(
            array(
                'name' => 'adv', 'text' => lang('adv_manage'), 'url' => url('Adv/adv_manage')
            ), array(
                'name' => 'adv_add', 'text' => lang('adv_add'), 'url' => url('Adv/adv_add')
            ),
            array(
                'name' => 'ap', 'text' => lang('ap_manage'), 'url' => url('Adv/ap_manage')
            ), array(
                'name' => 'ap_add', 'text' => lang('ap_add'), 'url' => "javascript:dsLayerOpen('" . url('Adv/ap_add') . "','" . lang('ds_add') . "')"
            ),
        );
        if (request()->action() == 'adv_edit') {
            $menu_array[] = array(
                'name' => 'edit', 'text' => '编辑', 'url' => url('Adv/adv_edit')
            );
        }
        return $menu_array;
    }

}

?>
