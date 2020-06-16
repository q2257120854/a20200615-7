<?php

namespace app\admin\controller;

use think\Lang;

class Config extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/config.lang.php');
    }

    /**
     * 网站配置
     * @return mixed
     */
    public function index() {
        $model_config = model('config');
        if (!request()->isPost()) {
            $list_config = rkcache('config', true);
            $this->assign('list_config', $list_config);
            /* 设置卖家当前栏目 */
            $this->setAdminCurItem('base');
            return $this->fetch();
        } else {
            //上传文件保存路径

            $upload_file = ROOT_PATH . DS . DIR_UPLOAD . DS . ATTACH_COMMON;

            if (!empty($_FILES['site_logo']['name'])) {

                $file = request()->file('site_logo');

                $info = $file->validate(['ext' => 'jpg,png,gif'])->move($upload_file, 'site_logo');
                if ($info) {
                    $upload['site_logo'] = $info->getFilename();
                } else {
                    // 上传失败获取错误信息
                    $this->error($file->getError());
                }
            }
            if (!empty($upload['site_logo'])) {
                $update_array['site_logo'] = $upload['site_logo'];
            }
            if (!empty($_FILES['member_logo']['name'])) {
                $file = request()->file('member_logo');
                $info = $file->validate(['ext' => 'jpg,png,gif'])->move($upload_file, 'member_logo');
                if ($info) {
                    $upload['member_logo'] = $info->getFilename();
                } else {
                    // 上传失败获取错误信息
                    $this->error($file->getError());
                }
            }
            if (!empty($upload['member_logo'])) {
                $update_array['member_logo'] = $upload['member_logo'];
            }
            if (!empty($_FILES['site_mobile_logo']['name'])) {
                $file = request()->file('site_mobile_logo');
                $info = $file->validate(['ext' => 'jpg,png,gif'])->move($upload_file, 'site_mobile_logo');
                if ($info) {
                    $upload['site_mobile_logo'] = $info->getFilename();
                } else {
                    // 上传失败获取错误信息
                    $this->error($file->getError());
                }
            }
            if (!empty($upload['site_mobile_logo'])) {
                $update_array['site_mobile_logo'] = $upload['site_mobile_logo'];
            }
            if (!empty($_FILES['site_logowx']['name'])) {
                $file = request()->file('site_logowx');
                $info = $file->validate(['ext' => 'jpg,png,gif'])->move($upload_file, 'site_logowx');
                if ($info) {
                    $upload['site_logowx
                    '] = $info->getFilename();
                } else {
                    // 上传失败获取错误信息
                    $this->error($file->getError());
                }
            }
            if (!empty($upload['site_logowx'])) {
                $update_array['site_logowx'] = $upload['site_logowx'];
            }

            $update_array['site_name'] = input('post.site_name');
            $update_array['icp_number'] = input('post.icp_number');
            $update_array['site_phone'] = input('post.site_phone');
            $update_array['site_tel400'] = input('post.site_tel400');
            $update_array['site_email'] = input('post.site_email');
            $update_array['flow_static_code'] = input('post.flow_static_code');
            $update_array['site_state'] = input('post.site_state');
            $update_array['closed_reason'] = input('post.closed_reason');

            $result = $model_config->updateConfig($update_array);
            if ($result) {
                dkcache('config');
                $this->log(lang('ds_edit') . lang('web_set'), 1);
                $this->success('修改成功', 'Config/index');
            } else {
                $this->log(lang('ds_edit') . lang('web_set'), 0);
            }
        }
    }

    /**
     * 防灌水设置
     */
    public function dump() {
        $model_config = model('config');
        if (!request()->isPost()) {
            $list_config = $model_config->getListConfig();
            $this->assign('list_config', $list_config);
            $this->setAdminCurItem('dump');
            return $this->fetch();
        } else {
            $update_array = array();
            $update_array['cache_open'] = intval(input('post.cache_open'));
            $update_array['guest_comment'] = intval(input('post.guest_comment'));
            $update_array['captcha_status_login'] = intval(input('post.captcha_status_login'));
            $update_array['captcha_status_register'] = intval(input('post.captcha_status_register'));
            $update_array['captcha_status_feedback'] = intval(input('post.captcha_status_feedback'));
            $result = $model_config->updateConfig($update_array);
            if ($result === true) {
                $this->log(lang('ds_edit') . lang('dis_dump'), 1);
                $this->success('修改成功', 'Config/dump');
            } else {
                $this->log(lang('ds_edit') . lang('dis_dump'), 0);
                $this->error(lang('修改失败'));
            }
        }
    }

    /**
     * 网站SEO设置
     */
    public function seo() {
        $model_config = model('config');
        if (!request()->isPost()) {
            $list_config = $model_config->getListConfig();
            $this->assign('list_config', $list_config);
            $this->setAdminCurItem('seo');
            return $this->fetch();
        } else {
            $update_array['seo_home_title'] = input('post.seo_home_title');
            $update_array['seo_home_title_type'] = input('post.seo_home_title_type');
            $update_array['seo_home_keywords'] = input('post.seo_home_keywords');
            $update_array['seo_home_description'] = input('post.seo_home_description');
            $result = $model_config->updateConfig($update_array);
            if ($result) {
                dkcache('config');
                $this->log(lang('ds_edit') . lang('web_set'), 1);
                $this->success('修改成功', 'Config/seo');
            } else {
                $this->log(lang('ds_edit') . lang('web_set'), 0);
            }
        }
    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'base',
                'text' => lang('site_set'),
                'url' => url('Admin/Config/index')
            ),
            array(
                'name' => 'dump',
                'text' => lang('anti_irrigation_set'),
                'url' => url('Admin/Config/dump')
            ),
            array(
                'name' => 'seo',
                'text' => lang('seo_set'),
                'url' => url('Admin/Config/seo')
            ),
        );
        return $menu_array;
    }

}
