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
class  Sellergoodsadd extends BaseSeller
{

    public function _initialize()
    {
        parent::_initialize();
        error_reporting(E_ERROR | E_WARNING);
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/sellergoodsadd.lang.php');
    }

    /**
     * 三方机构验证，商品数量，有效期
     */
    private function checkStore()
    {
        $goodsLimit = (int)$this->store_grade['storegrade_goods_limit'];
        if ($goodsLimit > 0) {
            // 是否到达商品数上限
            $goods_num = model('goods')->getGoodsCount(array('store_id' => session('store_id')));
            if ($goods_num >= $goodsLimit) {
                $this->error(lang('store_goods_index_goods_limit') . $goodsLimit . lang('store_goods_index_goods_limit1'), url('Sellergoodsonline/goods_list'));
            }
        }
    }

    public function index()
    {
        $this->checkStore();
        $this->add_step_one();
    }

    /**
     * 添加商品
     */
    public function add_step_one()
    {
        // 实例化商品分类模型
        $goodsclass_model = model('goodsclass');
        // 商品分类
        $goods_class = $goodsclass_model->getGoodsclass(session('store_id'));

        $this->assign('goods_class', $goods_class);
        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('sellergoodsadd');
        $this->setSellerCurItem();
        echo $this->fetch($this->template_dir . 'store_goods_add_step1');
        exit;
    }

    /**
     * 添加商品
     */
    public function add_step_two()
    {
        // 实例化商品分类模型
        $goodsclass_model = model('goodsclass');
        // 现暂时改为从匿名“自营机构专属等级”中判断
        $editor_multimedia = false;
        if ($this->store_grade['storegrade_function'] == 'editor_multimedia') {
            $editor_multimedia = true;
        }
        $this->assign('editor_multimedia', $editor_multimedia);

        $gc_id = intval(input('get.class_id'));

        // 验证商品分类是否存在且商品分类是否为最后一级
        $data = model('goodsclass')->getGoodsclassForCacheModel();
        if (!isset($data[$gc_id]) || isset($data[$gc_id]['child']) || isset($data[$gc_id]['childchild'])) {
            $this->error(lang('store_goods_index_again_choose_category1'));
        }

        // 如果不是自营机构或者自营机构未绑定全部商品类目，读取绑定分类
        if (!check_platform_store_bindingall_goodsclass()) {
            //商品分类  支持批量显示分类
            $storebindclass_model = model('storebindclass');
            $goods_class = model('goodsclass')->getGoodsclassForCacheModel();
            $where['store_id'] = session('store_id');
            $class_2 = isset($goods_class[$gc_id]['gc_parent_id'])?$goods_class[$gc_id]['gc_parent_id']:0;
            $class_1 = isset($goods_class[$class_2]['gc_parent_id'])?$goods_class[$class_2]['gc_parent_id']:0;
            $where['class_1'] = ($class_1>0)?$class_1:(($class_2>0)?$class_2:$gc_id);
            $where['class_2'] = ($class_1>0)?$class_2:(($class_2>0)?$gc_id:0);
            $where['class_3'] = ($class_1>0 && $class_2>0)?$gc_id:0;
            $bind_info = $storebindclass_model->getStorebindclassInfo($where);
            if (empty($bind_info)) {
                $where['class_3'] = 0;
                $bind_info = $storebindclass_model->getStorebindclassInfo($where);
                if (empty($bind_info)) {
                    $where['class_2'] = 0;
                    $where['class_3'] = 0;
                    $bind_info = $storebindclass_model->getStorebindclassInfo($where);
                    if (empty($bind_info)) {
                        $where['class_1'] = 0;
                        $where['class_2'] = 0;
                        $where['class_3'] = 0;
                        $bind_info = model('storebindclass')->getStorebindclassInfo($where);
                        if (empty($bind_info)) {
                            $this->error(lang('store_goods_index_again_choose_category2'));
                        }
                    }
                }
            }
        }

        // 更新常用分类信息
        $goods_class = $goodsclass_model->getGoodsclassLineForTag($gc_id);
        $this->assign('goods_class', $goods_class);

        // 实例化机构商品分类模型
        $store_goods_class = model('storegoodsclass')->getClassTree(array(
                                                                        'store_id' => session('store_id'),
                                                                        'storegc_state' => '1'
                                                                    ));
        $this->assign('store_goods_class', $store_goods_class);


        // 关联版式
        $plate_list = model('storeplate')->getStoreplateList(array('store_id' => session('store_id')), 'storeplate_id,storeplate_name,storeplate_position');
        $plate_list = array_under_reset($plate_list, 'storeplate_position', 2);
        $this->assign('plate_list', $plate_list);
        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('sellergoodsadd');
        $this->setSellerCurItem();
        return $this->fetch($this->template_dir . 'store_goods_add_step2');
    }

