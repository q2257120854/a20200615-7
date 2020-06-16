<?php

namespace app\mobile\controller;

class News extends BaseMall
{
    public function _initialize()
    {
        parent::_initialize();
    }
    /**
     * 案例信息 - 案例栏目
     * @return mixed
     */
    public function search()
    {
        $news_model = model('news');
        $condition = array();
        $where = array();
        $newscolumn_id = intval(input('param.id'));
        if ($newscolumn_id > 0) {
            $condition['column_id'] = $newscolumn_id;
        }
        $key = 'news_list_' . $newscolumn_id . '_' . input('param.page');
        $news = rcache($key);
        if (empty($news)) {
            $condition['news_displaytype'] = 1;
            $where['column_module'] = COLUMN_NEWS;
            $news['news_list'] = $news_model->getnewsList($condition,0, '*', 6);
            $news['page'] = model('news')->page_info->render();
            $news['news_column_list'] = model('column')->getColumnList($where);
            wcache($key, $news, '', 36000);
        }
        $this->assign('news_list', $news['news_list']);
        $this->assign('page', $news['page']);
        $this->assign('news_column', $news['news_column_list']);
        return $this->fetch($this->template_dir . 'search');
    }

    /**
     * 案例详情页
     * @return mixed
     */
    public function detail()
    {
        $condition = array();
        $where = array();
        $news_id = intval(input('param.news_id'));
        if ($news_id <= 0) {
            $this->error('参数错误');
        }
        $news_model = model('news');
        $condition['news_id'] = $news_id;
        $news_info = $news_model->getOneNews($condition);

        //获取案例列表
        $key = "newscolumn_list";
        $newscolumn_list = rcache($key);
        if (empty($newscolumn_list)) {
            $where['column_module'] = COLUMN_NEWS;
            $newscolumn_list = model('column')->getColumnList($where);
            wcache($key, $newscolumn_list, '', 36000);
        }
        $this->assign('news_column', $newscolumn_list);
        $this->assign('news_info', $news_info);
        return $this->fetch($this->template_dir . 'detail');
    }

}
