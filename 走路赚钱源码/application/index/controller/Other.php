<?php
namespace app\index\controller;
use think\Url;
use think\Cache;
use think\Request;
use Org\service\AddressService as AddressService;

class Other  extends Cmmcom
{
	//联系我们
    public function contact()
    {
		$contact = 'active';
		$where = array();
		
		$address = new AddressService();
		$where['id'] = ['>',0];
		$result = $address->AddreInfo($where);

		$this->assign('result',$result);
		$this->assign('contact',$contact);//导航高亮
        return $this->fetch();
    }
	//在线留言
    public function feedback()
    {
		$feedback = 'active';
		$where = array();

		$this->assign('feedback',$feedback);//导航高亮
        return $this->fetch();
    }

	
}
