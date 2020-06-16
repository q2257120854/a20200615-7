<?php

/*
 * 首页相关基本调用
 */
namespace app\home\controller;
use think\Lang;
class Index extends BaseMall
{
    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/index.lang.php');
    }

    public function index()
    {
        $this->assign('cases_list', $this->_get_cases_list());
        $this->assign('product_list', $this->_get_product_list());
        $this->assign('news_column', $this->_get_news_column());
        
        $this->_assign_seo();
        
        return $this->fetch($this->template_dir . 'index');
    }


    /**
     * 获取案例列表
     * @return array
     */
    public function _get_cases_list()
    {
        $key = 'home_cases';
        $hoem_cases_list = rcache($key);
        if (empty($hoem_cases_list)) {
            //获取案例列表（8条）
            $hoem_cases_list = model('cases')->getCasesList(array(), '*', 0, 8);
            wcache($key, $hoem_cases_list, '', 36000);
        }
        return $hoem_cases_list;
    }

    /**
     * 获取产品列表
     * @return array
     */
    public function _get_product_list()
    {
        $key = 'home_product';
        $home_product_list = rcache($key);
        if (empty($home_product_list)) {
            //获取产品列表（8条）
            $home_product_list = model('product')->getProductList(array(), '*', 0, 8);
            wcache($key, $home_product_list, '', 36000);
        }
        return $home_product_list;
    }

    /**
     * 获取新闻栏目列表
     * @return array
     */
    public function _get_news_column()
    {
        $condition = array();
        $where = array();
        $condition['column_module'] = COLUMN_NEWS;
        $condition['parent_id'] = 0;
        $key = 'home_column_news';
        $home_column_news_list = rcache($key);
        if (empty($home_column_news_list)) {
            $home_column_news_list = model('column')->getColumnList($condition, 3);
            foreach ($home_column_news_list as $key => $news_list) {
                //获取新闻栏目列表
                $where['column_id'] = $news_list['column_id'];
                $home_column_news_list[$key]['news_list'] = model('news')->getNewsList($where, 5);
            }
            wcache($key, $home_column_news_list, '', 36000);
        }
        return $home_column_news_list;
    }
}