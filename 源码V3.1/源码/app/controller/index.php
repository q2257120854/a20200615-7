<?php

namespace BL\app\controller;

use BL\app\libs\Controller;

/**首页控制器
 * Class index
 * @package BL\app\controller
 */
class index extends Controller
{
    public function index()
    {
      
        $class = $this->model()->select()->from('gdclass')->orderby('ord DESC')->fetchAll();      
     	 $cid = $this->req->get('cid') ? $this->req->get('cid') : -1;//分类id
        $is_ste = isset($_GET['is_ste']) ? $this->req->get('is_ste') : 1 ;
        $type = isset($_GET['type']) ? $this->req->get('type') : -1 ;
        $gname = $this->req->get('gname');
        $cons = '';
        $consArr = [];
        if($cid >= 0){
            $cons .= $cons ? ' and ' : '';
            $cons.= 'g.cid = ?';
            $consArr[] = $cid;
        }
        if($is_ste >= 0){
            $cons .= $cons ? ' and ' : '';
            $cons.= 'g.is_ste = ?';
            $consArr[] = $is_ste;
        }

        if($type >= 0){
            $cons .= $cons ? ' and ' : '';
            $cons.= 'g.type = ?';
            $consArr[] = $type;
        }
        if($gname){
            $cons .= $cons ? ' and ' : '';
            $cons.= "g.gname like ?";
            $consArr[] = '%' . $gname . '%';;
        }

        $lists = [];
        $page = $this->req->get('p');
        $page = $page ? $page : 1;
        $pagesize = 200;
        $totalsize = $this->model()->from('goods g')->where(array('fields' => $cons, 'values' => $consArr))->count();
        if ($totalsize) {
            $totalpage = ceil($totalsize / $pagesize);
            $page = $page > $totalpage ? $totalpage : $page;
            $offset = ($page - 1) * $pagesize;
            $lists = $this->model()->select('g.*,c.title')->from('goods g')->limit($pagesize)->left('gdclass c')->on('c.id=g.cid')->join()->offset($offset)->where(array('fields' => $cons, 'values' => $consArr))->orderby('g.ord desc')->fetchAll();
        }
          foreach ($lists as  &$value)
              {
              if($this->session->get('login_lid')){
                $value['price'] = $value["money{$this->session->get('login_lid')}"];
              }else{
                $value['price'] =  $value['gmoney'] ;
              }            	
      			$value['pwd'] = $value['pwd'] ? "=yes" : "";//判断商品需要密码验证
              }

        $pagelist = $this->page->put(array('page' => $page, 'pagesize' => $pagesize, 'totalsize' => $totalsize, 'url' => '?cid='.$cid.'&is_ste='.$is_ste.'&type='.$type.'&gname='.$gname.'&p='));
        $search =[
            'cid' => $cid,
            'is_ste' => $is_ste,
            'type' => $type,
            'gname' => $gname
        ];
      
      
        $data = [
            'class' => $class,
            'lists' => $lists,
            'data' => $data
        ];
        $this->put('index'.$this->config['indexmode'].'.php', $data);
    }

    public function typegd()
    {
        $data = $this->getReqdata($_POST) ? $this->getReqdata($_POST) : 0;//分类id
        $lists = $this->model()->select()->from('goods')->where(array('fields' => 'cid=? ', 'values' => array($data['cid'])))->orderby('ord desc')->fetchAll();
        $html = "";
        if ($lists) {
            foreach ($lists as $v) {
      			$pwd = $v['pwd'] ? "=yes" : "";//判断商品需要密码验证
                $html .= "<option data-pwd".$pwd." value=" . $v['id'] . ">" . $v['gname'] . "</option>";
            }
            echo json_encode(array('status' => 1, 'html' => $html));
            exit;
        }
        echo json_encode(array('status' => 0, 'html' => $html));
        exit;
    }

