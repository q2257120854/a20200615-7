<?php

namespace app\mobile\controller;

class Index extends BaseMall
{
    public function index()
    {
        $this->assign('cases_list', $this->_get_cases_list());
        $this->assign('product_list', $this->_get_product_list());
        $this->assign('news_list', $this->_get_news_column());

        return $this->fetch($this->template_dir . 'index');
    }


    /**
     * 获取案例列表
     * @return array
     */
    public function _get_cases_list()
    {
        $key = 'mobile_cases';
        $hoem_cases_list = rcache($key);
        if (empty($hoem_cases_list)) {
            //获取案例列表（4条）
            $hoem_cases_list = model('cases')->getCasesList(array(), '*', 0, 4);
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
        $key = 'mobile_product';
        $mobile_product_list = rcache($key);
        if (empty($mobile_product_list)) {
            //获取产品列表（4条）
            $mobile_product_list = model('product')->getProductList(array(), '*', 0, 4);
            wcache($key, $mobile_product_list, '', 36000);
        }
        return $mobile_product_list;
    }

    /**
     * 获取新闻栏目列表
     * @return array
     */
    public function _get_news_column()
    {
        $key = 'mobile_news';
        $mobile_news_list = rcache($key);
        if (empty($mobile_news_list)) {
            //获取新闻列表（4条）
            $mobile_news_list = model('news')->getNewsList(array(), 4);
            wcache($key, $mobile_news_list, '', 36000);
        }
        return $mobile_news_list;
    }
}
