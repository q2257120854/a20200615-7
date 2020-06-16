<?php

namespace app\mobile\controller;

class Job extends BaseMall
{
    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 岗位列表
     * @return type
     */
    public function index()
    {
        $job_list = $this->_get_job_list();
        $this->assign('job_list', $job_list['job_list']);
        $this->assign('page', $job_list['page']);
        return $this->fetch($this->template_dir . 'index');
    }

    /**
     * 获取岗位列表
     * @return array
     */
    private function _get_job_list()
    {
        $condition = array();
        $condition['job_displaytype'] = 1;
        $job_model = model('job');
        $key = 'home_job';
        $home_job_list = rcache($key);
        if (empty($home_job_list)) {
            //获取岗位列表
            $home_job_list['job_list'] = $job_model->getJobList($condition, '*', 6);
            $home_job_list['page'] = model('job')->page_info->render();
            wcache($key, $home_job_list, '', 36000);
        }
        return $home_job_list;
    }

    /**
     * 岗位详情
     */
    public function detail()
    {
        $condition = array();
        $job_id = input('param.job_id');
        $condition['job_id'] = $job_id;
        $job_detail = model('job')->getOneJob($condition);
        $this->assign('job_info', $job_detail);
        return $this->fetch($this->template_dir . 'detail');
    }


    /**
     * 职位申请
     */
    public function apply()
    {
        if (request()->isPost()) {
            $job_id = input('param.job_id');
            $resume_name = input('param.resume_name');
            $resume_telephone = input('param.resume_telephone');
            if (!$job_id || !$resume_name || !$resume_telephone) {
                $this->error('缺少必要信息,请重新填写');
            }


            $data = array(
                'job_id' => $job_id,
                'resume_name' => $resume_name,
                'resume_sex' => input('param.resume_sex'),
                'resume_birthday' => strtotime((input('param.resume_birthday'))),
                'resume_resume_place' => input('param.resume_resume_place'),
                'resume_telephone' => $resume_telephone,
                'resume_zip_code' => input('param.resume_zip_code'),
                'resume_email' => input('param.resume_email'),
                'resume_education' => input('param.resume_education'),
                'resume_professional' => input('param.resume_professional'),
                'resume_school' => input('param.resume_school'),
                'resume_address' => input('param.resume_address'),
                'resume_awards' => input('param.resume_awards'),
                'resume_experience' => input('param.resume_experience'),
                'resume_hobby' => input('param.resume_hobby')
            );
            //添加简历信息表 返回ID
            $resume_id = db('resume')->insertGetId($data);
            $jobcv_data = array(
                'jobcv_addtime' => TIMESTAMP,
                'jobcv_customer' => session('member_name'),
                'jobcv_ip' => request()->ip(),
                'resume_id' => $resume_id,
                'job_id' => $job_id
            );
            //添加投递信息表
            $jobcv = model('jobcv')->addJobcv($jobcv_data);
            if ($jobcv) {
                $this->success('投递成功！等待电话通知', url('job/index'));
            } else {
                $this->error('投递失败');
            }
        } else {
            $condition = array();
            $condition['job_displaytype'] = 1;
            $job_list = model('job')->getJobList($condition);
            $this->assign('job_list', $job_list);
            return $this->fetch($this->template_dir . 'apply');
        }

    }
}