<?php

namespace app\home\controller;
use think\Lang;
class News extends BaseMall
{
    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/news.lang.php');
    }

    /**
     * 新闻信息 - 新闻栏目
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
            $news['news_list'] = $news_model->getnewsList($condition, '', '*', 6);
            $news['page'] = model('news')->page_info->render();
            $news['news_column_list'] = model('column')->getColumnList($where);
            //当前分类
            $news['news_column'] = array();
            if($newscolumn_id>0){
                $news['news_column'] = model('column')->getOneColumn($newscolumn_id);
            }
            wcache($key, $news, '', 36000);
        }
        $this->assign('news_list', $news['news_list']);
        $this->assign('page', $news['page']);
        $this->assign('news_column', $news['news_column_list']);
        
        
        //面包屑导航
        $this->assign('ancestor', $this->get_ancestor($newscolumn_id));
        
        //SEO
        if (!empty($news['news_column'])) {
            $seo = array(
                'seo_title' => !empty($news['news_column']['seo_title']) ? $news['news_column']['seo_title'] : $news['news_column']['column_name'],
                'seo_keywords' => !empty($news['news_column']['seo_keywords']) ? $news['news_column']['seo_keywords'] : $news['news_column']['column_name'],
                'seo_description' => !empty($news['news_column']['seo_description']) ? $news['news_column']['seo_description'] : '',
            );
        }else{
            $seo = array(
                'seo_title' => '新闻资讯',
            );
        }
        $this->_assign_seo($seo);
        
        return $this->fetch($this->template_dir . 'search');
    }

    /**
     * 新闻详情
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
        
        //面包屑导航
        $this->assign('ancestor', $this->get_ancestor($news_info['column_id']));
        
        //SEO赋值
        $seo = array(
            'seo_title'=> !empty($news_info['seo_title'])?$news_info['seo_title']:$news_info['news_title'],
            'seo_keywords'=> !empty($news_info['seo_keywords'])?$news_info['seo_keywords']:$news_info['news_title'],
            'seo_description'=> !empty($news_info['seo_description'])?$news_info['seo_description']:ds_substing(htmlspecialchars_decode($news_info['news_content']),0,80),
        );
        $this->_assign_seo($seo);
        return $this->fetch($this->template_dir . 'detail');
    }
}