    public function getGoodsInfo()
    {
        $id = $this->req->post('id');
        $pass = $this->req->post('pass');
        $data = $this->model()->select()->from('goods')->where(array('fields' => 'id=?', 'values' => array($id)))->fetchRow();   
     	 if($data['pwd']&&$data['pwd']!=$pass)resMsg(0);//判断并验证密码查看
     	 if($this->session->get('login_lid')){
                $data['price'] = $data["money{$this->session->get('login_lid')}"];
              }else{
                $data['price'] =  $data['gmoney'] ;
              }
        if (!$data) resMsg(0);
        //判断是否是自动发卡
        if ($data['type'] != 1) {
            $html = "<div class=\"am-form-group ajaxdiv\">
                                      <label for=\"account\" class=\"am-u-sm-3 am-form-label\">联系方式</label>
                                        <div class=\"am-u-sm-9\">
                                            <input type=\"text\" id=\"account\" class=\"am-form-field am-round\"
                                                 placeholder=\"QQ号码或者电话\"   value=\"\">
                                        </div>
                     </div>
                     <div class=\"am-form-group ajaxdiv\">
                                        <label for=\"chapwd\" class=\"am-u-sm-3 am-form-label\">查询密码</label>
                                        <div class=\"am-u-sm-9\">
                                            <input type=\"text\" id=\"chapwd\" class=\"am-form-field am-round\"
                                                placeholder=\"请仔细查询密码，作为查询重要依据\"    value=\"\">
                                        </div>
                                    </div>";

        }else{
            //手工订单
            $html = "<div class=\"am-form-group ajaxdiv\"><label for=\"account\" class=\"am-u-sm-3 am-form-label\">".$data['onetle']."</label>
                                        <div class=\"am-u-sm-9\">
                                            <input type=\"text\" id=\"account\" class=\"am-form-field am-round\"
                                                    value=\"\">
                                        </div>
                     </div>";
            $ripu = explode(',',$data['gdipt']);
            if($ripu[0]){
                $ipu = 1;
                foreach ($ripu as $v){
                    $html.="<div class=\"am-form-group ajaxdiv\"><label for=\"ipu".$ipu."\" class=\"am-u-sm-3 am-form-label\">".$v."</label>
                                        <div class=\"am-u-sm-9\">
                                            <input type=\"text\" id=\"ipu".$ipu."\" class=\"am-form-field am-round\"
                                                    value=\"\">
                                        </div>
                     </div>";
                    $ipu = $ipu+1;
                }

            }
        }
        $res = [
            'info' => $data,
            'html' => $html
        ];
        resMsg(1, $res);
    }

  

