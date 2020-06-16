<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use Org\service\GclassService as GclassService;

class Module extends Controller
{
	//新闻URL查询
    public function nclass_url($module)
    {
		$where = array();		
		$nclass = new \Org\service\NewsclassService();
		$where['url'] = $module;
		$info = $nclass->nclassInfo($where);
		//dump($info);die;
		if ($info) {
			return true;
		} else {
			return false;
		}
    }	
}
