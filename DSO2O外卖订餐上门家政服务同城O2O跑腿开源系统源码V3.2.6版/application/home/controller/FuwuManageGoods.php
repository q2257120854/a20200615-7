<?php

namespace app\home\controller;

use think\Lang;
/**
 * ============================================================================
 * DSMall多用户商城
 * ============================================================================
 * 版权所有 2014-2028 长沙德尚网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.csdeshang.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * 控制器
 */
class  FuwuManageGoods extends BaseFuwu {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/fuwu_manage_goods.lang.php');
    }


    public function index() {
       
        $o2o_fuwu_goods_model = model('o2o_fuwu_goods');
        $o2o_fuwu_goods_state=1;
        if(input('param.o2o_fuwu_goods_state')!==null){
            $o2o_fuwu_goods_state=intval(input('param.o2o_fuwu_goods_state'));
            if(!in_array($o2o_fuwu_goods_state, array(0,1,10))){
                $this->error('状态错误');
            }
        }
        
        $conditions = array('o2o_fuwu_organization_id' => $this->o2o_fuwu_organization_info['o2o_fuwu_organization_id'],'o2o_fuwu_goods_state'=>$o2o_fuwu_goods_state);

        $goods_list = $o2o_fuwu_goods_model->getO2oFuwuGoodsList($conditions , '*', 20);

        $this->assign('goods_list', $goods_list);
        $this->assign('show_page', $o2o_fuwu_goods_model->page_info->render());
        
        
        switch($o2o_fuwu_goods_state){
            case 1:
                $menu='fuwu_manage_goods_on';
                break;
            case 0:
                $menu='fuwu_manage_goods_off';
                break;
            case 10:
                $menu='fuwu_manage_goods_close';
                break;
        }
        /* 设置机构当前菜单 */
        $this->setFuwuCurMenu($menu);
        /* 设置机构当前栏目 */
        $this->setFuwuCurItem('index');
        return $this->fetch($this->template_dir.'index');
    }
    public function add(){
        $this->get_common_data();
        /* 设置机构当前菜单 */
        $this->setFuwuCurMenu('fuwu_manage_goods_on');
        /* 设置机构当前栏目 */
        $this->setFuwuCurItem('add');
        return $this->fetch($this->template_dir.'form');
    }
    public function edit(){
        $o2o_fuwu_goods_id=intval(input('param.o2o_fuwu_goods_id'));
        
        $o2o_fuwu_goods_model=model('o2o_fuwu_goods');
        $conditions = array('o2o_fuwu_organization_id' => $this->o2o_fuwu_organization_info['o2o_fuwu_organization_id'],'o2o_fuwu_goods_id'=>$o2o_fuwu_goods_id);
        $o2o_fuwu_goods_info = $o2o_fuwu_goods_model->getO2oFuwuGoodsInfo($conditions);
        if(!$o2o_fuwu_goods_info){
            $this->error('服务不存在');
        }
        $o2o_fuwu_goods_spec_model=model('o2o_fuwu_goods_spec');
        $o2o_fuwu_goods_spec_list = $o2o_fuwu_goods_spec_model->getO2oFuwuGoodsSpecList($conditions);
        if(!$o2o_fuwu_goods_spec_list){
            $this->error('服务项目不存在');
        }
        
        $o2o_fuwu_goods_info['o2o_fuwu_goods_body']=json_decode($o2o_fuwu_goods_info['o2o_fuwu_goods_body'],true);
        $this->assign('goods',$o2o_fuwu_goods_info);
        $this->assign('o2o_fuwu_goods_spec_list',$o2o_fuwu_goods_spec_list);
        $this->get_common_data();
        /* 设置机构当前菜单 */
        $this->setFuwuCurMenu('fuwu_manage_goods_on');
        /* 设置机构当前栏目 */
        $this->setFuwuCurItem('edit');
        return $this->fetch($this->template_dir.'form');
    }
    public function save(){
        $o2o_fuwu_goods_id=intval(input('param.o2o_fuwu_goods_id'));

        $goods_data=array(
            'o2o_fuwu_goods_name'=>input('post.o2o_fuwu_goods_name'),
            'o2o_fuwu_goods_body'=>input('post.goods_body'),
            'o2o_fuwu_goods_advword'=>input('post.o2o_fuwu_goods_advword'),
            'o2o_fuwu_goods_image'=>input('post.o2o_fuwu_goods_image'),
            'o2o_fuwu_class_id'=>intval(input('post.o2o_fuwu_class_id')),
        );
        $o2o_fuwu_class_model=model('o2o_fuwu_class');
        
        $o2o_fuwu_goods_validate=validate('o2o_fuwu_goods');
        $o2o_fuwu_goods_spec_validate=validate('o2o_fuwu_goods_spec');
        $o2o_fuwu_goods_model=model('o2o_fuwu_goods');
        $o2o_fuwu_goods_spec_model=model('o2o_fuwu_goods_spec');
        
        if(!$o2o_fuwu_goods_id){
            $goods_data['o2o_fuwu_goods_state']=1;
            $goods_data['o2o_fuwu_organization_id']=$this->o2o_fuwu_organization_info['o2o_fuwu_organization_id'];
            $goods_data['o2o_fuwu_organization_name']=$this->o2o_fuwu_organization_info['o2o_fuwu_organization_name'];
        }else{
            $conditions = array('o2o_fuwu_organization_id' => $this->o2o_fuwu_organization_info['o2o_fuwu_organization_id'],'o2o_fuwu_goods_id'=>$o2o_fuwu_goods_id);
            $o2o_fuwu_goods_info = $o2o_fuwu_goods_model->getO2oFuwuGoodsInfo($conditions);
            if(!$o2o_fuwu_goods_info){
                ds_json_encode(10001, '服务不存在');
            }
        }
       
        
        $o2o_fuwu_goods_model->startTrans();
        try{
            if (!$o2o_fuwu_goods_validate->scene('o2o_fuwu_goods_save')->check($goods_data)) {
                exception($o2o_fuwu_goods_validate->getError());
            }
            $o2o_fuwu_class_info=$o2o_fuwu_class_model->getO2oFuwuClassInfo(array('o2o_fuwu_class_id'=>$goods_data['o2o_fuwu_class_id']));
            if(!$o2o_fuwu_class_info){
                exception('没有该服务分类');
            }
            $goods_data['o2o_fuwu_class_name']=$o2o_fuwu_class_info['o2o_fuwu_class_name'];
            $goods_data['o2o_fuwu_class_id_1']=$o2o_fuwu_class_info['o2o_fuwu_class_parent_id']?$o2o_fuwu_class_info['o2o_fuwu_class_parent_id']:$o2o_fuwu_class_info['o2o_fuwu_class_id'];
            $goods_data['o2o_fuwu_class_id_2']=$o2o_fuwu_class_info['o2o_fuwu_class_parent_id']?$o2o_fuwu_class_info['o2o_fuwu_class_id']:0;
            if(!$o2o_fuwu_goods_id){
                $o2o_fuwu_goods_id=$o2o_fuwu_goods_model->addO2oFuwuGoods($goods_data);
            }else{
                $o2o_fuwu_goods_model->editO2oFuwuGoods($goods_data,array('o2o_fuwu_goods_id'=>$o2o_fuwu_goods_id));
            }
            
            
            $spec_quantity=0;
            $default_price=false;
            $default_spec=0;
            
            $o2o_fuwu_goods_spec_id_list=input('post.o2o_fuwu_goods_spec_id/a');
            $o2o_fuwu_goods_spec_name_list=input('post.o2o_fuwu_goods_spec_name/a');
            $o2o_fuwu_goods_spec_unit_list=input('post.o2o_fuwu_goods_spec_unit/a');
            $o2o_fuwu_goods_spec_price_list=input('post.o2o_fuwu_goods_spec_price/a');
            $o2o_fuwu_goods_spec_type_list=input('post.o2o_fuwu_goods_spec_type/a');
            if(!$o2o_fuwu_goods_spec_id_list){
                exception('服务项目错误');
            }
            foreach($o2o_fuwu_goods_spec_id_list as $index => $spec){
                $o2o_fuwu_goods_spec_id=$spec;
                $spec_data=array(
                    'o2o_fuwu_organization_id'=>$this->o2o_fuwu_organization_info['o2o_fuwu_organization_id'],
                    'o2o_fuwu_goods_id'=>$o2o_fuwu_goods_id,
                    'o2o_fuwu_goods_spec_unit'=>$o2o_fuwu_goods_spec_unit_list[$index],
                    'o2o_fuwu_goods_spec_name'=>$o2o_fuwu_goods_spec_name_list[$index],
                    'o2o_fuwu_goods_spec_type'=>intval($o2o_fuwu_goods_spec_type_list[$index]),
                    'o2o_fuwu_goods_spec_price'=>floatval($o2o_fuwu_goods_spec_price_list[$index]),
                );
                if (!$o2o_fuwu_goods_spec_validate->scene('o2o_fuwu_goods_spec_save')->check($spec_data)) {
                    exception($o2o_fuwu_goods_spec_validate->getError());
                }
                if(!$o2o_fuwu_goods_spec_id){
                  $o2o_fuwu_goods_spec_id=$o2o_fuwu_goods_spec_model->addO2oFuwuGoodsSpec($spec_data);
                }else{
                  $o2o_fuwu_goods_spec_model->editO2oFuwuGoodsSpec($spec_data,array('o2o_fuwu_goods_spec_id'=>$o2o_fuwu_goods_spec_id));
                }
                
                if($spec_data['o2o_fuwu_goods_spec_type']==0){
                    $spec_quantity++;
                    if($default_price===false || $default_price>$spec_data['o2o_fuwu_goods_spec_price']){
                        $default_price=$spec_data['o2o_fuwu_goods_spec_price'];
                        $default_spec=$o2o_fuwu_goods_spec_id;
                    }
                }
            }
            if($spec_quantity==0){
                exception('至少需要一个默认服务项目');
            }
            $goods_data=array();
            $goods_data['o2o_fuwu_goods_default_price']=$default_price;
            $goods_data['o2o_fuwu_goods_spec_quantity']=$spec_quantity;
            $goods_data['o2o_fuwu_goods_default_spec']=$default_spec;
            $o2o_fuwu_goods_model->editO2oFuwuGoods($goods_data,array('o2o_fuwu_goods_id'=>$o2o_fuwu_goods_id));
        } catch (\Exception $e){
            $o2o_fuwu_goods_model->rollback();
            ds_json_encode(10001, $e->getMessage());
        }
        $o2o_fuwu_goods_model->commit();
        ds_json_encode(10000, lang('ds_common_op_succ'));
    }
    public function del(){
        $o2o_fuwu_goods_id=intval(input('param.o2o_fuwu_goods_id'));
        
        $o2o_fuwu_goods_model=model('o2o_fuwu_goods');
        $conditions = array('o2o_fuwu_organization_id' => $this->o2o_fuwu_organization_info['o2o_fuwu_organization_id'],'o2o_fuwu_goods_id'=>$o2o_fuwu_goods_id);
        if(!$o2o_fuwu_goods_model->delO2oFuwuGoods($conditions)){
            ds_json_encode(10001, lang('ds_common_op_fail'));
        }else{
            ds_json_encode(10000, lang('ds_common_op_succ'));
        }
    }
    public function get_common_data(){
        $o2o_fuwu_class_model = model('o2o_fuwu_class');
        $tmp_list = $o2o_fuwu_class_model->getO2oFuwuClassList(array('o2o_fuwu_class_parent_id'=>0));
        
        $class_list = array();
        if (is_array($tmp_list)) {
            foreach ($tmp_list as $k => $v) {
                $v['child']=$o2o_fuwu_class_model->getO2oFuwuClassList(array('o2o_fuwu_class_parent_id'=>$v['o2o_fuwu_class_id']));
                $class_list[] = $v;
            }
        }
        $this->assign('o2o_fuwu_class_list',$class_list);
    }
    public function show(){
        $o2o_fuwu_goods_id=intval(input('param.o2o_fuwu_goods_id'));
        $o2o_fuwu_goods_state=intval(input('param.o2o_fuwu_goods_state'));
        if(!in_array($o2o_fuwu_goods_state, array(0,1))){
            ds_json_encode(10001, '状态错误');
        }
        $o2o_fuwu_goods_model=model('o2o_fuwu_goods');
        $conditions = array('o2o_fuwu_organization_id' => $this->o2o_fuwu_organization_info['o2o_fuwu_organization_id'],'o2o_fuwu_goods_id'=>$o2o_fuwu_goods_id);
        if(!$o2o_fuwu_goods_model->editO2oFuwuGoods(array('o2o_fuwu_goods_state'=>$o2o_fuwu_goods_state),$conditions)){
            ds_json_encode(10001, lang('ds_common_op_fail'));
        }else{
            ds_json_encode(10000, lang('ds_common_op_succ'));
        }
    }
    
    public function pic_list() {
        /**
         * 实例化相册类
         */
        $o2o_fuwu_upload_model = model('o2o_fuwu_upload');
        /**
         * 图片列表
         */
        $param = array();
        $param['o2o_fuwu_organization_id'] = $this->o2o_fuwu_organization_info['o2o_fuwu_organization_id'];
        $type = input('param.item');
        
        switch($type){
            case 'goods_body':
                $key=O2O_FUWU_UPLOAD_GOODS_BODY;
                break;    
            case 'goods_image':
                $key=O2O_FUWU_UPLOAD_GOODS_IMAGE;
                break;      
            default:
        }
        $param['o2o_fuwu_upload_type']=$key;
        $pic_list = $o2o_fuwu_upload_model->getO2oFuwuUploadList($param,'*', 12);
        
        $this->assign('pic_list', $pic_list);
        $this->assign('show_page', $o2o_fuwu_upload_model->page_info->render());

        
        echo $this->fetch($this->template_dir.'pic_list');
    }
    
    /**
     *    栏目菜单
     */
    function getFuwuItemList() {
        $item_list = array(
            array(
                'name' => 'index',
                'text' => '服务列表',
                'url' => url('FuwuManageGoods/index',['o2o_fuwu_goods_state'=>input('param.o2o_fuwu_goods_state')]),
            ),
        );
        if(request()->action()=='add' || (request()->action()=='index' && input('param.o2o_fuwu_goods_state')==null)){
            $item_list[]=array(
                'name' => 'add',
                'text' => '新增',
                'url' => url('FuwuManageGoods/add'),
            );
        }
        if(request()->action()=='edit'){
            $item_list[]=array(
                'name' => 'edit',
                'text' => '编辑',
                'url' => 'javascript:void(0)',
            );
        }
        return $item_list;
    }

}

?>