    public function getGoodsInfoajax()
    {
        $id = $this->req->post('id');
        $pass = $this->req->post('pass');
        $data = $this->model()->select()->from('goods')->where(array('fields' => 'id=?', 'values' => array($id)))->fetchRow();   
     	 if($data['pwd']&&$data['pwd']!=$pass)resMsg(0);//判断并验证密码查看
     	 if($this->session->get('login_lid')){
                $data['price'] = $data["money{$this->session->get('login_lid')}"];
              }else{
                $data['price'] =  $data['gmoney'] ;
              }
        if (!$data) resMsg(0);
        //判断是否是自动发卡
        if ($data['type'] != 1) {
            $html = "<div class=\"am-form-group ajaxdiv\">
                                      <label for=\"account\" class=\"am-u-sm-4 am-form-label\">邮箱</label>
                                        <div class=\"am-u-sm-8\">
                                            <input type=\"text\" id=\"account\" class=\"am-form-field am-round\"
                                                 placeholder=\"邮箱将用于通知\"   value=\"\">
                                        </div>
                     </div>
                     <div class=\"am-form-group ajaxdiv\">
                                        <label for=\"chapwd\" class=\"am-u-sm-4 am-form-label\">查询密码</label>
                                        <div class=\"am-u-sm-8\">
                                            <input type=\"text\" id=\"chapwd\" class=\"am-form-field am-round\"
                                                placeholder=\"请仔细查询密码，作为查询重要依据\"    value=\"\">
                                        </div>
                                    </div>";

        }else{
            //手工订单
            $html = "<div class=\"am-form-group ajaxdiv\"><label for=\"account\" class=\"am-u-sm-4 am-form-label\">".$data['onetle']."</label>
                                        <div class=\"am-u-sm-8\">
                                            <input type=\"text\" id=\"account\" class=\"am-form-field am-round\"
                                                    value=\"\">
                                        </div>
                     </div>";
            $ripu = explode(',',$data['gdipt']);
            if($ripu[0]){
                $ipu = 1;
                foreach ($ripu as $v){
                    $html.="<div class=\"am-form-group ajaxdiv\"><label for=\"ipu".$ipu."\" class=\"am-u-sm-4 am-form-label\">".$v."</label>
                                        <div class=\"am-u-sm-8\">
                                            <input type=\"text\" id=\"ipu".$ipu."\" class=\"am-form-field am-round\"
                                                    value=\"\">
                                        </div>
                     </div>";
                    $ipu = $ipu+1;
                }

            }
        }
        $res = [
            'info' => $data,
            'html' => $html
        ];
        resMsg(1, $res);
    }
    /**
     * 提交订单
     */
    public function postOrder()
    {
        $post = $this->getReqdata($_POST);
        $post['number'] = intval($post['number']);
        if($post['gid'] =="" || intval($post['number']) <=0 || $post['account'] == ""){
            resMsg(0,null,'充值账号、数量、商品不能为空，请仔细填写');
        }
        $goods = $this->model()->select()->from('goods')->where(array('fields' => 'id=?', 'values' => array($post['gid'])))->fetchRow();      
       if($this->session->get('login_lid')){
                $goods['price'] = $goods["money{$this->session->get('login_lid')}"];
              }else{
                $goods['price'] =  $goods['gmoney'] ;
              }
      
      
        if(!$goods || $goods['is_ste'] == 0) resMsg(0,null,'商品不存在或已下架');
        if($goods['kuc'] < $post['number'])resMsg(0,null,'库存不足');
        /**
         * 自动发卡
         */
        if($goods['type'] != 1){
            if($post['chapwd'] == ""){
                resMsg(0,null,'查询密码不能为空');
            }
            if(!filter_var($post['account'],FILTER_VALIDATE_EMAIL)){
                /*resMsg(0,null,'邮箱格式错误，未确保能够收到邮件提醒请仔细填写');*/
            }
            $orderid = $this->zdOrder($post,$goods);
        }else{
            $ripu = explode(',',$goods['gdipt']);
            $ctnum = $ripu[0] != "" ?count($ripu):0;
            if($ctnum >0){
                if(trim($post['ipu1']) == "")resMsg(0,null,$ripu[0].'不能为空');
            }
            if($ctnum >1){
                if(trim($post['ipu2']) == "")resMsg(0,null,$ripu[1].'不能为空');
            }
            if($ctnum >2){
                if(trim($post['ipu3']) == "")resMsg(0,null,$ripu[2].'不能为空');
            }
            if($ctnum >3){
                if(trim($post['ipu4']) == "")resMsg(0,null,$ripu[3].'不能为空');
            }
            $orderid = $this->sgOrder($post,$goods);

        }

       
        /**
         * 支付方式选择
         */
        $payset = $this->model()->select()->from('acp')->where(array('fields' => ' is_ste > 0', 'values' => array()))->fetchAll();

       
			if($payset){
				 $html="<script>window.location.href='/pay/index?id=".$orderid."&type=zfbf2f&paycode=zfbf2f'</script>"; 
				 resMsg(1,$html,'下单成，请支付！');
				}









    }
    public function sgOrder($data,$goods)
    {
        if($goods['checks'] == 0){
            $check =[$data['account'],$goods['id']];
            //检测重复下单
            $order = $this->model()->select()->from('orders')->where(array('fields' => 'account = ? AND gid = ? AND ( `status` > 0 AND `status` <> 4  )', 'values' => $check))->fetchRow();
            if($order)resMsg(0,null,'本商品限制重复下单，一号一次');
        }
        $info = $goods['onetle'].':'.$data['account'];
        $ripu = explode(',',$goods['gdipt']);
        $index = 1;
        foreach ($ripu as $value){
            if($value!=""){
                $info.="<br/> ".$value.':'.$data['ipu'.$index];
                $index = $index+1;
            }
        }
 		$uid = $this->session->get('login_id') ? $this->session->get('login_id') : 0;//用户uid
        $inadd = [
            'orderid' =>$this->res->getOrderID(),
            'oname' => $goods['gname'].'x'.$data['number'],
            'gid' => $goods['id'],
            'omoney' => $goods['price'],
            'onum' => $data['number'],
            'cmoney' => $goods['price'] * $data['number'],
            'chapwd' => $data['chapwd'],
            'account' => $data['account'],
            'otype' => 1,
            'ctime' => time(),
            'status' => 0,
            'uid' => $uid,
            'info' => $info
        ];
        $addres = $this->model()->from('orders')->insertData($inadd)->insert();
        if($addres){
            if($goods['price'] == 0){
                resMsg(2,null,'下单成功！');
            }
            return $inadd['orderid'];
        }
        resMsg(0,null,'下单失败！');

    }

    /**自动发卡
     * @param $data
     * @param $goods
     */
    private function zdOrder($data,$goods)
    {
 		$uid = $this->session->get('login_id') ? $this->session->get('login_id') : 0;//用户uid
        $inadd = [
            'orderid' =>$this->res->getOrderID(),
            'oname' => $goods['gname'].'x'.$data['number'],
            'gid' => $goods['id'],
            'omoney' => $goods['price'],
            'onum' => $data['number'],
            'cmoney' => $goods['price'] * $data['number'],
            'chapwd' => $data['chapwd'],
            'account' => $data['account'],
            'otype' => $goods['type'],
            'ctime' => time(),
            'uid' => $uid,
            'status' => 0
        ];
        $addres = $this->model()->from('orders')->insertData($inadd)->insert();
        if($addres){
            if($goods['price'] == 0){
                resMsg(2,null,'下单成功！');
            }
            return $inadd['orderid'];
        }
        resMsg(0,null,'下单失败！');

    }


}