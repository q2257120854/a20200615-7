<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2017 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: zhangyajun <448901948@qq.com>
// +----------------------------------------------------------------------

namespace think\paginator\driver;

use think\Paginator;
use think\Config;

class Cmmphp extends Paginator
{
    // 分页配置
    protected $paginate = '';
    /**
     * 上一页按钮
     * @param string $text
     * @return string
	 * $text = "&laquo;"
     */
    protected function getPreviousButton($text = "上一页")
    {

        if ($this->currentPage() <= 1) {
            return $this->getDisabledTextWrapper($text);
        }

        $url = $this->url(
            $this->currentPage() - 1
        );

        return $this->getPageLinkWrapper($url, $text);
    }

    /**
     * 下一页按钮
     * @param string $text
     * @return string
	 * $text = '&raquo;'
     */
    protected function getNextButton($text = '下一页')
    {
        if (!$this->hasMore) {
            return $this->getDisabledTextWrapper($text);
        }

        $url = $this->url($this->currentPage() + 1);

        return $this->getPageLinkWrapper($url, $text);
    }

    /**
     * 页码按钮
     * @return string
     */
    protected function getLinks()
    {
        if ($this->simple)
            return '';

        $block = [
            'first'  => null,
            'slider' => null,
            'last'   => null
        ];

        $side   = 3;
        $window = $side * 2;

        if ($this->lastPage < $window + 6) {
            $block['first'] = $this->getUrlRange(1, $this->lastPage);
        } elseif ($this->currentPage <= $window) {
            $block['first'] = $this->getUrlRange(1, $window + 2);
            $block['last']  = $this->getUrlRange($this->lastPage - 1, $this->lastPage);
        } elseif ($this->currentPage > ($this->lastPage - $window)) {
            $block['first'] = $this->getUrlRange(1, 2);
            $block['last']  = $this->getUrlRange($this->lastPage - ($window + 2), $this->lastPage);
        } else {
            $block['first']  = $this->getUrlRange(1, 2);
            $block['slider'] = $this->getUrlRange($this->currentPage - $side, $this->currentPage + $side);
            $block['last']   = $this->getUrlRange($this->lastPage - 1, $this->lastPage);
        }

        $html = '';

        if (is_array($block['first'])) {
            $html .= $this->getUrlLinks($block['first']);
        }

        if (is_array($block['slider'])) {
            $html .= $this->getDots();
            $html .= $this->getUrlLinks($block['slider']);
        }

        if (is_array($block['last'])) {
            $html .= $this->getDots();
            $html .= $this->getUrlLinks($block['last']);
        }

        return $html;
    }

    /**
     * 渲染分页html
     * @return mixed
     */
    public function render()
    {
		$paginate = Config::get('paginate_cmm');
		
		if(isset($paginate['ul_type']) && $paginate['ul_type']){
			$ul_type = $paginate['ul_type'];
		}else{
			$ul_type = '<ul class="pagination  pagination-lg">%s %s %s</ul>';
		} 
		//dump($ul_type);die;

        if ($this->hasPages()) {
            if ($this->simple) {
                return sprintf(
                    '<ul class="pager">%s %s</ul>',
                    $this->getPreviousButton(),
                    $this->getNextButton()
                );
            } else {
                return sprintf(
                    $ul_type,
                    $this->getPreviousButton(),
                    $this->getLinks(),
                    $this->getNextButton()
                );
            }
        }
    }

    /**
     * 生成一个可点击的按钮
     *
     * @param  string $url
     * @param  int    $page
     * @return string
     */
    protected function getAvailablePageWrapper($url, $page)
    {
		$paginate = Config::get('paginate_cmm');	

		if($paginate['a_front'] && $paginate['a_after']){
			$li_front = $paginate['li_front'];
			$li_after = $paginate['li_after'];
			$a_front = $paginate['a_front'].' href="' . htmlentities($url) . '">' . $page;
			$a_after = $paginate['a_after'];
		}else{
			$li_front = '<li>';
			$li_after = '</li>';
			$a_front = '<a href="' . htmlentities($url) . '">' . $page ;
			$a_after = '</a>';
		}
		//$htm = '<li><a href="' . htmlentities($url) . '">' . $page . '</a></li>';
		$htm = $li_front.$a_front.$a_after.$li_after;
		//dump($htm);die;
		//dump($htm);die;
        return $htm ;
    }

    /**
     * 生成一个禁用的按钮
     *
     * @param  string $text
     * @return string
     */
    protected function getDisabledTextWrapper($text)
    {
		$paginate = Config::get('paginate_cmm');
		
		if($paginate['Prev_front'] && $paginate['Prev_after']){
			$Prev_front = $paginate['Prev_front'] . $text;
			$Prev_after = $paginate['Prev_after'];
		}else{
			$Prev_front = '<li class="disabled"><a href="#">' . $text ;
			$Prev_after = '</a></li>';
		}
		//$htm = '<li class="disabled"><a href="#">' . $text . '</a></li>';
		$htm = $Prev_front.$Prev_after;
		
        return $htm;
    }

    /**
     * 生成一个激活的按钮
     *
     * @param  string $text
     * @return string
     */
    protected function getActivePageWrapper($text)
    {
		$paginate = Config::get('paginate_cmm');
		
		if($paginate['active_front'] && $paginate['active_after']){
			$active_front = $paginate['active_front']. $text;
			$active_after = $paginate['active_after'];
		}else{
			$active_front = '<li class="active "><a href="#">' . $text ;
			$active_after = '</a></li>';
		}
		//$htm = '<li class="active "><a href="#">' . $text . '</a></li>';
		$htm = $active_front.$active_after;
		
        return $htm;
    }


    /**
     * 生成省略号按钮
     *
     * @return string
     */
    protected function getDots()
    {
        return $this->getDisabledTextWrapper('...');
    }

    /**
     * 批量生成页码按钮.
     *
     * @param  array $urls
     * @return string
     */
    protected function getUrlLinks(array $urls)
    {
        $html = '';

        foreach ($urls as $page => $url) {
            $html .= $this->getPageLinkWrapper($url, $page);
        }

        return $html;
    }

    /**
     * 生成普通页码按钮
     *
     * @param  string $url
     * @param  int    $page
     * @return string
     */
    protected function getPageLinkWrapper($url, $page)
    {
        if ($page == $this->currentPage()) {
            return $this->getActivePageWrapper($page);
        }

        return $this->getAvailablePageWrapper($url, $page);
    }

	
}
