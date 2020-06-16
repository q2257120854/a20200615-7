<?php

namespace app\admin\controller;

use think\View;
use think\Lang;
use think\Validate;

class News extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/news.lang.php');
    }

    /**
     * 新闻管理
     * @return type
     */
    public function index() {
        $model_news = model('news');
        $condition = array();
        $news_list = $model_news->getNewsList($condition,'', '*', 10);
        $this->assign('news_list', $news_list);
        $this->assign('show_page', $model_news->page_info->render());

        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    /**
     * 新增新闻
     * @return type
     */
    public function add() {
        if (request()->isPost()) {
            $column_id = intval(input('post.column_id'));
            if ($column_id <= 0) {
                $this->error('必须选择栏目');
            }
            $model_news = Model('news');
            $data = array(
                'column_id' => $column_id,
                'news_title' => input('post.news_title'),
                'news_order' => input('post.news_order') ? 1 : 0,
                'news_wap_ok' => input('post.news_wap_ok') ? 1 : 0,
                'news_displaytype' => input('post.news_displaytype'),
                'news_content' => input('post.news_content'),
                'news_addtime' => TIMESTAMP,
                'news_recycle' => NEWS_RECYCLE_OK,
                'news_issue' => $this->admin_info['admin_name'],
                'seo_title' => input('post.seo_title'),
                'seo_keywords' => input('post.seo_keywords'),
                'seo_description' => input('post.seo_description'),
            );
            //新闻主图处理 上传文件保存路径
            $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_NEWS;
            if (!empty($_FILES['news_imgurl']['name'])) {
                $file = request()->file('news_imgurl');
                $info = $file->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file);
                if ($info) {
                    $data['news_imgurl'] = $info->getSaveName(); //图片带路径
                } else {
                    // 上传失败获取错误信息
                    $this->error($file->getError());
                }
            }
            $new_validate = validate('news');
            if (!$new_validate->scene('add')->check($data)){
                $this->error($new_validate->getError());
            }
            $result = $model_news->addNews($data);
            if ($result) {
                $this->success(lang('add_succ'), url('News/index'));
            } else {
                $this->error(lang('add_fail'));
            }
        } else {
            $news = array(
                'news_wap_ok' => 0,
                'news_displaytype' => 0,
                'column_id' => 0,
            );
            $contion = array('column_module' => COLUMN_NEWS);
            $column_list = db('column')->where($contion)->select();
            
            $pic_list = model('pic')->getPicList(array('pic_id' => 0,'pic_type'=>'news'));
            $this->assign('news_pic_type', ['pic_type' => 'news']);
            $this->assign('pic_list', $pic_list);
            
            $this->assign('column_list', $column_list);
            $this->assign('news', $news);
            $this->setAdminCurItem('add');
            return $this->fetch('form');
        }
    }

    /**
     * 编辑新闻
     * @return type
     */
    public function edit() {
        $news_id = intval(input('param.news_id'));
        if ($news_id <= 0) {
            $this->error(lang('param_error'));
        }
        $news = model('news')->getOneNews(['news_id' => $news_id]);
        if(empty($news)){
            $this->error('系统错误');
        }
        
        if (request()->isPost()) {
            $data = array(
                'column_id' => input('post.column_id'),
                'news_title' => input('post.news_title'),
                'seo_title' => input('post.seo_title'),
                'seo_keywords' => input('post.seo_keywords'),
                'news_order' => input('post.news_order'),
                'news_wap_ok' => input('post.news_wap_ok') ? 1 : 0,
                'news_displaytype' => input('post.news_displaytype') ? 1 : 0,
                'seo_description' => input('post.seo_description'),
                'news_content' => input('post.news_content'),
                'news_updatetime' => TIMESTAMP,
                'news_issue' => $this->admin_info['admin_name']
            );
            if (!empty($_FILES['news_imgurl']['name'])) {
                //上传文件保存路径
                $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_NEWS;
                $file = request()->file('news_imgurl');
                $info = $file->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file);
                if ($info) {
                    //还需删除原来图片
                    $news_img_ori = $news['news_imgurl'];
                    if ($news_img_ori) {
                        @unlink($upload_file . DS . $news_img_ori);
                    }
                    $data['news_imgurl'] = $info->getSaveName(); //图片带路径
                } else {
                    // 上传失败获取错误信息
                    $this->error($file->getError());
                }
            }
            $new_validate = validate('news');
            if (!$new_validate->scene('edit')->check($data)){
                $this->error($new_validate->getError());
            }
            $result = model('news')->editNews(['news_id' => $news_id], $data);
            if ($result) {
                $this->success(lang('edit_succ'), url('News/index'));
            } else {
                $this->error(lang('edit_fail'));
            }
        } else {
            $pic_list = model('pic')->getPicList(array('pic_type_id' => $news_id,'pic_type'=>'news'));
            $this->assign('news_pic_type', ['pic_type' => 'news']);
            $this->assign('pic_list', $pic_list);
            
            $contion = array('column_module' => COLUMN_NEWS);
            $column_list = model('column')->where($contion)->select();
            
            $this->assign('column_list', $column_list);
            $this->assign('news', $news);
            $this->setAdminCurItem('edit');
            return $this->fetch('form');
        }
    }

    /**
     * 删除新闻
     */
    public function del() {
        $news_id = intval(input('param.news_id'));
        if ($news_id > 0) {
            $condition['news_id'] = $news_id;
            $result = model('news')->delNews($condition);
            if ($result) {
                ds_json_encode(10000, lang('del_succ'));
            } else {
                ds_json_encode(10001, lang('del_fail'));
            }
        } else {
            ds_json_encode(10001, lang('param_error'));
        }
    }

    /**
     * zjax操作
     */
    function ajax() {
        $branch = input('param.branch');
        switch ($branch) {
            case 'news':
                $news_mod = model('news');
                $condition = array('news_id' => intval(input('param.id')));
                $update[input('param.column')] = input('param.value');
                $news_mod->editnews($condition, $update);
                echo 'true';
        }
    }

    /**
     * 设置新闻
     */
    function setnews() {
        $news_type = input('param.news_type');
        $news_id = input('param.news_id');
        $res = model('news')->getOneNews(['news_id' => $news_id], $news_type);
        $id = $res[$news_type] == 0 ? 1 : 0;
        $update[$news_type] = $id;
        $condition['news_id'] = $news_id;
        if (model('news')->editnews($condition, $update)) {
            ds_json_encode(10000, lang('edit_succ'));
        } else {
            $this->error(lang('edit_fail'));
        }
    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     * @return string
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'index', 'text' => lang('ds_manage'), 'url' => url('News/index')
            ), array(
                'name' => 'add', 'text' => lang('ds_add'), 'url' => url('News/add')
            ),
        );
        if (request()->action() == 'edit') {
            $menu_array[] = array(
                'name' => 'edit', 'text' => lang('ds_edit'), 'url' => url('News/edit')
            );
        }
        return $menu_array;
    }

}
