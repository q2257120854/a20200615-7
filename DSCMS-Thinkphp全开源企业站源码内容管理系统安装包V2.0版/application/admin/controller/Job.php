<?php

namespace app\admin\controller;

use think\Lang;
use think\Validate;

class Job extends AdminControl
{
    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/job.lang.php');
    }

    /**
     * 职位管理
     */
    public function index()
    {
        $model_job = Model('job');
        $condition = array();
        $job_list = $model_job->getJobList($condition, '*', 5);
        $this->assign('job_list', $job_list);
        $this->assign('show_page', $model_job->page_info->render());
        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    /**
     * 添加职位
     */
    public function add()
    {
        if (request()->isPost()) {
            $data = array(
                'job_position' => input('post.job_position'),
                'job_count' => input('post.job_count'),
                'job_place' => input('post.job_place'),
                'job_deal' => input('post.job_deal'),
                'job_content' => input('post.job_content'),
                'job_order' => input('post.job_order'),
                'job_email' => input('post.job_email'),
                'job_top_ok' => input('post.job_top_ok') ? 1 : 0,
                'job_displaytype' => input('post.job_displaytype') ? 1 : 0,
            );
            if (!input('param.job_addtime')) {
                $data['job_addtime'] = TIMESTAMP;
            } else {
                $data['job_addtime'] = strtotime(input('param.job_addtime'));
            }
            if (!input('param.job_endtime')) {
                $data['job_endtime'] = TIMESTAMP;
            } else {
                $data['job_endtime'] = strtotime(input('param.job_endtime'));
            }
            $job_validate = validate('job');
            if (!$job_validate->scene('add')->check($data)){
                $this->error($job_validate->getError());
            }
            $result = model('job')->addJob($data);
            if ($result) {
                $this->log(lang('ds_job').'-'.lang('add_succ') . '[' . $data['job_position'] . ']', null);
                $this->success(lang('add_succ'), url('job/index'));
            } else {
                $this->error(lang('add_fail'));
            }
        } else {
            $job = array(
                'job_type' => 1,
                'job_top_ok' => 1,
                'job_displaytype' => 1,
                'job_addtime' => TIMESTAMP,
                'job_endtime' => TIMESTAMP+60*60*24*30,
            );
            $this->assign('job', $job);
            $this->setAdminCurItem('add');
            return $this->fetch('form');
        }
    }

    /**
     * 修改职位
     */
    public function edit()
    {
        $job_id = intval(input('param.job_id'));
        if (!request()->isPost()) {
            $job = model('job')->getOneJob(['job_id' => $job_id]);
            $this->assign('job', $job);
            $this->setAdminCurItem('add');
            return $this->fetch('form');
        } else {
            $data = array(
                'job_position' => input('post.job_position'),
                'job_count' => input('post.job_count'),
                'job_place' => input('post.job_place'),
                'job_deal' => input('post.job_deal'),
                'job_content' => input('post.job_content'),
                'job_order' => input('post.job_order'),
                'job_email' => input('post.job_email'),
                'job_top_ok' => input('post.job_top_ok') ? 1 : 0,
                'job_displaytype' => input('post.job_displaytype') ? 1 : 0,
            );
            if (!input('param.job_addtime')) {
                $data['job_addtime'] = TIMESTAMP;
            } else {
                $data['job_addtime'] = strtotime(input('param.job_addtime'));
            }
            if (!input('param.job_endtime')) {
                $data['job_endtime'] = TIMESTAMP;
            } else {
                $data['job_endtime'] = strtotime(input('param.job_endtime'));
            }
            $job_validate = validate('job');
            if (!$job_validate->scene('edit')->check($data)){
                $this->error($job_validate->getError());
            }
            $result = model('job')->editJob(['job_id' => $job_id], $data);
            if ($result) {
                $this->log(lang('ds_job').'-'.lang('edit_succ') . '[' . $data['job_position'] . ']', null);
                $this->success(lang('edit_succ'), url('job/index'));
            } else {
                $this->error(lang('edit_fail'));
            }
        }
    }

    /**
     * 删除职位
     */
    public function del()
    {
        $job_id = intval(input('param.job_id'));
        if ($job_id>0) {
            $condition['job_id'] = $job_id;
            $result = model('job')->delJob($condition);
            if ($result) {
                $this->log(lang('ds_job').'-'.lang('del_succ') . '[' . $job_id . ']', null);
                ds_json_encode(10000, lang('del_succ'));
            } else {
                ds_json_encode(10001, lang('del_fail'));
            }
        } else {
            ds_json_encode(10001, lang('del_fail'));
        }
    }

    /**
     * 设置职位
     */
    function setjob()
    {
        $job_type = input('param.job_type');
        $job_id = input('param.job_id');
        $res = model('job')->getOneJob(['job_id' => $job_id], $job_type);
        $id = $res[$job_type] == 0 ? 1 : 0;
        $update[$job_type] = $id;
        $condition['job_id'] = $job_id;
        if (model('job')->editJob($condition, $update)) {
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
            case 'job':
                $job_mod = model('job');
                $condition = array('Job_id' => intval(input('param.id')));
                $update[input('param.column')] = input('param.value');
                $job_mod->editjob($condition, $update);
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
                'name' => 'index', 'text' => lang('ds_manage'), 'url' => url('job/index')
            ), array(
                'name' => 'add', 'text' => lang('ds_add'), 'url' => url('job/add')
            )
        );
        if (request()->action() == 'edit') {
            $menu_array[] = array(
                'name' => 'edit', 'text' => lang('ds_edit'), 'url' => url('job/edit')
            );
        }
        return $menu_array;
    }

}

?>