    /**
     * 保存商品（商品发布第二步使用）
     */
    public function save_goods()
    {
        if (request()->isPost()) {
            $goods_model = model('goods');
            $goods_model->startTrans();
            try{
            // 分类信息
            $goods_class = model('goodsclass')->getGoodsclassLineForTag(intval(input('post.cate_id')));

            $common_array = array();
            $common_array['goods_name'] = input('post.g_name');
            $common_array['goods_advword'] = input('post.g_jingle');
            $common_array['gc_id'] = intval(input('post.cate_id'));
            $common_array['gc_id_1'] = intval($goods_class['gc_id_1']);
            $common_array['gc_id_2'] = intval($goods_class['gc_id_2']);
            $common_array['gc_id_3'] = intval($goods_class['gc_id_3']);
            $common_array['gc_name'] = input('post.cate_name');
            $common_array['goods_image'] = input('post.image_path');
            $common_array['goods_bg_image'] = input('post.bg_image_path');
            $common_array['goods_price'] = floatval(input('post.g_price'));
            $common_array['goods_serial'] = input('post.g_serial');
            $goods_body=input('post.goods_body');
            $goods_body=preg_replace_callback("/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i", function ($matches) {
                return strip_tags($matches[2]);
            }, $goods_body);
            $common_array['goods_body'] = $goods_body;

            // 序列化保存手机端商品描述数据
            $mobile_body = input('post.m_body');
            if ($mobile_body != '') {
                $mobile_body = str_replace('&quot;', '"', $mobile_body);
                $mobile_body = json_decode($mobile_body, true);
                if (!empty($mobile_body)) {
                    $mobile_body = serialize($mobile_body);
                }
                else {
                    $mobile_body = '';
                }
            }
            $common_array['mobile_body'] = $mobile_body;
            $common_array['goods_commend'] = intval(input('post.g_commend'));
            $common_array['goods_state'] = ($this->store_info['store_state'] != 1) ? 0 : intval(input('post.g_state')); // 机构关闭时，商品下架
            $common_array['goods_addtime'] = TIMESTAMP;
            $common_array['goods_edittime'] = TIMESTAMP;
            $common_array['goods_verify'] = (config('goods_verify') == 1) ? 10 : 1;
            $common_array['store_id'] = session('store_id');
            $common_array['store_name'] = session('store_name');
            $common_array['goods_vat'] = intval(input('post.g_vat'));

            $goods_validate = validate('sellergoodsadd');
            if (!$goods_validate->scene('save_goods')->check($common_array)) {
                exception($goods_validate->getError());
            }

            //查询机构商品分类
            $goods_stcids_arr = array();
            
            $sgcate_id_array = input('post.sgcate_id/a');#获取数组
            
            if (!empty($sgcate_id_array)) {
                $sgcate_id_arr = array();
                foreach ($sgcate_id_array as $k => $v) {
                    $sgcate_id_arr[] = intval($v);
                }
                $sgcate_id_arr = array_unique($sgcate_id_arr);
                $store_goods_class = model('storegoodsclass')->getStoregoodsclassList(array(
                                                                                          'store_id' => session('store_id'),
                                                                                          'storegc_id' => array(
                                                                                              'in', $sgcate_id_arr
                                                                                          ), 'storegc_state' => '1'
                                                                                      ));
                if (!empty($store_goods_class)) {
                    foreach ($store_goods_class as $k => $v) {
                        if ($v['storegc_id'] > 0) {
                            $goods_stcids_arr[] = $v['storegc_id'];
                        }
                        if ($v['storegc_parent_id'] > 0) {
                            $goods_stcids_arr[] = $v['storegc_parent_id'];
                        }
                    }
                    $goods_stcids_arr = array_unique($goods_stcids_arr);
                    sort($goods_stcids_arr);
                }
            }
            if (empty($goods_stcids_arr)) {
                $common_array['goods_stcids'] = '';
            }
            else {
                $common_array['goods_stcids'] = ',' . implode(',', $goods_stcids_arr) . ','; // 首尾需要加,
            }

            $common_array['plateid_top'] = intval(input('post.plate_top')) > 0 ? intval(input('post.plate_top')) : '';
            $common_array['plateid_bottom'] = intval(input('post.plate_bottom')) > 0 ? intval(input('post.plate_bottom')) : '';
            $common_array['is_platform_store'] = in_array(session('store_id'), model('store')->getOwnShopIds()) ? 1 : 0;

            // 保存数据
            $goods_id = $goods_model->addGoods($common_array);
            if ($goods_id) {
                // 记录日志
                $this->recordSellerlog('添加商品，平台货号:' . $goods_id);
                
            }
            else {
                exception(lang('store_goods_index_goods_add_fail'));
            }
            } catch (\Exception $e){
                $goods_model->rollback();
                $this->error($e->getMessage(), get_referer());
            }
            $goods_model->commit();
            $this->redirect(url('Sellergoodsonline/list_courses', ['goods_id' => $goods_id]));
        }
    }



    /**
     * 上传图片
     */
    public function image_upload()
    {
        // 判断图片数量是否超限
        $album_model = model('album');
        $album_limit = $this->store_grade['storegrade_album_limit'];
        if ($album_limit > 0) {
            $album_count = $album_model->getCount(array('store_id' => session('store_id')));

            if ($album_count >= $album_limit) {
                $error = lang('store_goods_album_climit');
                exit(json_encode(array('error' => $error)));
            }
        }
        $class_info = $album_model->getOne(array('store_id' => session('store_id'), 'aclass_isdefault' => 1), 'albumclass');


        $store_id = session('store_id');
        /**
         * 上传图片
         */
        //上传文件保存路径
        $upload_path = ATTACH_GOODS . '/' . $store_id;
        $save_name = session('store_id') . '_' . date('YmdHis') . rand(10000, 99999);
        $file_name = input('post.name');

        $result = upload_albumpic($upload_path, $file_name, $save_name);
        if($result['code']=='10000'){
            $img_path=$result['result'];
            list($width, $height, $type, $attr) = getimagesize($img_path);
            $img_path=substr(strrchr($img_path, "/"), 1);
        }else{
            //未上传图片或出错不做后面处理
            exit;
        }

        // 存入相册
        $insert_array = array();
        $insert_array['apic_name'] = $img_path;
        $insert_array['apic_tag'] = '';
        $insert_array['aclass_id'] = $class_info['aclass_id'];
        $insert_array['apic_cover'] = $img_path;
        $insert_array['apic_size'] = intval($_FILES[$file_name]['size']);
        $insert_array['apic_spec'] = $width . 'x' . $height;
        $insert_array['apic_uploadtime'] = TIMESTAMP;
        $insert_array['store_id'] = $store_id;
        $result = model('album')->addAlbumpic($insert_array);


        $data = array();
        if ($file_name == 'goods_bg_image') {
            $data ['thumb_name'] = goods_bgthumb($img_path, 'default', session('store_id'));
        } else {
            $data ['thumb_name'] = goods_cthumb($img_path, 270, session('store_id'));
        }
         $data ['name'] = $img_path;

        // 整理为json格式
        $output = json_encode($data);
        echo $output;
        exit();
    }

    /**
     * ajax获取商品分类的子级数据
     */
    public function ajax_goods_class()
    {
        $gc_id = intval(input('get.gc_id'));
        $deep = intval(input('get.deep'));
        if ($gc_id <= 0 || $deep <= 0 || $deep >= 4) {
            exit(json_encode(array()));
        }
        $goodsclass_model = model('goodsclass');
        $list = $goodsclass_model->getGoodsclass(session('store_id'), $gc_id, $deep);
        if (empty($list)) {
            exit(json_encode(array()));
        }
        echo json_encode($list);
    }




}

?>
